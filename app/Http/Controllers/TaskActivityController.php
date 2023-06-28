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
use App\Models\CommentDetail;
use App\Models\TaskDelayReason;
use App\Models\ReopenLog;
use App\Models\TimeElapseDetail;
use App\Models\DailyReportDetail;
use App\Models\ReplyMsgDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use DB;
use Auth;

class TaskActivityController extends Controller
{
    public function index($id='')
    {
        $project = null;
        $task_details = null;
        if(!empty($id))
        {
            $id = decrypt($id);
            
            $project = ProjectMaster::where('id',$id);
            if($project->exists())
            {
                $project = $project->first();
                $task_details = getTaskDetails($id);
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
        $departments = getTableAll('departments',['is_active'=>1]);
        return view('task_activities.index',compact('project','task_details','departments'));
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
        return view('task_activities.task_view',compact('task_details'));
    }

    public function startTask(Request $request)
    {
        $response = array('status'=>0,'message'=>'Failed to start the task. Please try again');
        if($request->method() == 'POST')
        {
            if(!empty($request->taskKey))
            {
                $task_details = TaskDetail::where('id',$request->taskKey);
                if($task_details->exists())
                {
                    $task_details = $task_details->first();
                    $task_details->is_complete = 1;
                    $task_details->task_start_date = date('Y-m-d h:i:s');
                    $task_details->started_by = Auth::user()->id;
                    if($task_details->update())
                    {
                        $response = array('status'=>1,'message'=>'Task Started successfully');
                    }
                }
            }
        }
        return response()->json($response);
    }

    public function saveComment(Request $request)
    {
        $response = array('status'=>0,'message'=>'');
        if(!empty($request->comment))
        {
            $comment = new CommentDetail;
            $comment->project_id = $request->project_id;
            $comment->task_detail_id = $request->task_id;
            $comment->comment = $request->comment;
            $comment->created_by = Auth::user()->id;
            $comment->commented_on = date('Y-m-d h:i:s');
            if($comment->save())
            {
                $comments = DB::table('comment_details')->where('project_id',$request->project_id)->where('task_detail_id',$request->task_id)->whereDate('commented_on',date('Y-m-d'))->get();

                $data[date('Y-m-d')] = serialize($comments);

                Storage::disk('local')->put('comments/task_detail_id_'.$request->task_id.'.txt', serialize($data));

                $response = array('status'=>1,'message'=>getUserName(Auth::user()->id).' : '.$request->comment);
            }
        }
        return response()->json($response);
    }
    public function finishTask(Request $request)
    {
        $response = array('status'=>0,'message'=>'Failed to finish the task. Please try again');
        if($request->method() == 'POST')
        {
            if(!empty($request->task_id))
            {
                $task_details = TaskDetail::where('id',$request->task_id);
                if($task_details->exists())
                {
                    $task_details = $task_details->first();
                    if(Auth::user()->id == $task_details->created_by)
                    {
                        $task_details->is_complete = 4;
                        $task_details->task_end_date = date('Y-m-d h:i:s');
                        $task_details->finished_by = Auth::user()->id;
                        if($task_details->update())
                        {
                            $response = array('status'=>1,'message'=>'Task Finished successfully');
                        }
                    }else{
                        $task_details->is_complete = 3;
                        $task_details->assigned_user_end_date = date('Y-m-d h:i:s');
                        $task_details->completed_by_assigned_user = Auth::user()->id;
                        if($task_details->update())
                        {
                            $response = array('status'=>1,'message'=>'Task Finished successfully');
                        }
                    }
                }
            }
        }
        return response()->json($response);
    }
    public function reopenTask(Request $request)
    {
        $response = array('status'=>0,'message'=>'Failed to Re-open the task. Please try again');
        if($request->method() == 'POST')
        {
            //dd($request->all());
            if(!empty($request->task_id))
            {
                $task_details = TaskDetail::where('id',$request->task_id);
                if($task_details->exists())
                {
                    $task_details = $task_details->first();
                    $project_id = $task_details->project_id;
                    $old_start_date = $task_details->start_date;
                    $old_end_date = $task_details->end_date;
                    if(Auth::user()->id == $task_details->created_by)
                    {
                        $task_details->is_complete = 2;
                        $task_details->assigned_user_end_date = null;
                        $task_details->completed_by_assigned_user = null;
                        $task_details->start_date = $request->start_date;
                        $task_details->end_date = $request->end_date;
                        $task_details->reopen_remark = $request->description;
                        $task_details->re_open_date = date('Y-m-d h:i:s');
                        if($task_details->update())
                        {
                            $logs_reopen = new ReopenLog;
                            $logs_reopen->task_id = $request->task_id;
                            $logs_reopen->start_date = $request->start_date;
                            $logs_reopen->end_date = $request->end_date;
                            $logs_reopen->old_start_date = $old_start_date;
                            $logs_reopen->old_end_date = $old_end_date;
                            $logs_reopen->reopen_remark = $request->description;
                            $logs_reopen->project_id = $project_id;
                            $logs_reopen->reopen_date = date('Y-m-d h:i:s');
                            $logs_reopen->created_by = Auth::user()->id;
                            $logs_reopen->save();
                            $response = array('status'=>1,'message'=>'Task Reopened successfully');
                        }
                    }
                }
            }
        }
        return response()->json($response);
    }

    public function getComment(Request $request)
    {
        $response = array('status'=>0,'message'=>'');
        //$comments =  CommentDetail::where('project_id',$request->project_id)->where('task_detail_id',$request->task_id)->whereDate('commented_on',date('Y-m-d'))->get();
        $comments =  $this->getFileRead('comments/task_detail_id_'.$request->task_id.'.txt');
        
        return response()->json([view('task_activities.comments',compact('comments'))->render()]);
    }

    public function delayReason(Request $request)
    {
        $response = array('status'=>0,'message'=>'Message '.$request->data.' failed to send');
        if($request->method() == 'POST')
        {
            if(!empty($request->taskKey))
            {
                $task_details = TaskDetail::where('id',$request->taskKey);
                if($task_details->exists())
                {
                    $task_details = $task_details->first();
                    $delay = new TaskDelayReason;
                    $delay->task_id = $task_details->id;
                    $delay->project_id = $task_details->project_id;
                    $delay->given_by = Auth::user()->id;
                    $delay->reason_date = date('Y-m-d h:i:s');
                    $delay->reason = $request->data;
                    if($delay->save())
                    {
                        $data = TaskDelayReason::where('task_id',$task_details->id)->where('project_id',$task_details->project_id)->get();

                        Storage::disk('local')->put('delays/task_detail_id_'.$task_details->id.'.txt', serialize($data));

                        $response = array('status'=>1,'message'=>'Message send successfully');
                    }
                }
            }
        }
        return response()->json($response);
    }

    public function showDelay(Request $request)
    {
        $response = array('status'=>0,'message'=>'');
        //$delays =  TaskDelayReason::where('project_id',$request->project_id)->where('task_id',$request->task_id)->get();
        $delays =  $this->getDeleyFileRead('delays/task_detail_id_'.$request->task_id.'.txt');
        
        return response()->json([view('task_activities.delay',compact('delays'))->render()]); 
    }
    public function getFileRead($filename)
    {
        if (Storage::disk('local')->exists($filename)) {
            $data = Storage::disk('local')->get($filename);
            $fileData = unserialize($data);
            
            if(!empty($fileData[date('Y-m-d')]))
            {
                $data = unserialize($fileData[date('Y-m-d')]);
            }else{
                return [];
            }
            
            return $data;
        }
        return [];
    }
    public function getDeleyFileRead($filename)
    {
        if (Storage::disk('local')->exists($filename)) {
            $data = Storage::disk('local')->get($filename);
            return unserialize($data);
        }
        return [];
    }

    public function getTimeElapsed(Request $request)
    {
        $response = array('status'=>1,'message'=>'Failed to save time elapse. Please try again!');
        if($request->method() == 'POST')
        {
            

            $task_details = DB::table('task_details')->where('id',$request->task_id)->first();

            
                                        
            if(!empty($request->time_els_id))
            {
                $time_elapsed =  TimeElapseDetail::where('id',$request->time_els_id);
                if($time_elapsed->exists())
                {
                    $time_elapsed = $time_elapsed->first();

                    $time_elapsed->project_id = $request->project_id; 
                    $time_elapsed->task_id = $request->task_id; 
                    $time_elapsed->start_date = $request->start_date; 
                    $time_elapsed->end_date = $request->end_date; 
                    $time_elapsed->remark = $request->remark; 
                    $time_elapsed->given_by = Auth::user()->id; 
                    if($time_elapsed->update())
                    {
                        
                        $response = array('status'=>1,'message'=>'Time elapse updated successfully');
                    }
                }
            }else{
                $time_elapsed = new TimeElapseDetail;
                $time_elapsed->project_id = $request->project_id; 
                $time_elapsed->task_id = $request->task_id; 
                $time_elapsed->start_date = $request->start_date; 
                $time_elapsed->end_date = $request->end_date; 
                $time_elapsed->remark = $request->remark; 
                $time_elapsed->given_by = Auth::user()->id; 
                if($time_elapsed->save())
                {
                    $response = array('status'=>1,'message'=>'Time elapse saved successfully');
                }
            }
        }
        return response()->json($response);
    }

    public function dailyReport()
    {
        $reportUsers = DailyReportDetail::where('is_active',1);
        if(!in_array(Auth::user()->role_id,[1,2]))
        {
            $reportUsers->where('created_by',Auth::user()->id);
        }
        $reportUsers = $reportUsers->select('created_by')->groupBy('created_by')->get();
        return view('task_activities.task_daily_report',compact('reportUsers'));
    }
    public function saveDailyReport(Request $request)
    {
        $response = array('status'=>0,'message'=>'error');
        if($request->method() == 'POST')
        {
            if($request->ajax())
            {
                $report = new DailyReportDetail;
                $report->remark = $request->remark;
                $report->title = $request->title;
                $report->start_date = $request->start_date;
                $report->end_date = $request->end_date;
                $report->created_by = Auth::user()->id;
                $report->given_on = date('Y-m-d h:i:s');
                $report->is_active = 1;
                if($report->save())
                {
                    $response = array('status'=>1,'message'=>'success');
                }
            }
        }
        return response()->json($response);
    }
    public function saveReplyDailyReport(Request $request)
    {
        $response = array('status'=>0,'message'=>'error');
        if($request->method() == 'POST')
        {
            if($request->ajax())
            {
                if(!empty($request->comments))
                {
                    $report = new ReplyMsgDetail;
                    $report->comments = $request->comments;
                    $report->report_id = $request->report_id;
                    $report->given_by = Auth::user()->id;
                    $report->given_on = date('Y-m-d h:i:s');
                    $report->is_read = 0;
                    if($report->save())
                    {
                        $response = array('status'=>1,'message'=>'success','data'=>getUserName(Auth::user()->id));
                    }
                }
            }
        }
        return response()->json($response);
    }
    public function isReplyReadDailyReport(Request $request)
    {
        $response = array('status'=>0,'message'=>'error');
        if($request->method() == 'POST')
        {
            if($request->ajax())
            {
                if(!empty($request->report_id))
                {
                    $report =  ReplyMsgDetail::where('report_id',$request->report_id)->where('is_read',0)->get();
                    if(isset($report) && count($report) > 0)
                    {
                        foreach($report as $rp)
                        {
                            $isRead = ReplyMsgDetail::where('id',$rp->id)->where('is_read',0)->first();
                            $isRead->is_read = 1;
                            if($isRead->update())
                            {
                                $response = array('status'=>1,'message'=>'success');
                            }
                        }
                    }
                    
                }
            }
        }
        return response()->json($response);
    }

}
