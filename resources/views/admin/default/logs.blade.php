<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title>Logs | ManagerX Ubundi </title>
    @include('layouts.head')
    <style>
        .log-entry {
            background-color: #f8f9fa;
            padding: 1rem;
            margin-bottom: 1rem;
            border-left: 5px solid #007bff;
            border-radius: 4px;
        }
        .log-timestamp {
            font-weight: bold;
            color: #007bff;
        }
        .log-level {
            font-weight: bold;
            text-transform: uppercase;
            margin-left: 10px;
        }
        .log-message {
            margin-top: 0.5rem;
            color: #333;
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <div id="layout-wrapper">
        @include('layouts.header')
        @include('layouts.navbar_menu')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">Application Logs</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Log Entries</h4>
                                </div>
                                <div class="card-body">
                                    @if(count($logEntries) > 0)
                                        @each('partials.log_entry', $logEntries, 'entry', 'partials.no_logs')
                                    @else
                                        <p>No log entries found.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>

    @include('layouts.theme_settings')
    @include('accessories.init_js')
</body>
</html>
