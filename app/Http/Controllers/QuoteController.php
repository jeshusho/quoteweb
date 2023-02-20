<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Exchange;
use App\Models\Part;
use App\Models\Quote;
use App\Models\QuoteDetail;
use App\Models\QuoteNote;
use App\Models\QuotePart;
use App\Models\QuoteService;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PDF;

class QuoteController extends Controller
{
    protected $quote;
    // protected $exchange_rate;
    // protected $exchange_sell;
    protected $exchange;
    protected $roles;

    public function __construct()
    {
        $today= Carbon::today('America/Lima')->isoFormat('YYYY-MM-DD');
        $this->exchange = Exchange::where('date',$today)->first();
        if(is_null($this->exchange)){
            app('App\Http\Controllers\ExchangeController')->createToday();
            app('App\Http\Controllers\ExchangeController')->updateToday();
            $this->exchange = Exchange::orderBy('id','DESC')->first();
        }
        $this->roles = User::find(auth()->id());
        //$this->exchange_rate = $exchange->exchange_rate;
        //$this->exchange_sell = $exchange->sell;
    }

    public function index(){
        $quotes = Quote::where('status','<>','deleted')->orderBy('id','DESC')->paginate(10);
        return Inertia::render('Quotes/All', [
            'quotes' => $this->transform($quotes),
            'exchange' =>  $this->exchange,
            'roles' => $this->roles,
        ]);
    }

    public function create(){
        return Inertia::render('Quotes/Quote', [
            'servicesparts' => $this->servicesparts(),
            'exchange' =>  $this->exchange,
            'default_payday' => intval(Setting::where('parameter','default_payday')->first()->value),
        ]);
        //return $this->servicesparts();
    }

    public function edit($id){
        $quote = Quote::find($id);
        if($quote->status === 'deleted') return redirect()->route('quotes.index');
        return Inertia::render('Quotes/Quote', [
            'servicesparts' => $this->servicesparts(),
            'exchange' =>  $this->exchange,
            'dataquote' => $quote,
        ]);
    }

    public function destroy($id){
        /*QuotePart::where('quote_id',$id)->delete();
        QuoteService::where('quote_id',$id)->delete();
        QuoteNote::where('quote_id',$id)->delete();
        QuoteDetail::where('quote_id',$id)->delete();
        Quote::where('id',$id)->delete();*/
        Quote::where('id',$id)->update(['status' => 'deleted']);
    }

    public function searchCustomers($term){
        return Customer::select('*')->selectRaw("CONCAT(code,' - ',name,' - ',document_number)  AS label")
                        ->when(request('term'), function ($query, $term) {
                            $query->where('code', 'like', "%$term%")
                            ->orWhere('name','like',"%$term%")
                            ->orWhere('document_number','like',"%$term%");
                        })->orderBy('code','ASC')->limit(8)->get();
    }

    public function searchServices($term,$jsonids){
        $ids = json_decode($jsonids);
        if($term !== 'all'){
            return Service::select('*')->selectRaw("CONCAT(code,' - ',description)  AS label")
            ->whereNotIn('id',$ids)
            ->when(request('term'), function ($query, $term) {
                $query->where('code', 'like', "$term%")
                ->orWhere('description','like',"$term%");
            })
                 
            ->orderBy('code','ASC')->limit(10)->get();
        }
        else{
            return Service::select('*')->selectRaw("CONCAT(code,' - ',description)  AS label")->whereNotIn('id',$ids)->orderBy('code','ASC')->limit(10)->get();
        }
    }

    public function searchParts($term,$jsonids){
        $ids = json_decode($jsonids);
        if($term !== 'all'){
            return Part::whereNotIn('id',$ids)
                    ->where('description','like',"$term%")
                    ->where('status',true)  
                    ->orderBy('description','ASC')->limit(10)->get();
        }
        else{
            return Part::whereNotIn('id',$ids)->where('status',true)->orderBy('description','ASC')->limit(10)->get();
        }
    }


    public function selectedService($id){
        return Service::find($id)->parts;
    }

    public function servicesparts(){
        return DB::table('service_part')
                    ->join('parts','parts.id','=','service_part.part_id')
                    ->join('services','services.id','=','service_part.service_id')
                    ->select(   'service_part.service_id',
                                'service_part.part_id',
                                DB::raw('(CASE WHEN service_part.part_qty IS NULL THEN 1 ELSE service_part.part_qty END) AS part_qty'),
                                'service_part.measure',
                                'service_part.inherit_measure',
                                //'services.code',
                                'parts.description')
                    ->get();
    }

    public function store(Request $request)
    {
        //return $request->all();
        $data = $this->mergeData($request);
        $this->quote =  Quote::create($data);
        if(!is_null($data['customer_id'])){
            $customer=Customer::find($data['customer_id']);
            if( $data['document_type']!==$customer->document_type
                || $data['document_number']!==$customer->document_number
                || $data['name']!==$customer->name
                || $data['address']!==$customer->address
                || $data['email']!==$customer->email
                || $data['phone']!==$customer->phone
                || $data['contact']!==$customer->contact
            ){
                Customer::where('id',$customer->id)
                        ->update([
                            'document_type' => $data['document_type'],
                            'document_number' => $data['document_number'],
                            'name' => $data['name'],
                            'address' => $data['address'],
                            'email' => $data['email'],
                            'phone' => $data['phone'],
                            'contact' => $data['contact']
                        ]);
            }
        }
        
        foreach ($data['services'] as $row) {
            $this->quote->services()->create($row);
        }

        foreach ($data['parts'] as $row) {
            $this->quote->parts()->create($row);
        }

        foreach ($data['notes'] as $row) {
            $this->quote->notes()->create($row);
        }

        foreach ($data['details'] as $row) {
            $this->quote->details()->create($row);
        }
        return $this->edit($this->quote->id);
    }


    public function update(Request $request,$id)
    {
        $data = $request->all();
        $this->quote = Quote::find($id);
        $this->quote->update($data);
        if(!is_null($data['customer_id'])){
            $customer=Customer::find($data['customer_id']);
            if( $data['document_type']!==$customer->document_type
                || $data['document_number']!==$customer->document_number
                || $data['name']!==$customer->name
                || $data['address']!==$customer->address
                || $data['email']!==$customer->email
                || $data['phone']!==$customer->phone
                || $data['contact']!==$customer->contact
            ){
                Customer::where('id',$customer->id)
                        ->update([
                            'document_type' => $data['document_type'],
                            'document_number' => $data['document_number'],
                            'name' => $data['name'],
                            'address' => $data['address'],
                            'email' => $data['email'],
                            'phone' => $data['phone'],
                            'contact' => $data['contact']
                        ]);
            }
        }
        
        $this->quote->services()->delete();
        foreach ($data['services'] as $row) {
            $this->quote->services()->create($row);
        }

        $this->quote->parts()->delete();
        foreach ($data['parts'] as $row) {
            $this->quote->parts()->create($row);
        }
        
        $this->quote->notes()->delete();
        foreach ($data['notes'] as $row) {
            $this->quote->notes()->create($row);
        }

        $this->quote->details()->delete();
        foreach ($data['details'] as $row) {
            $this->quote->details()->create($row);
        }

        /*
        foreach ($data['services'] as $row) {
            if(count(QuoteService::where('quote_id',$id)->where('service_id',$row['service_id'])->get())>0)
                QuoteService::where('quote_id',$id)->where('service_id',$row['service_id'])->update($row);
            else $this->quote->services()->create($row);
        }

        foreach ($data['parts'] as $row) {
            if(count(QuotePart::where('quote_id',$id)->where('part_id',$row['part_id'])->get())>0)
                QuotePart::where('quote_id',$id)->where('service_id',$row['part_id'])->update($row);
            else $this->quote->parts()->create($row);
        }
        */
    }


    public function mergeData($inputs)
    {
        $quote_init_number = intval(Setting::where('parameter','quote_init_number')->first()->value);
        $values = [
            'external_id' => Str::uuid()->toString(),
            'user_id' => auth()->id(),
            'number' => str_pad($quote_init_number + Quote::count(), 6, '0', STR_PAD_LEFT),
            'date' => Carbon::today('America/Lima')->isoFormat('YYYY-MM-DD'),
        ]; 

        $inputs->merge($values);

        return $inputs->all();
    }


    private function transform($rows){
        $collect_data = collect($rows->all());
        
        $data = $collect_data->transform(function($row, $key) {
            switch($row->status){
                case 'scheduled':
                    $estado='Programado';
                    break;
                case 'terminated':
                    $estado='Finalizado';
                    break;
                case 'cacelled':
                    $estado='Cancelado';
                    break;
                default:
                    $estado='Creado';
            }
            $array = [
                'id' => $row->id,
                'external_id' => $row->external_id,
                'number' => $row->number,
                'name' => $row->name,
                'total' => $row->total,
                'symbol' => ($row->currency==='PEN') ? 'S/.' : 'US$',
                'fecha_creacion' => Carbon::parse($row->created_at, 'UTC')->setTimezone('America/Lima')->isoFormat('DD/MM/YY'),
                'fecha_programada' => (!is_null($row->scheduled_date)) ? Carbon::parse($row->scheduled_date, 'UTC')->isoFormat('DD/MM/YY hh:mm A'): null,
                'fecha_ejecucion' => (!is_null($row->executed_date)) ?  Carbon::parse($row->executed_date, 'UTC')->isoFormat('DD/MM/YY hh:mm A') : null,
                'estado' => $estado,
            ];
            return $array;
        });
        $rows->data = $data;       
        $transform =  json_decode(json_encode($rows));
        $transform->data = $data;
        return $transform;
    }

    public function getPDF($external_id){
        
        $quote = Quote::where('external_id',$external_id)->orderBy('id','DESC')->first();
        $q = $this->transformQuote($quote);
        //return $q;
        //return $deducibles;

        $pdf = app('dompdf.wrapper');
        //$pdf->getDomPDF()->set_option("enable_php", true)->set_paper("A4", "portrait");
        $pdf->getDomPDF()->set_option("dpi", '75')->set_option("isRemoteEnabled", true)->set_option('isHtml5ParserEnabled', true)->set_paper("A4", "portrait");
        $pdf->loadView('templates.pdf.quote', 
                        [
                            'quote' => $q,
                            'company' => Company::find(1),
                            'quote_important_note_1' => Setting::where('parameter','quote_important_note_1')->first()->value,
                            'quote_important_note_2' => Setting::where('parameter','quote_important_note_2')->first()->value,
                            'quote_important_note_3' => Setting::where('parameter','quote_important_note_3')->first()->value,
                            'quote_contact_consultants' => Setting::where('parameter','quote_contact_consultants')->first()->value,
                        ]);
        return $pdf->stream('Presupuesto_'.$quote->number . '.pdf');
    }

    private function transformQuote($quote){
        switch($quote->document_type){
            case 'ruc':
                $doc_type='RUC';
                break;
            case 'dni':
                $doc_type='DNI';
                break;
            case 'ce':
                $doc_type='CE';
                break;
            case 'passport':
                $doc_type='Pasaporte';
                break;
            default:
                $doc_type='Documento Nro.';
                break;
        }
        switch($quote->status){
            case 'scheduled':
                $status='Programado';
                break;
            case 'terminated':
                $status='Finalizado';
                break;
            case 'cacelled':
                $status='Cancelado';
                break;
            default:
                $status='Creado';
        }

        $quote->status = $status;
        $quote->document_type = $doc_type;
        $quote->created_date = Carbon::parse($quote->date, 'UTC')->setTimezone('America/Lima')->isoFormat('DD/MM/YYYY');
        $quote->scheduled_date = (!is_null($quote->scheduled_date)) ? Carbon::parse($quote->scheduled_date, 'UTC')->isoFormat('DD/MM/YYYY hh:mm A'): null;
        $quote->executed_date = (!is_null($quote->executed_date)) ?  Carbon::parse($quote->executed_date, 'UTC')->isoFormat('DD/MM/YYYY hh:mm A') : null;
        $quote->symbol = ($quote->currency==='PEN') ? 'S/.' : 'US$';

       return $quote;
    }
}
