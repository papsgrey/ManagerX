<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Create Limits | ManagerX Ubundi </title>
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
                        <h4 class="mb-sm-0">Create Limit</h4>
                    </div>

                    <div class="container">
                        <!-- Display success message -->
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    
                        <!-- Display validation errors -->
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    
                    <!-- Form for Creating Limit -->
                    <div class="card-body">
                        <form action="{{ route('store_limit') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <!-- Dropdown for UM Server -->
                                <div class="col-md-6">
                                    <label for="um-server" class="form-label">UM Server</label>
                                    <select id="um-server" name="um_server_id" class="form-control" required>
                                        <option value="">Select UM Server</option>
                                        @foreach ($umServers as $umServer)
                                            <option value="{{ $umServer->id }}">{{ $umServer->server_name }} || {{ $umServer->ip_address }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Other Fields -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Limit Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="e.g., 20Mbps-Speed" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="transfer-limit" class="form-label">Transfer Limit (in bytes)</label>
                                    <input type="text" name="transfer_limit" id="transfer-limit" class="form-control" placeholder="e.g., 200G">
                                </div>
                                <div class="col-md-6">
                                    <label for="uptime-limit" class="form-label">Uptime Limit</label>
                                    <input type="text" name="uptime_limit" id="uptime-limit" class="form-control" placeholder="e.g., 1d">
                                </div>
                                <div class="col-md-6">
                                    <label for="rate-limit-rx" class="form-label">Rate Limit RX (in bytes/s)</label>
                                    <input type="text" name="rate_limit_rx" id="rate-limit-rx" class="form-control" placeholder="e.g., 20M">
                                </div>
                                <div class="col-md-6">
                                    <label for="rate-limit-tx" class="form-label">Rate Limit TX (in bytes/s)</label>
                                    <input type="text" name="rate_limit_tx" id="rate-limit-tx" class="form-control" placeholder="e.g., 20M">
                                </div>
                                <div class="col-md-6">
                                    <label for="rate-priority" class="form-label">Rate Limit Priority</label>
                                    <input type="number" name="rate_priority" id="rate-priority" class="form-control" placeholder="e.g., 0">
                                </div>
                            </div>
                    
                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route('set.bundle') }}" class="btn btn-outline-danger">Cancel</a>
                                <button type="submit" class="btn btn-success">Create Limit</button>
                            </div>
                        </form>
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
