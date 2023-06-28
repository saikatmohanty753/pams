<?php

if(!function_exists('getTable'))
{
    function getTable($table='',$where=array())
    {
        $data = DB::table($table)->where($where)->first();
        return $data;
    }
}

if(!function_exists('getTableName'))
{
    function getTableName($table='',$where=array(),$column1='name')
    {
        $data = @DB::table($table)->where($where)->first()->$column1;
        return $data;
    }
}

if(!function_exists('getTableAll'))
{
    function getTableAll($table='',$where=array())
    {
        $data = DB::table($table)->where($where)->orderBy('id','desc')->get();
        return $data;
    }
}

if(!function_exists('getTableASCAll'))
{
    function getTableASCAll($table='',$where=array())
    {
        $data = DB::table($table)->where($where)->orderBy('id','asc')->get();
        return $data;
    }
}

if(!function_exists('getTaskDetails'))
{
    function getTaskDetails($projectId)
    {
        $data = DB::table('task_details')->where('project_id',$projectId)->where('type',1)->where('is_delete',0);
        if(Auth::user()->tier_user != 1)
        {
            if(!in_array(Auth::user()->role_id,[1,2]))
            {
                $data->where('dept_id',Auth::user()->dept_id);
            }
        }
        if(Auth::user()->tier_user == 1)
        {
            if(!in_array(Auth::user()->role_id,[1,2]))
            {
                $data->where('dept_id',Auth::user()->dept_id);
            }
        }
        $data = $data->get();
        return $data;
    }
}
if(!function_exists('getSubTaskDetails'))
{
    function getSubTaskDetails($parentaskId)
    {
        $data = DB::table('task_details')->where('parent_task_id',$parentaskId)->where('type',2)->where('is_delete',0);
        if(Auth::user()->tier_user != 1)
        {
            if(!in_array(Auth::user()->role_id,[1,2]))
            {
                $data->where('dept_id',Auth::user()->dept_id);
            }
        }
        if(Auth::user()->tier_user == 1)
        {
            if(!in_array(Auth::user()->role_id,[1,2]))
            {
                $data->where('dept_id',Auth::user()->dept_id);
            }
        }
        $data = $data->get();
        return $data;
    }
}

if(!function_exists('getPluck'))
{
    function getPluck($table='',$where=array(),$column1='',$column2='')
    {
        if(!empty($column1) && !empty($column2))
        {
            return DB::table($table)->where($where)->pluck($column2,$column1);
        }else{
            return DB::table($table)->where($where)->pluck($column1);
        }
    }
}

if(!function_exists('getAssignedProject'))
{
    function getAssignedProject($projectId='')
    {
        $name = '<ol>';
        $projectDetails = getTableAll('project_assign_details',[['project_id',$projectId]]);
        if(isset($projectDetails) && count($projectDetails) > 0)
        {
            foreach($projectDetails as $project)
            {
                $user = getTable('users',['id'=>$project->assign_to_user_id]);
                $name .= '<li>'.$user->first_name.' '.$user->last_name.' ( '.getTableName('designations',['id'=>$user->desig_id]).', '.getTableName('departments',['id'=>$user->dept_id]).' ) </li>';
            }
        }
        $name .= '</ol>';
        return $name;
    }
}

if(!function_exists('getAssignedProjectTask'))
{
    function getAssignedProjectTask($projectId='')
    {
        $name = '<ol>';
        $projectDetails = getTableAll('task_details',[['project_id',$projectId]]);
        if(isset($projectDetails) && count($projectDetails) > 0)
        {
            foreach($projectDetails as $project)
            {
                $name .= '<li>'.$project->task_subject.' ( '.$is_complete.' ) </li>';
            }
        }
        $name .= '</ol>';
        return $name;
    }
}

if(!function_exists('getStatus'))
{
    function getStatus($key)
    {
        $status = array('1'=>'Active','2'=>'In-active',''=>'Not available','0'=>'Not available');
        return $status[$key];
    }
}

if(!function_exists('getUserName'))
{
    function getUserName($userId='')
    {
        $user = getTable('users',['id'=>$userId]);

        $name = $user->first_name.' '.$user->last_name.' ( '.getTableName('designations',['id'=>$user->desig_id]).', '.getTableName('departments',['id'=>$user->dept_id]).' ) ';

        return $name;
    }
}

if(!function_exists('tierStatus'))
{
    function tierStatus($key='')
    {
        //$tiers = array('1' => 'Tier - 1', '2'=>'Tier - 2','3'=>'Tier - 3',''=>'Not available');
        $tier = '';
        switch($key)
        {
            case '1':
                $tier = 'Tier - 1';
                break;
            case '2':
                $tier = 'Tier - 2';
                break;
            case '3':
                $tier = 'Tier - 3';
                break;
            default:
                $tier = 'Not available';
                break;
        }
        return $tier;
    }
}

if(!function_exists('findInSet'))
{
    function findInSet($table='',$where=array(),$column='',$searchvalue)
    {
        $query = DB::table($table)
                    ->whereRaw('FIND_IN_SET(?, '.$column.')', [$searchvalue])
                    ->where($where)
                    ->first();
        return $query;
    }
}

if(!function_exists('getSubDeptArr'))
{
    function getSubDeptArr($project_id='',$dept_id='')
    {
        $sub_arr = array();
        $getSub = DB::table('sub_depts_project_details')->where('project_id',$project_id)->where('dept_id',$dept_id)->get();
        if(!empty($getSub))
        {
            foreach($getSub as $sub)
            {
                $sub_arr[] = $sub->sub_dept_id.'@@'.$sub->dept_id;
            }
        }
        return $sub_arr;
    }
}

if(!function_exists('getDeptArr'))
{
    function getDeptArr($project_id='')
    {
        $dept_arr = array();
        $getDept = DB::table('departs_project_details')->where('project_id',$project_id)->get();
        if(!empty($getDept))
        {
            foreach($getDept as $dept)
            {
                $dept_arr[] = $dept->dept_id;
            }
        }
        return $dept_arr;
    }
}

if(!function_exists('getDesignation'))
{
    function getDesignation($id)
    {
        $name = '';
        $designation = DB::table('designations')->where('id',$id)->first();
        if(!empty($designation->name))
        {
            $name = $designation->name;
        }
        return $name;
    }
}

if(!function_exists('timeDifference'))
{
    function timeDifference($endate)
    {
        $elapsed = '';
        $badge = 0;
        $data = array();
        $datetime1 = new DateTime();
        $datetime2 = new DateTime($endate);
        $interval = $datetime1->diff($datetime2);
        $min=$interval->format('%i');
        //$sec=$interval->format('%s');
        $hour=$interval->format('%h');
        $mon=$interval->format('%m');
        $day=$interval->format('%d');
        $year=$interval->format('%y');
        if($interval->invert == 1)
        {
            if($year!=0)
            {
                $elapsed .= $year.' Year ';

            }
            if($mon!=0)
            {
                $elapsed .= $mon.' Month ';

            }
            if($day!=0)
            {
                $elapsed .= $day.' Days ';

            }
            if($hour!=0)
            {
                $elapsed .= $hour.' Hours ';

            }
            if($min!=0)
            {
                $elapsed .= $min.' Minutes ';

            }

            if($year!=0 || $day != 0 || $hour > 3)
            {
                $badge = 1;
            }elseif($min != 0)
            {
                $badge = 2;
            }
        }

        $data['elapsed'] = $elapsed;
        $data['badge'] = $badge;
        return $data;
    }
}

if(!function_exists('timeTotalDifference'))
{
    function timeTotalDifference($startdate,$endate)
    {
        $elapsed = '';
        $badge = 0;
        $data = array();
        $datetime1 = new DateTime($startdate);
        $datetime2 = new DateTime($endate);
        $interval = $datetime1->diff($datetime2);
        $min=$interval->format('%i');
        //$sec=$interval->format('%s');
        $hour=$interval->format('%h');
        $mon=$interval->format('%m');
        $day=$interval->format('%d');
        $year=$interval->format('%y');
        if($interval->invert == 1)
        {
            if($year!=0)
            {
                $elapsed .= $year.' Year ';

            }
            if($mon!=0)
            {
                $elapsed .= $mon.' Month ';

            }
            if($day!=0)
            {
                $elapsed .= $day.' Days ';

            }
            if($hour!=0)
            {
                $elapsed .= $hour.' Hours ';

            }
            if($min!=0)
            {
                $elapsed .= $min.' Minutes ';

            }
            /* if($sec!=0)
            {
                $elapsed .= $sec.' Seconds ';

            } */

            if($year!=0 || $day != 0 || $hour > 3)
            {
                $badge = 1;
            }elseif($min != 0)
            {
                $badge = 2;
            }
        }

        $data['elapsed'] = $elapsed;
        $data['badge'] = $badge;
        return $data;
    }

    if(!function_exists('getUserFrmRemTknNotApi'))
    {
        function getUserFrmRemTknNotApi($remember_token)
        {
            $response = null;
            if(!empty($remember_token))
            {
                $user = User::where('remember_token',$remember_token)->where('is_active',1)->where('is_deleted',0);
                if($user->exists())
                {
                    $user = $user->first();
                    $response = $user;
                }
            }
            return $response;
        }
    }
}

if(!function_exists('calHours'))
{
    function calHours($startdate,$endate)
    {
        $d1= new DateTime($startdate); // first date
        $d2= new DateTime($endate); // second date
        $interval= $d1->diff($d2); // get difference between two dates
        return ($interval->days * 9) + $interval->h.' hrs '.$interval->m.' mins';
    }
}
