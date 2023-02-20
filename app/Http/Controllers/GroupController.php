<?php

namespace App\Http\Controllers;

use App\Models\Group;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Throwable;

class GroupController extends Controller
{
    protected $items;

    public function __construct()
    {
        $this->items=Group::where('status',true)->orderBy('description','ASC')->paginate(20);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        return Inertia::render('Groups/All', [
            'items' => $this->transform($this->items),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //return Service::find(34);
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
            $item = Group::create($data);
            $message = "El repuesto '". $item->description .  "' fue creado con éxito.";
        } catch (Throwable $e) {
            report($e);
            $response='Error';
            $message = 'Hubo un error al crear el grupo';
            //return false;
        }

        
        return Inertia::render('Groups/All', [
            'items' => $this->transform($this->items),
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
        return redirect()->route('groups.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('groups.index');
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
        

        try {
            $data = $request->all();
            Group::where('id',$id)->update($data);
            $item = Group::find($id);

            $message = "El repuesto '". $item->description .  "' se actualizó con éxito.";
        } catch (Throwable $e) {
            return $e;
            report($e);
            $response='Error';
            $message = 'Hubo un error al actualizar el repuesto';
        }
        $this->items=Group::where('status',true)->orderBy('description','ASC')->paginate(20);
        return Inertia::render('Groups/All', [
            'items' => $this->transform($this->items),
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
        $item = Group::find($id);
        $item->status = false;
        $item->save();
        $this->items=Group::where('status',true)->orderBy('description','ASC')->paginate(20);
        return Inertia::render('Groups/All', [
            'items' => $this->transform($this->items),
            'message' => 'Se eliminó el repuesto ' . $item->description,
            'response' => 'Delete',
        ]);
    }


    private function transform($rows){
        $collect_data = collect($rows->all());
        
        $data = $collect_data->transform(function($row, $key) {
            $array = [
                'id' => $row->id,
                'description' => $row->description,
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
