<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>DHCP Client List | ManagerX Ubundi </title>
    @include('layouts.head')
</head>

<body>
    <div id="layout-wrapper">
        @include('layouts.header')
        @include('layouts.navbar_menu')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Display success or error messages -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Page title with "Add DHCP Server" button -->
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">HS DHCP Server List</h4>
                        
                        <!-- Button to add DHCP Server -->
                        <a href="{{ route('hs_dhcp_addserver') }}" class="btn btn-primary">
                            Add DHCP Server
                        </a>
                    </div>

                    <!-- HS DHCP Client List Section -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">HS Clients with DHCP Servers</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Client Name</th>
                                                    <th>IP Address</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($hsClients as $index => $client)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $client->hs_name }}</td>
                                                        <td>{{ $client->ip_address }}</td>
                                                        <td>
                                                            <span class="badge {{ $client->status == 'Online' ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $client->status }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('hs_dhcp_lease', $client->id) }}" class="btn btn-primary btn-sm">View Leases</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- container-fluid -->
            </div>
            @include('layouts.footer')
        </div>
    </div>

    @include('layouts.theme_settings')
    @include('accessories.init_js')

</body>
</html>
