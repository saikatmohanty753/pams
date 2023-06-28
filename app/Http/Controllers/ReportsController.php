<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class ReportsController extends Controller
{
    public function index()
    {
        $start_date = '';
        $end_date = '';
        $status = '';
        $user_id = '';
        $dept_id = '';
        $sub_dept_id = '';
        return view('reports.index',compact('start_date','end_date','status','user_id','dept_id','sub_dept_id'));
    }
    public function getReportList(Request $request)
    {
        $task_details = DB::table('task_details')->where('is_delete',0);
        $start_date = '';
        $end_date = '';
        $status = '';
        $user_id = '';
        $dept_id = '';
        $sub_dept_id = '';
        if(!empty($request->start_date))
        {
            $start_date = $request->start_date;
            $task_details->whereDate('start_date','>=',$request->start_date);
        }
        if(!empty($request->end_date))
        {
            $end_date = $request->end_date;
            $task_details->whereDate('end_date','<=',$request->end_date);
        }
        if(!empty($request->task_start_date))
        {
            $task_start_date = $request->task_start_date;
            $task_details->whereDate('task_start_date','>=',$request->task_start_date);
        }
        if(!empty($request->task_end_date))
        {
            $task_end_date = $request->task_end_date;
            $task_details->whereDate('task_end_date','<=',$request->task_end_date);
        }
        if(isset($request->status) && $request->status!='')
        {
            $status = $request->status;
            $task_details->where('is_complete',$request->status);
        }
        if(!empty($request->user_id))
        {
            $user_id = $request->user_id;

            $assign = DB::table('assign_users_details')->where('assign_user_id',$request->user_id)->where('is_removed',0)->pluck('task_detail_id')->toArray();

            $observe = DB::table('assign_observer_users_details')->where('observer_user_id',$request->user_id)->where('is_removed',0)->pluck('task_detail_id')->toArray();

            $task_arr = array_merge($assign,$observe);

            $task_details->whereIn('id',$assign);
        }else{
            if(!in_array(Auth::user()->dept_id,[7]))
            {
                if(in_array(Auth::user()->tier_user,[1,2]))
                {
                    $task_details->where('dept_id',Auth::user()->dept_id);
                }else{
                    $assign = DB::table('assign_users_details')->where('assign_user_id',Auth::user()->id)->where('is_removed',0)->pluck('task_detail_id')->toArray();
                    $observe = DB::table('assign_observer_users_details')->where('observer_user_id',Auth::user()->id)->where('is_removed',0)->pluck('task_detail_id')->toArray();

                    $task_arr = array_merge($assign,$observe);

                    $task_details->whereIn('id',$assign);
                }

            }
        }
        if(!empty($request->dept_id))
        {
            $dept_id = $request->dept_id;

            //$projects = DB::table('departs_project_details')->where('dept_id',$request->dept_id)->pluck('project_id')->toArray();
            $task_details->where('dept_id',$dept_id);
        }
        if(!empty($request->sub_dept_id))
        {
            $sub_dept_id = $request->sub_dept_id;

            $projects = DB::table('sub_depts_project_details')->where('sub_dept_id',$request->sub_dept_id)->pluck('project_id')->toArray();
            $task_details->whereIn('project_id',$projects);
        }
        $task_details = $task_details->get();
        return response()->json([view('reports.report_list_ajax',compact('task_details','start_date','end_date','status','user_id','dept_id','sub_dept_id'))->render()]);
    }
    public function projectWiseList()
    {
        return view('reports.project_wise');
    }
    public function projectWiseListAjax(Request $request)
    {
        $estimate_start_date = (!empty($request->start_date))?$request->start_date:'';
        $estimate_end_date = (!empty($request->end_date))?$request->end_date:'';
        $actual_start_date = (!empty($request->actual_start_date))?$request->actual_start_date:'';
        $actual_end_date = (!empty($request->actual_end_date))?$request->actual_end_date:'';
        $dept_id = (!empty($request->dept_id))?$request->dept_id:'';
        $sub_dept_id = (!empty($request->sub_dept_id))?$request->sub_dept_id:'';
        $projects = DB::table('project_masters')->where([['is_deleted',0]]);
        if(!empty($estimate_start_date))
        {
            $projects->whereDate('estimate_start_date','>=',$estimate_start_date);
        }
        if(!empty($estimate_end_date))
        {
            $projects->whereDate('estimate_end_date','<=',$estimate_end_date);
        }
        if(!empty($actual_start_date))
        {
            $projects->whereDate('actual_start_date','<=',$actual_start_date);
        }
        if(!empty($actual_end_date))
        {
            $projects->whereDate('actual_end_date','>=',$actual_end_date);
        }
        if(!empty($dept_id))
        {
            $assign_depts = DB::table('departs_project_details')->where('dept_id',$dept_id)->pluck('project_id')->toArray();

            if(!empty($assign_depts))
            {
                $projects->whereIn('id',$assign_depts);
            }
        }
        if(!empty($sub_dept_id))
        {
            $assign_depts = DB::table('sub_depts_project_details')->where('sub_dept_id',$sub_dept_id)->pluck('project_id')->toArray();

            if(!empty($assign_depts))
            {
                $projects->whereIn('id',$assign_depts);
            }
        }
        $projects = $projects->orderBy('id','desc')->get();
        $depts = DB::table('departments')->pluck('name','id');
        return response()->json([view('reports.project_wise_ajax',compact('projects','depts','dept_id','sub_dept_id'))->render()]);
    }
    public function getProjectWiseReportList(Request $request)
    {
        $task_details = DB::table('task_details')->where('is_delete',0);
        $start_date = '';
        $end_date = '';
        $status = '';
        $user_id = '';
        $dept_id = '';
        $sub_dept_id = '';
        if(!empty($request->start_date))
        {
            $start_date = $request->start_date;
            $task_details->whereDate('start_date','>=',$request->start_date);
        }
        if(!empty($request->end_date))
        {
            $end_date = $request->end_date;
            $task_details->whereDate('end_date','<=',$request->end_date);
        }
        if(isset($request->status) && $request->status!='')
        {
            $status = $request->status;
            $task_details->where('is_complete',$request->status);
        }
        if(!empty($request->user_id))
        {
            $user_id = $request->user_id;

            $assign = DB::table('assign_users_details')->where('assign_user_id',$request->user_id)->where('is_removed',0)->pluck('task_detail_id')->toArray();

            $observe = DB::table('assign_observer_users_details')->where('observer_user_id',$request->user_id)->where('is_removed',0)->pluck('task_detail_id')->toArray();

            $task_arr = array_merge($assign,$observe);

            $task_details->whereIn('id',$task_arr);
        }else{
            if(!in_array(Auth::user()->dept_id,[7]))
            {
                $assign = DB::table('assign_users_details')->where('assign_user_id',Auth::user()->id)->where('is_removed',0)->pluck('task_detail_id')->toArray();

                $observe = DB::table('assign_observer_users_details')->where('observer_user_id',Auth::user()->id)->where('is_removed',0)->pluck('task_detail_id')->toArray();

                $task_arr = array_merge($assign,$observe);

                $task_details->whereIn('id',$task_arr);
            }
        }
        if(!empty($request->dept_id))
        {
            $dept_id = $request->dept_id;

            $projects = DB::table('departs_project_details')->where('dept_id',$request->dept_id)->pluck('project_id')->toArray();
            $task_details->whereIn('project_id',$projects);
        }
        if(!empty($request->sub_dept_id))
        {
            $sub_dept_id = $request->sub_dept_id;

            $projects = DB::table('sub_depts_project_details')->where('sub_dept_id',$request->sub_dept_id)->pluck('project_id')->toArray();
            $task_details->whereIn('project_id',$projects);
        }
        $task_details = $task_details->get();
        return response()->json([view('reports.report_list_ajax',compact('task_details','start_date','end_date','status','user_id','dept_id','sub_dept_id'))->render()]);
    }
    public function otherReport(Request $request)
    {
        return view('reports.other_report');
    }

    public function otherReportAjax(Request $request)
    {
        if(!in_array(Auth::user()->tier_user,[1]))
        {
            $reports = DB::table('daily_report_details')->where('created_by',Auth::user()->id);
        }else{
            $reports = DB::table('daily_report_details')->where('is_active',1);
        }

        if(!empty($request->user_id))
        {
            $reports->where('created_by',$request->user_id);
        }
        if(!empty($request->start_date))
        {
            $reports->whereDate('start_date','>=',$request->start_date);
        }
        if(!empty($request->end_date))
        {
            $reports->where('end_date','<=',$request->end_date);
        }
        $reports = $reports->get();
        return response()->json([view('reports.other_report_ajax',compact('reports'))->render()]);
    }
}
