<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProjectMaster;
use App\Models\ProjectAssignDetail;
use App\Models\ReportingDesigDetail;
use App\Models\AssignUserDetail;
use App\Models\AssignObserverUserDetail;
use App\Models\Department;
use App\Models\Designation;
use App\Models\TaskDetail;
use Illuminate\Support\Facades\Log;
use DB;
use Auth;

class TaskManagementController extends Controller
{
    public function index(Request $request)
    {
        $projects_list = DB::table('project_assign_details')->where('assign_to_user_id',Auth::user()->id)->orderBy('id','desc')->get();
        $projects_options = DB::table('project_masters')
                            ->join('project_assign_details as psd','psd.project_id','=','project_masters.id');

        if(Auth::user()->role_id != 1){
            $projects_options = $projects_options->where('psd.assign_to_user_id',Auth::user()->id);
        }

        $projects_options = $projects_options->select('project_masters.id as id','project_masters.name as name')->distinct()->get();

        $users_lists = DB::table('users');
        if(Auth::user()->role_id!=1)
        {
            $users_lists->where([['reporting_id',Auth::user()->reporting_id]]);
        }
        $users_lists = $users_lists->where([['is_active',1],['is_deleted',0]])->orderBy('id','asc')->get();


        return view('task.assign_task',compact('projects_list','projects_options','users_lists'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'project_id'=>'required',
                'dept_id'=>'required',
                'title'=>'required',
                'description'=>'required',
                //'participant.*'=>'required',
                'responsible_person'=>'required',
                'start_date'=>'required',
                'end_date'=>'required|after_or_equal:start_date'
            ],[
                'project_id.required'=>'Something went wrong. Please try again.',
                'dept_id.required'=>'Something went wrong. Please try again.',
                'title.required'=>'Please enter the title',
                'description.required'=>'Please enter the description',
                //'participant.*.required'=>'Please select the participants',
                'responsible_person.required'=>'Please select the responsible person',
                'start_date.required'=>'Please enter the start date',
                'end_date.required'=>'Please enter the end date',
            ]);

            $task_details = new TaskDetail;
            $task_details->project_id = $request->project_id;
            $task_details->dept_id = $request->dept_id;
            $task_details->task_subject = $request->title;
            $task_details->responsible_person = $request->responsible_person;
            $task_details->start_date = $request->start_date;
            $task_details->end_date = $request->end_date;
            $task_details->created_by = Auth::user()->id;
            $task_details->task_description = $request->description;
            $task_details->is_active = 1;
            if($task_details->save())
            {
                $task_detail_id = $task_details->id;
                $task_details_assigned = new AssignUserDetail;
                $task_details_assigned->task_detail_id = $task_detail_id;
                $task_details_assigned->project_id = $request->project_id;
                $task_details_assigned->project_id = $request->project_id;
                $task_details_assigned->assign_user_id = $request->responsible_person;
                $task_details_assigned->assigned_by_user_id = Auth::user()->id;
                $task_details_assigned->status = 1;
                $task_details_assigned->is_active = 1;
                $task_details_assigned->is_responsible = 1;
                if($task_details_assigned->save())
                {
                    if(isset($request->participant) && count($request->participant) > 0)
                    {
                        foreach($request->participant as $participant)
                        {
                            $task_details_assign = new AssignUserDetail;
                            $task_details_assign->task_detail_id = $task_detail_id;
                            $task_details_assign->project_id = $request->project_id;
                            $task_details_assign->project_id = $request->project_id;
                            $task_details_assign->assign_user_id = $participant;
                            $task_details_assign->assigned_by_user_id = Auth::user()->id;
                            $task_details_assign->status = 1;
                            $task_details_assign->is_active = 1;
                            $task_details_assign->save();
                        }
                    }
                    if(isset($request->observer) && count($request->observer) > 0)
                    {
                        foreach($request->observer as $observer)
                        {
                            $task_details_observer = new AssignObserverUserDetail;
                            $task_details_observer->task_detail_id = $task_detail_id;
                            $task_details_observer->project_id = $request->project_id;
                            $task_details_observer->project_id = $request->project_id;
                            $task_details_observer->observer_user_id = $observer;
                            $task_details_observer->add_by_user_id = Auth::user()->id;
                            $task_details_observer->status = 1;
                            $task_details_observer->is_active = 1;
                            $task_details_observer->save();
                        }
                    }
                }
                session()->put('success','Task created successfully');
            }else{
                session()->put('error','Failed to create task. Please try again');
            }
        }else{
            session()->put('error','Invalid call to url');
        }
        return redirect()->back();
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }
    public function update(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'project_id'=>'required',
                'dept_id'=>'required',
                'title'=>'required',
                'description'=>'required',
                //'participant.*'=>'required',
                'responsible_person'=>'required',
                'start_date'=>'required',
                'end_date'=>'required|after_or_equal:start_date'
            ],[
                'project_id.required'=>'Something went wrong. Please try again.',
                'dept_id.required'=>'Something went wrong. Please try again.',
                'title.required'=>'Please enter the title',
                'description.required'=>'Please enter the description',
                //'participant.*.required'=>'Please select the participants',
                'responsible_person.required'=>'Please select the responsible person',
                'start_date.required'=>'Please enter the start date',
                'end_date.required'=>'Please enter the end date',
            ]);
            if(empty($request->participant))
            {
                $request->participant = array();
            }
            if(empty($request->observer))
            {
                $request->observer = array();
            }

            $task_details =  TaskDetail::where('id',$request->id);
            if($task_details->exists())
            {
                $task_details = $task_details->first();

                $task_details->project_id = $request->project_id;
                $task_details->dept_id = $request->dept_id;
                $task_details->task_subject = $request->title;
                $task_details->responsible_person = $request->responsible_person;
                $task_details->start_date = $request->start_date;
                $task_details->end_date = $request->end_date;
                $task_details->created_by = Auth::user()->id;
                $task_details->task_description = $request->description;
                $task_details->is_active = 1;
                if($task_details->update())
                {
                    $task_detail_id = $task_details->id;

                    $task_delete_users = AssignUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('is_removed',0)->get();

                    if(isset($task_delete_users) && count($task_delete_users) > 0)
                    {
                        foreach($task_delete_users as $task_remove)
                        {
                            if(!in_array($task_remove->assign_user_id,$request->participant))
                            {
                                $task_delete_users = AssignUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('assign_user_id',$task_remove->assign_user_id)->where('is_removed',0)->first();

                                $task_delete_users->is_removed = 1;
                                $task_delete_users->removed_date = date('Y-m-d h:i:s');
                                $task_delete_users->update();

                            }
                        }
                    }
                    $task_assign_res_users = AssignUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('assign_user_id',$request->responsible_person)->where('is_removed',0);

                    $is_update = 0;

                    if(!$task_assign_res_users->exists())
                    {

                        $task_details_assigned = new AssignUserDetail;
                        $task_details_assigned->task_detail_id = $task_detail_id;
                        $task_details_assigned->project_id = $request->project_id;
                        $task_details_assigned->project_id = $request->project_id;
                        $task_details_assigned->assign_user_id = $request->responsible_person;
                        $task_details_assigned->assigned_by_user_id = Auth::user()->id;
                        $task_details_assigned->status = 1;
                        $task_details_assigned->is_active = 1;
                        $task_details_assigned->is_responsible = 1;
                        if($task_details_assigned->save())
                        {
                            $is_update = 1;
                        }
                    }else{
                        $task_assign_res_users = $task_assign_res_users->first();

                        $task_assign_res_users->task_detail_id = $task_detail_id;
                        $task_assign_res_users->project_id = $request->project_id;
                        $task_assign_res_users->project_id = $request->project_id;
                        $task_assign_res_users->assign_user_id = $request->responsible_person;
                        $task_assign_res_users->assigned_by_user_id = Auth::user()->id;
                        $task_assign_res_users->status = 1;
                        $task_assign_res_users->is_active = 1;
                        $task_assign_res_users->is_responsible = 1;
                        if($task_assign_res_users->update())
                        {
                            $is_update = 1;
                        }
                    }

                    if($is_update == 1)
                    {
                        if(isset($request->participant) && count($request->participant) > 0)
                        {
                            foreach($request->participant as $participant)
                            {
                                $task_assign_users = AssignUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('assign_user_id',$participant)->where('is_removed',0);

                                if(!$task_assign_users->exists())
                                {
                                    $task_details_assign = new AssignUserDetail;
                                    $task_details_assign->task_detail_id = $task_detail_id;
                                    $task_details_assign->project_id = $request->project_id;
                                    $task_details_assign->project_id = $request->project_id;
                                    $task_details_assign->assign_user_id = $participant;
                                    $task_details_assign->assigned_by_user_id = Auth::user()->id;
                                    $task_details_assign->status = 1;
                                    $task_details_assign->is_active = 1;
                                    $task_details_assign->save();
                                }else{
                                    $task_assign_users = $task_assign_users->first();
                                    $task_assign_users->task_detail_id = $task_detail_id;
                                    $task_assign_users->project_id = $request->project_id;
                                    $task_assign_users->project_id = $request->project_id;
                                    $task_assign_users->assign_user_id = $participant;
                                    $task_assign_users->assigned_by_user_id = Auth::user()->id;
                                    $task_assign_users->status = 1;
                                    $task_assign_users->is_active = 1;
                                    $task_assign_users->update();
                                }
                            }
                        }

                        $task_delete_users = AssignObserverUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('is_removed',0)->get();

                        if(isset($task_delete_users) && count($task_delete_users) > 0)
                        {
                            foreach($task_delete_users as $task_remove)
                            {
                                if(!in_array($task_remove->assign_user_id,$request->observer))
                                {
                                    $task_delete_users = AssignObserverUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('observer_user_id',$task_remove->observer_user_id)->where('is_removed',0)->first();
                                    $task_delete_users->is_removed = 1;
                                    $task_delete_users->removed_date = date('Y-m-d h:i:s');
                                    $task_delete_users->update();
                                }
                            }
                        }

                        if(isset($request->observer) && count($request->observer) > 0)
                        {
                            foreach($request->observer as $observer)
                            {
                                $task_observer_users = AssignObserverUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('observer_user_id',$observer)->where('is_removed',0);

                                if(!$task_observer_users->exists())
                                {
                                    $task_details_observer = new AssignObserverUserDetail;
                                    $task_details_observer->task_detail_id = $task_detail_id;
                                    $task_details_observer->project_id = $request->project_id;
                                    $task_details_observer->project_id = $request->project_id;
                                    $task_details_observer->observer_user_id = $observer;
                                    $task_details_observer->add_by_user_id = Auth::user()->id;
                                    $task_details_observer->status = 1;
                                    $task_details_observer->is_active = 1;
                                    $task_details_observer->save();
                                }else{
                                    $task_observer_users = $task_observer_users->first();
                                    $task_observer_users->task_detail_id = $task_detail_id;
                                    $task_observer_users->project_id = $request->project_id;
                                    $task_observer_users->project_id = $request->project_id;
                                    $task_observer_users->observer_user_id = $observer;
                                    $task_observer_users->add_by_user_id = Auth::user()->id;
                                    $task_observer_users->status = 1;
                                    $task_observer_users->is_active = 1;
                                    $task_observer_users->update();
                                }
                            }
                        }
                    }
                    session()->put('success','Task updated successfully');
                }else{
                    session()->put('error','Failed to update task. Please try again');
                }
            }
        }else{
            session()->put('error','Invalid call to url');
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        if(!empty($id))
        {
            $id = decrypt($id);
            $task_details = TaskDetail::where('id',$id);
            if($task_details->exists())
            {
                $task_details = $task_details->first();
                $task_details->is_delete = 1;
                $task_details->deleted_date = date('Y-m-d h:i:s');
                if($task_details->update())
                {
                    $sub_task_details = TaskDetail::where('parent_task_id',$id)->where('is_delete',0);
                    if($sub_task_details->exists())
                    {
                        $sub_task_details = $sub_task_details->get();
                        foreach($sub_task_details as $subtsk)
                        {
                            $sub_tsk_details = TaskDetail::where('id',$subtsk->id)->first();
                            $sub_tsk_details->is_delete = 1;
                            $sub_tsk_details->deleted_date = date('Y-m-d h:i:s');
                            $sub_tsk_details->delete_remark = 'Sub Task deleted due to main task deleted';
                            $sub_tsk_details->update();
                        }
                    }
                    session()->put('success','Task has been deleted successfully');
                }else{
                    session()->put('error','Failed to delete the task. Please try again');
                }
            }else{
                session()->put('error',"Invalid Task!");
            }
        }else{
            session()->put('success','Invalid call of the url');
        }
        return redirect()->back();
    }

    public function getDepartmentUser(Request $request)
    {
        $options = '<option value="">Select</option>';
        if($request->method() == 'POST')
        {
            if(!empty($request->dept_id))
            {
                $users = User::where('dept_id',$request->dept_id)->where([['is_deleted',0],['role_id','!=',1]])->whereIn('tier_user',[3,2])->get();
                if(isset($users) && count($users) > 0)
                {
                    foreach($users as $user)
                    {
                        $options .= '<option value='.$user->id.'>'.getUserName($user->id).'</option>';
                    }
                }
            }
        }
        return response()->json(['status'=>1,'data'=>$options]);
    }

    public function taskAssignListAjax(Request $request)
    {

        $task_details = TaskDetail::where([['is_delete',0],['is_active',1]]);
        if(Auth::user()->tier_user == 1)
        {
            if(!in_array(Auth::user()->role_id,[1,2]))
            {
                $task_details->where('dept_id',Auth::user()->dept_id);
            }
        }
        if(in_array(Auth::user()->tier_user,[2,3]))
        {
            $task_assign = array();

            if(Auth::user()->tier_user == 3)
            {
                $task_assign = DB::table('assign_users_details')->where('assign_user_id',Auth::user()->id)->where('is_removed',0)->pluck('task_detail_id')->toArray();
            }

            if(!empty($task_details) && Auth::user()->tier_user != 2)
            {
                $task_details->whereIn('id',$task_assign);
            }
            if(Auth::user()->tier_user == 2)
            {
                $task_assign = DB::table('assign_users_details')->where('assign_user_id',Auth::user()->id)->where('is_removed',0)->pluck('task_detail_id')->toArray();
                $task_details->where('dept_id',Auth::user()->dept_id);
                if(!empty($task_details) && Auth::user()->tier_user != 2)
                {
                    $task_details->whereIn('id',$task_assign);
                }else{
                    $task_details->where('responsible_person',Auth::user()->id);
                }
            }
        }
        if(!empty($request->start_date))
        {
            $task_details->where('start_date','>=',$request->start_date);
        }
        if(!empty($request->end_date))
        {
            $task_details->where('end_date','<=',$request->end_date);
        }
        if(isset($request->status) && $request->status!=null)
        {
            if(in_array($request->status,[1,2,3]))
            {
                $task_details->whereIn('is_complete',[1,2,3]);
            }else{
                $task_details->where('is_complete',$request->status);
            }
        }
        $task_details = $task_details->orderBy('id','desc')->get();

        return response()->json([view('task.task_list_ajax',compact('task_details'))->render()]);
    }

    public function taskObserver(Request $request)
    {
        $task_details = TaskDetail::where([['is_delete',0],['is_active',1]]);

        $task_observer = DB::table('assign_observer_users_details')->where('observer_user_id',Auth::user()->id)->where('is_removed',0)->pluck('task_detail_id')->toArray();

        $task_details->where('id',$task_observer);

        if(!empty($request->start_date))
        {
            $task_details->where('start_date','>=',$request->start_date);
        }
        if(!empty($request->end_date))
        {
            $task_details->where('end_date','<=',$request->end_date);
        }
        if(isset($request->status) && $request->status!=null)
        {
            if(in_array($request->status,[1,2,3]))
            {
                $task_details->whereIn('is_complete',[1,2,3]);
            }else{
                $task_details->where('is_complete',$request->status);
            }
        }

        $task_details = $task_details->get();
        return response()->json([view('task.task_observer',compact('task_details'))->render()]);
    }
    public function taskTeam(Request $request)
    {
        $task_details = TaskDetail::where([['is_delete',0],['is_active',1]]);

        $users = DB::table('users')->where('dept_id',Auth::user()->dept_id)->where('id','!=',Auth::user()->id)->pluck('id')->toArray();

        $task_details->where('responsible_person','!=',Auth::user()->id);
        $task_details->whereIn('responsible_person',$users);

        if(!empty($request->start_date))
        {
            $task_details->where('start_date','>=',$request->start_date);
        }
        if(!empty($request->end_date))
        {
            $task_details->where('end_date','<=',$request->end_date);
        }
        if(isset($request->status) && $request->status!=null)
        {
            if(in_array($request->status,[1,2,3]))
            {
                $task_details->whereIn('is_complete',[1,2,3]);
            }else{
                $task_details->where('is_complete',$request->status);
            }
        }

        $task_details = $task_details->get();

        return response()->json([view('task.task_team',compact('task_details'))->render()]);
    }

    public function taskUpdate($id)
    {
        $task_details = null;
        if(!empty($id))
        {
            $id = decrypt($id);
            $task_details = TaskDetail::where('id',$id)->first();
        }else{
            return redirect()->back();
        }
        return view('task.task_update',compact('task_details'));
    }

    public function createSubTask(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'project_id'=>'required',
                'dept_id'=>'required',
                'title'=>'required',
                'description'=>'required',
                //'participant.*'=>'required',
                'responsible_person'=>'required',
                'start_date'=>'required',
                'end_date'=>'required|after_or_equal:start_date'
            ],[
                'project_id.required'=>'Something went wrong. Please try again.',
                'dept_id.required'=>'Something went wrong. Please try again.',
                'title.required'=>'Please enter the title',
                'description.required'=>'Please enter the description',
                //'participant.*.required'=>'Please select the participants',
                'responsible_person.required'=>'Please select the responsible person',
                'start_date.required'=>'Please enter the start date',
                'end_date.required'=>'Please enter the end date',
            ]);
            if(empty($request->participant))
            {
                $request->participant = array();
            }
            if(empty($request->observer))
            {
                $request->observer = array();
            }

            $task_details =  TaskDetail::where('id',$request->task_id);
            if($task_details->exists())
            {
                $task_details = $task_details->first();

                $sub_task_details = new TaskDetail;

                $sub_task_details->project_id = $request->project_id;
                $sub_task_details->type = 2;
                $sub_task_details->parent_task_id = $request->task_id;
                $sub_task_details->dept_id = $request->dept_id;
                $sub_task_details->task_subject = $request->title;
                $sub_task_details->responsible_person = $request->responsible_person;
                $sub_task_details->start_date = $request->start_date;
                $sub_task_details->end_date = $request->end_date;
                $sub_task_details->created_by = Auth::user()->id;
                $sub_task_details->task_description = $request->description;
                $sub_task_details->is_active = 1;
                if($sub_task_details->save())
                {
                    $task_detail_id = $sub_task_details->id;

                    $task_delete_users = AssignUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('is_removed',0)->get();

                    if(isset($task_delete_users) && count($task_delete_users) > 0)
                    {
                        foreach($task_delete_users as $task_remove)
                        {
                            if(!in_array($task_remove->assign_user_id,$request->participant))
                            {
                                $task_delete_users = AssignUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('assign_user_id',$task_remove->assign_user_id)->where('is_removed',0)->first();

                                $task_delete_users->is_removed = 1;
                                $task_delete_users->removed_date = date('Y-m-d h:i:s');
                                $task_delete_users->update();

                            }
                        }
                    }
                    $task_assign_res_users = AssignUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('assign_user_id',$request->responsible_person)->where('is_removed',0);

                    $is_update = 0;

                    if(!$task_assign_res_users->exists())
                    {

                        $task_details_assigned = new AssignUserDetail;
                        $task_details_assigned->task_detail_id = $task_detail_id;
                        $task_details_assigned->project_id = $request->project_id;
                        $task_details_assigned->project_id = $request->project_id;
                        $task_details_assigned->assign_user_id = $request->responsible_person;
                        $task_details_assigned->assigned_by_user_id = Auth::user()->id;
                        $task_details_assigned->status = 1;
                        $task_details_assigned->is_active = 1;
                        $task_details_assigned->is_responsible = 1;
                        if($task_details_assigned->save())
                        {
                            $is_update = 1;
                        }
                    }else{
                        $task_assign_res_users = $task_assign_res_users->first();

                        $task_assign_res_users->task_detail_id = $task_detail_id;
                        $task_assign_res_users->project_id = $request->project_id;
                        $task_assign_res_users->project_id = $request->project_id;
                        $task_assign_res_users->assign_user_id = $request->responsible_person;
                        $task_assign_res_users->assigned_by_user_id = Auth::user()->id;
                        $task_assign_res_users->status = 1;
                        $task_assign_res_users->is_active = 1;
                        $task_assign_res_users->is_responsible = 1;
                        if($task_assign_res_users->update())
                        {
                            $is_update = 1;
                        }
                    }

                    if($is_update == 1)
                    {
                        if(isset($request->participant) && count($request->participant) > 0)
                        {
                            foreach($request->participant as $participant)
                            {
                                $task_assign_users = AssignUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('assign_user_id',$participant)->where('is_removed',0);

                                if(!$task_assign_users->exists())
                                {
                                    $task_details_assign = new AssignUserDetail;
                                    $task_details_assign->task_detail_id = $task_detail_id;
                                    $task_details_assign->project_id = $request->project_id;
                                    $task_details_assign->project_id = $request->project_id;
                                    $task_details_assign->assign_user_id = $participant;
                                    $task_details_assign->assigned_by_user_id = Auth::user()->id;
                                    $task_details_assign->status = 1;
                                    $task_details_assign->is_active = 1;
                                    $task_details_assign->save();
                                }else{
                                    $task_assign_users = $task_assign_users->first();
                                    $task_assign_users->task_detail_id = $task_detail_id;
                                    $task_assign_users->project_id = $request->project_id;
                                    $task_assign_users->project_id = $request->project_id;
                                    $task_assign_users->assign_user_id = $participant;
                                    $task_assign_users->assigned_by_user_id = Auth::user()->id;
                                    $task_assign_users->status = 1;
                                    $task_assign_users->is_active = 1;
                                    $task_assign_users->update();
                                }
                            }
                        }

                        $task_delete_users = AssignObserverUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('is_removed',0)->get();

                        if(isset($task_delete_users) && count($task_delete_users) > 0)
                        {
                            foreach($task_delete_users as $task_remove)
                            {
                                if(!in_array($task_remove->assign_user_id,$request->observer))
                                {
                                    $task_delete_users = AssignObserverUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('observer_user_id',$task_remove->observer_user_id)->where('is_removed',0)->first();
                                    $task_delete_users->is_removed = 1;
                                    $task_delete_users->removed_date = date('Y-m-d h:i:s');
                                    $task_delete_users->update();
                                }
                            }
                        }

                        if(isset($request->observer) && count($request->observer) > 0)
                        {
                            foreach($request->observer as $observer)
                            {
                                $task_observer_users = AssignObserverUserDetail::where('project_id',$request->project_id)->where('task_detail_id',$task_detail_id)->where('observer_user_id',$observer)->where('is_removed',0);

                                if(!$task_observer_users->exists())
                                {
                                    $task_details_observer = new AssignObserverUserDetail;
                                    $task_details_observer->task_detail_id = $task_detail_id;
                                    $task_details_observer->project_id = $request->project_id;
                                    $task_details_observer->project_id = $request->project_id;
                                    $task_details_observer->observer_user_id = $observer;
                                    $task_details_observer->add_by_user_id = Auth::user()->id;
                                    $task_details_observer->status = 1;
                                    $task_details_observer->is_active = 1;
                                    $task_details_observer->save();
                                }else{
                                    $task_observer_users = $task_observer_users->first();
                                    $task_observer_users->task_detail_id = $task_detail_id;
                                    $task_observer_users->project_id = $request->project_id;
                                    $task_observer_users->project_id = $request->project_id;
                                    $task_observer_users->observer_user_id = $observer;
                                    $task_observer_users->add_by_user_id = Auth::user()->id;
                                    $task_observer_users->status = 1;
                                    $task_observer_users->is_active = 1;
                                    $task_observer_users->update();
                                }
                            }
                        }
                    }
                    session()->put('success','Sub Task Created successfully');
                }else{
                    session()->put('error','Failed to create sub task. Please try again');
                }
            }
        }else{
            session()->put('error','Invalid call to url');
        }
        return redirect()->back();
    }
    public function taskDetailsList($id)
    {
        if(!empty($id))
        {
            $id = decrypt($id);
            $task_details = DB::table('task_details')->where('is_delete',0)->where('project_id',$id)->orderBy('project_id','desc')->get();

            $task_details_deadline1 = DB::select('select * from `task_details` where `end_date` < `task_end_date` and project_id = '.$id.' and `is_delete` = 0 order by `project_id` desc');

            $task_details_deadline2 = DB::select('select * from `task_details` where `end_date` < "'.date('Y-m-d').'" and is_complete in (1,2,3) and project_id = '.$id.' and `is_delete` = 0 order by `project_id` desc');

            $task_details_deadline = array_merge($task_details_deadline1,$task_details_deadline2);

            $task_details_planned = DB::table('task_details')->where('project_id',$id)->where('is_complete',0)->orderBy('project_id','desc')->get();

            $task_details_closes = DB::table('task_details')->where('project_id',$id)->where('is_complete',4)->orderBy('project_id','desc')->get();

            $task_details_progress = DB::table('task_details')->where('project_id',$id)->whereIn('is_complete',[1,2,3])->orderBy('project_id','desc')->get();

            $project_details = DB::table('project_masters')->where('id',$id)->first();

            return view('task.task_list',compact('task_details','task_details_deadline','task_details_planned','task_details_closes','task_details_progress','project_details'));
        }else{
            return redirect()->back();
        }
    }
}
