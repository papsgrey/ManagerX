<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>UM Client | ManagerX Ubundi </title>
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
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">UM CLIENT POPULATION</h4>
                                <div class="page-title-right d-flex gap-2">
                                    <!-- Add UM Client Button -->
                                    <a href="{{ route('create_umclients') }}" class="btn btn-primary">Add UM Client</a>
                                    <form action="{{ route('umclients_sendConfigurations') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-arrow-right"></i> Send All
                                        </button>
                                    </form>
                                    @if(session('error'))
                                        <script>
                                            alert('{{ session('error') }}');
                                        </script>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- UM Clients Table -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">List - UM Clients</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Client Name</th>
                                                <th>IP Address</th>
                                                <th>UM Server</th>
                                                <th>Username</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($umClients as $client)
                                                <tr>
                                                    <td>{{ $client->id }}</td>
                                                    <td>{{ $client->client_name }}</td>
                                                    <td>{{ $client->ip_address }}</td>
                                                    <td>{{ $client->umServer->server_name ?? 'N/A' }}</td>
                                                    <td>{{ $client->username }}</td>
                                                    <td>
                                                        <span class="badge {{ $client->status == 'Online' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                            {{ $client->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('umclients_sendConfigurations') }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                                                            <button type="submit" class="btn btn-success btn-sm">Send</button>
                                                        </form>
                                                        <a href="{{ route('edit_umclients', $client->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                                        <form action="{{ route('destroy_umclients', $client->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
            </div>
            <!-- Footer -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>

    <!-- Theme Settings -->
    @include('layouts.theme_settings')

    <!-- JAVASCRIPT -->
    <!--@include('accessories.add_um_server_bb_js')-->
    @include('accessories.init_js')

    
</body>
</html>
