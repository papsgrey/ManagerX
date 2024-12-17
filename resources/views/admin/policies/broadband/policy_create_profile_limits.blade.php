<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Profile Limits | ManagerX Ubundi </title>
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
                        <h4 class="mb-sm-0">Create Profile Limits</h4>
                    </div>

                    <!-- Form for Creating Profile Limits -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">New Profile Limits</h4>
                        </div>
                        <div id="notification" class="alert d-none" role="alert"></div>

                        <div class="card-body">
                            <form action="{{ route('store_profile_limitation') }}" method="POST" id="createProfileLimitationForm">
                                @csrf
                                <div class="row g-3">
                                    <!-- UM Server Dropdown -->
                                    <div class="col-md-6">
                                        <label for="um-server" class="form-label">UM Server</label>
                                        <div class="d-flex gap-2">
                                            <select id="um-server" name="um_server_id" class="form-control" required>
                                                <option value="">Select UM Server</option>
                                                @foreach ($umServers as $umServer)
                                                    <option value="{{ $umServer->id }}">{{ $umServer->server_name }} || {{ $umServer->ip_address }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" id="loadButton" class="btn btn-primary">Load</button>
                                        </div>
                                    </div>

                                    <!-- Profile Dropdown -->
                                    <div class="col-md-6">
                                        <label for="profile" class="form-label">Profile</label>
                                        <select id="profile" name="profile" class="form-control" disabled required>
                                            <option value="">Select Profile</option>
                                        </select>
                                    </div>

                                    <!-- Limitation Dropdown -->
                                    <div class="col-md-6">
                                        <label for="limitation" class="form-label">Limits</label>
                                        <select id="limitation" name="limitation" class="form-control" disabled required>
                                            <option value="">Select Limits</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="mt-4 d-flex justify-content-between">
                                    <a href="{{ route('set.bundle') }}" class="btn btn-outline-danger">Cancel</a>
                                    <button type="submit" class="btn btn-success" id="createButton" disabled>Create Profile Limits</button>
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
    @include('accessories.policies.profile_limits_js')

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
