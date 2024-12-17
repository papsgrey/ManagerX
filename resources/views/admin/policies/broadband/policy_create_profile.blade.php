<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Create Profile | ManagerX Ubundi </title>
@include('layouts.head')

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.header')

        <!--========== App Menu ==========-->
        @include('layouts.navbar_menu')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Create Profile</h4>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title">New Profile</h4>
                        </div>
                        <div class="card-body">
                            <!-- Display Errors -->
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif


                            <!-- Form for Creating Profile -->
                            <form action="{{ route('store_profile') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <!-- UM Server Dropdown -->
                                    <div class="col-md-6">
                                        <label for="um-server" class="form-label">UM Server</label>
                                        <select id="um-server" name="um_server_id" class="form-control" required>
                                            <option value="">Select UM Server</option>
                                            @foreach ($umServers as $umServer)
                                                <option value="{{ $umServer->id }}">{{ $umServer->server_name }} || {{ $umServer->ip_address }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Profile Name -->
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Profile Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="e.g., 20Mbps-Unlimited-Speed" required>
                                    </div>

                                    <!-- Validity -->
                                    <div class="col-md-6">
                                        <label for="validity" class="form-label">Validity (e.g., 1d or 30d)</label>
                                        <input type="text" name="validity" id="validity" class="form-control" placeholder="e.g., 1d">
                                    </div>

                                    <!-- Name for Users -->
                                    <div class="col-md-6">
                                        <label for="name-for-users" class="form-label">Name for Users</label>
                                        <input type="text" name="name_for_users" id="name-for-users" class="form-control" placeholder="e.g., 20Mbps-Unlimited-Speed" required>
                                    </div>

                                    <!-- Starts When -->
                                    <div class="col-md-6">
                                        <label for="starts-when" class="form-label">Starts When</label>
                                        <select name="starts_when" id="starts-when" class="form-control">
                                            <option value="first-auth">First Auth</option>
                                            <option value="immediate">Immediate</option>
                                        </select>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-6">
                                        <label for="price" class="form-label">Price </label>
                                        <input type="number" name="price" id="price" class="form-control" placeholder="e.g., 100">
                                    </div>

                                    <!-- Override Shared Users -->
                                    <div class="col-md-6">
                                        <label for="override-shared-users" class="form-label">Override Shared Users</label>
                                        <select name="override_shared_users" id="override-shared-users" class="form-control">
                                            <option value="off">Off</option>
                                            <option value="on">On</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4 d-flex justify-content-between">
                                    <a href="{{ route('set.bundle') }}" class="btn btn-outline-danger">Cancel</a>
                                    <button type="submit" class="btn btn-success">Create Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
        
    </div>

    <!-- Theme Settings -->
    @include('layouts.theme_settings')

    <!-- JAVASCRIPT -->
    <!--@include('accessories.add_um_server_bb_js')-->
    @include('accessories.init_js')

    <script>
        document.getElementById('save-server-btn').addEventListener('click', function() {
            const button = this;
        
            // Add the bounce animation class
            button.classList.add('animate__bounce');
        
            // Remove the class after the animation ends to allow it to be triggered again
            button.addEventListener('animationend', function() {
                button.classList.remove('animate__bounce');
            }, { once: true }); // Use { once: true } to ensure the listener is removed after it runs
        });
    </script>
</body>
</html>
