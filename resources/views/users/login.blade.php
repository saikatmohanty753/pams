<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>PAMS | Login - Sign in</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Oasys Tech Solutions Pvt. Ltd." />
        <meta name="keywords" content="pmis,dashboard" />
        <meta name="author" content="stacks" />
        
        <!-- Styles -->
        <link href="{{ url('assets/plugins/pace-master/themes/blue/pace-theme-flash.css') }}" rel="stylesheet"/>
        <link href="{{ url('assets/plugins/uniform/css/default.css') }}" rel="stylesheet"/>
        <link href="{{ url('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('assets/plugins/fontawesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('assets/plugins/line-icons/simple-line-icons.css') }}" rel="stylesheet" type="text/css"/>	
        <link href="{{ url('assets/plugins/offcanvasmenueffects/css/menu_cornerbox.css') }}" rel="stylesheet" type="text/css"/>	
        <link href="{{ url('assets/plugins/waves/waves.min.css') }}" rel="stylesheet" type="text/css"/>	
        <link href="{{ url('assets/plugins/switchery/switchery.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('assets/plugins/3d-bold-navigation/css/style.css') }}" rel="stylesheet" type="text/css"/>	
        
        <!-- Theme Styles -->
        <link href="{{ url('assets/css/meteor.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('assets/css/layers/dark-layer.css') }}" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="{{ url('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
        
        <script src="{{ url('assets/plugins/3d-bold-navigation/js/modernizr.js') }}"></script>
        <script src="{{ url('assets/plugins/offcanvasmenueffects/js/snap.svg-min.js') }}"></script>
        
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            .captcha{
                display: inline-block;
                float: right;
                position: relative;
                top: 36px;
            }
        </style>
    </head>
    <body class="page-login">
        <main class="page-content">
            <div class="page-inner">
                <div id="main-wrapper">
                    <div class="row">
                        <div class="col-md-3 center">
                            <div class="panel panel-white" id="js-alerts">
                                <div class="panel-body">
                                    @include('alert_message')
                                    @if($errors->any())
                                    @foreach($errors->all() as $error)
                                    <div class="alert alert-danger" role="alert">
                                        {{ $error }}
                                    </div>
                                    @endforeach
                                    @endif
                                    <div class="login-box">
                                        <a href="#" class="logo-name text-lg text-center m-t-xs">Oasys Tech Solutions Pvt. Ltd.</a>
                                        <p class="text-center m-t-md">PAMS Login</p>
                                        <form class="m-t-md" action="{{ url('/login') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control password" placeholder="Password" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="captcha">
                                                    <span>{!! captcha_img() !!}</span>
                                                    <button type="button" class="btn btn-danger" class="reload" id="reload">↻</button>
                                                </div>
                                                <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                            </div>
                                            
                                            <button type="submit" class="btn btn-success btn-block">Login</button>
                                            
                                        </form>
                                        <a href="{{route('forgot-password')}}" class="display-block text-center m-t-md text-sm">Forgot Password?</a>
                                        <p class="text-center m-t-xs text-sm">@php echo date('Y') @endphp &copy; pams</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row -->
                </div><!-- Main Wrapper -->
            </div><!-- Page Inner -->
        </main><!-- Page Content -->
	

        <!-- Javascripts -->
        <script src="{{ url('assets/plugins/jquery/jquery-3.1.0.min.js') }}"></script>
        <script src="{{ url('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
        <script src="{{ url('assets/plugins/pace-master/pace.min.js') }}"></script>
        <script src="{{ url('assets/plugins/jquery-blockui/jquery.blockui.js') }}"></script>
        <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ url('assets/plugins/switchery/switchery.min.js') }}"></script>
        <script src="{{ url('assets/plugins/uniform/js/jquery.uniform.standalone.js') }}"></script>
        <script src="{{ url('assets/plugins/offcanvasmenueffects/js/classie.js') }}"></script>
        <script src="{{ url('assets/plugins/waves/waves.min.js') }}"></script>
        <script src="{{ url('assets/js/meteor.min.js') }}"></script>
        <script type="text/javascript">
            $('#reload').click(function () {
                $.ajax({
                type: 'GET',
                url: '{{ url("reload-captcha") }}',
                success: function (data) {
                        $(".captcha span").html(data.captcha);
                    }
                });
            });
        </script>
    </body>
</html>