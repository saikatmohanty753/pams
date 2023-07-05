<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;
use App\Models\ProjectMaster;
use App\Models\ProjectAssignDetail;
use App\Models\ReportingDesigDetail;
use Illuminate\Support\Facades\Log;
use DB;
use Mail;
use App\Mail\SendNotificationMail;

class UsersController extends Controller
{
    private $errors = array();

    public function __construct()
    {
        /* $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['addUser', 'updateUser','']]); */

        $this->middleware('permission:user-create', ['only' => ['addUser', 'updateUser']]);

        $this->middleware('permission:user-edit', ['only' => ['updateUser']]);

        $this->middleware('permission:user-delete', ['only' => ['deleteUser']]);
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
    public function forgotPassword(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'email'=>'required|email'
            ]);
            $users = User::where('email',$request->email);
            $password = 'Oasys@'.rand(1000,9999);
            if($users->exists())
            {
                $users = $users->first();
                $users->password = Hash::make($password);
                if($users->update())
                {
                    $subject = 'Forgot Password';
                    $details = [
                        'email'=>$request->email,
                        'password'=>'Oasys@1234',
                        'title'=>'Your new password'
                    ];
                    try {
                        Mail::to($request->email)->send(new SendNotificationMail($subject,$details));
                        session()->put('success','Your password has been sent to your registered email id. Please check your mail to login');
                    } catch (\Throwable $th) {
                        session()->put('error','Failed to gernerate new password. Please try again');
                    }
                }
            }else{
                session()->put('error','Email Id is not registered');
            }
            return redirect()->back();
        }
        return view('users.forgot_password');
    }

    public function changePassword(Request $request)
    {
        if($request->method() == 'POST')
        {
            $request->validate([
                'old_password'=>'required',
                'new_password'=>'required',
                'confirm_password'=>'required',
            ]);

            $user = User::where('id',Auth::user()->id)->first();
            $email = $user->email;
            if(Hash::check($request->old_password, $user->password))
            {
                if($request->new_password == $request->confirm_password)
                {
                    $user->password = Hash::make($request->new_password);
                    if($user->update())
                    {
                        $subject = 'Reset Password';
                        $details = [
                            'email'=>$email,
                            'password'=>$request->new_password,
                            'title'=>'Your new password'
                        ];
                        try {
                            Mail::to($email)->send(new SendNotificationMail($subject,$details));
                        } catch (\Throwable $th) {
                        }
                        return redirect('change-msg-password');
                    }
                }
            }else{
                session()->put('error','Invalid old password');
                return redirect()->back();
            }
        }
        return view('users.change_password');
    }

    public function login(Request $request)
    {
        if($request->method() == "POST")
        {
            $request->validate([
                'email'=>'required|email',
                'password'=>'required',
                'captcha'=>'required|captcha',
            ],[
                'email.required'=>'Please enter the email id',
                'email.email'=>'Please provide the valid email id',
                'password.required'=>'Please enter the password',
                'captcha.captcha'=>'captcha is invalid'
            ]);

            $user = User::where('email',$request->email)->where('is_active',1);
            if($user->exists())
            {
                $user = $user->first();
                if(Hash::check($request->password, $user->password))
                {
                    Auth::login($user);
                    session()->put('user',$user);
                    return redirect('/dashboard');
                }
            }else{
                return redirect()->back()->withErrors(['Invalid login and password'])->withInput();
            }
        }
        return redirect()->back()->with('error','Invalid Email id and password');
    }

    public function updateProfile(Request $request)
    {
        if($request->method() == 'POST')
        {
            $user = User::where('id',Auth::user()->id)->where('is_active',1)->first();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->mobile_no = $request->mobile_no;
            $user->alt_mobile_no = $request->alt_mobile_no;
            $emp_code = 'new_emp';
            if(!empty($emp_code))
            {
                $emp_code = $user->emp_code;
            }
            $fileName = '';
            if($request->hasFile('profile_pic'))
            {
                $file = $request->file('profile_pic');
                if(!in_array($file->getClientOriginalExtension(),['jpg','png','jpeg']))
                {
                    return response()->json(['status'=>0,'msg'=>'Please upload profile pic in jpg,jpeg or png format']);
                }
                $fileName = $emp_code.'_'.time().'.'.$file->getClientOriginalExtension();
                $destinationPath = public_path().'/users';
                $file->move($destinationPath,$fileName);
                $user->profile_pic = $fileName;
            }
            if(!empty($request->dob))
            {
                $user->dob = $request->dob;
            }
            if($user->update())
            {
                return response()->json(['status'=>1,'msg'=>'Updated successfully','img'=>$fileName]);
            }else{
                return response()->json(['status'=>0,'msg'=>'Failed to update','img'=>$fileName]);
            }
        }
        return response()->json(['status'=>0,'msg'=>'Failed to update as method is not valid','img'=>$fileName]);
    }
    public function index()
    {
        return view('masters.add_user');
    }
    public function addUser(Request $request)
    {
        if($request->method() == 'POST')
        {
            $valid = $request->validate([
                'first_name'=>'required',
                'last_name'=>'required',
                'emp_code'=>'required|unique:users,emp_code',
                'email'=>'required|unique:users,email|email',
                'mobile_no'=>'required',
                'dob'=>'required|date',
                'role_id'=>'required',
                'reporting_id'=>'required',
                'desig_id'=>'required',
                'dept_id'=>'required',
                'tier_user'=>'required',
            ],[
                'emp_code.required'=>'Please enter the employee code',
                'first_name.alpha'=>'First Name must not be a number',
                'last_name.alpha'=>'Last Name must not be a number',
                'role_id.required'=>'Please select the role',
                'reporting_id.required'=>'Please select reporting designation',
                'desig_id.required'=>'Please select the designation',
                'dept_id.required'=>'Please select the department',
                'tier_user.required'=>'Please select the user tier',
            ]);

            /* $reporting_id = getTableName('reporting_desig_details',[['dept_id',$request->dept_id],['desig_id',$request->desig_id],['is_active',1],['is_delete',0]],'reporting_id'); */

            /* if(empty($reporting_id))
            {
                session()->put('error','Please assign reporting designation against selected designation');
                return redirect()->back();
            } */
            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->role_id = $request->role_id;
            $user->desig_id = $request->desig_id;
            $user->dept_id = $request->dept_id;
            $user->reporting_id = (!empty($request->reporting_id))?$request->reporting_id:0;
            $user->last_name = $request->last_name;
            $user->emp_code = $request->emp_code;
            $user->email = $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->dob = $request->dob;
            $user->alt_mobile_no = $request->alt_mobile_no;
            $user->is_active = $request->is_active;
            $user->tier_user = $request->tier_user;
            if(!empty($request->sub_dept_id))
            {
                $user->sub_dept_id = $request->sub_dept_id;
            }
            //$password = 'Oasys@'.rand(1000,9999);
            $password = 12345;
            $user->password = Hash::make($password);

            if($user->save())
            {
                $user->assignRole($request->input('role_id'));

                $subject = 'Login Credentials';
                $details = [
                    'email'=>$request->email,
                    'password'=>$password,
                    'title' => 'Login Credentials'
                ];
                try {
                    Mail::to($request->email)->send(new SendNotificationMail($subject,$details));
                    session()->put('success','Your password has been sent to your registered email id. Please check your mail to login');
                } catch (\Throwable $th) {
                    session()->put('error','Failed to gernerate new password. Please try again');
                }
                session()->put('success','User Added successfully');
                return redirect()->back();
            }else{
                session()->put('error','Failed to added user. Please try again');
                return redirect()->back();
            }
        }

        return view('masters.add_user');
    }

    public function updateUser(Request $request,$id='')
    {
        if($request->method() == 'POST')
        {
            if(empty($request->id))
            {
                session()->put('error','Unauthorized user');
                return redirect()->back();
            }
            $request->validate([
                'email'=>'required|unique:users,email,'.$request->id,
                'emp_code'=>'required|unique:users,emp_code,'.$request->id,
                'first_name'=>'required',
                'last_name'=>'required',
                'dept_id'=>'required',
                'desig_id'=>'required',
                'role_id'=>'required',
                'mobile_no'=>'required',
                'reporting_id'=>'required',
                'tier_user'=>'required',
            ]);

            /* $reporting_id = getTableName('reporting_desig_details',[['desig_id',$request->desig_id],['dept_id',$request->dept_id],['is_active',1],['is_delete',0]],'reporting_id');
            if(empty($reporting_id))
            {
                session()->put('error','Please assign reporting designation against selected designation');
                return redirect()->back();
            } */
            $user = User::where('id',$request->id)->first();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->dept_id = $request->dept_id;
            $user->role_id = $request->role_id;
            $user->desig_id = $request->desig_id;
            $user->reporting_id = $request->reporting_id;
            $user->last_name = $request->last_name;
            $user->emp_code = $request->emp_code;
            $user->email = $request->email;
            $user->mobile_no = $request->mobile_no;
            $user->dob = $request->dob;
            $user->alt_mobile_no = $request->alt_mobile_no;
            $user->is_active = $request->is_active;
            $user->tier_user = $request->tier_user;
            if(!empty($request->sub_dept_id))
            {
                $user->sub_dept_id = $request->sub_dept_id;
            }else{
                $user->sub_dept_id = null;
            }
            if($user->update())
            {
                $user->assignRole($request->input('role_id'));
                session()->put('success','User Updated successfully');
            }else{
                session()->put('error','Failed to update. please try again');
            }
            return redirect()->route('addUser');
        }
        $id = decrypt($id);
        $usersdata = getTable('users',array('id'=>$id));
        return view('masters.edit_user',compact('usersdata'));
    }

    public function deleteUser(Request $request,$id='')
    {
        $id = decrypt($id);
        $delete_user = User::where('id',$id);
        if($delete_user->exists())
        {
            $delete_user = $delete_user->first();
            $delete_user->is_active = 0;
            $delete_user->is_deleted = 1;
            $delete_user->delete_date = date('Y-m-d h:i:s');
            if($delete_user->update())
            {
                session()->put('success','Deleted successfully');
                Log::critical('User '.$delete_user->first_name.' '.$delete_user->last_name .' ('.$id.') deleted by '.Auth::user()->first_name.' '.Auth::user()->last_name.' of user id ('.Auth::user()->id.') on '.date('Y-m-d h:i:s'));
                return redirect()->back();
            }
        }
    }
    public function usrAllowTimeElapsed(Request $request)
    {
        if(!empty($request->key))
        {
            $user = User::where('id',$request->key);
            if($user->exists())
            {
                $user = $user->first();
                if($user->is_allowed_time_elapsed == 1)
                {
                    $user->is_allowed_time_elapsed = 0;
                    if($user->update()){
                        return response()->json(['status'=>1]);
                    }
                }
                if($user->is_allowed_time_elapsed == 0)
                {
                    $user->is_allowed_time_elapsed = 1;
                    if($user->update()){
                        return response()->json(['status'=>1]);
                    }
                }
            }
        }
        return response()->json(['status'=>0]);
    }
}
