<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public $view = 'admin.user.';
    public $route = 'admin.users.';
    public $title = 'User';
    public $permission = 'User';
    public $model;

    public function __construct(User $model)
    {
        $this->model = $model;
        $permission = $this->permission;

        $this->middleware(["permission:$permission index|$permission create|$permission edit|$permission|$permission show|$permission delete"]);

        View::share('title', $this->title);
        View::share('route', $this->route);
        View::share('view', $this->view);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = $this->model->paginate(15);
        return view($this->view.'index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view($this->view.'create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $result = $this->model->create($input);

        $role = Role::find($input['role']);
        $result->assignRole($role->name);

        if ($result) {
            Alert::success('Create Success!', 'Success create data '.$this->title);
            return redirect()->route($this->route.'index');
        }

        Alert::error('Create Failed!', 'Failed create data '.$this->title);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->model->find($id);
        $roles = Role::all();
        return view($this->view.'edit', compact('data', 'roles'));
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
        $input = $request->all();

        if ($input['password'] !== null) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        $user = $this->model->find($id);
        $result = $user->update($input);

        $role = Role::find($input['role']);
        $user->syncRoles([$role->name]);

        if ($result) {
            Alert::success('Update Success!', 'Success update data '.$this->title);
            return redirect()->route($this->route.'index');
        }

        Alert::error('Update Failed!', 'Failed update data '.$this->title);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->model->find($id);
        $result = $this->model->find($id)->delete();

        if ($result) {
            Alert::success('Delete Success!', 'Success delete data '.$this->title);
            return redirect()->route($this->route.'index');
        }

        Alert::error('Delete Failed!', 'Failed delete data '.$this->title);
        return back();
    }
}
