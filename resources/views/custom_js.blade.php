<script type="text/javascript">
$(document).ready(function(){
    $('.summernote').summernote();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.select2').select2({
        width: 'resolve',
    });
    $('#sub_department').select2({
        width: 'resolve',
        placeholder:'Select Sub Department'
    });
    /* @if(in_array(Request::segment(1),['admin']))
        $('.main-menue').removeClass('active open');
        $('#menue2').addClass('active open');
        @if(in_array(Request::segment(2),['add-user','edit-user','add-project','add-role']))
        $('#menue2 ul li').removeClass('active open');
        $('#menue2 ul').show();
        $('#menue2 ul li').addClass('active');
        @endif
    @elseif(in_array(Request::segment(1),['dashboard']))
        $('.main-menue').removeClass('active open');
        $('#menue1').addClass('active open');
    @endif */

    var table = $('.datatable').DataTable({});
    var table1 = $('.datatable-tasklist').DataTable({
        /* "dom": '<"pull-left"f><"pull-right"l>tip', */
        bLengthChange:false,
        "ordering": false,
        dom: 'Bfrtip',
        buttons: [
            'excel','pdf'
        ],
        initComplete: function() {
            $('.buttons-excel').html('<i class="fa fa-file-excel-o" />');
            $('.buttons-pdf').html('<i class="fa fa-file-pdf-o" />');

        }

    });
    var table2 = $('.datatable-deadline').DataTable({
        /* "dom": '<"pull-left"f><"pull-right"l>tip', */
        bLengthChange:false,
        dom: 'Bfrtip',
        "ordering": false,
        buttons: [
            'excel','pdf'
        ],
        initComplete: function() {
            $('.buttons-excel').html('<i class="fa fa-file-excel-o" />');
            $('.buttons-pdf').html('<i class="fa fa-file-pdf-o" />');

        }

    });
    var table3 = $('.datatable-plannedline').DataTable({
        /* "dom": '<"pull-left"f><"pull-right"l>tip', */
        bLengthChange:false,
        dom: 'Bfrtip',
        "ordering": false,
        buttons: [
            'excel','pdf'
        ],
        initComplete: function() {
            $('.buttons-excel').html('<i class="fa fa-file-excel-o" />');
            $('.buttons-pdf').html('<i class="fa fa-file-pdf-o" />');

        }

    });
    var table4 = $('.datatable-closedline').DataTable({
        /* "dom": '<"pull-left"f><"pull-right"l>tip', */
        bLengthChange:false,
        dom: 'Bfrtip',
        "ordering": false,
        buttons: [
            'excel','pdf'
        ],
        initComplete: function() {
            $('.buttons-excel').html('<i class="fa fa-file-excel-o" />');
            $('.buttons-pdf').html('<i class="fa fa-file-pdf-o" />');

        }

    });
    var table5 = $('.datatable-progressline').DataTable({
        /* "dom": '<"pull-left"f><"pull-right"l>tip', */
        bLengthChange:false,
        dom: 'Bfrtip',
        "ordering": false,
        buttons: [
            'excel','pdf'
        ],
        initComplete: function() {
            $('.buttons-excel').html('<i class="fa fa-file-excel-o" />');
            $('.buttons-pdf').html('<i class="fa fa-file-pdf-o" />');

        },
        fixedColumns: true
    });

});


function popoverFun(key)
{
    $('[data-toggle="'+key+'"]').popover();
}

function editProfile()
{
    $('#myProfile').modal('hide');
    $('#editProfileDiv').modal('show');
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
function updateProfile()
{
    var form = $("#updateProfileData");
    var postData = new FormData(form[0]);
    $.post({
        url:"{{ route('update-profile') }}",
        type:"POST",
        data:postData,
        contentType: false,
        processData: false,
        success:function(res)
        {
            if(res.status == 1)
            {
                $('#alert-msg').show();
                $('#alert-msg').removeClass('alert-danger');
                $('#alert-msg').removeClass('alert-success');
                $('#alert-msg').addClass('alert-success');
                $('#alert-msg').html(res.msg);
            }else{
                $('#alert-msg').show();
                $('#alert-msg').removeClass('alert-danger');
                $('#alert-msg').removeClass('alert-success');
                $('#alert-msg').addClass('alert-danger');
                $('#alert-msg').html(res.msg);
            }
            setTimeout(()=>{
                $('#alert-msg').fadeOut();
                changeProfile(res.img)
            },2000);
        }
    });
}
function changeProfile(img)
{
    if(img!='')
    {
        $('#profile-avatar').attr('src','{{ url("users") }}/'+img);
    }
}

function changePassword()
{
    if($('#old_password').val() == '')
    {
        $('.removeOld').remove();
        $('#old_password').after('<span style="color:red;font-weight:bold" class="removeOld">Please enter the old password</span>');
    }else{
        $('.removeOld').remove();
    }

    $('#newpasswordMsg').html(checkStrength($('#new_password').val(),'newpasswordMsg'));

}
function checkStrength(password,msgId) {
    var strength = 0
    if (password.length < 6) {
        $('#'+msgId).removeClass()
        $('#'+msgId).addClass('Short')
        return 'Too short'
    }
    if (password.length > 7) strength += 1
    // If password contains both lower and uppercase characters, increase strength value.
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
    // If it has numbers and characters, increase strength value.
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
    // If it has one special character, increase strength value.
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
    // If it has two special characters, increase strength value.
    if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
    // Calculated strength value, we can return messages
    // If value is less than 2
    if($('#confirm_password').val() == password && $('#confirm_password').val().length >= 8 && $('#confirm_password').val()!='')
    {
        $('#confirmpasswordMsg').removeClass();
        $('#confirmpasswordMsg').addClass('Good');
        $('#confirmpasswordMsg').html('✔ Matched')
    }

    if (strength < 2) {
        $('#'+msgId).removeClass()
        $('#'+msgId).addClass('Weak')
        return 'Weak'
    } else if (strength == 2) {
        $('#'+msgId).removeClass()
        $('#'+msgId).addClass('Good')
        return 'Good'
    } else {
        $('#'+msgId).removeClass()
        $('#'+msgId).addClass('Strong')
        return 'Strong'
    }
}

function updatePassword()
{
    var old_password = $('#old_password').val();
    var new_password = $('#new_password').val();
    var confirm_password = $('#confirm_password').val();

    changePassword();

    if(old_password!='' && old_password.length > 0 && new_password == confirm_password && new_password.length>=8 && confirm_password.length >=8)
    {
        $('#form-save').submit();
    }

}

function getRole()
{
    var url = '{{ route("get-roles") }}';
    var tier_user = $('#tier_user').val();
    var value = $('#dept_id').val();
    if(value!='')
    {
        $.ajax({
            url:url,
            type:'POST',
            data:{"_token":"{{ csrf_token() }}","dept_id":value},
            dataType:"JSON",
            success:function(res)
            {
                if(res.status == 1)
                {
                    $('#role_id').empty();
                    $('#role_id').html(res.data);
                }
            }
        });
    }

    if(tier_user!=1 && tier_user!='' && tier_user!=null && value == 3)
    {
        $('#sub_dept_id_div').show();
        $('#sub_dept_id').val(null).trigger("change");
        $('#sub_dept_id').attr('required', 'required');
    }else{
        $('#sub_dept_id').val(null).trigger("change");
        $('#sub_dept_id_div').hide();
        $('#sub_dept_id').removeAttr('required');
    }
}

function getDepartmentUser(value,key)
{
    var url = '{{ route("get-dept-user") }}';
    if(value!='')
    {
        $.ajax({
            url:url,
            type:'POST',
            data:{"_token":"{{ csrf_token() }}","dept_id":value},
            dataType:"JSON",
            success:function(res)
            {
                if(res.status == 1)
                {
                    $('#participant'+key).empty();
                    $('#responsible_person'+key).empty();
                    $('#participant'+key).html(res.data);
                    $('#responsible_person'+key).html(res.data);
                }
            }
        });
    }
}

function getDepartmentUserUpdate(value,key)
{
    var url = '{{ route("get-dept-user") }}';
    if(value!='')
    {
        $.ajax({
            url:url,
            type:'POST',
            data:{"_token":"{{ csrf_token() }}","dept_id":value},
            dataType:"JSON",
            success:function(res)
            {
                if(res.status == 1)
                {
                    $('#participant_update'+key).empty();
                    $('#responsible_person_update'+key).empty();
                    $('#participant_update'+key).html(res.data);
                    $('#responsible_person_update'+key).html(res.data);
                }
            }
        });
    }
}

function showProduction(value)
{
    let l = m = 0;
    $('.checkbox-class').each(function(){
        if($(this).prop('checked'))
        {
            if(this.value == 3)
            {
                $('#sub_dept_div').show();
                m = 1;
            }else if(m!=1){
                $('#sub_dept_div').hide();
            }
            l = 1;
        }
    });
    if(m!=1)
    {
        $('#sub_department').val(null).trigger("change");
    }
    if(l!=1)
    {
        $('#sub_dept_div').hide();
        $('#sub_department').val(null).trigger("change");
    }

}
function beforeSubmitProject()
{
    let l = m = 0;
    var html = '<button class="btn btn-info space-button" type="button" disabled><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...</button>';

    $('.checkbox-class').each(function(){
        if($(this).prop('checked'))
        {
            if(this.value == 3)
            {
                m = 1;
            }
            l = 1;
        }
    });
    var length = $("#sub_department").select2('data').length;
    if(l!=1)
    {
        /* $('.checkbox-class').attr('data-toggle',"tooltip");
        $('.checkbox-class').attr('data-placement',"bottom");
        $('.checkbox-class').attr('title',"Please choose anyone of these");
        $('.checkbox-class').tooltip('show'); */
        var ErrorText ='Please choose anyone department';
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : false
        }
        toastr.warning(ErrorText);
        return false;
    }else{
        if(m!=1)
        {
            var ErrorText ='Please choose anyone sub department';
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : false
            }
            toastr.warning(ErrorText);
            return false;
        }else if(length == 0){
            return false;
        }
    }

    $('button[type="submit"]').after(html);
    $('button[type="submit"]').hide();

    return true;
}

function formSubmit()
{
    if(beforeSubmitProject())
    {
        $('#formSave').submit();
    }
}

$('.formSave').on('submit',function(){
    var html = '<button class="btn btn-info space-button" type="button" disabled><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Loading...</button>';

    $('button[type="submit"]').after(html);

    $('button[type="submit"]').hide();
});

function startTask(taskId)
{
    var url = "{{ route('start-task') }}";
    $.ajax({
        url:url,
        type:'POST',
        data:{"_token":"{{ csrf_token() }}","taskKey":taskId},
        dataType:"JSON",
        success:function(res)
        {
            if(res.status == 1)
            {
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : false
                }
                toastr.success(res.message);
                $('#start_task').remove();
                window.location.reload();
            }else{
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : false
                }
                toastr.error(res.message);
            }
        }
    });
}

function showComment(taskId,projectId)
{
    var comment = $('#input-rounded').val();
    var url = "{{ route('update-comment') }}";

    var html = '<button class="btn btn-success space-button" id="sending-btn" style="margin-left: 70px;" type="button" disabled><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Sending...</button>';

    $('#comment_btn').hide();
    $('#comment_btn').after(html);
    $.ajax({
        url:url,
        type:'POST',
        data:{"_token":"{{ csrf_token() }}","project_id":projectId,"task_id":taskId,"comment":comment},
        dataType:'JSON',
        success:function(res)
        {
            if(res.status == 1)
            {
                $('#input-rounded').val('')
                $('#comment_btn').fadeOut();
            }
            $('#sending-btn').remove();
        }
    });
}

$('#input-rounded').focus(function(){
    $('#comment_btn').fadeIn();
});

function finishTask(taskId)
{
    var url = "{{ route('finish-task') }}";
    $.ajax({
        url:url,
        type:'POST',
        data:{"_token":"{{ csrf_token() }}","task_id":taskId},
        dataType:'JSON',
        success:function(res)
        {
            if(res.status == 1)
            {
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : false
                }
                toastr.success(res.message);
                $('#finish_task').remove();
                window.location.reload();
            }else{
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : false
                }
                toastr.error(res.message);
            }
        }
    })
}

function reopenTask(taskId)
{
    var url = "{{ route('reopen-task') }}";
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    var description = $('#reopen-des').val();
    if(start_date == '')
    {
        alert("Please enter the start date");
        return false;
    }
    if(end_date == '')
    {
        alert("Please enter the end date");
        return false;
    }
    if(description == '')
    {
        alert("Please enter the reason for reopen");
        return false;
    }
    $.ajax({
        url:url,
        type:'POST',
        data:{"_token":"{{ csrf_token() }}","task_id":taskId,"start_date":start_date,"end_date":end_date,"description":description},
        dataType:'JSON',
        success:function(res)
        {
            if(res.status == 1)
            {
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : false
                }
                toastr.success(res.message);
                $('[data-dismiss="modal"]').click();
                $('#reopen_task').remove();
                window.location.reload();
            }else{
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : false
                }
                toastr.error(res.message);
            }
        }
    })
}

function finishWithDelay(taskId)
{
    var url = "{{ route('delay-reason') }}";
    var data = $('#delay-msg').val();
    $.ajax({
        url:url,
        type:'POST',
        data:{"_token":"{{ csrf_token() }}","data":data,"taskKey":taskId},
        dataType:'JSON',
        success:function(res)
        {
            if(res.status == 1)
            {
                $('#delay-msg').val('');
                $('[data-dismiss="modal"]').click();
                finishTask(taskId);
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : false
                }
                toastr.success(res.message);
            }else{
                $('#delay-msg').val('');
                $('[data-dismiss="modal"]').click();
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : false
                }
                toastr.error(res.message);

            }
        },
        error:function(error)
        {
            console.error(error);
        }
    });
}
function getSubDepartments(value)
{
    var url = "{{ route('get-sub-dept') }}";
    $.ajax({
        url:url,
        type:'GET',
        data:{"_token":"{{ csrf_token() }}","dept_id":value},
        dataType:"JSON",
        success:function(res)
        {
            $('#sub_dept_id').empty();
            $('#sub_dept_id').html(res.data);
        }
    });
}
function getTimeElapsed(project_id,task_id)
{
    var url = "{{ route('time-elapsed') }}";
    var start_date = $('#time_start_date').val();
    var end_date = $('#time_end_date').val();
    var remark = $('#remark').val();
    var time_els_id = $('#time_els_id').val();
    if(start_date!='' && end_date!='' && remark!='')
    {
        var html = '<button class="btn btn-success space-button" id="time-saving-btn" style="margin-left: 16px" type="button" disabled><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>Saving...</button>';

        $('#time_elapsed_save').hide();
        $('#time_elapsed_save').after(html);

        $.ajax({
            url:url,
            type:'POST',
            data:{"_token":"{{ csrf_token() }}","project_id":project_id,"task_id":task_id,"start_date":start_date,"end_date":end_date,"remark":remark,"time_els_id":time_els_id},
            dataType:"JSON",
            success:function(res)
            {
                if(res.status == 1)
                {
                    toastr.options =
                    {
                        "closeButton" : true,
                        "progressBar" : false
                    }
                    toastr.success(res.message);
                    $('#time-saving-btn').remove();
                    $('#time_elapse_save_div').remove();
                    window.location.reload();
                }else{
                    toastr.options =
                    {
                        "closeButton" : true,
                        "progressBar" : false
                    }
                    toastr.error(res.message);
                    $('#time-saving-btn').remove();
                    $('#time_elapsed_save').show();
                }
            }
        });
    }
}
function getTimeUpdateElapsed(project_id,task_id,time_elsed_id,start_date,end_date,remark,id)
{
    var newId = id.split('time-elapsed');
    $('#'+id).hide();
    $('#time_elapse_save_div').show();
    $('#remark').val(remark);
    $('#time_end_date').val(end_date);
    $('#time_start_date').val(start_date);
    $('#time_els_id').val(newId[1]);
}

function writeReply()
{
    $('.reply-report').toggle();
    $('.write-reply').toggle();
    $('.reply-report-send').toggle();
}

function saveDailyReport()
{
    var title = $('#title').val();
    var remark = $('#remark').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    var url = "{{ route('save-daily-report') }}";
    if(title.length == 0 || $.trim(title) == '')
    {
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : false
        }
        toastr.error('Please enter the title');
        return false;
    }
    if(remark.length == 0 || $.trim(remark) == '')
    {
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : false
        }
        toastr.error('Please enter the your daily report description');
        return false;
    }
    if(end_date=='')
    {
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : false
        }
        toastr.error('Please enter the your daily report completion date');
        return false;
    }
    if(start_date=='')
    {
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : false
        }
        toastr.error('Please enter the your daily report start date');
        return false;
    }
    $.ajax({
        url:url,
        type:'POST',
        data:{"_token":"{{ csrf_token() }}","remark":remark,"title":title,"start_date":start_date,"end_date":end_date},
        dataType:"JSON",
        success:function(res)
        {
            if(res.status == 1)
            {
                $('#title').val('');
                $('#remark').val('');
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : false
                }
                toastr.success('Submitted successfully');
                window.location.reload();
            }
        }
    })
}
function sendReportReply(reportId)
{
    var comments = $('#comment'+reportId).val();
    if(comments!='')
    {
        $.ajax({
            url:"{{ route('daily-reply-report') }}",
            type:"POST",
            data:{"_token":"{{ csrf_token() }}","report_id":reportId,"comments":comments},
            dataType:"JSON",
            success:function(res)
            {
                if(res.status == 1)
                {
                    $('#quotes'+reportId).last().after('<blockquote><p>'+comments+'</p><footer><cite title="Source Title">'+res.data+'</cite></footer></blockquote>');
                    $('#comment'+reportId).val('');
                    writeReply();
                }
            }
        });
    }

}

function readMsg(reportId)
{
    if(reportId!='')
    {
        $.ajax({
            url:"{{ route('daily-seen-report') }}",
            type:"POST",
            data:{"_token":"{{ csrf_token() }}","report_id":reportId},
            dataType:"JSON",
            success:function(res)
            {
                if(res.status == 1)
                {
                    $('#isRead'+reportId).remove();
                }
            }
        });
    }
}

function projectReportList()
{
    var data = {};
    data['start_date'] = $('#start_date').val();
    data['end_date'] = $('#end_date').val();
    data['dept_id'] = $('#dept_id').val();
    data['sub_dept_id'] = $('#sub_dept_id').val();

    var url = "{{ route('project-reports-list-ajax') }}";

    $.ajax({
        url:url,
        type:"GET",
        data:{"_token":"{{ csrf_token() }}",...data},
        dataType:"JSON",
        success:function(res)
        {
            $('#project-wise-report-list').html(res);
        }
    });
}
function otherReportList()
{
    var data = {};
    data['start_date'] = $('#start_date').val();
    data['end_date'] = $('#end_date').val();
    data['user_id'] = $('#user_id').val();

    var url = "{{ route('other-reports-list-ajax') }}";

    $.ajax({
        url:url,
        type:"GET",
        data:{"_token":"{{ csrf_token() }}",...data},
        dataType:"JSON",
        success:function(res)
        {
            $('#other-wise-report-list').html(res);
        }
    });
}
</script>
