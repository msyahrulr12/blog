<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public $view = 'admin.permission.';
    public $route = 'admin.permissions.';
    public $title = 'Permission';
    public $permission = 'Permission';
    public $model;

    public function __construct(Permission $model)
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
    public function store(PermissionRequest $request)
    {
        $crud = ['index', 'create', 'show', 'edit', 'delete'];
        $input = $request->all();

        if ($request->crud == 'on') {
            foreach ($crud as $key => $value) {
                $dataCrud['name'] = $input['name'].' '.$value;
                $result = $this->model->create($dataCrud);

                if ($request->role !== null) {
                    $role = Role::find($request->role);
                    $result->assignRole($role);
                }
            }
        } else {
            $result = $this->model->create($input);
            if ($request->role !== null) {
                $role = Role::find($request->role);
                $result->assignRole($role);
            }
        }

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
    public function update(PermissionRequest $request, $id)
    {
        $input = $request->all();
        $result = $this->model->find($id)->update($input);

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
        $result = $this->model->find($id)->delete();

        if ($result) {
            Alert::success('Delete Success!', 'Success delete data '.$this->title);
            return redirect()->route($this->route.'index');
        }

        Alert::error('Delete Failed!', 'Failed delete data '.$this->title);
        return back();
    }
}
