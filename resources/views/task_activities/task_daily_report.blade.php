@extends('./layout/main')
@section('content')
<style>
    .bdrs-head{
        padding: 9px 15px;
    }
    .row > .col-text-6 {
        margin-top: 5%;
        text-align: center;
        font-weight: 700;
        word-break: break-all;
    }
    blockquote{
        margin-top: 2px;
        margin-bottom: 3px;
    }
    .panel-default>.panel-heading .badge{
        background-color: #d11c1c;
    }
    .dt-field{
        display: inline-flex;
        margin-top: 5px;
        flex: 1;
    }
    .dt-field > input[type="datetime-local"] {
        margin-left: 2px;
    }
    .dt-field > span {
        margin-top: 7px;
        width: 200px;
        margin-left: 8px;
        font-weight: bold;
    }
    .link-dashed{
        text-decoration: none !important;
    }
    .input-group-lg > textarea{
        height: 114px !important;
    }
    label.form-label.text-nowrap {
        line-height: 32px;
    }
</style>
<div class="container-card">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-white bdrs-10">
                <div class="panel-body">
                    <div class="bg-info rounded bdrs-10 w-100 bdrs-head">
                        <span><strong>Today's report description</strong></span>
                    </div>
                    <input class="form-control" id="title" placeholder="Title" style="margin-bottom: 3px">
                    <form class="m-b-sm">
                        <div class="form-group no-s">
                            <div class="input-group-lg">
                                <textarea class="form-control" id="remark" placeholder="Please enter your report here..."></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 dt-field">
                                <label class="form-label text-nowrap"> Start date : </label> <input type="datetime-local" id="start_date" class="form-control" min="{{ date('Y-m-d h:i') }}" max="{{ date('Y-m-d h:i') }}">
                            </div>
                            <div class="col-md-6 dt-field">
                            <label class="form-label  text-nowrap"> End date : </label> <input type="datetime-local" id="end_date" class="form-control" min="{{ date('Y-m-d h:i') }}">
                            </div>
                        </div>
                    </form>
                    <a href="javascript:;" onclick="saveDailyReport()" class="btn btn-info m-b-xs">Report</a>
                    <a href="javascript:;" onclick="dailyReport()" class="btn btn-default m-b-xs">Reset</a>
                </div>
            </div>

        </div>
        <div class="col-md-4 bdrs-10">
            <div class="bg-info rounded bdrs-10 w-100 bdrs-head">
                <img class="img-circle avatar" src="{{ url('assets/images/dummy-profile-pic.jpg') }}" width="20" height="20" alt="">
                <span><strong>{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</strong></span>
            </div>
            <div class="panel panel-white">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-6 col-text-6">Designation </div>
                        <div class="col-sm-6 col-text-6" style="text-decoration: dashed"><a href="#" class="link-dashed">{{ getTableName('designations',['id'=>Auth::user()->desig_id])}}</a></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-text-6">Departments </div>
                        <div class="col-sm-6 col-text-6" style="text-decoration: dashed"><a href="#" class="link-dashed">{{ getTableName('departments',['id'=>Auth::user()->dept_id])}}</a></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-text-6">Email </div>
                        <div class="col-sm-6 col-text-6" style="text-decoration: dashed"><a href="#" class="link-dashed">{{ Auth::user()->email }}</a></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-text-6">Mobile </div>
                        <div class="col-sm-6 col-text-6" style="text-decoration: dashed"><a href="#" class="link-dashed">{{ Auth::user()->mobile_no }}</a></div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Daily Report list --}}
        @include('../includes/show_daily_reports')
        {{-- Daily Report list ends --}}
    </div>
</div>
<script type="text/javascript">
function dailyReport()
{
    window.location.reload();
}
</script>
@endsection
