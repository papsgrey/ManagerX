<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Add UM Server | ManagerX Ubundi </title>
@include('layouts.head')

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.header')

        <!-- ========== App Menu ========== -->
        @include('layouts.navbar_menu')

        <!-- Main content starts here -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- Start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">Adding UM Server</h4>
                            </div>
                        </div>
                    </div>
                    <!-- End page title -->

                    <div class="container mt-4">
                        <h4 class="mb-3">Provide UM Server Details</h4>

                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Error Messages -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form to Add UM Server -->
                        <form action="{{ route('store_umservers') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="server_name" class="form-label">Server Name</label>
                                <input type="text" class="form-control" id="server_name" name="server_name" placeholder="Enter Server Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="ip_address" class="form-label">IP Address</label>
                                <input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="Enter IP Address" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Save Server</button>
                                <a href="{{ route('show_list_umservers') }}" class="btn btn-outline-danger">Cancel</a>
                            </div>
                        </form>
                    </div>

                </div> <!-- End container-fluid -->
            </div> <!-- End Page-content -->

            <!-- Footer -->
            @include('layouts.footer')
        </div>
        <!-- End main content -->

    </div>


    <!-- End layout-wrapper -->

    <!-- Theme Settings -->
    @include('layouts.theme_settings')

    <!-- JAVASCRIPT -->
    @include('accessories.init_js')

</body>
</html>
