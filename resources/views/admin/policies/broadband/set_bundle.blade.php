<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Bundles | ManagerX Ubundi </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    

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
                    <!-- Page Header -->
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Profiles Management</h4>
                        <div class="d-flex align-items-center gap-2">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="createOptions" data-bs-toggle="dropdown" aria-expanded="false">
                                    Select Action
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="createOptions">
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-action="limits">Create Limits</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-action="profile">Create Profile</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-action="profile_limitation">Create Profile Limitation</a></li>
                                </ul>
                            </div>
                            <button id="addButton" class="btn btn-success">Add</button>
                        </div>
                    </div>

                    <!-- Card Section -->
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between">
                            <h4 class="card-title">UM Server Profiles</h4>
                            <select id="umServerSelect" class="form-select" style="width: auto;">
                                <option value="">-- Select UM Server --</option>
                                @foreach($umServers as $server)
                                    <option value="{{ $server->id }}">{{ $server->server_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="card-body">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="profiles-tab" data-bs-toggle="tab" href="#profiles" role="tab" aria-controls="profiles" aria-selected="true">Profiles</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="limits-tab" data-bs-toggle="tab" href="#limits" role="tab" aria-controls="limits" aria-selected="false">Limits</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-limits-tab" data-bs-toggle="tab" href="#profile-limits" role="tab" aria-controls="profile-limits" aria-selected="false">Profile Limits</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3">
                                <!-- Profiles Tab -->
                                <div class="tab-pane fade show active" id="profiles" role="tabpanel">
                                    <div id="profilesTable" class="table-responsive">
                                        <p class="text-muted">Please select a UM Server to view profiles.</p>
                                    </div>
                                </div>
                                <!-- Limits Tab -->
                                <div class="tab-pane fade" id="limits" role="tabpanel">
                                    <div id="limitsTable" class="table-responsive">
                                        <p class="text-muted">Please select a UM Server to view limits.</p>
                                    </div>
                                </div>
                                <!-- Profile Limits Tab -->
                                <div class="tab-pane fade" id="profile-limits" role="tabpanel">
                                    <div id="profileLimitsTable" class="table-responsive">
                                        <p class="text-muted">Please select a UM Server to view profile limitations.</p>
                                    </div>
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
    @include('accessories.init_js')
    <script>
        // Handle UM Server selection
        document.getElementById('umServerSelect').addEventListener('change', function () {
            const serverId = this.value;

            if (serverId) {
                fetchProfiles(serverId);
                fetchLimits(serverId);
                fetchProfileLimits(serverId);
            } else {
                clearTables();
            }
        });

        // Fetch Profiles
        function fetchProfiles(serverId) {
            fetch(`/um-servers/${serverId}/profiles`)
                .then(response => response.json())
                .then(data => updateTable('profilesTable', data, ['Profile Name', 'Download Limit', 'Upload Limit', 'Validity']));
        }

        // Fetch Limits
        function fetchLimits(serverId) {
            fetch(`/um-servers/${serverId}/limits`)
                .then(response => response.json())
                .then(data => updateTable('limitsTable', data, ['Limit Name', 'Download Limit', 'Upload Limit']));
        }

        // Fetch Profile Limits
        function fetchProfileLimits(serverId) {
            fetch(`/um-servers/${serverId}/profile-limits`)
                .then(response => response.json())
                .then(data => updateTable('profileLimitsTable', data, ['Profile Name', 'Limit Name']));
        }

        // Update Tables
        function updateTable(tableId, data, columns) {
            const tableContainer = document.getElementById(tableId);
            tableContainer.innerHTML = '';

            if (data.length === 0) {
                tableContainer.innerHTML = '<p class="text-muted">No data available.</p>';
                return;
            }

            let table = `<table class="table table-bordered"><thead><tr>`;
            columns.forEach(column => {
                table += `<th>${column}</th>`;
            });
            table += `</tr></thead><tbody>`;

            data.forEach(row => {
                table += `<tr>`;
                for (const key in row) {
                    table += `<td>${row[key]}</td>`;
                }
                table += `</tr>`;
            });

            table += `</tbody></table>`;
            tableContainer.innerHTML = table;
        }

        // Clear all tables
        function clearTables() {
            document.getElementById('profilesTable').innerHTML = '<p class="text-muted">Please select a UM Server to view profiles.</p>';
            document.getElementById('limitsTable').innerHTML = '<p class="text-muted">Please select a UM Server to view limits.</p>';
            document.getElementById('profileLimitsTable').innerHTML = '<p class="text-muted">Please select a UM Server to view profile limitations.</p>';
        }
    </script>
</body>
</html>
