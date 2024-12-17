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

        <!-- main content goes Here-->
        
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
