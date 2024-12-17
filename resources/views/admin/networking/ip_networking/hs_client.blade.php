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
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">HS CLIENT POPULATION</h4>

                                <div class="page-title-right d-flex gap-2">
                                     <!-- Add HS Client Button -->
                                    <a href="{{ route('add_hs_client') }}" class="btn btn-primary">
                                        Add HS Client
                                    </a>

                                    <!-- Send Configuration Button -->
                                    <form action="{{ route('send_hs_configuration') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-arrow-right"></i> Send
                                        </button>
                                    </form>

                                    <!-- Error Handling -->
                                    @if(session('error'))
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                alert('{{ session('error') }}');
                                            });
                                        </script>
                                    @endif

                                </div>
                          </div>
                     </div>
                 </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">List - HS Client</h4>
                                </div>
                                <div class="card-body">
                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif
                                    
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>HS Name</th>
                                                <th>IP Address</th>
                                                <th>UM Server</th>
                                                <th>Username</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($hsClients as $client)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $client->hs_name }}</td>
                                                    <td>{{ $client->ip_address }}</td>
                                                    <td>{{ $client->um_server }}</td>
                                                    <td>{{ $client->username }}</td>
                                                    <td>
                                                        <span class="badge {{ $client->status == 'Online' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $client->status }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <!-- Edit Button -->
                                                        <a href="{{ route('edit_hs_client', $client->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                                            Edit
                                                        </a>
                                                        
                                                        <!-- Delete Button -->
                                                        <form action="{{ route('delete_hs_client', $client->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this HS Client?');">
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
