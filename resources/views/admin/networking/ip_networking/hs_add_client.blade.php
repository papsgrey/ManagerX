<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>HS Client | ManagerX Ubundi </title>
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
                        <h4 class="mb-sm-0">Add HS Client</h4>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('store_hs_client') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="hs_name" class="form-label">HS Name</label>
                                            <input type="text" name="hs_name" class="form-control" id="hs_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="ip_address" class="form-label">IP Address</label>
                                            <input type="text" name="ip_address" class="form-control" id="ip_address" required>
                                        </div>
                                        
                                        <!-- UM Server Dropdown -->
                                        <div class="mb-3">
                                            <label for="um_server" class="form-label">Select UM Server</label>
                                            <select name="um_server" id="um_server" class="form-select" required>
                                                <option value="">-- Select UM Server --</option>
                                                @foreach($umServers as $server)
                                                    <option value="{{ $server->ip_address }}">{{ $server->server_name }} ({{ $server->ip_address }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" id="username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add HS Client</button>
                                        <a href="{{ route('hs_client') }}" class="btn btn-secondary">Cancel</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @include('layouts.footer')
        </div>
        <!-- end main content-->
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
