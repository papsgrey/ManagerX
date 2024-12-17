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

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">UM SERVER POPULATION</h4>

                                <!-- Add UM Server Button -->
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <a href="{{ route('create_umservers') }}" class="btn btn-primary">
                                            <i class="bi bi-plus-lg"></i> Add UM Server
                                        </a>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- Server List Section -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">List - UM Server</h4>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <!-- Table for displaying UM Servers -->
                                    <div id="server-list" class="server-list-table">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Server Name</th>
                                                    <th scope="col">IP Address</th>
                                                    <th scope="col">Username</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Actions</th> 
                                                </tr>
                                            </thead>
                                            <tbody id="server-table-body">
                                                @foreach ($servers as $server)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $server->server_name }}</td>
                                                        <td>{{ $server->ip_address }}</td>
                                                        <td>{{ $server->username }}</td>
                                                        <td>
                                                            @if ($server->status == 'Online')
                                                                <span class="badge bg-success-subtle text-success">Online</span>
                                                            @else
                                                                <span class="badge bg-danger-subtle text-danger">Offline</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <!-- Edit Button -->
                                                            <a href="{{ route('edit_umservers', $server->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                                Edit
                                                            </a>
                                                            
                                                            <!-- Delete Button -->
                                                            <form action="{{ route('destroy_umservers', $server->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this server?');">
                                                                    Delete
                                                                </button>
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
                    </div>
                    <!--end row-->
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

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