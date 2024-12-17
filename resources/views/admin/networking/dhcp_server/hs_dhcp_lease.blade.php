<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>DHCP Leases | ManagerX Ubundi </title>
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
                    
                    <!-- Page Title -->
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">DHCP Leases for {{ $client->hs_name }}</h4>
                    </div>

                    <!-- DHCP Lease List Section -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">HS Client DHCP Leases</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>IP Address</th>
                                                    <th>MAC Address</th>
                                                    <th>Host Name</th>
                                                    <th>Server</th>
                                                    <th>Active Address</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($paginatedLeases as $lease)
                                                    <tr>
                                                        <td>{{ $lease['address'] ?? 'N/A' }}</td>
                                                        <td>{{ $lease['mac-address'] ?? 'N/A' }}</td>
                                                        <td>{{ $lease['host-name'] ?? 'N/A' }}</td>
                                                        <td>{{ $lease['server'] ?? 'N/A' }}</td>
                                                        <td>{{ $lease['active-address'] ?? 'N/A' }}</td>
                                                        <td>{{ $lease['status'] ?? 'Unknown' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination Links -->
                                    <div class="d-flex justify-content-center">
                                        {{ $paginatedLeases->links() }}
                                    </div>

                                    <!-- Buttons -->
                                    <div class="mt-4 d-flex justify-content-end">
                                        <a href="{{ route('hs_dhcp_list') }}" class="btn btn-outline-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container-fluid -->
            </div> <!-- End Page-content -->
            
            @include('layouts.footer')
        </div> <!-- end main content -->
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
