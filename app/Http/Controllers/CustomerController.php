<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    protected $items;


    public function __construct()
    {
        $this->items=Customer::where('status',true)->orderBy('name','ASC')->paginate(20);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        return Inertia::render('Customers/All', [
            'items' => $this->transform($this->items),
            'default_payday' => intval(Setting::where('parameter','default_payday')->first()->value),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $message = '';
        $response='OK';

        try {
            $data = $this->mergeData($request);
            $customer = Customer::create($data);
            $message = "El cliente '". $customer->name .  "' fue creado con éxito.";
        } catch (Throwable $e) {
            report($e);
            $response='Error';
            $message = 'Hubo un error al crear el cliente';
            if(count(Customer::where('code',$request->input('code'))->get())>0) $message = 'Código de cliente ya existe.';
            //return false;
        }

        
        return Inertia::render('Customers/All', [
            'items' => $this->transform($this->items),
            'default_payday' => intval(Setting::where('parameter','default_payday')->first()->value),
            'message' => $message,
            'response' => $response,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('customers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('customers.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = '';
        $response='OK';
        $this->items=Customer::where('status',true)->orderBy('name','ASC')->paginate(20);

        try {
            $data = $request->all();
            Customer::where('id',$id)->update($data);
            $customer = Customer::find($id);
            $message = "El cliente '". $customer->name .  "' fue actualizó con éxito.";
        } catch (Throwable $e) {
            //return $e;
            report($e);
            $response='Error';
            $message = 'Hubo un error al actualizar el cliente';
        }

        return Inertia::render('Customers/All', [
            'items' => $this->transform($this->items),
            'default_payday' => intval(Setting::where('parameter','default_payday')->first()->value),
            'message' => $message,
            'response' => $response,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        $customer->status = false;
        $customer->code = uniqid();
        $customer->save();
        $this->items=Customer::where('status',true)->orderBy('name','ASC')->paginate(20);
        return Inertia::render('Customers/All', [
            'items' => $this->transform($this->items),
            'default_payday' => intval(Setting::where('parameter','default_payday')->first()->value),
            'message' => 'Se eliminó el cliente ' . $customer->name,
            'response' => 'Delete',
        ]);
    }


    private function transform($rows){
        $collect_data = collect($rows->all());
        
        $data = $collect_data->transform(function($row, $key) {
            switch($row->document_type){
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
            $array = [
                'id' => $row->id,
                'code' => $row->code,
                'document_type' => $row->document_type,
                'document_number' => $row->document_number,
                'name' => $row->name,
                'address' => $row->address,
                'phone' => $row->phone,
                'email' => $row->email,
                'payday' => $row->payday,
                'currency' => $row->currency,
                'factor2' => $row->factor2,
                'contact' => $row->contact,
                'payment_day' => $row->payment_day,
                'payment_phone' => $row->payment_phone,
                'payment_contact' => $row->payment_contact,
                'document' =>  (!is_null($row->document_number)&&$row->document_number!=='')? $doc_type . ' ' . $row->document_number : null,
            ];
            return $array;
        });
        $rows->data = $data;       
        $transform =  json_decode(json_encode($rows));
        $transform->data = $data;
        return $transform;
    }

    public function mergeData($inputs)
    {
        //$code = $inputs->input('code');
        // if(!is_null($code)&&$code!==''){
        //     if(count(Customer::where('code',$code)->get())>0) $code = $code . strval(random_int(1,99));
        // }
        // else{
        //     $code = str_replace(' ', '', substr($inputs->input('name'),0,5)).strval(random_int(1,99));
        // }
        
        $values = [
            'user_id' => auth()->id(),
            //'code' => $code,
        ]; 

        $inputs->merge($values);

        return $inputs->all();
    }

}
