<div class="col-md-7">
    <div class="row">
        <div class="col-md-6">
            <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs"style="cursor: pointer;">
                <div class="m-dash-card-header" style="margin: 0">
                    <div class="m-dash-card-title">
                        <i class="bi bi-telephone-minus-fill"
                            style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                        Pending Call-outs
                    </div>
                    <hr>
                </div>
                <div class="m-dash-card-value" id="filtered-callouts-value">
                    {{-- {{ $fl_pending_call_out_dash_count_all ?? 0 }} --}}
                    100,204
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="m-dash-card m-dash-default" data-cardname="Pending Call-Outs"style="cursor: pointer;">
                <div class="m-dash-card-header" style="margin: 0">
                    <div class="m-dash-card-title">
                        <i class="bi bi-emoji-frown-fill"
                            style="background: #948979; color:white; padding: 4px 5px 4px 5px; border-radius: 7px;"></i>
                        Abandoned Units
                    </div>
                    <hr>
                </div>
                <div class="m-dash-card-value" id="filtered-callouts-value">
                    {{-- {{ $fl_abandoned_units_dash_count ?? 0 }} --}}
                    50,023
                </div>
            </div>
        </div>

        <div class="col-md-12">
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
                                <th style="font-size: 10px" class="text-uppercase">
                                    Reference No.
                                </th>
                                <th style="font-size: 10px" class="text-uppercase">
                                    Warranty Type
                                </th>
                                <th style="font-size: 10px" class="text-uppercase hidden">
                                    Case Type
                                </th>
                                <th style="font-size: 10px" class="text-uppercase">
                                    Model
                                </th>
                                <th style="font-size: 10px" class="text-uppercase">
                                    Customer
                                </th>
                                <th style="font-size: 10px" class="text-uppercase hidden">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody style="text-align: left; background: rgba(240, 246, 247, 0.7);">
                            <tr>
                                <td style="font-size: 12px">reference_no</td>
                                <td style="font-size: 12px">warranty_status</td>
                                <td class="hidden" style="font-size: 12px">case_status</td>
                                <td style="font-size: 12px">model_name</td>
                                <td style="font-size: 12px">last_name . ',' . $item->first_name</td>
                                <td class="hidden" style="font-size: 12px">status_name</td>
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
    </div>
</div>
