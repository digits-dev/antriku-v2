<style>
    .notification-container-cus {
        position: relative;
        display: inline-block;
        cursor: pointer;
        padding-left: 8px;
        font-family: Arial, sans-serif;
    }

    .icon-cus {
        width: 32px;
        height: 32px;
        background-color: #34495e; /* Dark gray for sidebar look */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        transition: transform 0.2s ease-in-out;
    }

    .icon-cus:hover {
        transform: scale(1.1);
    }

    .notif-count-cus {
        position: absolute;
        top: -2px;
        right: -2px;
        background-color: red;
        color: white;
        font-size: 10px;
        font-weight: bold;
        width: 16px;
        height: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transform: scale(1);
        transform-origin: top right;
        animation: pop 0.3s ease-in-out;
    }

    @keyframes pop {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        80% {
            transform: scale(1.2);
            opacity: 1;
        }
        100% {
            transform: scale(1);
        }
    }

    .main-sidebar {
        height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
    }
</style>

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-{{ cbLang('left') }} image">
                <img src="{{ CRUDBooster::myPhoto() }}" class="img-circle" style="height: 45px;" alt="{{ cbLang('user_image') }}"/>
            </div>
            <div class="pull-{{ cbLang('left') }} info">
                <p>{{ CRUDBooster::myName() }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> {{ cbLang('online') }}</a>
            </div>
        </div>


        <div class='main-menu'>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header text-uppercase">{{cbLang("menu_navigation")}}</li>
                <!-- Optionally, you can add icons to the links -->

                <?php $dashboard = CRUDBooster::sidebarDashboard();?>
                @if($dashboard)
                    <li data-id='{{$dashboard->id}}' class="{{ (Request::is(config('crudbooster.ADMIN_PATH'))) ? 'active' : '' }}"><a
                        href='{{CRUDBooster::adminPath()}}' class='{{($dashboard->color)?"text-".$dashboard->color:""}}'>
                        {{-- <i class='fa fa-dashboard'></i> --}}
                        <img src="https://cdn-icons-png.flaticon.com/128/1828/1828673.png" alt="dash_icon" width="18">
                        <span>{{cbLang("text_dashboard")}}</span> </a></li>
                @endif

                @foreach(CRUDBooster::sidebarMenu() as $menu)
                    <li data-id='{{$menu->id}}' class='{{(!empty($menu->children))?"treeview":""}} {{ (Request::is($menu->url_path."*"))?"active":""}}'>
                        <a href='{{ ($menu->is_broken)?"javascript:alert('".cbLang('controller_route_404')."')":$menu->url }}'
                           class='{{($menu->color)?"text-".$menu->color:""}}'>
                            @if ($menu->name == 'Pending Repair')
                                <span>⚙️</span>
                            @elseif ($menu->name == 'To Diagnose')
                                <img src="https://cdn-icons-png.flaticon.com/128/675/675579.png" alt="dash_icon" width="18">
                            @elseif ($menu->name == 'Transaction History')
                                <img src="https://cdn-icons-png.flaticon.com/128/11411/11411453.png" width="18" alt="">
                            @elseif ($menu->name == 'Submaster Module')
                                <img src="https://cdn-icons-png.flaticon.com/128/10848/10848122.png" width="18" alt="">
                            @elseif ($menu->name == 'Call Out')
                                <img src="https://cdn-icons-png.flaticon.com/128/1256/1256652.png" width="18" alt="">
                            @elseif ($menu->name == 'To Pay Diagnostic')
                                <img src="https://cdn-icons-png.flaticon.com/128/8984/8984290.png" width="18" alt="">
                            @elseif ($menu->name == 'Create Transactions')
                                <img src="https://cdn-icons-png.flaticon.com/128/2921/2921226.png" width="18" alt="">
                            @elseif ($menu->name == 'Inventory')
                                <img src="https://cdn-icons-png.flaticon.com/128/10951/10951872.png" width="18" alt="">
                            @else
                                <i class='{{$menu->icon}} {{($menu->color)?"text-".$menu->color:""}}'></i> 
                            @endif  
                            <span>{{$menu->name}}</span>

                            {{-- module notif count  --}}
                            @if($menu->name == 'Pending Repair')
                                <div class="notification-container-cus" style="display: {{$ongoing_repair_count == 0 ? 'none' : ''}}">
                                    <div class="icon-cus">🔔</div>
                                    <div class="notif-count-cus">{{$ongoing_repair_count}}</div>
                                </div>
                            @endif

                            @if($menu->name == 'To Diagnose')
                                <div class="notification-container-cus" style="display: {{$to_diagnose_count == 0 ? 'none' : ''}}">
                                    <div class="icon-cus">🔔</div>
                                    <div class="notif-count-cus">{{$to_diagnose_count}}</div>
                                </div>
                            @endif

                            @if($menu->name == 'Pending Mail-In Shipment')
                                <div class="notification-container-cus" style="display: {{$pending_mail_in_shipment == 0 ? 'none' : ''}}">
                                    <div class="icon-cus">🔔</div>
                                    <div class="notif-count-cus">{{$pending_mail_in_shipment}}</div>
                                </div>
                            @endif

                            @if($menu->name == 'Call Out')
                                <div class="notification-container-cus" style="display: {{$callout_count_sidebar == 0 ? 'none' : ''}}">
                                    <div class="icon-cus">🔔</div>
                                    <div class="notif-count-cus">{{$callout_count_sidebar}}</div>
                                </div>
                            @endif

                            @if(!empty($menu->children))<i class="fa fa-angle-{{ cbLang("right") }} pull-{{ cbLang("right") }}"></i>@endif
                        </a>
                        @if(!empty($menu->children))
                            <ul class="treeview-menu">
                                @foreach($menu->children as $child)
                                    <li data-id='{{$child->id}}' class='{{(Request::is($child->url_path .= !Str::endsWith(Request::decodedPath(), $child->url_path) ? "/*" : ""))?"active":""}}'>
                                        <a href='{{ ($child->is_broken)?"javascript:alert('".cbLang('controller_route_404')."')":$child->url}}'
                                           class='{{($child->color)?"text-".$child->color:""}}'>
                                            @if (in_array($child->name, ['Stocks', 'Stock Reservations', 'Stock-In', 'Stock Dispose', 'Stock Receiving']))
                                                <img src="https://cdn-icons-png.flaticon.com/128/10951/10951869.png" width="18px" alt="">
                                            @else
                                                <i class='{{$child->icon}}'></i> 
                                            @endif
                                            <span>{{$child->name}}</span>

                                            @if($child->name == 'Receiving')
                                            <div class="notification-container-cus" style="display: {{$receiving == 0 ? 'none' : ''}}">
                                                <div class="icon-cus">🔔</div>
                                                <div class="notif-count-cus">{{$receiving}}</div>
                                            </div>
                                             @endif
                                            @if($child->name == 'Releasing')
                                            <div class="notification-container-cus" style="display: {{$releasing == 0 ? 'none' : ''}}">
                                                <div class="icon-cus">🔔</div>
                                                <div class="notif-count-cus">{{$releasing}}</div>
                                            </div>
                                             @endif
                                            
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach



                @if(CRUDBooster::isSuperadmin())
                    <li class="header">{{ cbLang('SUPERADMIN') }}</li>
                    <li class='treeview'>
                        <a href='#'><i class='fa fa-key'></i> <span>{{ cbLang('Privileges_Roles') }}</span> <i
                                    class="fa fa-angle-{{ cbLang("right") }} pull-{{ cbLang("right") }}"></i></a>
                        <ul class='treeview-menu'>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/privileges/add*')) ? 'active' : '' }}"><a
                                        href='{{Route("PrivilegesControllerGetAdd")}}'>{{ $current_path }}<i class='fa fa-plus'></i>
                                    <span>{{ cbLang('Add_New_Privilege') }}</span></a></li>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/privileges')) ? 'active' : '' }}"><a
                                        href='{{Route("PrivilegesControllerGetIndex")}}'><i class='fa fa-bars'></i>
                                    <span>{{ cbLang('List_Privilege') }}</span></a></li>
                        </ul>
                    </li>

                    <li class='treeview'>
                        <a href='#'><i class='fa fa-users'></i> <span>{{ cbLang('Users_Management') }}</span> <i
                                    class="fa fa-angle-{{ cbLang("right") }} pull-{{ cbLang("right") }}"></i></a>
                        <ul class='treeview-menu'>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/users/add*')) ? 'active' : '' }}"><a
                                        href='{{Route("AdminCmsUsersControllerGetAdd")}}'><i class='fa fa-plus'></i>
                                    <span>{{ cbLang('add_user') }}</span></a></li>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/users')) ? 'active' : '' }}"><a
                                        href='{{Route("AdminCmsUsersControllerGetIndex")}}'><i class='fa fa-bars'></i>
                                    <span>{{ cbLang('List_users') }}</span></a></li>
                        </ul>
                    </li>

                    <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/menu_management*')) ? 'active' : '' }}"><a
                                href='{{Route("MenusControllerGetIndex")}}'><i class='fa fa-bars'></i>
                            <span>{{ cbLang('Menu_Management') }}</span></a></li>
                    <li class="treeview">
                        <a href="#"><i class='fa fa-wrench'></i> <span>{{ cbLang('settings') }}</span> <i
                                    class="fa fa-angle-{{ cbLang("right") }} pull-{{ cbLang("right") }}"></i></a>
                        <ul class="treeview-menu">
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/settings/add*')) ? 'active' : '' }}"><a
                                        href='{{route("SettingsControllerGetAdd")}}'><i class='fa fa-plus'></i>
                                    <span>{{ cbLang('Add_New_Setting') }}</span></a></li>
                            <?php
                            $groupSetting = DB::table('cms_settings')->groupby('group_setting')->pluck('group_setting');
                            foreach($groupSetting as $gs):
                            ?>
                            <li class="<?=($gs == Request::get('group')) ? 'active' : ''?>"><a
                                        href='{{route("SettingsControllerGetShow")}}?group={{urlencode($gs)}}&m=0'><i class='fa fa-wrench'></i>
                                    <span>{{$gs}}</span></a></li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                    <li class='treeview'>
                        <a href='#'><i class='fa fa-th'></i> <span>{{ cbLang('Module_Generator') }}</span> <i
                                    class="fa fa-angle-{{ cbLang("right") }} pull-{{ cbLang("right") }}"></i></a>
                        <ul class='treeview-menu'>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/module_generator/step1')) ? 'active' : '' }}"><a
                                        href='{{Route("ModulsControllerGetStep1")}}'><i class='fa fa-plus'></i>
                                    <span>{{ cbLang('Add_New_Module') }}</span></a></li>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/module_generator')) ? 'active' : '' }}"><a
                                        href='{{Route("ModulsControllerGetIndex")}}'><i class='fa fa-bars'></i>
                                    <span>{{ cbLang('List_Module') }}</span></a></li>
                        </ul>
                    </li>

                    <li class='treeview'>
                        <a href='#'><i class='fa fa-dashboard'></i> <span>{{ cbLang('Statistic_Builder') }}</span> <i
                                    class="fa fa-angle-{{ cbLang("right") }} pull-{{ cbLang("right") }}"></i></a>
                        <ul class='treeview-menu'>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/statistic_builder/add')) ? 'active' : '' }}"><a
                                        href='{{Route("StatisticBuilderControllerGetAdd")}}'><i class='fa fa-plus'></i>
                                    <span>{{ cbLang('Add_New_Statistic') }}</span></a></li>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/statistic_builder')) ? 'active' : '' }}"><a
                                        href='{{Route("StatisticBuilderControllerGetIndex")}}'><i class='fa fa-bars'></i>
                                    <span>{{ cbLang('List_Statistic') }}</span></a></li>
                        </ul>
                    </li>

                    <li class='treeview'>
                        <a href='#'><i class='fa fa-fire'></i> <span>{{ cbLang('API_Generator') }}</span> <i
                                    class="fa fa-angle-{{ cbLang("right") }} pull-{{ cbLang("right") }}"></i></a>
                        <ul class='treeview-menu'>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/api_generator/generator*')) ? 'active' : '' }}"><a
                                        href='{{Route("ApiCustomControllerGetGenerator")}}'><i class='fa fa-plus'></i>
                                    <span>{{ cbLang('Add_New_API') }}</span></a></li>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/api_generator')) ? 'active' : '' }}"><a
                                        href='{{Route("ApiCustomControllerGetIndex")}}'><i class='fa fa-bars'></i>
                                    <span>{{ cbLang('list_API') }}</span></a></li>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/api_generator/screet-key*')) ? 'active' : '' }}"><a
                                        href='{{Route("ApiCustomControllerGetScreetKey")}}'><i class='fa fa-bars'></i>
                                    <span>{{ cbLang('Generate_Screet_Key') }}</span></a></li>
                        </ul>
                    </li>

                    <li class='treeview'>
                        <a href='#'><i class='fa fa-envelope-o'></i> <span>{{ cbLang('Email_Templates') }}</span> <i
                                    class="fa fa-angle-{{ cbLang("right") }} pull-{{ cbLang("right") }}"></i></a>
                        <ul class='treeview-menu'>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/email_templates/add*')) ? 'active' : '' }}"><a
                                        href='{{Route("EmailTemplatesControllerGetAdd")}}'><i class='fa fa-plus'></i>
                                    <span>{{ cbLang('Add_New_Email') }}</span></a></li>
                            <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/email_templates')) ? 'active' : '' }}"><a
                                        href='{{Route("EmailTemplatesControllerGetIndex")}}'><i class='fa fa-bars'></i>
                                    <span>{{ cbLang('List_Email_Template') }}</span></a></li>
                        </ul>
                    </li>

                    <li class="{{ (Request::is(config('crudbooster.ADMIN_PATH').'/logs*')) ? 'active' : '' }}"><a href='{{Route("LogsControllerGetIndex")}}'><i
                                    class='fa fa-flag'></i> <span>{{ cbLang('Log_User_Access') }}</span></a></li>
                @endif

            </ul><!-- /.sidebar-menu -->

        </div>

    </section>
    <!-- /.sidebar -->
</aside>

