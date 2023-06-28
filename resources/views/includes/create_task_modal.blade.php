<div id="myModal{{ $project->id }}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header label-primary">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" style="color:white">Create Task</h4>
        </div>
        <form action="{{ route('create-task') }}" method="POST" class="formSave">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 z-index">
                    <label>Title: <span style="color: red">*</span></label>
                    <input type="text" class="form-control" name="title" placeholder="Enter the task tittle" autocomplete="off">
                </div>
                @if(!in_array(Auth::user()->role_id,[1,2,4]))
                
                @php
                $users = $users = DB::table('users')->where([['is_deleted',0],['role_id','!=',1]])->whereIn('tier_user',[3,2]);
                if(Auth::user()->tier_user == 1)
                {
                    if(!in_array(Auth::user()->role_id,[1,2]))
                    {
                        $users->where('dept_id',Auth::user()->dept_id);
                    }
                }
                $users = $users->get();
                @endphp

                <input name="dept_id" type="hidden" value="{{ Auth::user()->dept_id }}">
                @else
                @php
                    $users = array();
                @endphp

                <div class="col-md-6 z-index">
                    <label for="dept_id">Department <span style="color: red">*</span></label>
                    <select name="dept_id" id="dept_id{{ $project->id }}" class="form-control select2"  style="width: 100%;" onchange="getDepartmentUser(this.value,{{ $project->id }})" required>
                        <option value="">Select</option>
                        @if(isset($departments) && count($departments) > 0)
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}" @if(!empty($usersdata->dept_id) && $usersdata->dept_id == $department->id) selected @endif>{{ $department->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                @endif
            </div>
                @php
                    $usersObserve = getTableAll('users',[['is_active',1],['is_deleted',0],['id','!=',1]]);
                @endphp
                <div class="row">
                    <div class="col-md-6 z-index">
                        <label>Participants: </label>
                        <select class="select2 form-control z-index" name="participant[]" multiple="multiple" style="width: 100%;z-index: 9999;" id="participant{{ $project->id }}">
                            @if(isset($users) && count($users) > 0)
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ getUserName($user->id) }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6 z-index">
                        <label>Responsible Person: <span style="color: red">*</span></label>
                        <select class="select2 form-control" name="responsible_person" style="width: 100%;" id="responsible_person{{ $project->id }}"  required>
                            @if(isset($users) && count($users) > 0)
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ getUserName($user->id) }}</option>
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
                        <option value="{{ $user->id }}">{{ getUserName($user->id) }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Start date: <span style="color: red">*</span></label>
                    <input type="datetime-local" class="form-control" name="start_date" placeholder="Enter the start date" autocomplete="off">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="float: inherit;">
                    <label>End date: <span style="color: red">*</span></label>
                    <input type="datetime-local" class="form-control" name="end_date" placeholder="Enter the end date" autocomplete="off">
                </div>
                
                <div class="col-md-12">
                    <label>Description: <span style="color: red">*</span></label>
                    <textarea class="summernote" name="description"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Create</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </div>
     </form>
    </div>
</div>