<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Customer;
use App\Models\Log;
use App\Models\Quote;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;
use Throwable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $items;
    protected $roles;

    public function __construct()
    {
        $this->items=User::where('status',true)->orderBy('name','ASC')->paginate(20);
        $this->roles=Role::select('id','title')->orderBy('title','ASC')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Inertia::render('Users/All', [
            'items' => $this->transform($this->items),
            'roles' => $this->roles,
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
    public function store(StoreUserRequest $request)
    {
        $message = '';
        $response='OK';
        try {
            $data = $this->mergeData($request);
            $item = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'remember_token' => Str::random(50),
            ]);
            //$item = User::create($request->validated());
            $item->roles()->sync($request->input('roles', []));
            $message = "El usuario '". $item->email .  "' fue creado con éxito.";
        } catch (Throwable $e) {
            report($e);
            //return $e;
            $response='Error';
            $message = 'Hubo un error al crear el usuario';
            if(count(User::where('email',$request->input('email'))->get())>0) $message = 'Email de usuario ya existe.';
        }
        
        return Inertia::render('Users/All', [
            'items' => $this->transform($this->items),
            'roles' =>  $this->roles,
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
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('users.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $message = '';
        $response='OK';

        try {
            $data = $request->all();
            $arraydata = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'remember_token' => Str::random(50),
            ];
            if($data['password']===''|| is_null($data['password'])) unset($arraydata['password']);
            User::where('id',$id)->update($arraydata);
            $item = User::find($id);
            $item->roles()->sync($request->input('roles', []));
            $message = "El usuario '". $item->email .  "' se actualizó con éxito.";
        } catch (Throwable $e) {
            //return $e;
            report($e);
            $response='Error';
            $message = 'Hubo un error al actualizar el usuario';
            if(count(User::where('email',$request->input('email'))->where('id','!=',$data['id'])->get())>0) $message = 'Email de usuario ya existe.';
        }
        return Inertia::render('Users/All', [
            'items' => $this->transform($this->items),
            'roles' =>  $this->roles,
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
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Quote::where('user_id', $id)->update(['user_id' => 1]);
        Customer::where('user_id', $id)->update(['user_id' => 1]);
        Log::where('user_id', $id)->update(['user_id' => 1]);
        $item = User::find($id);
        $item->roles()->detach();
        //$item->status = false;
        //$item->save();
        $item->delete();
        $this->items=User::where('status',true)->orderBy('name','ASC')->paginate(20);
        return Inertia::render('Users/All', [
            'items' => $this->transform($this->items),
            'roles' =>  $this->roles,
            'message' => 'Se eliminó el usuario ' . $item->email,
            'response' => 'Delete',
        ]);
    }

    private function transform($rows){
        $collect_data = collect($rows->all());
        
        $data = $collect_data->transform(function($row, $key) {
            $r = '';
            foreach($row->roles as $key => $value){
                $r = $r . (($key>0)?', ':'') . $value->title;
            }
            $array = [
                'id' => $row->id,
                'name' => $row->name,
                'email' => $row->email,
                'status' => $row->status,
                'roles' => $row->roles,
                'strRoles' => $r,
            ];
            return $array;
        });
        $rows->data = $data;       
        $transform =  json_decode(json_encode($rows));
        $transform->data = $data;
        return $transform;
    }

    private function mergeData($inputs)
    {       
        $values = [
            'status' => true,
        ]; 

        $inputs->merge($values);

        return $inputs->all();
    }
}
