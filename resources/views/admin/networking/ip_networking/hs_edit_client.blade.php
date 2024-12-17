<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Edit UM Server | ManagerX Ubundi </title>
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
                                <h4 class="mb-sm-0">Edit HS Client</h4>
                            </div>
                        </div>
                    </div>
                    <!-- End page title -->

                    <div class="container mt-4">
                        <h4 class="mb-3">Edit HS Client Details</h4>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Edit HS Client Form -->
                        <form action="{{ route('update_hs_client', $hsClient->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="hs_name" class="form-label">HS Client Name</label>
                                <input type="text" class="form-control" name="hs_name" value="{{ $hsClient->hs_name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="ip_address" class="form-label">IP Address</label>
                                <input type="text" class="form-control" name="ip_address" value="{{ $hsClient->ip_address }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="um_server" class="form-label">UM Server</label>
                                <select name="um_server" id="um_server" class="form-select" required>
                                    <option value="">-- Select UM Server --</option>
                                    @foreach($umServers as $server)
                                        <option value="{{ $server->ip_address }}" 
                                                {{ $hsClient->um_server == $server->ip_address ? 'selected' : '' }}>
                                            {{ $server->server_name }} ({{ $server->ip_address }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="{{ $hsClient->username }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Leave blank to keep the same">
                            </div>

                            <button type="submit" class="btn btn-primary">Update HS Client</button>
                            <a href="{{ route('hs_client') }}" class="btn btn-outline-danger">Cancel</a>
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
