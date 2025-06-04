<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset('vendor/crudbooster/assets/adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

<!-- Bootstrap 3.4.1 JS -->
<script src="{{ asset('vendor/crudbooster/assets/adminlte/bootstrap/js/bootstrap.min.js') }}" type="text/javascript">
</script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/crudbooster/assets/adminlte/dist/js/app.js') }}" type="text/javascript"></script>

<!--BOOTSTRAP DATEPICKER-->
<script src="{{ asset('vendor/crudbooster/assets/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<link rel="stylesheet" href="{{ asset('vendor/crudbooster/assets/adminlte/plugins/datepicker/datepicker3.css') }}">

<!--BOOTSTRAP DATERANGEPICKER 2.1.27 AND MOMENT 2.13.0 -->
<script src="{{ asset('vendor/crudbooster/assets/adminlte/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('vendor/crudbooster/assets/adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<link rel="stylesheet"
    href="{{ asset('vendor/crudbooster/assets/adminlte/plugins/daterangepicker/daterangepicker-bs3.css') }}">

<!-- Bootstrap time Picker -->
<link rel="stylesheet"
    href="{{ asset('vendor/crudbooster/assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.css') }}">
<script src="{{ asset('vendor/crudbooster/assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js') }}">
</script>

<link rel='stylesheet' href='{{ asset('vendor/crudbooster/assets/lightbox/dist/css/lightbox.min.css') }}' />
<script src="{{ asset('vendor/crudbooster/assets/lightbox/dist/js/lightbox.min.js') }}"></script>

<!--SWEET ALERT-->
<script src="{{ asset('vendor/crudbooster/assets/sweetalert/dist/sweetalert.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/crudbooster/assets/sweetalert/dist/sweetalert.css') }}">

<!--MONEY FORMAT-->
<script src="{{ asset('vendor/crudbooster/jquery.price_format.2.0.min.js') }}"></script>

<!--DATATABLE-->
<link rel="stylesheet"
    href="{{ asset('vendor/crudbooster/assets/adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
<script src="{{ asset('vendor/crudbooster/assets/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/crudbooster/assets/adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}">
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.2-rc.1/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script>
    var ASSET_URL = "{{ asset('/') }}";
    var APP_NAME = "{{ Session::get('appname') }}";
    var ADMIN_PATH = '{{ url(config('crudbooster.ADMIN_PATH')) }}';
    var NOTIFICATION_JSON = "{{ route('NotificationsControllerGetLatestJson') }}";
    var NOTIFICATION_INDEX = "{{ route('NotificationsControllerGetIndex') }}";

    var NOTIFICATION_YOU_HAVE = "{{ cbLang('notification_you_have') }}";
    var NOTIFICATION_NOTIFICATIONS = "{{ cbLang('notification_notification') }}";
    var NOTIFICATION_NEW = "{{ cbLang('notification_new') }}";

    $(function() {
        $('.datatables-simple').DataTable();
        $('.js-example-basic-single').select2();
    })
</script>
<script src="{{ asset('vendor/crudbooster/assets/js/main.js') . '?r=' . time() }}"></script>

<style>
    :root {
      --primary-load: #3a86ff;
      --secondary-load: #8338ec;
      --background-load: #f8f9fa;
      --modal-bg-load: rgba(255, 255, 255, 0.95);
      --overlay-bg-load: rgba(0, 0, 0, 0.4);
      --text-load: #212529;
      --shadow-load: rgba(0, 0, 0, 0.1);
    }

    /* Top loading bar container */
    .top-loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 10000;
      animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
      transform-origin: top center;
    }

    /* Modal container */
    .modal-cus {
      background-color: var(--modal-bg-load);
      box-shadow: 0 4px 20px var(--shadow-load);
      padding: 15px 25px;
      width: 100%;
      max-width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.2);
      animation: float 4s ease-in-out infinite;
      position: relative;
    }

    /* Subtle glow effect */
    .modal-cus::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(90deg, var(--primary-load), transparent, var(--secondary-load));
      z-index: -1;
      opacity: 0.2;
      filter: blur(15px);
      animation: glow 3s ease-in-out infinite alternate;
    }

    .loader-container {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 20px;
      width: 100%;
      max-width: 600px;
    }

    .loader-left {
      display: flex;
      align-items: center;
    }

    .loader-right {
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .loader {
      position: relative;
      width: 40px;
      height: 40px;
    }

    /* Main spinner */
    .spinner {
      position: absolute;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      border: 2px solid transparent;
      border-top-color: var(--primary-load);
      animation: spin 1.5s linear infinite;
    }

    .spinner:before, .spinner:after {
      content: '';
      position: absolute;
      border-radius: 50%;
      border: 2px solid transparent;
    }

    .spinner:before {
      top: 3px;
      left: 3px;
      right: 3px;
      bottom: 3px;
      border-top-color: var(--secondary-load);
      animation: spin 2s linear infinite reverse;
    }

    .spinner:after {
      top: 8px;
      left: 8px;
      right: 8px;
      bottom: 8px;
      border-top-color: var(--primary-load);
      animation: spin 1s linear infinite;
    }

    /* Pulsing circle */
    .pulse {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 15px;
      height: 15px;
      background-color: rgba(58, 134, 255, 0.2);
      border-radius: 50%;
      animation: pulse 1.5s ease-in-out infinite;
    }

    /* Dots animation */
    .dots {
      display: flex;
      gap: 6px;
      align-items: center;
    }

    .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background-color: var(--primary-load);
      opacity: 0.6;
    }

    .dot:nth-child(1) {
      animation: fade 1.5s ease-in-out infinite;
    }

    .dot:nth-child(2) {
      animation: fade 1.5s ease-in-out 0.5s infinite;
    }

    .dot:nth-child(3) {
      animation: fade 1.5s ease-in-out 1s infinite;
    }

    /* Progress bar */
    .progress-container {
      width: 100%;
      height: 4px;
      background-color: rgba(0, 0, 0, 0.1);
      border-radius: 4px;
      overflow: hidden;
    }

    .progress-bar {
      height: 100%;
      width: 0;
      background: linear-gradient(90deg, var(--primary-load), var(--secondary-load));
      animation: progress 2s ease-in-out infinite;
      border-radius: 4px;
    }

    .loading-text {
      font-size: 14px;
      font-weight: 500;
      letter-spacing: 0.5px;
      color: var(--text-load);
      opacity: 0.8;
      animation: fadeInOut 2s ease-in-out infinite;
    }

    /* Keyframes */
    @keyframes popIn {
      0% {
        transform: translateY(-100%) scale(0.8);
        opacity: 0;
      }
      50% {
        transform: translateY(5%) scale(1.02);
      }
      100% {
        transform: translateY(0) scale(1);
        opacity: 1;
      }
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }

    @keyframes pulse {
      0%, 100% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 0.5;
      }
      50% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 0.8;
      }
    }

    @keyframes fade {
      0%, 100% {
        opacity: 0.3;
        transform: scale(0.8);
      }
      50% {
        opacity: 1;
        transform: scale(1);
      }
    }

    @keyframes progress {
      0% {
        width: 0%;
      }
      50% {
        width: 100%;
      }
      100% {
        width: 0%;
      }
    }

    @keyframes fadeInOut {
      0%, 100% {
        opacity: 0.5;
      }
      50% {
        opacity: 1;
      }
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(3px);
      }
    }

    @keyframes glow {
      0% {
        opacity: 0.1;
      }
      100% {
        opacity: 0.3;
      }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .loader-container {
        flex-direction: column;
        gap: 10px;
      }
      
      .loader-right {
        width: 100%;
      }
      
      .modal-cus {
        padding: 15px;
      }
    }

    .custom-swal-popup {
      border-radius: 15px !important;
    }

</style>


{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.1/lottie.min.js"></script>

<script>
  const nottalkingimg = "{{ asset('/img/talking.png') }}";
  const talkinglottiePath = "{{ asset('/img/talking_json.json') }}";

  Swal.fire({
    position: "top-end",
    html: `
      <div class="row">
        <div class="col-md-4">
          <span id="lottie-animation" class="talking-lottie" style="width: 300px; height: 300px;"></span>
          <img src="${nottalkingimg}" style="width: 125px; height: 90px; display:none;" class="stop_talking" />
        </div>
        <div class="col-md-8">
          <h5 style="font-size: 13px; text-align: left; display: block;"><b>Welcomeback Fronliner!</b></h5>
          <small style="font-size: 13px; text-align: left; display: block;">
            You currently have active tasks to do, let's tackle <br> them efficiently and stay on track.
            Thank you, <br> have a Good day. 
          </small>
        </div>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4">
              <div style="background: #222831; border-radius: 10px; padding: 5px 8px 8px 8px;">
                <small style="font-size: 13px; color: white;" class="text-uppercase">
                  Mail-In 20
                </small>
                <div class="notification-container-cus" style="padding: 0px;">
                    <div class="icon-cus">🔔</div>
                    <div class="notif-count-cus" style="height: 10px; width: 10px"></div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div style="background: #222831; border-radius: 10px; padding: 5px 8px 8px 8px;">
                <small style="font-size: 13px; color: white;" class="text-uppercase">
                  Carry-In 20
                </small>
                <div class="notification-container-cus" style="padding: 0px;">
                    <div class="icon-cus">🔔</div>
                    <div class="notif-count-cus" style="height: 10px; width: 10px"></div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div style="background: #222831; border-radius: 10px; padding: 5px 8px 8px 8px;">
                <small style="font-size: 13px; color: white;" class="text-uppercase">
                  Releasing 20
                </small>
                <div class="notification-container-cus" style="padding: 0px;">
                    <div class="icon-cus">🔔</div>
                    <div class="notif-count-cus" style="height: 10px; width: 10px"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
    `,
    showConfirmButton: false,
    allowOutsideClick: false,
    allowEscapeKey: false,
    customClass: {
      popup: 'custom-swal-popup'
    },

    didOpen: () => {
      lottie.loadAnimation({
        container: document.getElementById('lottie-animation'),
        renderer: 'svg',
        loop: true,
        autoplay: true,
        path: talkinglottiePath
      });
    }
  });
</script> --}}

