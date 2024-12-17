<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Add UM Client | ManagerX Ubundi </title>
@include('layouts.head')

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.header')

        <!-- ========== App Menu ========== -->
        @include('layouts.navbar_menu')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- Start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">Add UM Client</h4>
                            </div>
                        </div>
                    </div>
                    <!-- End page title -->

                    <div class="container mt-4">
                        <h4 class="mb-3">Provide UM Client Details</h4>

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

                        <!-- Form to Add UM Client -->
                        <form action="{{ route('store_umclients') }}" method="POST">
                            @csrf
                            
                            <!-- Client Name -->
                            <div class="mb-3">
                                <label for="client_name" class="form-label">Client Name</label>
                                <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Enter Client Name" required>
                            </div>
                            
                            <!-- IP Address -->
                            <div class="mb-3">
                                <label for="ip_address" class="form-label">IP Address</label>
                                <input type="text" class="form-control" id="ip_address" name="ip_address" placeholder="Enter IP Address" required>
                            </div>
                            
                            <!-- Select UM Server -->
                            <div class="mb-3">
                                <label for="um_server_ip" class="form-label">Select UM Server</label>
                                <select class="form-control" id="um_server_ip" name="um_server_ip" required>
                                    <option value="">-- Select UM Server --</option>
                                    @foreach($umServers as $server)
                                        <option value="{{ $server->ip_address }}">{{ $server->server_name }} | {{ $server->ip_address }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                            </div>
                            
                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Save Client</button>
                                <a href="{{ route('show_list_umclients') }}" class="btn btn-outline-danger">Cancel</a>
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
