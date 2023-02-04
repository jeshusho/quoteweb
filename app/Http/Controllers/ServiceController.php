<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Part;
use App\Models\QuotePart;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    protected $items;
    protected $groups;
    protected $parts;

    public function __construct()
    {
        $this->items=Service::where('status',true)->orderBy('code','ASC')->paginate(20);
        $this->groups = Group::where('status',true)->orderBy('description','ASC')->get();
        $this->parts = Part::where('status',true)->orderBy('description','ASC')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        return Inertia::render('Services/All', [
            'items' => $this->transform($this->items),
            'groups' =>  $this->groups,
            'parts' =>  $this->parts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return Service::find(34);
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
            $item = Service::create([
                'code' => $data['code'],
                'group_id' => $data['group_id'],
                'description' => $data['description'],
                'unit_price' => $data['unit_price'],
                'have_measures' => $data['have_measures'],
                'have_parts' => $data['have_parts'],
                'is_qty' => $data['is_qty'],
                'is_variable' => $data['is_variable'],
            ]);
            $parts = $data['parts'];
            if(count($parts)>0 && $data['have_parts']){
                $dataparts = [];
                foreach ($parts as $row) {
                    $dataparts[$row['id']] = [
                        'part_qty' =>  $row['pivot']['part_qty']
                    ];
                }
                $item->parts()->sync($dataparts);
            }
            else{
                $item->parts()->detach();
            }
            $message = "El servicio '". $item->description .  "' fue creado con éxito.";
        } catch (Throwable $e) {
            report($e);
            return $e;
            $response='Error';
            $message = 'Hubo un error al crear el cliente';
            if(count(Service::where('code',$request->input('code'))->get())>0) $message = 'Código de servicio ya existe.';
            //return false;
        }

        
        return Inertia::render('Services/All', [
            'items' => $this->transform($this->items),
            'groups' =>  $this->groups,
            'parts' =>  $this->parts,
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
        return redirect()->route('services.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('services.index');
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
        $this->items=Service::where('status',true)->orderBy('code','ASC')->paginate(20);

        try {
            $data = $request->all();
            Service::where('id',$id)
                    ->update([
                        'code' => $data['code'],
                        'group_id' => $data['group_id'],
                        'description' => $data['description'],
                        'unit_price' => $data['unit_price'],
                        'have_measures' => $data['have_measures'],
                        'have_parts' => $data['have_parts'],
                        'is_qty' => $data['is_qty'],
                        'is_variable' => $data['is_variable'],
                    ]);
            $item = Service::find($id);
            $parts = $data['parts'];
            if(count($parts)>0 && $data['have_parts']){
                $dataparts = [];
                foreach ($parts as $row) {
                    $dataparts[$row['id']] = [
                        'part_qty' =>  $row['pivot']['part_qty']
                    ];
                }
                $item->parts()->sync($dataparts);
            }
            else{
                $item->parts()->detach();
            }
            $message = "El servicio '". $item->description .  "' se actualizó con éxito.";
        } catch (Throwable $e) {
            //return $e;
            report($e);
            $response='Error';
            $message = 'Hubo un error al actualizar el servicio';
            if(count(Service::where('code',$request->input('code'))->get())>0) $message = 'Código de servicio ya existe.';
        }

        return Inertia::render('Services/All', [
            'items' => $this->transform($this->items),
            'groups' =>  $this->groups,
            'parts' =>  $this->parts,
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
        $item = Service::find($id);
        $item->status = false;
        $item->code = rand(10000,20000);
        $item->save();
        $item->parts()->detach();
        $this->items=Service::where('status',true)->orderBy('code','ASC')->paginate(20);
        return Inertia::render('Services/All', [
            'items' => $this->transform($this->items),
            'groups' =>  $this->groups,
            'parts' =>  $this->parts,
            'message' => 'Se eliminó el servicio ' . $item->description,
            'response' => 'Delete',
        ]);
    }


    private function transform($rows){
        $collect_data = collect($rows->all());
        
        $data = $collect_data->transform(function($row, $key) {
            $array = [
                'id' => $row->id,
                'group_id' => $row->group_id,
                'code' => $row->code,
                'description' => $row->description,
                'repo' => $row->repo,
                'measure' => $row->measure,
                'have_igv' => $row->have_igv,
                'unit_price' => $row->unit_price,
                'have_measures' => $row->have_measures,
                'have_parts' => $row->have_parts,
                'is_qty' => $row->is_qty,
                'is_variable' => $row->is_variable,
                'parts' => $row->parts,
                'price' => (!$row->is_variable) ? 'S/. ' . number_format((float)$row->unit_price, 2, '.', '') : 'Variable',
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
        $values = [
            'user_id' => auth()->id(),
            //'code' => $code,
        ]; 

        $inputs->merge($values);

        return $inputs->all();
    }

}
