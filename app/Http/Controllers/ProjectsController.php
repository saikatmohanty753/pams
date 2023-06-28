<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;
use App\Models\ProjectMaster;
use App\Models\ProjectAssignDetail;
use App\Models\ReportingDesigDetail;
use App\Models\Department;
use App\Models\Designation;
use App\Models\SubDeptsProjectDetail;
use App\Models\DepartsProjectDetail;
use Illuminate\Support\Facades\Log;
use DB;
use Mail;
use App\Mail\SendNotificationMail;

class ProjectsController extends Controller
{
    private $errors = array();

    public function __construct()
    {
        /* $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['addUser', 'updateUser','']]); */

        $this->middleware('permission:project-create|project-edit', ['only' => ['saveProject', 'projectEdit','assignProject','updateProject']]);

        $this->middleware('permission:project-edit', ['only' => ['projectEdit','updateProject']]);

        $this->middleware('permission:project-delete', ['only' => ['deleteProject']]);
    } 
    public function projectAdd(Request $request)
    {
        $users = DB::table('users')->where([['is_deleted',0],['role_id','!=',1]])->whereIn('tier_user',[1,2])->get();
        $options = array();
        foreach($users as $user)
        {
            $options += array(
                $user->dept_id.'@@'.$user->id=>$user->first_name.' '.$user->last_name.' ( '.getTableName('designations',['id'=>$user->desig_id]).', '.getTableName('departments',['id'=>$user->dept_id]).' )',
            );
        }
        $projectsdata = DB::table('project_masters')->where('is_deleted',0);
        if(Auth::user()->tier_user == 1)
        {
            if(!in_array(Auth::user()->role_id,[1,2]))
            {
                $dept_ids = DB::table('departs_project_details')->where('dept_id',Auth::user()->dept_id)->pluck('project_id')->toArray();
                $projectsdata->whereIn('id',$dept_ids);
            }
        }
        $projectsdata = $projectsdata->get();
        return view('masters.add_project',compact('options','projectsdata'));
    }

    public function projectEdit($id)
    {
        $projects = null;
        if(!empty($id))
        {
            $id = decrypt($id);
            $projects = DB::table('project_masters')->where('id',$id)->first();
        }
        $users = getTableAll('users',[['is_deleted',0],['role_id','!=',1]]);
        $options = array();
        foreach($users as $user)
        {
            $options += array(
                $user->dept_id.'@@'.$user->id=>$user->first_name.' '.$user->last_name.' ( '.getTableName('designations',['id'=>$user->desig_id]).', '.getTableName('departments',['id'=>$user->dept_id]).' )',
            );
        }
        return view('masters.edit_project',compact('projects','options'));
    }
    public function saveProject(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'name'=>'required|unique:project_masters,name',
                'is_active'=>'required',
                'estimate_start_date'=>'required|date',
                'estimate_end_date'=>'required|date|after_or_equal:estimate_start_date',
                'dept_id.*'=>'required',
                /* 'actual_start_date'=>'date',
                'actual_end_date'=>'date|after_or_equal:actual_start_date', */
            ],[
                'name.required'=>'Please enter the project name',
                'name.unique'=>'This project already exists',
                'is_active.required'=>'Please select the project status',
                'estimate_end_date.required'=>'Please enter the estimate end date of the project',
                'estimate_start_date.required'=>'Please enter the estimate start date of the project',
                'dept_id.*.required'=>'Please choose the department',
            ]);

            $add_project = new ProjectMaster;
            $add_project->name = $request->name;
            $add_project->estimate_start_date = $request->estimate_start_date;
            $add_project->estimate_end_date = $request->estimate_end_date;
            $add_project->actual_start_date = $request->actual_start_date;
            $add_project->actual_end_date = $request->actual_end_date;
            if(!empty($request->description)){
                $add_project->description = $request->description;
            }
            $add_project->is_active = $request->is_active;
            $add_project->created_by = Auth::user()->id;
            if($add_project->save())
            {
                if(!empty($request->dept_id))
                {
                    $deleteAll = DepartsProjectDetail::where('project_id',$add_project->id)->delete();
                    foreach($request->dept_id as $dept_id)
                    {
                        $dept_ids = new DepartsProjectDetail;
                        $dept_ids->project_id = $add_project->id;
                        $dept_ids->dept_id = $dept_id;
                        $dept_ids->save();
                    }
                    if(!empty($request->sub_department))
                    {
                        $deleteSubAll = SubDeptsProjectDetail::where('project_id',$add_project->id)->delete();
                        foreach($request->sub_department as $sub_department)
                        {
                            $sub_dept = explode('@@',$sub_department);
                            $sub_department = new SubDeptsProjectDetail;
                            $sub_department->project_id = $add_project->id;
                            $sub_department->sub_dept_id = $sub_dept[0];
                            $sub_department->dept_id = $sub_dept[1];
                            $sub_department->save();
                        }
                    }
                }
                session()->put('success','Project successfully created');
            }else{
                session()->put('error','Failed to create project. Please try again');
            }
        }
        return redirect()->route('project-list');
    }

    public function updateProject(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'name'=>'required|unique:project_masters,name,'.$request->id,
                'is_active'=>'required',
                'estimate_start_date'=>'required|date',
                'estimate_end_date'=>'required|date|after_or_equal:estimate_start_date',
                'dept_id.*'=>'required',
                /* 'actual_start_date'=>'date',
                'actual_end_date'=>'date|after_or_equal:actual_start_date', */
            ],[
                'name.required'=>'Please enter the project name',
                'name.unique'=>'This project already exists',
                'is_active.required'=>'Please select the project status',
                'estimate_end_date.required'=>'Please enter the estimate end date of the project',
                'estimate_start_date.required'=>'Please enter the estimate start date of the project',
                'dept_id.*.required'=>'Please choose the department',
            ]);

            $update_project = ProjectMaster::where('id',$request->id)->first();
            $update_project->name = $request->name;
            $update_project->estimate_start_date = $request->estimate_start_date;
            $update_project->estimate_end_date = $request->estimate_end_date;
            $update_project->actual_start_date = $request->actual_start_date;
            $update_project->actual_end_date = $request->actual_end_date;
            $update_project->description = $request->description;
            $update_project->is_active = $request->is_active;
            //$update_project->created_by = Auth::user()->id;
            if($update_project->update())
            {
                $deleteAll = DepartsProjectDetail::where('project_id',$request->id)->delete();
                $deleteSubAll = SubDeptsProjectDetail::where('project_id',$request->id)->delete();
                if(!empty($request->dept_id))
                {
                    foreach($request->dept_id as $dept_id)
                    {
                        $dept_ids = new DepartsProjectDetail;
                        $dept_ids->project_id = $request->id;
                        $dept_ids->dept_id = $dept_id;
                        $dept_ids->save();
                    }
                    if(!empty($request->sub_department))
                    {
                        foreach($request->sub_department as $sub_department)
                        {
                            $sub_dept = explode('@@',$sub_department);
                            
                            $sub_department = new SubDeptsProjectDetail;
                            $sub_department->project_id = $request->id;
                            $sub_department->sub_dept_id = $sub_dept[0];
                            $sub_department->dept_id = $sub_dept[1];
                            $sub_department->save();
                        }
                    }
                }
                session()->put('success','Project updated successfully');
            }else{
                session()->put('error','Failed to update project. Please try again');
                return redirect()->back();
            }
        }
        return redirect()->route('project-list');
    }

    public function deleteProject(Request $request,$id='')
    {
        $id = decrypt($id);
        $delete_project = ProjectMaster::where('id',$id);
        if($delete_project->exists())
        {
            $delete_project = $delete_project->first();
            $delete_project->is_deleted = 1;
            $delete_project->deleted_date = date('Y-m-d');
            if($delete_project->update())
            {
                $project_assign = ProjectAssignDetail::where('project_id',$id);
                if($project_assign->exists())
                {
                    $project_assign = $project_assign->first();
                    $project_assign->is_active = 0;
                    $project_assign->update();
                }
                session()->put('success','Deleted successfully');
                return redirect()->back();
            }
        }
    }

    public function assignProject(Request $request)
    {
        if($request->method() == 'POST')
        {
            if(!empty($request->assign_to) && count($request->assign_to) > 0)
            {
                foreach($request->assign_to as $assign_to)
                {
                    $user_details = explode("@@",$assign_to);
                    $dept_id = $user_details[0];
                    $assign_to_user_id = $user_details[1];
                    $project_id = $request->project_id;

                    $is_exists = ProjectAssignDetail::where([['project_id',$project_id],['assign_to_user_id',$assign_to_user_id],['dept_id',$dept_id],['is_active',1]]);

                    $users = getTable('users',['id'=>$assign_to_user_id]);

                    if(!$is_exists->exists())
                    {
                        $project_assign = new ProjectAssignDetail;
                        $project_assign->project_id = $project_id;
                        $project_assign->dept_id = $dept_id;
                        $project_assign->assign_to_user_id = $assign_to_user_id;
                        if($project_assign->save())
                        {
                            $this->errors []= array(
                                'success'=>'Project assigned to '.$users->first_name.' '.$users->last_name.' successfully',
                            );
                        }
                    }else{
                        $this->errors []= array(
                            'warning'=>'Project is already assigned to '.$users->first_name.' '.$users->last_name,
                        );
                    }
                }
            }
        }
        session()->put('customError',$this->errors);

        return redirect()->back();
    }

    public function projectList()
    {
        $users = DB::table('users')->where([['is_deleted',0],['role_id','!=',1]])->whereIn('tier_user',[1,2])->get();
        $options = array();
        foreach($users as $user)
        {
            $options += array(
                $user->dept_id.'@@'.$user->id=>$user->first_name.' '.$user->last_name.' ( '.getTableName('designations',['id'=>$user->desig_id]).', '.getTableName('departments',['id'=>$user->dept_id]).' )',
            );
        }
        $projectsdata = DB::table('project_masters')->where('is_deleted',0);
        if(Auth::user()->tier_user == 1)
        {
            if(!in_array(Auth::user()->role_id,[1,2]))
            {
                $dept_ids = DB::table('departs_project_details')->where('dept_id',Auth::user()->dept_id)->pluck('project_id')->toArray();
                $projectsdata->whereIn('id',$dept_ids);
            }
        }
        $projectsdata = $projectsdata->get();
        return view('masters.project_list',compact('projectsdata','options'));
    }
}
