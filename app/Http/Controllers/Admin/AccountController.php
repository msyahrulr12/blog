<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AccountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use RealRashid\SweetAlert\Facades\Alert;

class AccountController extends Controller
{
    public $view = 'admin.account.';
    public $route = 'admin.accounts.';
    public $title = 'Account';
    public $permission = 'Account';
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
        $data = $this->model->find(auth()->user()->id);
        return view($this->view.'account', compact('data'));
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
        //
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
    public function update(AccountRequest $request, $id)
    {
        $input = $request->all();

        if ($input['password'] == null) {
            unset($input['password']);
            unset($input['repeat_password']);
        } else {
            if ($input['password'] !== $input['repeat_password']) {
                Alert::error('Password Different!', 'Failed update data '.$this->title);
                return back();
            }

            // success
            $input['password'] = Hash::make($input['password']);
            $input['repeat_password'] = Hash::make($input['repeat_password']);
        }

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
        //
    }
}
