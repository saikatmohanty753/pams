<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use DB;
use Mail;
use App\Models\User;
use Illuminate\Support\Str;

class WebservicesController extends Controller
{
    private $data = array();

    /* ********************************************************************************************
    * mobileLogin funtion will Authenticate users based on request parametes i.e email & password
    ********************************************************************************************** */
    public function mobileLogin(Request $request)
    {
        $response = array('status'=>0,'msg'=>'error','result'=>'error');
        $user = User::where('email',$request->email)->where('is_active',1)->where('is_deleted',0);
        if($user->exists())
        {
            $user = $user->first();
            if(Hash::check($request->password, $user->password))
            {
                $rememberToken = Str::random(30);
                $user->remember_token = $rememberToken.$user->id;
                $user->update();
                $this->data = array(
                    'remember_token'=>$user->remember_token,
                );
                $response = array('status'=>1,'msg'=>'Logged In successful','result'=>$this->data);
            }
        }else{
            $response = array('status'=>0,'msg'=>'','result'=>[]);
        }
        return response()->json($response);
    }

    /* ***********************************************************************************
    * getUserFromRememberToken funtion will give users details based on Token given
    * at the time of login
    ************************************************************************************* */
    public function getUserFromRememberToken(Request $request)
    {
        $response = array('status'=>0,'msg'=>'error','result'=>['error']);
        $sub_department = null;
        if(!empty($request->remember_token))
        {
            $user = User::where('remember_token',$request->remember_token)->where('is_active',1)->where('is_deleted',0);
            if($user->exists())
            {
                $user = $user->first();
                if(!empty($user->sub_dept_id))
                {
                    $sub_department = getTableName('sub_departments',['id'=>$user->sub_dept_id]);
                }
                $this->data = array(
                    'emp_code'=>$user->emp_code,
                    'first_name'=>$user->first_name,
                    'last_name'=>$user->last_name,
                    'desig'=>getTableName('designations',['id'=>$user->desig_id]),
                    'dept'=>getTableName('departments',['id'=>$user->dept_id]),
                    'sub_dept'=>$sub_department,
                    'dept_id'=>$user->dept_id,
                    'sub_dept_id'=>$user->sub_dept_id,
                    'tier_user'=>tierStatus($user->tier_user),
                    'tier_user_id'=>$user->tier_user,
                    'role_id'=>$user->role_id,
                    'base_url'=>asset('/users'),
                    'profile_pic'=>$user->profile_pic,
                    'project_module'=>$user->can('project-module'),
                    'project_edit'=>$user->can('project-edit'),
                    'project_create'=>$user->can('project-create'),
                    'project_list'=>$user->can('project-list'),
                    'project_delete'=>$user->can('project-delete'),
                    'task_module'=>$user->can('task-module'),
                    'task_edit'=>$user->can('task-edit'),
                    'task_create'=>$user->can('task-create'),
                    'task_list'=>$user->can('task-list'),
                    'task_delete'=>$user->can('task-delete'),
                );
                $response = array('status'=>1,'msg'=>'success','result'=>$this->data);
            }else{
                $response = array('status'=>0,'msg'=>'Invalid token','result'=>['error']);
            }
        }else{
            $response = array('status'=>0,'msg'=>'Token missing','result'=>['error']);
        }
        return response()->json($response);
    }

    /* ***********************************************************************************
    * getDepartment funtion will give department master data based on request
    ************************************************************************************* */
    public function getDepartment(Request $request)
    {
        $this->data = DB::table('departments')->where('is_active',1)->select('id','name')->get();
        return response()->json(['status'=>1,'msg'=>'success','result'=>$this->data]);
    }

    /* *****************************************************************************************
    * getSubDepartment funtion will give sub department master data based on request department
    ******************************************************************************************* */
    public function getSubDepartment(Request $request)
    {
        if(!empty($request->dept_id))
        {
            $this->data = DB::table('sub_departments')->where('dept_id',$request->dept_id)->where('is_active',1);
            if($this->data->exists())
            {
                $this->data = $this->data->select('id','name')->get();
                return response()->json(['status'=>1,'msg'=>'success','result'=>$this->data]);
            }else{
                return response()->json(['status'=>0,'msg'=>'No sub department found','result'=>[]]);
            }
        }else{
            return response()->json(['status'=>0,'msg'=>'Invalid department id','result'=>['error']]);
        }
    }

    /* *****************************************************************************************
    * getRoles funtion will give users roles based on request department
    ******************************************************************************************* */
    public function getRoles(Request $request)
    {
        if(!empty($request->dept_id))
        {
            $this->data = DB::table('roles')->where('dept_id',$request->dept_id)->where('dept_id','!=',7);
            if($this->data->exists())
            {
                $this->data = $this->data->select('id','name')->get();
                return response()->json(['status'=>1,'msg'=>'success','result'=>$this->data]);
            }else{
                return response()->json(['status'=>0,'msg'=>'No role found','result'=>[]]);
            }
        }else{
            return response()->json(['status'=>0,'msg'=>'Invalid department id','result'=>['error']]);
        }
    }



}
