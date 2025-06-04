<style>
    .sidebar-toggle {
        display: inline-block;
        transition: transform 0.4s ease;
        padding: 10px;
        background-color: #007bff;
        border-radius: 0px;
        text-align: center;
        cursor: pointer;
    }

    /* Rotation effect */
    .rotate {
        transform: rotate(360deg);
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        20%,
        60% {
            transform: translateX(-10px);
        }

        40%,
        80% {
            transform: translateX(10px);
        }
    }

    .shake {
        animation: shake 0.5s;
        animation-fill-mode: forwards;
    }

    .content-header{
        margin-top: 70px;
    }

    @media (max-width: 767px) {
        .content-header {
            margin-top: 110px;
        }

        .time-date-card-cust {
            display: none !important;
        }
    }

    .datetime-card {
      display: flex;
      align-items: center;
      gap: 20px;
      margin: 7.5px 10px 0 0;
      padding: 8px 16px;
      background: linear-gradient(135deg, rgba(236, 236, 236, 0.08), rgba(236, 236, 236, 0.414));
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      font-weight: 500;
      font-size: 15px;
      color: #f9f9f9;
      max-width: fit-content;
    }

    .datetime-card i {
      font-size: 15px;
      color: white;
    }

    .datetime-item {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Optional hover effect */
    .datetime-card:hover {
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
      transform: translateY(-1px);
      transition: 0.3s ease;
    }

    .sidebar-toggle:hover {
        background: transparent !important;
    }

    .card-invo {
      background: white;
      border-radius: 10px;
      padding: 30px;
      /* box-shadow: 0 2px 10px rgba(0,0,0,0.1); */
      max-width: 400px;
      width: 100%;
    }

    .card-invo h2 {
      margin-bottom: 20px;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
    }

    .switch-invo {
      position: relative;
      display: inline-block;
      width: 55px;
      height: 29px;
      margin-right: 10px;
    }

    .switch-invo input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider-invo {
      position: absolute;
      cursor: pointer;
      top: 0; left: 0;
      right: 0; bottom: 0;
      background-color: #ccc;
      transition: 0.4s;
      border-radius: 34px;
    }

    .slider-invo:before {
      position: absolute;
      content: "";
      height: 21px;
      width: 21px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      transition: 0.4s;
      border-radius: 50%;
    }

    input:checked + .slider-invo {
      background-color: #f52f2f;
    }

    input:checked + .slider-invo:before {
      transform: translateX(26px);
    }

    .status-text-invo {
      display: inline-block;
      vertical-align: middle;
      font-size: 16px;
    }
</style>

<!-- Main Header -->
<header class="main-header" style="position: fixed; width: 100%; background: #111827 !important; padding: 10px 0 10px 0">

    <!-- Logo -->
    <a href="{{url(config('crudbooster.ADMIN_PATH'))}}" title='{{Session::get('appname')}}' class="logo" style="background: #111827;">
        <center>
            {{-- <i class="bi bi-box-fill"></i> --}}
            <img src="{{ asset('/img/btbt.png') }}" width="35px" alt="">
            <small style="font-size: 17px;">
                {{CRUDBooster::getSetting('appname')}}
            </small>
        </center>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="background: #111827;">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li>
                    <div class="datetime-card time-date-card-cust">
                        <div class="datetime-item">
                          <i class="bi bi-clock-fill"></i>
                          <span id="time">--:--:-- --</span>
                        </div>
                    
                        <div class="datetime-item">
                          <i class="bi bi-calendar-day-fill"></i>
                          <span id="date">--/--/----</span>
                        </div>
                    </div>
                </li>

                @if (CRUDBooster::myPrivilegeId() == 10)
                    <li>
                        <div style="color: white; margin: 15px 8px 15px 8px; cursor:pointer;" id="invoices_config">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                    </li>
                @endif

                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title='Notifications' aria-expanded="false" id="notification_bell">
                        <i id='icon_notification' class="fa fa-bell"></i>
                        <span id='notification_count' class="label label-danger" style="display:none">0</span>
                        {{-- <div class="notification-container-cus">
                            <div class="icon-cus">🔔</div>
                            <div class="notif-count-cus">0</div>
                        </div> --}}
                    </a>
                    <ul id='list_notifications' class="dropdown-menu">
                        <li class="header">{{cbLang("text_no_notification")}}</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;">
                                <ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
                                    <li>
                                        <a href="#">
                                            <em>{{cbLang("text_no_notification")}}</em>
                                        </a>
                                    </li>

                                </ul>
                                <div class="slimScrollBar"
                                     style="width: 3px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 195.122px; background: rgb(0, 0, 0);"></div>
                                <div class="slimScrollRail"
                                     style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>
                            </div>
                        </li>
                        <li class="footer"><a href="{{route('NotificationsControllerGetIndex')}}">{{cbLang("text_view_all_notification")}}</a></li>
                    </ul>
                </li>

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ CRUDBooster::myPhoto() }}" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        {{-- <span class="hidden-xs">{{ CRUDBooster::myName() }}</span> --}}
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header" style="background: #111827">
                            <img src="{{ CRUDBooster::myPhoto() }}" class="img-circle" alt="User Image"/>
                            <p>
                                {{ CRUDBooster::myName() }}
                                <small>{{ CRUDBooster::myPrivilegeName() }}</small>
                                <small><em><?php echo date('d F Y')?></em></small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-{{ cbLang('left') }}">
                                <a style="border-radius: 7px;" href="{{ route('AdminCmsUsersControllerGetProfile') }}" class="btn btn-default btn-flat">
                                    <i class='fa fa-user'></i> {{cbLang("label_button_profile")}}
                                </a>
                            </div>
                            <div class="pull-{{ cbLang('right') }}">
                                <a style="border-radius: 7px;" title='Lock Screen' href="{{ route('getLockScreen') }}" class='btn btn-default btn-flat'><i class='fa fa-key'></i></a>
                                <a style="border-radius: 7px;" href="javascript:void(0)" onclick="swal({
                                        title: '{{cbLang('alert_want_to_logout')}}',
                                        type:'info',
                                        showCancelButton:true,
                                        allowOutsideClick:true,
                                        confirmButtonColor: '#DD6B55',
                                        confirmButtonText: '{{cbLang('button_logout')}}',
                                        cancelButtonText: '{{cbLang('button_cancel')}}',
                                        closeOnConfirm: false
                                        }, function(){
                                        location.href = '{{ route("getLogout") }}';

                                        });" title="{{cbLang('button_logout')}}" class="btn btn-danger btn-flat"><i class='fa fa-power-off'></i></a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggleButton = document.querySelector('.sidebar-toggle');

        toggleButton.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.toggle('rotate');
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const notificationBell = document.getElementById('notification_bell');
        const iconNotification = document.getElementById('icon_notification');

        notificationBell.addEventListener('click', function() {
            iconNotification.classList.add('shake');

            setTimeout(function() {
                iconNotification.classList.remove('shake');
            }, 500);
        });
    });

    function updateDateTime() {
      const now = new Date();

      // Format time to 12-hour with AM/PM
      let hours = now.getHours();
      const minutes = now.getMinutes().toString().padStart(2, '0');
      const seconds = now.getSeconds().toString().padStart(2, '0');
      const ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12; // the hour '0' should be '12'
      const time = `${hours.toString().padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;

      // Format date: DD-MM-YYYY
      const day = now.getDate().toString().padStart(2, '0');
      const month = (now.getMonth() + 1).toString().padStart(2, '0');
      const year = now.getFullYear();
      const date = `${day}-${month}-${year}`;

      document.getElementById('time').textContent = time;
      document.getElementById('date').textContent = date;
    }

    updateDateTime(); // Initial run
    setInterval(updateDateTime, 1000);
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#invoices_config').on('click', function(){
        Swal.fire({
            html: `
            <center>
                <div class="card-invo">
                    <img src="https://cdn-icons-png.flaticon.com/128/3643/3643948.png" alt="sheild_icon"/>
                    <h2>Uploaded Invoices Configuration</h2>
                    <small>
                        Please make sure you want to hide all the uploaded invoces,
                        Once you turn it on here, all of the uploaded invoices will disappear. 
                        If you want to make it visible again, just turn it off here. Thanks
                    </small>
                    <br><br>
                    <form>
                    <label class="switch-invo">
                        <input type="checkbox" name="user_viewing_enabled" id="user_viewing_enabled" value="{{ $manager_invoices_viewing_config == 'SHOW' ? 'hidden_off' : 'hidden_on' }}" {{ $manager_invoices_viewing_config == 'SHOW' ? '' : 'checked' }}>
                        <span class="slider-invo"></span>
                    </label>
                    <span class="status-text-invo"><b>Disabled Viewing</b></span>
                    </form>
                </div>
            </center>
            `,
            cancelButtonText: '<i class="fa fa-times"></i> No, Cancel',
            confirmButtonText: '<i class="fa fa-save"></i> Save Configuration',
            showCancelButton: true,
            showConfirmButton: true,
            allowOutsideClick: false,
            preConfirm: () => {
                const viewing_status = $('#user_viewing_enabled').val();

                if(viewing_status !== null || viewing_status !== " "){
                    $.ajax({ 
                        url: "{{ route('invoices-config') }}",
                        type: "POST",
                        data: {
                            'viewing_status': viewing_status,
                            _token: '{!! csrf_token() !!}'
                            },
                        success: function(response)
                        {
                            if(response.success == true) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Success',
                                    text: response.message,
                                    allowOutsideClick: false,
                                    confirmButtonText: 'Okay, Got it',
                                    preConfirm: () => {
                                        location.reload();
                                    },
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error request, Please try again. Thank you!',
                                });
                            }
                        }                    
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: `Empty viewing toogle status, 
                        please turn it Off or On based on your needs. Thanks!`
                    });
                }
            },
        });
    });
</script>
