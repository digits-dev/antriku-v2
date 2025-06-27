@include('FrontEnd/tracker_header')
    <!-- Search Screen -->
    <div id="searchScreen" class="search-screen-CLD">
        <div class="search-container-CLD">
            <!-- Welcome Card -->
            <div class="card-CLD mb-6-CLD">
                <div class="card-content-CLD">
                    <div class="text-center-CLD mb-6-CLD">
                        <div class="welcome-icon-CLD">
                            <i class="fas fa-search"></i>
                        </div>
                        <h2 class="welcome-title-CLD">Track Your Repair</h2>
                        <p class="welcome-subtitle-CLD">Enter your details to view your device repair status</p>
                    </div>

                    <form id="searchForm" method="GET" action="{{ route('start-tracking-jo') }}">
                        @csrf
                        <div class="form-group-CLD">
                            <label class="form-label-CLD" for="referenceNumber">Reference Number</label>
                            <input type="text" id="referenceNumber" name="referenceNumber" class="form-input-CLD" placeholder="Enter your Reference Number here..." autocomplete="off" required>
                        </div>

                        @if(session('error'))
                            <div class="alert-CLD alert-error-CLD">
                                <div class="flex-CLD items-center-CLD">
                                    <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>
                                    <span>{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="btn-CLD btn-primary-CLD w-full-CLD" id="searchBtn">
                            <i class="fas fa-search" id="initial_icon_search"></i>
                            <span id="searchBtnText">Track My Repair</span>
                        </button>
                    </form>

                </div>
            </div>

            <!-- Security Notice -->
            <div class="card-CLD mb-4-CLD" style="background: #eff6ff; border-color: #bfdbfe;">
                <div class="card-content-CLD" style="padding: 1rem;">
                    <div class="flex-CLD" style="align-items: flex-start; gap: 0.75rem;">
                        <i class="fas fa-shield-alt" style="color: #2563eb; margin-top: 0.125rem;"></i>
                        <div>
                            <h3 class="font-medium-CLD" style="color: #1e3a8a; margin-bottom: 0.25rem;">Secure Access</h3>
                            <p class="text-sm-CLD" style="color: #1e40af;">
                                Your repair information is protected. We verify your identity using the reference number 
                                provided during drop-off.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('searchForm').addEventListener('submit', function () {
                document.getElementById('initial_icon_search').style.display = 'none';
                document.getElementById('searchBtnText').innerHTML = `
                    <div style="display: flex; align-items: center;">
                        <div class="spinner-CLD" style="margin-right: 0.5rem;"></div>
                        <div>Searching...</div>
                    </div>`;
            });
        });
    </script>
@include('FrontEnd/tracker_footer')
