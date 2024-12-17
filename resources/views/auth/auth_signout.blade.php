<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">


<head>

    <meta charset="utf-8" />
    <title>ManagerX Ubundi | Log Out </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="ManagerX" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

   <!-- Layout config Js -->
   <script src="{{ asset('js/layout.js') }}"></script>
   <!-- Bootstrap Css -->
   <link href="{{ asset('css/bootstrap.min.css') }}"    rel="stylesheet" type="text/css" />
   <!-- Icons Css -->
   <link href="{{ asset('css/icons.min.css') }}"  rel="stylesheet" type="text/css" />
   <!-- App Css-->
   <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />
   <!-- custom Css-->
   <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index.html" class="d-inline-block auth-logo">
                                    <img src="{{asset('images/logo-light2.png')}}" alt="" height="120">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4 card-bg-fill">
                            <div class="card-body p-4 text-center">
                                <lord-icon src="https://cdn.lordicon.com/hzomhqxz.json" trigger="loop" colors="primary:#405189,secondary:#08a88a" style="width:180px;height:180px"></lord-icon>

                                <div class="mt-4 pt-2">
                                    <h5>You are Logged Out</h5>
                                    <p class="text-muted">Sign back in <span class="fw-semibold">Ubundi</span> anytime</p>
                                    <div class="mt-4">
                                        <a href="{{route('signin')}}" class="btn btn-success w-100">Sign In</a>
                                    </div>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        @include('layouts.footer')
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->


        <!-- JAVASCRIPT -->
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/simplebar.min.js') }}"></script>
        <script src="{{ asset('js/lord-icon-2.1.0.js') }}"></script>
        <script src="{{ asset('js/waves.min.js') }}"></script>
        <script src="{{ asset('js/feather.min.js') }}"></script>
        <script src="{{ asset('js/plugins.js') }}"></script>
    
        <!-- particles js -->
        <script src="{{ asset('js/particles.js/particles.js') }}"></script>
        <!-- particles app js -->
        <script src="{{ asset('js/particles.app.js') }}"></script>
</body>


</html>