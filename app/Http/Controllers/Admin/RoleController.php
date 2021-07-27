<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public $view = 'admin.role.';
    public $route = 'admin.roles.';
    public $title = 'Role';
    public $permission = 'Role';
    public $model;

    public function __construct(Role $model)
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
        return view($this->view.'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $input = $request->all();
        $result = $this->model->create($input);

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
        return view($this->view.'edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
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
