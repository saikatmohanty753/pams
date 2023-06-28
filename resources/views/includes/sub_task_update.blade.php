@php
    $responsible_persons = DB::table('users')->where('dept_id',$subtsk->dept_id)->where([['is_deleted',0],['role_id','!=',1]])->whereIn('tier_user',[3,2])->get();
@endphp
<div id="mysubupdateModal{{ $subtsk->id }}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header label-primary">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="color:white">Update Sub Task</h4>
        </div>
        <form action="{{ route('update-task') }}" method="POST" class="formSave">
        @csrf
        <input type="hidden" name="project_id" value="{{ $subtsk->project_id }}">
        <input type="hidden" name="id" value="{{ $subtsk->id }}">
        @can('task-edit')
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 z-index">
                    <label>Title: <span style="color: red">*</span></label>
                    <input type="text" class="form-control" name="title" placeholder="Enter the task tittle" value="{{ $subtsk->task_subject }}" autocomplete="off">
                </div>
                @if(!in_array(Auth::user()->role_id,[1,2,4]))
                
                @php
                $users = $users = DB::table('users')->where([['is_deleted',0],['role_id','!=',1]])->whereIn('tier_user',[3,2])->get();
                @endphp
                <input name="dept_id" type="hidden" value="{{ $subtsk->dept_id }}">
                @else
                @php
                    $users = array();
                @endphp

                <div class="col-md-6 z-index">
                    <label for="dept_id">Department <span style="color: red">*</span></label>
                    <select name="dept_id" id="dept_id_update{{ $subtsk->id }}" class="form-control select2"  style="width: 100%;" onchange="getDepartmentUserUpdate(this.value,{{ $subtsk->id }})" required>
                        <option value="">Select</option>
                        @if(isset($departments) && count($departments) > 0)
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}" @if(!empty($subtsk->dept_id) && $subtsk->dept_id == $department->id) selected @endif>{{ $department->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                @endif
            </div>
                @php
                    $usersObserve = getTableAll('users',[['is_active',1],['is_deleted',0],['id','!=',1]]);

                    $participants = getPluck('assign_users_details',[['task_detail_id',$subtsk->id],['is_active',1],['is_responsible',0],['is_removed',0] ],'assign_user_id')->toArray();

                    $observers = getPluck('assign_observer_users_details',[['task_detail_id',$subtsk->id],['is_active',1],['is_removed',0]],'observer_user_id')->toArray();
                @endphp
            <div class="row">
                <div class="col-md-6 z-index">
                    <label>Participants: </label>
                    <select class="select2 form-control z-index" name="participant[]" multiple="multiple" style="width: 100%;z-index: 9999;" id="participant_update{{ $subtsk->id }}">
                        @if(isset($responsible_persons) && count($responsible_persons) > 0)
                        @foreach($responsible_persons as $user)
                        <option value="{{ $user->id }}" @if(!empty($participants) && in_array($user->id,$participants)) selected @endif>{{ getUserName($user->id) }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6 z-index">
                    <label>Responsible Person: <span style="color: red">*</span></label>
                    <select class="select2 form-control" name="responsible_person" style="width: 100%;" id="responsible_person_update{{ $subtsk->id }}"  required>
                        @if(isset($responsible_persons) && count($responsible_persons) > 0)
                        @foreach($responsible_persons as $user)
                        <option value="{{ $user->id }}" @if(!empty($subtsk->responsible_person) && $subtsk->responsible_person == $user->id) selected @endif>{{ getUserName($user->id) }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 z-index">
                    <label>Observer:</label>
                    <select class="select2 form-control" name="observer[]" multiple="multiple" style="width: 100%;">
                        @if(isset($usersObserve) && count($usersObserve) > 0)
                        @foreach($usersObserve as $user)
                        <option value="{{ $user->id }}" @if(!empty($observers) && in_array($user->id,$observers)) selected @endif>{{ getUserName($user->id) }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Start date: <span style="color: red">*</span></label>
                    <input type="datetime-local" class="form-control" name="start_date" placeholder="Enter the start date" autocomplete="off" value="{{ $subtsk->start_date }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="float: inherit;">
                    <label>End date: <span style="color: red">*</span></label>
                    <input type="datetime-local" class="form-control" name="end_date" placeholder="Enter the end date" autocomplete="off" value="{{ $subtsk->end_date }}">
                </div>
                
                <div class="col-md-12">
                    <label>Description: <span style="color: red">*</span></label>
                    <textarea class="summernote" name="description">{{ $subtsk->task_description }}</textarea>
                </div>
            </div>
        </div>
        @endcan
        <div class="modal-footer">
            @can('task-edit')
            @if(Auth::user()->id == $subtsk->created_by)
            <button type="submit" class="btn btn-info">Update</button>
            @endif
            @endcan
            @can('task-delete')
            @if(Auth::user()->id == $subtsk->created_by)
            <a href="{{ route('delete-task',[encrypt($subtsk->id)]) }}" onclick="return confirm('Are you sure ?')" class="btn btn-danger">Delete</a>
            @endif
            @endcan
            <button type="button" id="update_task" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
     </form>
    </div>
</div>
