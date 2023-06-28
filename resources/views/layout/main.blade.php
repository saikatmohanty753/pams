<!DOCTYPE html>
<html lang="en">
    <head>
        
        <!-- Title -->
        <title>PAMS | Oasys Tech Solutions Pvt. Ltd.</title>
        
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">
        <meta name="description" content="Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="stacks" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
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
        <link href="{{ url('assets/plugins/slidepushmenus/css/component.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('assets/css/select2.min.css') }}" rel="stylesheet" />
        
        <!-- Theme Styles -->
        <link href="{{ url('assets/css/meteor.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ url('assets/css/layers/dark-layer.css') }}" class="theme-color" rel="stylesheet" type="text/css"/>
        <link href="{{ url('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>
        
        <script src="{{ url('assets/plugins/3d-bold-navigation/js/modernizr.js') }}"></script>
        <script src="{{ url('assets/plugins/offcanvasmenueffects/js/snap.svg-min.js') }}"></script>

        <link href="{{ url('assets/plugins/datatables/css/jquery.datatables.min.css') }}" rel="stylesheet" type="text/css"/>	
        <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>	
        <link href="{{ url('assets/plugins/datatables/css/jquery.datatables_themeroller.css') }}" rel="stylesheet" type="text/css"/>	

        <link rel="stylesheet" type="text/css" href="{{ url('assets/css/toastr.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('assets/css/custom.css') }}">
        <link href="{{ url('assets/plugins/summernote-master/summernote.css') }}" rel="stylesheet" type="text/css"/>

        <script src="{{ url('assets/plugins/jquery/jquery-3.1.0.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            .msg-content{
                justify-content: center;
            }
            
        </style>
    </head>
        <main class="page-content content-wrap">
            {{-- Header --}}
                @include('elements/header')
            {{-- Ends Header --}}
            {{-- Sidebar --}}
                @include('elements/sidebar')
            {{-- Ends Sidebar --}}
            <div class="page-inner">
                @yield('content')
                <div class="page-footer">
                    <p class="no-s">Made with <i class="fa fa-heart" style="color: red"></i> by Oasys Tech Solutions</p>
                </div>
            </div>
            
        </main>
    <body class="compact-menu">
     <!-- Javascripts -->
     
     
    <script src="{{ url('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    {{-- <script src="{{ url('assets/plugins/pace-master/pace.min.js') }}"></script> --}}
    <script src="{{ url('assets/plugins/jquery-blockui/jquery.blockui.js') }}"></script>
    <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ url('assets/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ url('assets/plugins/uniform/js/jquery.uniform.standalone.js') }}"></script>
    <script src="{{ url('assets/plugins/offcanvasmenueffects/js/classie.js') }}"></script>
    <script src="{{ url('assets/plugins/waves/waves.min.js') }}"></script>
    <script src="{{ url('assets/plugins/3d-bold-navigation/js/main.js') }}"></script>
    <script src="{{ url('assets/js/meteor.min.js') }}"></script>
    <script src="{{ url('assets/js/select2.min.js') }}"></script>
    <script src="{{ url('assets/plugins/datatables/js/jquery.datatables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="{{ url('assets/js/toastr.min.js') }}"></script>
    <script src="{{ url('assets/plugins/summernote-master/summernote.min.js') }}"></script>
     


     {{-- Flash Messages --}}
     <script>
         $(document).ready(function(){
            @if(Session::has('success'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : false
            }
            toastr.success("{{ session('success') }}");
            {{ Session::forget('success') }}
            @endif

            @if(Session::has('error'))
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : false
                }
                toastr.error("{{ session('error') }}");
                {{ Session::forget('error') }}
            @endif

            @if(Session::has('info'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : false
            }
                toastr.info("{{ session('info') }}");
                {{ Session::forget('info') }}
            @endif

            @if(Session::has('warning'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : false
            }
            toastr.warning("{{ session('warning') }}");
            {{ Session::forget('warning') }}
            @endif

            @if($errors->any())
            @foreach($errors->all() as $error)
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : false
            }
            toastr.error("{{ $error }}");
            @endforeach
            @endif

            @if(Session::has('customError'))
            @foreach(session('customError') as $customerror)

            @if(array_key_exists("error",$customerror))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : false
            }
            toastr.error("{{ $customerror['error'] }}");
            @endif

            @if(array_key_exists("success",$customerror))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : false
            }
            toastr.success("{{ $customerror['success'] }}");
            @endif

            @if(array_key_exists("info",$customerror))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : false
            }
            toastr.info("{{ $customerror['info'] }}");
            @endif

            @if(array_key_exists("warning",$customerror))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : false
            }
            toastr.warning("{{ $customerror['warning'] }}");
            @endif

            @endforeach
            {{ Session::forget('customError') }}
            @endif
         })
     </script>
     
     {{-- Flash Messages Ends Here --}}
     {{-- Custom JS --}}
     @include('custom_js')
     {{-- Custom JS Ends --}}

     {{-- Validation.js --}}
     @include('validation');
     {{-- Validation.js Ends --}}

 </body>
</html>