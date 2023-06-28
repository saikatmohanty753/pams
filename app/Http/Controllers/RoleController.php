<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('role.add_role');
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
        if($request->method() == 'POST')
        {
            $request->validate([
                'name'=>'required',
                'dept_id'=>'required'
            ],[
                'name.required'=>'Please enter the role',
                'dept_id.required'=>'Please select the department'
            ]);
            $is_check = Role::where('dept_id',$request->dept_id)->where('name',$request->name);
            if(!$is_check->exists())
            {
                $role = new Role;
                $role->name = $request->name;
                $role->dept_id = $request->dept_id;
                if($role->save())
                {
                    session()->put('success','Role added successfully');
                }else{
                    session()->put('error','Failed add role');
                }
            }else{
                session()->put('error','Role already exists');
            }
        }
        return redirect()->route('add-role');
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
        $roles = null;
        if(!empty($id))
        {
            $id = decrypt($id);
            $roles = DB::table('roles')->where('id',$id)->first();
        }else{
            return redirect()->back();
        }
        $permission = Permission::get();

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();

        $departments = getTableAll('departments',['is_active'=>1]);
        
        return view('role.edit',compact('roles','rolePermissions','permission','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'name'=>'required',
                'dept_id'=>'required'
            ],[
                'name.required'=>'Please enter the role',
                'dept_id.required'=>'Please select the department'
            ]);
            $role = Role::where('id',$request->id)->first();
            $role->name = $request->name;
            $role->dept_id = $request->dept_id;
            if($role->update())
            {
                $role->syncPermissions($request->input('permission'));
                session()->put('success','Role updated successfully');
            }else{
                session()->put('error','Failed update role');
                return redirect()->back();
            }
        }
        return redirect()->route('add-role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id', $id)->delete();
        return redirect()->route('add-role')->with('success', 'Role deleted successfully');
    }

    public function getRole(Request $request)
    {
        $options = '<option value="">Select</option>';
        if($request->method() == 'POST')
        {
            if(!empty($request->dept_id))
            {
                $roles = Role::where('dept_id',$request->dept_id)->orderBy('name','asc')->get();
                if(isset($roles) && count($roles) > 0)
                {
                    foreach($roles as $role)
                    {
                        $options .= '<option value='.$role->id.'>'.$role->name.'</option>';
                    }
                }
            }
        }
        return response()->json(['status'=>1,'data'=>$options]);
    }
}
