<div class="col-md-3">
    <div class="row">
        <div class="col-md-12">
            <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs"style="cursor: pointer;">
                <div class="m-dash-card-header" style="margin: 0">
                    <div class="m-dash-card-title">
                        <i class="bi bi-telephone-minus-fill"
                            style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                        Pending Call-outs
                    </div>
                    <hr>
                </div>
                <div class="m-dash-card-value" id="fl_pending_call_out_dash_count_all">
                    {{ count($fl_pending_call_out_bgc) ?? 0 }}
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <br>
            <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs"style="cursor: pointer;">
                <div class="m-dash-card-header" style="margin: 0">
                    <div class="m-dash-card-title">
                        <i class="bi bi-emoji-frown-fill"
                            style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                        Abandoned Units
                    </div>
                    <hr>
                </div>
                <div class="m-dash-card-value" id="fl_abandoned_units_dash_count_all">
                    {{ count($fl_abandoned_units_bgc) ?? 0 }}
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <br>
            <div class="transactions-container">
                <div class="transactions-header" style="margin: 0%;">
                    <h2 class="card-title-dash" style="margin-top: 1px;">
                        <div class="card-icon-dash icon-default">
                            <i class="bi bi-bar-chart-line-fill" style="font-size: 12px"></i>
                        </div>
                        Aging Call-Out Distribution
                    </h2>
                </div>
                <div class="card-body-dash" style="margin: 0%">
                    <div class="chart-container"
                        style="position: relative; height: 428px; width: 100%; display: flex; flex-direction: column; align-items: center; padding: 10px 0;">
                        <canvas id="aging_callout_BGC" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-9">
    <div class="transactions-container">
        <div class="transactions-header" style="margin: 0%;">
            <h2 class="card-title-dash" style="margin-top: 1px">
                <div class="card-icon-dash icon-default">
                    <i class="bi bi-bar-chart-steps" style="font-size: 12px"></i>
                </div>
                Aging Call-Out Per Type Distribution
            </h2>
        </div>
        <div class="card-body-dash" style="margin: 0%">
            <div class="chart-container"
                style="position: relative; height: 280px; width: 100%; display: flex; flex-direction: column; align-items: center; padding: 10px 0;">
                <canvas id="aging_callout_types_BGC" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="col-md-9">
    <br>
    <div class="transactions-container">
        <div class="transactions-header" style="margin: 0%">
            <h2 class="card-title-dash">
                <div class="card-icon-dash icon-default">
                    <i class="bi bi-table" style="font-size: 12px"></i>
                </div>
                Summary of Data
            </h2>
            <div class="search-container">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="search-icon">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65">
                    </line>
                </svg>
                <input type="text" class="search-input" placeholder="Search transactions...">
            </div>
        </div>
        <div style="height: 295px; overflow: auto;">
            <table class="transactions-table" autofocus>
                <thead>
                    <tr>
                        <th style="font-size: 12px" class="text-uppercase">
                            Reference No.
                        </th>
                        <th style="font-size: 12px" class="text-uppercase">
                            Warranty Type
                        </th>
                        <th style="font-size: 12px" class="text-uppercase">
                            Case Type
                        </th>
                        <th style="font-size: 12px" class="text-uppercase">
                            Model
                        </th>
                        <th style="font-size: 12px" class="text-uppercase">
                            Customer
                        </th>
                        <th style="font-size: 12px" class="text-uppercase">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody style="text-align: left; background: rgba(240, 246, 247, 0.7);">
                    @php
                        $flAllData = [];

                        // Helper function to merge with unique status labels
                        function mergeDataBGC(&$flAllData, $collection, $label)
                        {
                            foreach ($collection as $item) {
                                $id = $item->id ?? ($item->reference_no ?? uniqid()); // fallback in case no ID

                                if (!isset($flAllData[$id])) {
                                    $item->status_labels = [$label];
                                    $flAllData[$id] = $item;
                                } else {
                                    // If already exists, just add the label
                                    if (!in_array($label, $flAllData[$id]->status_labels)) {
                                        $flAllData[$id]->status_labels[] = $label;
                                    }
                                }
                            }
                        }

                        mergeDataBGC($flAllData, $fl_pending_call_out_bgc, 'fl-pending-callout');
                        mergeDataBGC($flAllData, $fl_abandoned_units_bgc, 'fl-abandoned-unit');
                    @endphp

                    @foreach ($flAllData as $item)
                        <tr data-status="{{ implode(' ', $item->status_labels) }}">
                            <td style="font-size: 12px">{!! $item->reference_no ?? '<small class="m-dash-negative">Empty Data</small>' !!}</td>
                            <td style="font-size: 12px">{!! $item->warranty_status ?? '<small class="m-dash-negative">Empty Data</small>' !!}</td>
                            <td style="font-size: 12px">{!! $item->case_status ?? '<small class="m-dash-negative">Empty Data</small>' !!}</td>
                            <td style="font-size: 12px">{!! $item->model_name ?? '<small class="m-dash-negative">Empty Data</small>' !!}</td>
                            <td style="font-size: 12px">{!! $item->last_name . ', ' . $item->first_name ?? '<small class="m-dash-negative">Empty Data</small>' !!}</td>
                            <td
                                style="font-size: 12px; color:{{ $item->status_name == 'COMPLETE' ? 'limegreen' : 'darkorange' }}">
                                {!! $item->status_name ?? '<small class="m-dash-negative">Empty</small>' !!}
                            </td>
                        </tr>
                    @endforeach

                    <tr class="no-data-row" style="display: none;">
                        <td colspan="6"
                            style="text-align: center; font-size: 14px; padding: 20px; color: #888;">
                            <br>
                            <center>
                                <img src="https://cdn-icons-png.flaticon.com/128/7486/7486747.png" alt="">
                            </center>
                            <center>
                                <small class="text-uppercase">Empty Data. Please select
                                    <br> what report you want to check.</small>
                            </center>
                            <br><br>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer-dash">
            <span class="card-footer-text-dash showing_data_tech_overview" id="showing_data_tech_overview">
                Showing 100 Total of Data
            </span>
        </div>
    </div>
</div>
