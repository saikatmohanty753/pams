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
                        <div class="col-md-6 center">
                            <div class="panel panel-white" id="js-alerts">
                                <div class="panel-heading clearfix">
                                    <h3 class="panel-title">Password Changed! <small>successfully</small></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        <h4>Oh snap! You have successfully changed your password!</h4>
                                        <p>Please login with your changed password or go through your e-mail to get your new password.</p>
                                        <p>
                                            <a href="{{url('/')}}" class="btn btn-info">Login</a>
                                        </p>
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
    </body>
</html>