@if(Session::has('success'))
<div class="alert alert-success custom-alert" role="alert" id="alert-success">
    {{ Session::get('success') }}
</div>
{{ Session::forget('success') }}
@endif

@if(Session::has('error'))
<div class="alert alert-danger custom-alert" role="alert" id="alert-danger">
    {{ Session::get('error') }}
</div>
{{ Session::forget('error') }}
@endif