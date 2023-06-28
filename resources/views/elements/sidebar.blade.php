<div class="page-sidebar sidebar">
    <div class="page-sidebar-inner slimscroll">
        <ul class="menu accordion-menu">
            <li class="main-menue" id="menue1"><a href="{{ url('/dashboard') }}" class="waves-effect waves-button"><span class="menu-icon icon-home"></span><p>Dashboard</p></a></li>

            @can('user-module')
            <li class="main-menue" id="menue1"><a href="{{ route('addUser') }}" class="waves-effect waves-button"><span class="menu-icon icon-user"></span><p>Users</p></a></li>
            @endcan

            @can('master-module')
            <li class="droplink main-menue" id="menue2"><a href="#" class="waves-effect waves-button"><span class="menu-icon icon-layers"></span><p>Masters</p><span class="arrow"></span><span class="active-page"></span></a>
                <ul class="sub-menu">
                    {{-- <li><a href="{{ route('add-report') }}">Add Reporting Designation</a></li> --}}
                    <li><a href="{{ route('add-department') }}"> Departments</a></li>
                    <li><a href="{{ route('add-sub-department') }}"> Sub Departments</a></li>
                    <li><a href="{{ route('add-designation') }}"> Designations</a></li>
                </ul>
            </li>
            @endcan

            @can('role-module')
            <li class="main-menue"><a href="{{ route('add-role') }}" class="waves-effect waves-button"><span class="menu-icon icon-equalizer"></span>  Roles </a></li>
            @endcan

            @can('project-module')
            <li class="main-menue"><a href="{{ route('project-list') }}" class="waves-effect waves-button"><span class="menu-icon icon-hourglass"></span> Projects </a></li>
            @endcan

            @can('task-module')
            <li class="main-menue"><a href="{{ route('add-task') }}" class="waves-effect waves-button"><span class="menu-icon icon-list"></span> Tasks </a></li>
            @endcan

            <li class="droplink main-menue"><a href="#" class="waves-effect waves-button"><span class="menu-icon icon-book-open"></span><p>Reports</p><span class="arrow"></span><span class="active-page"></span></a>
                <ul class="sub-menu">
                    <li><a href="{{ route('reports') }}"> Task Wise List</a></li>
                    <li><a href="{{ route('project-reports-list') }}"> Project Wise List</a></li>
                    <li><a href="{{ route('other-reports-list') }}"> Other Report List</a></li>
                </ul>
            </li>

            <li class="main-menue"><a href="{{ route('daily-report') }}" class="waves-effect waves-button"><span class="menu-icon  icon-briefcase"></span> Other </a></li>
        </ul>
    </div><!-- Page Sidebar Inner -->
</div>
