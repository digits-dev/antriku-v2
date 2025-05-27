@extends('crudbooster::admin_template')
@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .content {
            padding: 0;
        }

        .content-header {
            display: none;
        }

        .cust-ch {
            margin-top: 50px !important;
        }

        @media (max-width: 767px) {
            .cust-ch {
                margin-top: 100px;
            }
        }

        .swal2-popup {
            border-radius: 10px !important;
        }
    </style>
@endpush
@section('content')
    <main class="container-dash dashboard-dash cust-ch">
        <div class="dashboard-title-section" style="margin-bottom: 10px;">
            <div class="dashboard-title-content">
                <h1 class="dashboard-title" style="margin-top: 8px">
                    <span class="dashboard-title-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                    </span>
                    Manager's Dashboard
                </h1>
                <p class="dashboard-subtitle">
                </p>
            </div>
        </div>

        <div class="tabs-dash m-dash-new-users text-uppercase" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
            <div class="tab-dash" data-tab="tab-jaymar-bi">
                <svg xmlns="http://www.w3.org/2000/svg" role="presentation" width="15" height="15" viewBox="0 0 1600 1600" fill="none">
                    <mask id="mask0_8592:56198" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="200" y="0" width="1200" height="1600">
                    <path d="M1333.25 0C1370.11 0 1400 29.8849 1400 66.75V1533.25C1400 1570.11 1370.11 1600 1333.25 1600H266.667C229.848 1600 200 1570.15 200 1533.33V866.667C200 829.848 229.848 800 266.667 800H525V466.667C525 429.848 554.848 400 591.667 400H850V66.75C850 29.885 879.885 0 916.75 0H1333.25Z" fill="white"/>
                    </mask>
                    <g mask="url(#mask0_8592:56198)">
                    <path d="M1400 66.75L1400 1533.25C1400 1570.11 1370.11 1600 1333.25 1600H916.75C879.885 1600 850 1570.11 850 1533.25L850 66.75C850 29.885 879.885 0 916.75 0H1333.25C1370.12 0 1400 29.8849 1400 66.75Z" fill="url(#paint0_linear_8592:56198)"/>
                    <g filter="url(#filter0_dd_8592:56198)">
                    <path d="M1075 466.667V1600H525V466.667C525 429.848 554.848 400 591.667 400H1008.33C1045.15 400 1075 429.848 1075 466.667Z" fill="url(#paint1_linear_8592:56198)"/>
                    </g>
                    <path d="M200 866.667V1533.33C200 1570.15 229.848 1600 266.667 1600H750V866.667C750 829.848 720.152 800 683.333 800H266.667C229.848 800 200 829.848 200 866.667Z" fill="url(#paint2_linear_8592:56198)"/>
                    </g>
                    <defs>
                    <filter id="filter0_dd_8592:56198" x="391.667" y="300" width="816.667" height="1466.67" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="6.33333"/>
                    <feGaussianBlur stdDeviation="6.33333"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.2 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_8592:56198"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="33.3333"/>
                    <feGaussianBlur stdDeviation="66.6667"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.18 0"/>
                    <feBlend mode="normal" in2="effect1_dropShadow_8592:56198" result="effect2_dropShadow_8592:56198"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_8592:56198" result="shape"/>
                    </filter>
                    <linearGradient id="paint0_linear_8592:56198" x1="758.333" y1="-1.49632e-05" x2="1447.82" y2="1507.15" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#E6AD10"/>
                    <stop offset="1" stop-color="#C87E0E"/>
                    </linearGradient>
                    <linearGradient id="paint1_linear_8592:56198" x1="524.955" y1="400" x2="1105.79" y2="1561.67" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#F6D751"/>
                    <stop offset="1" stop-color="#E6AD10"/>
                    </linearGradient>
                    <linearGradient id="paint2_linear_8592:56198" x1="199.955" y1="800" x2="519.784" y2="1581.68" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#F9E589"/>
                    <stop offset="1" stop-color="#F6D751"/>
                    </linearGradient>
                    </defs>
                </svg>
                Power BI Dashboard
            </div>

            <div class="tab-dash active" data-tab="tab-system-dash">
                <img src="https://cdn-icons-png.flaticon.com/128/1828/1828673.png" alt="" width="17px">
                System Dashboard
            </div>
        </div>

        <div id="tab-jaymar-bi" class="tab-content-dash">
            <div class="card-dash" style="border-top-left-radius:0%; border-top-right-radius:0%">
                <div class="card-header-dash hidden" style="padding: 0px 10px 0px 10px;">
                    <h2 class="card-title-dash text-uppercase" style="color: white;">
                        <img src="https://cdn-icons-png.flaticon.com/128/7756/7756168.png" alt="" width="20px">
                        <small style="font-size: 14px;">Overview</small>
                    </h2>

                    <div>
                        <small class="text-uppercase" style="color: lightgrey">Home <i class="bi bi-chevron-right" style="font-size: 10px;"></i> Dashboard</small>
                    </div>
                </div>
                <div class="card-body-dash">
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <iframe
                                title="NO"
                                style="width: 100%; height: 800px"
                                src='{{$PBI}}'
                                frameBorder="0"
                                allowFullScreen="true">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="tab-system-dash" class="tab-content-dash active system_dashboard_content">
            <div class="card-dash" style="border-top-left-radius:0%; border-top-right-radius:0%">
                <div class="card-header-dash" style="padding: 0px 20px 0px 20px;">
                    <h2 class="card-title-dash text-uppercase" style="color: white;">
                        <img src="https://cdn-icons-png.flaticon.com/128/7756/7756168.png" alt="" width="20px">
                        <small style="font-size: 14px;">
                            Overview of
                            <span id="selected_branch">
                            </span>
                        </small>
                    </h2>

                    <div style="display: flex; align-items:center; justify-content:center; background: whitesmoke; padding: 0 7px 0 7px; border-radius: 10px;">
                        <img src="https://cdn-icons-png.flaticon.com/128/2098/2098316.png" alt="branch_icon" width="20px">
                        <select name="branch" id="branch" class="input-cus" style="border: 0 !important; outline: none !important; 
                            box-shadow: none !important; background: transparent !important;">
                            @foreach ($branch as $per_branch)
                                <option value="{{ $per_branch->id }}" data-val="{{$per_branch->branch_name}}" {{$per_branch->id == 1 ? 'selected' : ''}}> {{ $per_branch->branch_name }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body-dash">
                    <div style="padding-bottom: 10px;">
                        <small class="text-uppercase"> 
                            <i class="bi bi-person-workspace"></i>
                            Frontliner's Dashboard 
                        </small>
                    </div>
                    <div class="row">
                        @include('manager.manager_fl_dashboard')
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('bottom')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.onload = function() {
        window.scrollTo(0, 0);
    };

    $(document).ready(function () {
        function updateSelectedBranch() {
            const selectedVal = $('#branch option:selected').data('val');
            const branch_id = $('#branch option:selected').val();
            $('#selected_branch').text(selectedVal);

            if(branch_id == '' || branch_id == null){
                alert('Empty Branch');
                return;
            }

            $.ajax({
                url: "{{ route('get_manager_dashboard') }}",
                type: "post",
                data: {
                    'branch_id': branch_id,
                    _token: '{!! csrf_token() !!}',
                },
                success: function (response) {
                    
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Error Dashboard request",
                        text: "An error occurred while filtering dashboard per branch. Please try again.",
                    });
                }
            });

        }

        // Initial load
        updateSelectedBranch();

        $('#branch').on('change', updateSelectedBranch);
    });

    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-dash');
        const tabContents = document.querySelectorAll('.tab-content-dash');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked tab
                tab.classList.add('active');

                // Show corresponding content
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>
@endpush
