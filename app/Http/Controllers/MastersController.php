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
use App\Models\SubDepartment;
use App\Models\Designation;
use Illuminate\Support\Facades\Log;
use DB;
use Mail;
use App\Mail\SendNotificationMail;

class MastersController extends Controller
{
    
    public $errors = array();
    
    public function reportDesignation(Request $request)
    {
        return view('masters.add_reporting_desig');
    }

    public function editReportingDesignation($id)
    {
        $reporting = null;
        if(!empty($id))
        {
            $id = decrypt($id);
            $reporting = ReportingDesigDetail::where('id',$id)->first();
        }else{
            return redirect()->back();
        }
        return view('masters.edit_reporting_desig',compact('reporting'));
    }

    public function saveReportDesig(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'desig_id'=>'required',
                'reporting_id'=>'required',
                'dept_id'=>'required'
            ],[
                'reporting_id.required'=>'Please select reporting designation',
                'desig_id.required'=>'Please select the designation',
                'dept_id.required'=>'Please select the department'
            ]);

            $reporting = new ReportingDesigDetail;
            $reporting->desig_id = $request->desig_id;
            $reporting->reporting_id = $request->reporting_id;
            $reporting->dept_id = $request->dept_id;
            $reporting->created_by = Auth::user()->id;
            $reporting->is_active = $request->is_active;
            if($reporting->save())
            {
                session()->put('success','Reporting designation added successfully');
            }else{
                session()->put('error','Failed to add reporting designation. Please try again');
            }
        }else{
            session()->put('warning','Invalid method');
        }
        return redirect()->back();
    }

    public function updateReportDesig(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'desig_id'=>'required',
                'reporting_id'=>'required',
                'dept_id'=>'required'
            ],[
                'reporting_id.required'=>'Please select reporting designation',
                'desig_id.required'=>'Please select the designation',
                'dept_id.required'=>'Please select the department'
            ]);

            $reporting =  ReportingDesigDetail::where('id',$request->id);
            if($reporting->exists())
            {
                $reporting = $reporting->first();
                $reporting->desig_id = $request->desig_id;
                $reporting->reporting_id = $request->reporting_id;
                $reporting->dept_id = $request->dept_id;
                $reporting->created_by = Auth::user()->id;
                $reporting->is_active = $request->is_active;
                if($reporting->update())
                {
                    session()->put('success','Reporting designation updated successfully');
                }else{
                    session()->put('error','Failed to update reporting designation. Please try again');
                }
            }else{
                session()->put('warning','Invalid reporting designation details');
            }
        }else{
            session()->put('warning','Invalid method');
        }
        return redirect()->back();
    }

    public function deleteReportingDesignation($id)
    {
        if(!empty($id))
        {
            $id = decrypt($id);
            $deleteReport = ReportingDesigDetail::where('id',$id);
            if($deleteReport->exists())
            {
                $deleteReport = $deleteReport->first();
                $deleteReport->is_delete = 1;
                $deleteReport->deleted_date = date('Y-m-d h:i:s');
                if($deleteReport->update())
                {
                    session()->put('success','Reporting designation deleted successfully');
                }else{
                    session()->put('error','Failed to delete designation report');
                }
            }else{
                session()->put('warning','Reporting designation doesnot exist');
            }
        }
        return redirect()->back();
    }

    public function addDepartment(Request $request)
    {
        return view('masters.add_department');
    }

    public function saveDepartment(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'name'=>'required',
                'is_active'=>'required'
            ]);

            $department = new Department;
            $department->name = $request->name;
            $department->is_active = $request->is_active;
            if($department->save())
            {
                session()->put('success','Department added successfully');
            }else{
                session()->put('error','Failed to add department. Please try again');
            }
        }
        return redirect()->back();
    }

    public function editDepartment($id)
    {
        $departments = null;
        if(!empty($id))
        {
            $id = decrypt($id);
            $departments = Department::where('id',$id);
            if($departments->exists())
            {
                $departments = $departments->first();
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
        return view('masters.edit_department',compact('departments'));
    }

    public function updateDepartment(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'name'=>'required',
                'is_active'=>'required'
            ]);

            $department =  Department::where('id',$request->id);
            if($department->exists())
            {
                $department = $department->first();
                $department->name = $request->name;
                $department->is_active = $request->is_active;
                if($department->update())
                {
                    session()->put('success','Department updated successfully');
                }else{
                    session()->put('error','Failed to update department. Please try again');
                }
            }
        }
        return redirect('add-department');
    }

    public function addDesignation(Request $request)
    {
        return view('masters.add_designation');
    }

    public function saveDesignation(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'name'=>'required',
                'is_active'=>'required'
            ]);

            $designations = new Designation;
            $designations->name = $request->name;
            $designations->is_active = $request->is_active;
            if($designations->save())
            {
                session()->put('success','Designation added successfully');
            }else{
                session()->put('error','Failed to add designation. Please try again');
            }
        }
        return redirect()->back();
    }

    public function editDesignation($id)
    {
        $designations = null;
        if(!empty($id))
        {
            $id = decrypt($id);
            $designations = Designation::where('id',$id);
            if($designations->exists())
            {
                $designations = $designations->first();
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
        return view('masters.edit_designation',compact('designations'));
    }

    public function updateDesignation(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'name'=>'required',
                'is_active'=>'required'
            ]);

            $designations =  Designation::where('id',$request->id);
            if($designations->exists())
            {
                $designations = $designations->first();
                $designations->name = $request->name;
                $designations->is_active = $request->is_active;
                if($designations->update())
                {
                    session()->put('success','Designation updated successfully');
                }else{
                    session()->put('error','Failed to update designation. Please try again');
                }
            }
        }
        return redirect('add-designation');
    }

    public function subDepartment()
    {
        $departments = getTableAll('departments',['is_active'=>1]);
        return view('masters.add_sub_department',compact('departments'));
    }

    public function saveSubDepartment(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'dept_id'=>'required',
                'name'=>'required|unique:sub_departments,name',
                'is_active'=>'required'
            ],[
                'dept_id.required'=>'Please select the department',
                'name.required'=>'Please enter the sub department name',
                'is_active.required'=>'Please select the status'
            ]);

            $sub_department = new SubDepartment;
            $sub_department->dept_id = $request->dept_id;
            $sub_department->name = $request->name;
            $sub_department->is_active = $request->is_active;
            if($sub_department->save())
            {
                session()->put('succes','Sub department added successfully');
            }else{
                session()->put('error','Failed to add sub department. Please try again');
            }
        }else{
            session()->put('error','Invalid call to url');
        }
        return redirect()->back();
    }
    
    public function editSubDepartment($id)
    {
        if(!empty($id))
        {
            $id = decrypt($id);
            $sub_department =  SubDepartment::where('id',$id);
            if($sub_department->exists())
            {
                $sub_department = $sub_department->first();
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
        $departments = getTableAll('departments',['is_active'=>1]);
        return view('masters.edit_sub_department',compact('sub_department','departments'));
    }
    
    public function updateSubDepartment(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'dept_id'=>'required',
                'name'=>'required|unique:sub_departments,name,'.$request->id,
                'is_active'=>'required'
            ],[
                'dept_id.required'=>'Please select the department',
                'name.required'=>'Please enter the sub department name',
                'is_active.required'=>'Please select the status'
            ]);

            $sub_department =  SubDepartment::where('id',$request->id);
            if($sub_department->exists())
            {
                $sub_department = $sub_department->first();
                $sub_department->dept_id = $request->dept_id;
                $sub_department->name = $request->name;
                $sub_department->is_active = $request->is_active;
                if($sub_department->update())
                {
                    session()->put('succes','Sub department added successfully');
                }else{
                    session()->put('error','Failed to add sub department. Please try again');
                }
            }else{
                session()->put('error','Something went wrong. Please try again.');
            }
        }else{
            session()->put('error','Invalid call to url');
        }
        return redirect()->back();
    }

    public function getSubDepartment(Request $request)
    {
        $options = '<option value="">Select</option>';
        if(!empty($request->dept_id))
        {
            $sub_department = getTableAll('sub_departments',[['dept_id',$request->dept_id]]);
            if(isset($sub_department) && count($sub_department) > 0)
            {
                foreach($sub_department as $sub_dept)
                {
                    $options .= '<option value="'.$sub_dept->id.'">'.$sub_dept->name.'</option>';
                }
            }
        }
        return response()->json(['status'=>1,'data'=>$options]);
    }
}
