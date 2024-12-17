<div class="container-fluid">


    <div id="two-column-menu">
    </div>
    <ul class="navbar-nav" id="navbar-nav">
        <li class="menu-title"><span data-key="t-menu">Ubundi</span></li>
        <li class="nav-item">
            <a class="nav-link menu-link" href="{{route('admin.dashboard')}}" data-bs-toggle="none" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
            </a>
        </li> <!-- end Dashboard -->
        
        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                <i class="ri-apps-2-line"></i> <span data-key="t-apps">BroadBand</span> 
            </a>
            <div class="collapse menu-dropdown" id="sidebarApps">
                <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                        <a href="#sidebarCalendar" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCalendar" data-key="t-calender">
                            Customers
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarCalendar">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="apps-calendar.html" class="nav-link" data-key="t-main-calender"> New Customer </a>
                                </li>
                                <li class="nav-item">
                                    <a href="apps-calendar-month-grid.html" class="nav-link" data-key="t-month-grid"> All Customers </a>
                                </li>
                                <li class="nav-item">
                                    <a href="apps-calendar-month-grid.html" class="nav-link" data-key="t-month-grid"> Sort Customers</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <li class="nav-item">
                        <a href="#sidebarEmail" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarEmail" data-key="t-email">
                            Zone Management
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarEmail">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="apps-mailbox.html" class="nav-link" data-key="t-mailbox"> New Zone </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#sidebaremailTemplates" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebaremailTemplates" data-key="t-email-templates">
                                        Manage Zones
                                    </a>
                                    <div class="collapse menu-dropdown" id="sidebaremailTemplates">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="apps-email-basic.html" class="nav-link" data-key="t-basic-action"> Basic Action </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="apps-email-ecommerce.html" class="nav-link" data-key="t-ecommerce-action"> Ecommerce Action </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                   

                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                <i class="ri-layout-3-line"></i> <span data-key="t-layouts">HotSpot</span> </a>
            <div class="collapse menu-dropdown" id="sidebarLayouts">
                <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                        <a href="#sidebarEmail" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarEmail" data-key="t-email">
                            WiFi Users
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarEmail">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="apps-mailbox.html" class="nav-link" data-key="t-mailbox">List </a>
                                </li>
                                <li class="nav-item">
                                    <a href="apps-mailbox.html" class="nav-link" data-key="t-mailbox">Status </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="#sidebarAnalytics" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAnalytics" data-key="t-email">
                            Analytics
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarAnalytics">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="apps-mailbox.html" class="nav-link" data-key="t-mailbox"> Sessions </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#sidebaremailTemplates" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebaremailTemplates" data-key="t-email-templates">
                                        Reports
                                    </a>
                                    <div class="collapse menu-dropdown" id="sidebaremailTemplates">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="apps-email-basic.html" class="nav-link" data-key="t-basic-action"> Graphs </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="apps-email-ecommerce.html" class="nav-link" data-key="t-ecommerce-action"> DPi </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                    
                </ul>
            </div>
        </li> <!-- end Dashboard Menu -->

        <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">SET UP</span></li>

        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarNetworking" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarNetworking">
                <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Networking</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarNetworking">
                <ul class="nav nav-sm flex-column">
                    
                    <!-- IP Networking Section -->
                    <li class="nav-item">
                        <a href="#sidebarIpNetworking" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarIpNetworking" data-key="t-ipnetworking"> IP Networking
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarIpNetworking">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('show_list_umservers') }}" class="nav-link" data-key="t-umserver">UM Server</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-key="t-umclient" onclick="event.preventDefault(); document.getElementById('um-client-form').submit();"> UM Client
                                    </a>
                                    <form id="um-client-form" action="{{ route('show_list_umclients') }}" method="get" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('hs_client') }}" class="nav-link" data-key="t-hsclient"> HS Client
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
        
                    <!-- DHCP Server Section -->
                    <li class="nav-item">
                        <a href="#sidebarDhcpServer" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDhcpServer" data-key="t-dhcpserver"> DHCP Server
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarDhcpServer">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('dhcp_list') }}" class="nav-link" data-key="t-umclient-dhcp"> UM Client DHCP
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('hs_dhcp_list') }}" class="nav-link" data-key="t-hsclient-dhcp"> HS Client DHCP</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </li>
        

        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                <i class="ri-pages-line"></i> <span data-key="t-pages">Policies</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarPages">
                <ul class="nav nav-sm flex-column">
        
                    <!-- Broadband Section -->
                    <li class="nav-item">
                        <a href="#sidebarBroadband" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarBroadband" data-key="t-level-1.2">BroadBand</a>
                        <div class="collapse menu-dropdown" id="sidebarBroadband">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('set.bundle') }}" class="nav-link" data-key="t-level-2.1">Set Bundle</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-key="t-level-2.2">Create Profile</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
        
                    <!-- HotSpot Section -->
                    <li class="nav-item">
                        <a href="#sidebarHotspot" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarHotspot" data-key="t-level-1.3">HotSpot</a>
                        <div class="collapse menu-dropdown" id="sidebarHotspot">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="#sidebarHotspotUser" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarHotspotUser" data-key="t-level-2.3">WiFi User Policy</a>
                                    <div class="collapse menu-dropdown" id="sidebarHotspotUser">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-level-3.1">Speed Plan Policy</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-level-3.2">Data Plan Policy</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
        
                </ul>
            </div>
        </li>
        

        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLanding">
                <i class="ri-rocket-line"></i> <span data-key="t-landing">Billing</span>
            </a>
            <div class="collapse menu-dropdown" id="sidebarLanding">
                <ul class="nav nav-sm flex-column">
        
                    <!-- BroadBand Section -->
                    <li class="nav-item">
                        <a href="#sidebarBroadbandBilling" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarBroadbandBilling" data-key="t-level-1.2">BroadBand</a>
                        <div class="collapse menu-dropdown" id="sidebarBroadbandBilling">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="#sidebarBroadbandAccounts" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarBroadbandAccounts" data-key="t-level-2.2">Manage Accounts</a>
                                    <div class="collapse menu-dropdown" id="sidebarBroadbandAccounts">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-level-3.1">Invoice</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-level-3.2">Transactions</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-key="t-level-2.1">Payment Gateways</a>
                                </li>
                            </ul>
                        </div>
                    </li>
        
                    <!-- HotSpot Section -->
                    <li class="nav-item">
                        <a href="#sidebarHotspotBilling" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarHotspotBilling" data-key="t-level-1.3">HotSpot</a>
                        <div class="collapse menu-dropdown" id="sidebarHotspotBilling">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="#sidebarHotspotFiscals" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarHotspotFiscals" data-key="t-level-2.2">Fiscals</a>
                                    <div class="collapse menu-dropdown" id="sidebarHotspotFiscals">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-level-3.1">Invoice</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" data-key="t-level-3.2">Transactions</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link" data-key="t-level-2.1">Payment Gateways</a>
                                </li>
                            </ul>
                        </div>
                    </li>
        
                </ul>
            </div>
        </li>
        
        <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Administration</span></li>

        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarUI" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUI">
                <i class="ri-pencil-ruler-2-line"></i> <span data-key="t-base-ui">Users</span>
            </a>
            <div class="collapse menu-dropdown mega-dropdown-menu" id="sidebarUI">
                <div class="row">
                    <div class="col-lg-4">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="ui-alerts.html" class="nav-link" data-key="t-alerts">Manage Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="ui-badges.html" class="nav-link" data-key="t-badges">Zone Binding</a>
                            </li>
                            <li class="nav-item">
                                <a href="ui-buttons.html" class="nav-link" data-key="t-buttons">Captive Portal</a>
                            </li>
                            <li class="nav-item">
                                <a href="ui-colors.html" class="nav-link" data-key="t-colors">Logs</a>
                            </li>
                            <li class="nav-item">
                                <a href="ui-cards.html" class="nav-link" data-key="t-cards">API Documentation</a>
                            </li>

                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link menu-link" href="#sidebarAdvanceUI" data-bs-toggle="none" role="button" aria-expanded="false" aria-controls="sidebarAdvanceUI">
                <i class="ri-stack-line"></i> <span data-key="t-advance-ui">Reports</span>
            </a>

        </li>

        <li class="nav-item">
            <a class="nav-link menu-link" href="{{ route('logs') }}">
                <i class="ri-honour-line"></i> <span data-key="t-widgets">Logs</span>
            </a>
        </li>
        

      

    </ul>
</div>