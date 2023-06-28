@if(isset($reportUsers) && count($reportUsers) > 0)
@foreach($reportUsers as $userKey=>$users)
@php
 $getdatas = DB::table('daily_report_details')->where('created_by',$users->created_by)->get();
@endphp
<div class="col-md-8">
    <div class="panel panel-white">
        <div class="bg-primary rounded bdrs-10 w-100 bdrs-head">
            <img class="img-circle avatar" src="{{ url('assets/images/dummy-profile-pic.jpg') }}" width="20" height="20" alt="">
            <span><strong>{{ getUserName($users->created_by) }}</strong></span>
            <div class="text-right" style="display:inline-flex;float: right;">
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" class="panel-reload" data-original-title="Reload" style="color:white;text-decoration:none" onclick="dailyReport()"><i class="icon-reload"></i></a>
            </div>
        </div>
        <div class="panel-body">
            @if(isset($getdatas) && count($getdatas) > 0)
            @foreach($getdatas as $Rkey => $getdata)
            @php
             $getReplydatas = DB::table('reply_msg_details')->where('report_id',$getdata->id)->get();
             $getReplycheck = DB::table('reply_msg_details')->where('report_id',$getdata->id)->where('is_read',0);
            @endphp
            <div class="panel-group" id="accordion{{ $userKey }}{{ $Rkey }}" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne{{ $userKey }}{{ $Rkey }}">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion{{ $userKey }}{{ $Rkey }}" href="#{{ $userKey }}{{ $Rkey }}" aria-expanded="false" @if($getReplycheck->exists()) onclick="readMsg('{{ $getdata->id }}')" @endif aria-controls="collapseOne">
                                {{ $getdata->title }} @if($getReplycheck->exists())<span class="badge badge-danger blink_me" id="isRead{{ $getdata->id }}"><strong>New</strong></span>@endif
                            </a>
                            <span style="float: right"><strong>{{ date('d-m-Y',strtotime($getdata->given_on))}}</strong></span>
                        </h4>
                    </div>
                    <div id="{{ $userKey }}{{ $Rkey }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne{{ $userKey }}{{ $Rkey }}">
                        <div class="panel-body">
                            <p style="float:right;text-decoration: underline;"> Start Time : {{ date('h:i A',strtotime($getdata->start_date)) }} & End Time : {{ date('h:i A',strtotime($getdata->end_date)) }}</p><br><br>
                            <p>{!! $getdata->remark !!}</p>

                            @if(isset($getReplydatas) && count($getReplydatas) > 0)
                            @foreach($getReplydatas as $getReplydata)
                            <blockquote>
                                <p>{!! $getReplydata->comments !!}</p>
                                <footer><cite title="Source Title">{{ getUserName($getReplydata->given_by) }}</cite></footer>
                            </blockquote>
                            @endforeach
                            @endif
                            <span id="quotes{{ $getdata->id }}"></span>
                            <a href="javascript:;" style="float: right;text-decoration:none" class="reply-report" onclick="writeReply()">Reply</a>
                            <textarea class="form-control write-reply" placeholder="write here...." style="display: none" id="comment{{ $getdata->id }}"></textarea>
                            <a href="javascript:;" style="float: right;display: none;text-decoration:none" class="reply-report-send" onclick="sendReportReply('{{ $getdata->id }}')"><span class="icon-cursor"></span></a>
                            
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

@endforeach
@endif
