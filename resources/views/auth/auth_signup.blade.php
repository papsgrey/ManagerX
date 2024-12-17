<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">


<head>

    <meta charset="utf-8" />
    <title>ManagerX Ubundi | Sign Up </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
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

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Create New Account</h5>
                                    
                                </div>
                                
                                <div class="p-2 mt-4">
                                    <form class="needs-validation" novalidate action="{{ route('signup.submit') }}" method="POST">
                                        @csrf
                                                                                
                                        <div class="mb-3">
                                            <label for="fullname" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter full name" required>
                                            <div class="invalid-feedback">
                                                Please enter full name
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                                            <div class="invalid-feedback">
                                                Please enter username
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email"   placeholder="Enter email address" required>
                                            <div class="invalid-feedback">
                                                Please enter email
                                            </div>
                                        </div>
                                         <!-- Mobile Number -->
                                        <div class="mb-3">
                                            <label for="mobile_number" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter mobile number" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid mobile number
                                            </div>
                                        </div>

                                        <!-- Password -->
                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password <span class="text-danger">*</span></label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5" name="password" id="password-input" placeholder="Enter password" required>
                                                <div class="invalid-feedback">
                                                    Please enter a password
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Confirm Password -->
                                        <div class="mb-3">
                                            <label class="form-label" for="password-confirm">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" name="password_confirmation" id="password-confirm" placeholder="Confirm your password" required>
                                            <div class="invalid-feedback">
                                                Password confirmation doesn't match
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the Velzon <a href="#" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a></p>
                                        </div>

                                        <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                            <h5 class="fs-13">Password must contain:</h5>
                                            <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                            <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                                            <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                            <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign Up</button>
                                        </div>


                                    </form>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Already have an account ? <a href="{{ route('signin') }}" class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

@include('layouts.footer')
    </div>
    <!-- end auth-page-wrapper -->

      <!-- JAVASCRIPT -->
      <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('js/simplebar.min.js') }}"></script>
      <script src="{{ asset('js/lord-icon-2.1.0.js') }}"></script>
      <script src="{{ asset('js/waves.min.js') }}"></script>
      <script src="{{ asset('js/feather.min.js') }}"></script>
      <script src="{{ asset('js/plugins.js') }}"></script>
      <script src="{{ asset('js/password-addon.init.js') }}"></script>
      <!-- particles js -->
      <script src="{{ asset('js/particles.js/particles.js') }}"></script>
      <script src="{{ asset('js/particles.js/particles.app.js') }}"></script>
      <script src="{{ asset('js/form-validation.init.js') }}"></script>
      <script src="{{ asset('js/passowrd-create.init.js') }}"></script>

</body>


</html>