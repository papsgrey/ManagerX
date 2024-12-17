<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>UM Servers | ManagerX Ubundi </title>
@include('layouts.head')

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.header')

        <!--========== App Menu ==========-->
        @include('layouts.navbar_menu')


<!-- Main content starts here -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                <h4 class="mb-sm-0">Add DHCP Server for HS Client</h4>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Form to add DHCP Server for HS Client -->
                            <form action="{{ route('store_hs_dhcp_server') }}" method="POST">
                                @csrf
                                
                                <!-- Dropdown to select HS Client -->
                                <div class="mb-3">
                                    <label for="hs_client" class="form-label">Select HS Client</label>
                                    <select name="hs_client_id" id="hs_client" class="form-select" required>
                                        <option value="">-- Select HS Client --</option>
                                        @foreach($hsClients as $hsClient)
                                            <option value="{{ $hsClient->id }}">{{ $hsClient->hs_name }} ({{ $hsClient->ip_address }})</option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <!-- DHCP Configuration Fields -->
                                <div class="mb-3">
                                    <label for="server_name" class="form-label">DHCP Server Name</label>
                                    <input type="text" name="server_name" class="form-control" id="server_name" required>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="interface" class="form-label">DHCP Server Interface</label>
                                    <input type="text" name="interface" class="form-control" id="interface" required>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="address_space" class="form-label">DHCP Address Space (e.g., 192.168.88.0/24)</label>
                                    <input type="text" name="address_space" class="form-control" id="address_space" required>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="gateway" class="form-label">Gateway for DHCP Network</label>
                                    <input type="text" name="gateway" class="form-control" id="gateway" required>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="addresses" class="form-label">Addresses to Give Out (e.g., 192.168.88.10-192.168.88.50)</label>
                                    <input type="text" name="addresses" class="form-control" id="addresses" required>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="dns_servers" class="form-label">DNS Servers (comma-separated)</label>
                                    <input type="text" name="dns_servers" class="form-control" id="dns_servers" required>
                                </div>
                        
                                <div class="mb-3">
                                    <label for="lease_time" class="form-label">Lease Time (default: 00:30:00)</label>
                                    <input type="text" name="lease_time" class="form-control" id="lease_time" value="00:30:00" required>
                                </div>
                        
                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Configure DHCP Server</button>
                                <a href="{{ route('hs_dhcp_list') }}" class="btn btn-outline-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
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
