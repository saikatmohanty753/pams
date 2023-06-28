<style>
    .profile-img{
        width: 100px;
        height:100px;
        border: 5px solid black;
    }
</style>

<div class="navbar">
    <div class="navbar-inner">
        <div class="sidebar-pusher">
            <a href="javascript:void(0);" class="waves-effect waves-button push-sidebar">
                <i class="icon-arrow-right"></i>
            </a>
        </div>
        <div class="logo-box">
            <a href="index.html" class="logo-text"><span>PAMS</span></a>
        </div><!-- Logo Box -->
        <div class="search-button">
            <a href="javascript:void(0);" class="show-search"><i class="icon-magnifier"></i></a>
        </div>
        <div class="topmenu-outer">
            <div class="top-menu">
                <ul class="nav navbar-nav navbar-left">
                    <li>		
                        <a href="javascript:void(0);" class="sidebar-toggle"><i class="icon-arrow-left"></i></a>
                    </li>
                    <li>
                        <a href="#cd-nav" class="cd-nav-trigger"><i class="icon-support"></i></a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                   @php
                   $desig = '';
                    if(Auth::check())
                    {
                        $desig = getDesignation(Auth::user()->desig_id);
                    }    
                   @endphp
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="user-name">{{ Auth::user()->first_name.' '.Auth::user()->last_name }} @if(!empty($desig)) ({{ $desig }}) @endif <i class="fa fa-angle-down"></i></span>
                            @if(!empty(Auth::user()->profile_pic))
                            <img class="img-circle avatar" src="{{ url('users')}}/{{ Auth::user()->profile_pic }}" width="40" height="40" alt="" id="profile-avatar">
                            @else
                            <img class="img-circle avatar" src="{{ url('assets/images/dummy-profile-pic.jpg') }}" width="40" height="40" alt="" id="profile-avatar">
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-list" role="menu">
                            <li role="presentation"><a href="javascript:;" data-toggle="modal" data-target=".profile-modal"><i class="icon-user"></i>Profile</a></li>
                            <li role="presentation"><a href="{{ route('change-password') }}"><i class="icon-action-redo"></i>Change password</a></li>
                            {{-- <li role="presentation"><a href="calendar.html"><i class="icon-calendar"></i>Calendar</a></li>
                            <li role="presentation"><a href="inbox.html"><i class="icon-envelope-open"></i>Inbox<span class="badge badge-success pull-right">4</span></a></li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation"><a href="lock-screen.html"><i class="icon-lock"></i>Lock screen</a></li> --}}
                            <li role="presentation"><a href="{{ route('logout') }}"><i class="icon-key m-r-xs"></i>Log out</a></li>
                        </ul>
                    </li>
                    {{-- <li>
                        <a href="javascript:void(0);" id="showRight">
                            <i class="icon-bubbles"></i>
                        </a>
                    </li> --}}
                </ul><!-- Nav -->
            </div><!-- Top Menu -->
        </div>
    </div>
</div>

{{-- Profile Modal --}}
<div class="modal fade profile-modal" tabindex="-1" role="dialog" aria-labelledby="myProfileLabel" aria-hidden="true" id="myProfile">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myProfileLabel">Profile</h4>
            </div>
            <div class="modal-body container bootstrap snippets bootdey">
                <link rel="stylesheet" href="{{ url('assets/css/profile.css')}}">
                <div class="">
                    <div class="row">
                      <div class="profile-nav col-md-3">
                          <div class="panel">
                              <div class="user-heading round">
                                  <a href="#">
                                    @if(!empty(Auth::user()->profile_pic))
                                        <img src="{{ url('users')}}/{{ Auth::user()->profile_pic }}" alt="">
                                    @else
                                        <img src="{{ url('assets/images/dummy-profile-pic.jpg') }}" alt="">
                                    @endif
                                  </a>
                                  <h1>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</h1>
                                  <p>{{ Auth::user()->email }}</p>
                              </div>
                    
                              <ul class="nav nav-pills nav-stacked">
                                  <li class="active"><a href="#"> <i class="fa fa-user"></i> Profile</a></li>
                                  <li><a href="#"> <i class="fa fa-calendar"></i> Recent Activity <span class="label label-info pull-right r-activity">9</span></a></li>
                                  {{-- <li><a href="javascript:;" data-toggle="modal" data-target=".edit-profile"> <i class="fa fa-edit"></i> Edit profile</a></li> --}}
                                  <li><a href="javascript:;" onclick="editProfile()"> <i class="fa fa-edit"></i> Edit profile</a></li>
                              </ul>
                          </div>
                      </div>
                      <div class="profile-info col-md-6">
                          <div class="panel">
                              <form>
                                  <textarea placeholder="Whats in your mind today?" rows="2" class="form-control input-lg p-text-area"></textarea>
                              </form>
                              <footer class="panel-footer">
                                  <button class="btn btn-info pull-right">Post</button>
                                  <ul class="nav nav-pills">
                                      <li>
                                          <a href="#"><i class="fa fa-map-marker"></i></a>
                                      </li>
                                      <li>
                                          <a href="#"><i class="fa fa-camera"></i></a>
                                      </li>
                                      <li>
                                          <a href="#"><i class=" fa fa-film"></i></a>
                                      </li>
                                      <li>
                                          <a href="#"><i class="fa fa-microphone"></i></a>
                                      </li>
                                  </ul>
                              </footer>
                          </div>
                          <div class="panel">
                              <div class="bio-graph-heading">
                                “It is always the start that requires the greatest effort.”– James Penney, founder and CEO J.C. Penny
                              </div>
                              <div class="panel-body bio-graph-info">
                                  <div class="row">
                                      <div class="bio-row">
                                          <p><span>First Name </span>: {{ Auth::user()->first_name }}</p>
                                      </div>
                                      @if(!empty(Auth::user()->last_name))
                                      <div class="bio-row">
                                          <p><span>Last Name </span>: {{ Auth::user()->last_name }}</p>
                                      </div>
                                      @endif
                                      <div class="bio-row">
                                          <p><span>Country </span>: India</p>
                                      </div>
                                      <div class="bio-row">
                                          <p><span>Birthday</span>: {{ (!empty(Auth::user()->dob))?date('d-m-Y',strtotime(Auth::user()->dob)):'' }}</p>
                                      </div>
                                      <div class="bio-row">
                                          <p><span>Designation </span>: {{ getTableName('designations',['id'=>Auth::user()->desig_id])}}</p>
                                      </div>
                                      <div class="bio-row">
                                          <p><span>Email </span>: {{ Auth::user()->email }}</p>
                                      </div>
                                      <div class="bio-row">
                                          <p><span>Mobile </span>: {{ Auth::user()->mobile_no }}</p>
                                      </div>
                                      @if(!empty(Auth::user()->alt_mobile_no))
                                      <div class="bio-row">
                                          <p><span>Alternate Mobile </span>: {{ Auth::user()->alt_mobile_no }}</p>
                                      </div>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div>
                              
                          </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
               {{--  <button type="button" class="btn btn-success">Update changes</button> --}}
            </div>
        </div>
    </div>
</div>
{{-- Profile Modal Ends --}}

{{-- Edit Profile Modal --}}
<div class="modal fade edit-profile" tabindex="-1" role="dialog" aria-labelledby="myEditProfileLabel" aria-hidden="true" id="editProfileDiv">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myEditProfileLabel">Edit Profile</h4>
            </div>
            <form method="POST" enctype="multipart/form-data" action="{{ route('update-profile')}}" id="updateProfileData">
                @csrf
                <div class="modal-body">
                    <div class="alert" role="alert" id="alert-msg" style="display: none"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" name="first_name" value="{{ Auth::user()->first_name }}">
                        </div>
                        <div class="col-md-6">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" name="last_name" value="{{ Auth::user()->last_name }}">
                        </div>
                        <div class="col-md-6">
                            <label for="email">Birthday date</label>
                            <input type="date" class="form-control" name="dob" value="{{ Auth::user()->dob }}">
                        </div>
                        <div class="col-md-6">
                            <label for="emp_code">Employee Code</label>
                            <input type="text" class="form-control" name="emp_code" value="{{ Auth::user()->emp_code }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="desig_id">Designation</label>
                            <input type="text" class="form-control" name="desig_id" value="{{ getTableName('designations',['id'=>Auth::user()->desig_id]) }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="mobile_no">Mobile number</label>
                            <input type="text" class="form-control" name="mobile_no" value="{{ Auth::user()->mobile_no }}">
                        </div>
                        <div class="col-md-6">
                            <label for="mobile_no">Alternate Mobile number</label>
                            <input type="text" class="form-control" name="alt_mobile_no" value="{{ Auth::user()->alt_mobile_no }}">
                        </div>
                        <div class="col-md-6">
                            <label for="profile_pic">Upload Profile Pic</label>
                            <input type="file" name="profile_pic" onchange="readURL(this)" accept=".png,.jpg,.jpeg">
                        </div>
                        <div class="col-md-6 mt-2">
                            <img id="blah" src="{{ url('users')}}/{{ Auth::user()->profile_pic }}" alt="Profile pic" width="95px" height="95px" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick="updateProfile()" class="btn btn-primary">Update changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Edit Profile Modal Ends --}}
