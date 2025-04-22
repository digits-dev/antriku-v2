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

{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
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
    .demo-button {
        position: fixed;
        display: none;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 12px 24px;
        background: #6366f1;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
        transition: all 0.3s ease;
    }

    .demo-button:hover {
        background: #4f46e5;
        transform: translateX(-50%) translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
    }

    /* Overlay */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        z-index: 10000;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.4s ease, visibility 0.4s ease;
    }

    .overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* Welcome popup */
    .welcome-popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.9);
        width: 90%;
        max-width: 900px;
        height: 500px;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        z-index: 10000;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        opacity: 0;
        visibility: hidden;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .welcome-popup.active {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%) scale(1);
    }

    /* Left side with GIF */
    .popup-left {
        flex: 1;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        padding: 40px;
    }

    .popup-left::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 0.3;
    }

    .gif-container {
        width: 220px;
        height: 220px;
        border-radius: 20%;
        overflow: hidden;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        margin-bottom: 20px;
        position: relative;
    }

    .gif-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pulse {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 20%;
        background: rgba(255, 255, 255, 0.2);
        animation: pulse 1s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 0.7;
        }

        70% {
            transform: scale(1.1);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 0;
        }
    }

    .welcome-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
        text-align: center;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .welcome-subtitle {
        font-size: 16px;
        opacity: 0.9;
        text-align: center;
        max-width: 280px;
    }

    /* Right side with tasks */
    .popup-right {
        flex: 1.2;
        padding: 40px;
        position: relative;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    .close-button {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f3f4f6;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .close-button:hover {
        background: #e5e7eb;
        transform: rotate(90deg);
    }

    .close-button::before,
    .close-button::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 2px;
        background: #6b7280;
    }

    .close-button::before {
        transform: rotate(45deg);
    }

    .close-button::after {
        transform: rotate(-45deg);
    }

    .tasks-header {
        margin-bottom: 24px;
    }

    .tasks-title {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 8px;
    }

    .tasks-subtitle {
        font-size: 14px;
        color: #6b7280;
    }

    .task-stats {
        display: flex;
        gap: 10px;
        margin-bottom: 24px;
    }

    .stat-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .stat-badge.high {
        background: #fee2e2;
        color: #b91c1c;
    }

    .stat-badge.today {
        background: #e0e7ff;
        color: #4338ca;
    }

    .stat-badge.total {
        background: #f3e8ff;
        color: #7e22ce;
    }

    .tasks-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 30px;
    }

    .task-item {
        display: flex;
        align-items: center;
        padding: 16px;
        border-radius: 12px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
        animation: slideIn 0.5s ease forwards;
        opacity: 0;
        transform: translateY(10px);
    }

    .task-item:hover {
        background: #f3f4f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    @keyframes slideIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .task-priority {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .priority-high {
        background: #ef4444;
        box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
    }

    .priority-medium {
        background: #f59e0b;
        box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2);
    }

    .priority-low {
        background: #10b981;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
    }

    .task-content {
        flex: 1;
    }

    .task-title {
        font-size: 14px;
        font-weight: 500;
        color: #111827;
        margin-bottom: 4px;
    }

    .task-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #6b7280;
    }

    .task-due {
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        background: #f3f4f6;
        color: #374151;
        margin-left: auto;
    }

    .task-due.today {
        background: #fee2e2;
        color: #b91c1c;
    }

    .popup-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        padding-top: 20px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-custom {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-outline-custom {
        background: transparent;
        border: 1px solid #d1d5db;
        color: #4b5563;
    }

    .btn-outline-custom:hover {
        background: #f3f4f6;
        border-color: #9ca3af;
    }

    .btn-primary-custom {
        background: #6366f1;
        border: 1px solid #6366f1;
        color: white;
        box-shadow: 0 2px 5px rgba(99, 102, 241, 0.2);
    }

    .btn-primary-custom:hover {
        background: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes scaleIn {
        from {
            transform: scale(0.9);
        }

        to {
            transform: scale(1);
        }
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .welcome-popup {
            flex-direction: column;
            height: auto;
            max-height: 90vh;
        }

        .popup-left {
            padding: 30px 20px;
        }

        .gif-container {
            width: 150px;
            height: 150px;
            margin-bottom: 15px;
        }

        .welcome-title {
            font-size: 22px;
        }

        .popup-right {
            padding: 30px 20px;
        }
    }
</style>

<button class="demo-button" id="showPopup">Show Welcome Announcement</button>

<div class="overlay" id="overlay"></div>

<div class="welcome-popup" id="welcomePopup">
    <!-- Left side with GIF -->
    <div class="popup-left">
        <div class="gif-container">
            <div class="pulse"></div>
            <!-- Replace with your actual talking person GIF -->
            <img src="{{ asset('img/talk.gif') }}" alt="User speaking" style="display: none;" id="talking_user">
            <img src="{{ asset('img/static.png') }}" alt="User stop speaking" id="static_user">
        </div>
        <h2 class="welcome-title">Welcome back, Frontliner!</h2>
        <p class="welcome-subtitle">
            You currently have 20 active tasks to do in total. 
            Let's tackle them efficiently and stay on track. 
            Thanks, have a good day.
        </p>
    </div>

    <!-- Right side with tasks -->
    <div class="popup-right">
        <button class="close-button" id="closePopup"></button>

        <div class="tasks-header">
            <h3 class="tasks-title">
                <img src="https://cdn-icons-png.flaticon.com/128/439/439338.png" style="width: 25px; margin-right: 10px" alt="">
                Your Pending Tasks
            </h3>
            <p class="tasks-subtitle">Here's what needs your attention today</p>
        </div>

        <div class="task-stats">
            <span class="stat-badge high">3 high priority</span>
            <span class="stat-badge today">4 due today</span>
            <span class="stat-badge total">6 total tasks</span>
        </div>

        <div class="tasks-list">
            <!-- Task 1 -->
            <div class="task-item" style="animation-delay: 0.1s">
                <div class="task-priority priority-high"></div>
                <div class="task-content">
                    <div class="task-title">Complete project proposal</div>
                    <div class="task-meta">Marketing • 2 hours estimated</div>
                </div>
                <div class="task-due today">Today</div>
            </div>

            <!-- Task 2 -->
            <div class="task-item" style="animation-delay: 0.2s">
                <div class="task-priority priority-high"></div>
                <div class="task-content">
                    <div class="task-title">Review team submissions</div>
                    <div class="task-meta">Design • 1 hour estimated</div>
                </div>
                <div class="task-due today">Today</div>
            </div>
        </div>

        <div class="popup-footer">
            <button class="btn-custom btn-outline-custom" id="dismiss">Dismiss</button>
            <button class="btn-custom btn-primary-custom" id="set_session_off">Okay, Got it</button>
        </div>
    </div>
</div>

<script>
    const showPopupBtn = document.getElementById('showPopup');
    const closePopupBtn = document.getElementById('closePopup');
    const overlay = document.getElementById('overlay');
    const welcomePopup = document.getElementById('welcomePopup');
    const dismissBtn = document.querySelector('.btn-outline-custom');
    const viewAllBtn = document.querySelector('.btn-primary-custom');

    function playAudio() {
        const firstAudio = new Audio('/audio/notif.mp3');
        const secondAudio = new Audio('/audio/talk.mp3');

        // When the first audio ends
        firstAudio.addEventListener('ended', () => {
            // Show user images while talking
            $('#talking_user').show();
            $('#static_user').hide();
            secondAudio.play().catch(e => console.log('Second audio error:', e));
        });

        // When the second audio ends
        secondAudio.addEventListener('ended', () => {
            $('#talking_user').hide();
            $('#static_user').show();
        });

        // Start with the first audio
        firstAudio.play().catch(e => console.log('First audio error:', e));
    }

    // Function to show popup
    function showPopup() {
        overlay.classList.add('active');
        welcomePopup.classList.add('active');

        playAudio();

        // Animate task items with staggered delay
        const taskItems = document.querySelectorAll('.task-item');
        taskItems.forEach((item, index) => {
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 300 + (index * 100));
        });
    }

    // Function to hide popup
    function hidePopup() {
        overlay.classList.remove('active');
        welcomePopup.classList.remove('active');

        // Reset task animations
        const taskItems = document.querySelectorAll('.task-item');
        taskItems.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(10px)';
        });
    }

    // Event listeners
    showPopupBtn.addEventListener('click', showPopup);
    closePopupBtn.addEventListener('click', hidePopup);
    // overlay.addEventListener('click', hidePopup);
    dismissBtn.addEventListener('click', hidePopup);
    viewAllBtn.addEventListener('click', () => {
        // alert('Navigating to all tasks...');
        hidePopup();
    });

    @if (session('just_logged_in'))
        setTimeout(showPopup, 400);
    @endif
</script>
<script>
    $('#set_session_off, #closePopup, #dismiss').on('click', function () {
        $.ajax({
            url: '/admin/clear-just-logged-in',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                console.log('Session cleared:', response);
            },
            error: function () {
                console.error('Failed to clear session');
            }
        });
    });
</script>



