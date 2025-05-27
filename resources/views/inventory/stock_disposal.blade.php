@extends('crudbooster::admin_template')

@push('head')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --secondary: #64748b;
            --light: #f8fafc;
            --dark: #1e293b;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --border: #ced3d8;
            --shadow: rgba(0, 0, 0, 0.1);
        }
        
        .card-stocks {
            background-color: white;
            border-radius: 8px;
            border: 1px dashed lightgrey;
            /* box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); */
            margin-bottom: 20px;
        }

        .card-header-stocks {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title-stocks {
            font-size: 18px;
            font-weight: 600;
        }

        .card-body-stocks {
            padding: 20px;
        }

        .search-filter-stocks {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .search-input-stocks {
            flex: 1;
            min-width: 250px;
            position: relative;
        }

        .search-input-stocks input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .search-input-stocks::before {
            content: "🔍";
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary);
        }

        .search-input-stocks input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .filter-group-stocks {
            flex: 1;
            min-width: 200px;
        }

        .filter-group-stocks label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--secondary);
        }

        .filter-group-stocks select {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 16px;
            background-color: white;
        }

        .filter-group-stocks select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: whitesmoke;
        }

        .product-table th {
            background-color: #60B5FF;
            text-align: left;
            padding: 12px 15px;
            font-weight: 600;
            color: var(--secondary);
            border-bottom: 1px solid var(--border);
        }

        .product-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .product-table tr:hover {
            background-color: #e8e9eb;
        }

        .product-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-icon {
            width: 40px;
            height: 40px;
            background-color: #f1f5f9;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .product-details h3 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .product-details p {
            font-size: 14px;
            color: var(--secondary);
        }

        .empty-state {
            text-align: center;
            padding: 30px 0;
            color: var(--secondary);
        }

        .empty-state-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .quantity-input {
            width: 80px;
            padding: 8px;
            border: 1px solid var(--border);
            border-radius: 6px;
            text-align: center;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .price-input {
            width: 100px;
            padding: 8px;
            border: 1px solid var(--border);
            border-radius: 6px;
            text-align: center;
        }

        .price-input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .remove-btn {
            color: var(--danger);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 24px;
        }

        .search-result-box {
        position: absolute;
        top: 100%; /* Position right below the input */
        left: 0;
        width: 100%;
        background-color: white;
        border: 1px solid var(--border);
        border-radius: 0 0 6px 6px;
        box-shadow: 0 4px 12px var(--shadow);
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000; /* Higher z-index to ensure it appears above other elements */
        margin-top: -1px; /* Connect with input */
        display: none;
    }
    
    .search-result-box.active {
        display: block;
    }
    
    /* Rest of your styles remain the same */
    .result-item {
        padding: 12px 15px;
        border-bottom: 1px solid var(--border);
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .result-item:last-child {
        border-bottom: none;
    }
    
    .result-item.selected {
        background-color: #e0f2fe;
    }
    
    .result-item:last-child {
        border-bottom: none;
    }
    
    .result-item:hover {
        background-color: #f1f5f9;
    }
    
    .result-item .item-name {
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 3px;
    }
    
    .result-item .item-description {
        font-size: 13px;
        color: var(--secondary);
    }
    
    .result-item .item-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 5px;
        font-size: 13px;
    }
    
    .result-item .item-cost {
        font-weight: 600;
        color: var(--primary-dark);
    }
    
    .no-results {
        padding: 15px;
        text-align: center;
        color: var(--secondary);
    }
</style>
@endpush

@section('content')
    <div class="panel panel-default" style="margin: 0; padding:0">
        <div class="dashboard-title-content" style="margin: 15px 15px 0 15px;">
            <h1 class="dashboard-title">
                <span class="dashboard-title-icon">
                    <img src="https://cdn-icons-png.flaticon.com/128/8890/8890077.png" width="20px" alt="">
                </span>
                Stocks Disposal
            </h1>
        </div>
        <div class="panel-body">
            <div class="row">

                <div class="col-md-12">
                    <div>
                        <div class="card-stocks">
                            <div class="card-body-stocks">
                                <div class="search-filter-stocks">
                                    <div class="search-input-stocks">
                                        <input type="text" id="product-search" placeholder="Search item by service code...">
                                        <div id="search-results" class="search-result-box"></div>
                                    </div>
                                </div>

                                <div style="margin-bottom: 8px;">
                                    <textarea name="disposal_memo" id="disposal_memo" cols="30" rows="2" placeholder="Type Memo here..." class="input-cus"></textarea>
                                </div>
        
                                <div style="overflow: auto;height: 320px;">
                                    <table class="product-table" id="order-items-table">
                                        <thead>
                                            <tr>
                                                <th style="color: white;" width="40%">Item Parts</th>
                                                <th style="color: white;">Quantity</th>
                                                <th style="color: white;">Cost</th>
                                                <th style="color: white;">Total Cost</th>
                                                <th style="color: white;" width="50px"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="order-items-body">
                                            <tr id="nofilter">
                                                <td colspan="5">
                                                    <div id="empty-order-items" class="empty-state">
                                                        <div class="empty-state-icon">📦</div>
                                                        <p>
                                                            No items added yet <br>
                                                            Use search filter to add item
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right">
                            <button type="button" onclick="disposeStocks(this)" class="btn btn-danger">
                                <i class="fa fa-trash"></i>
                                Dispose
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('bottom')
<script>
    $(document).ready(function () {
        let inventoryData = @json($inventory_data);
        let searchTimeout;
        
        // Show/hide search results
        $('#product-search').on('focus', function() {
            if ($(this).val().length > 0) {
                $('#search-results').addClass('active');
            }
        });
        
        // Handle search input with debounce
        $('#product-search').on('input', function () {
            let query = $(this).val().toLowerCase();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Set new timeout to prevent excessive searches while typing
            searchTimeout = setTimeout(function() {
                if (query.length === 0) {
                    $('#search-results').removeClass('active');
                    return;
                }
                
                let filtered = inventoryData.filter(item =>
                    item.spare_parts.toLowerCase().includes(query) ||
                    item.item_description.toLowerCase().includes(query)
                );
                
                if (filtered.length === 0) {
                    $('#search-results').html('<div class="no-results">No items found</div>');
                } else {
                    let resultsHTML = filtered.map(item => `
                        <div class="result-item" data-item_parts_id="${item.id}" data-name="${item.spare_parts}" data-desc="${item.item_description}" data-cost="${item.cost}">
                            <div class="item-name">${item.spare_parts}</div>
                            <div class="item-description">${item.item_description || ''}</div>
                            <div class="item-details">
                                <span class="item-stock">${item.stock_qty || '0 / N/A'} in stock</span>
                                <span class="item-cost">₱${item.cost || '0.00'}</span>
                            </div>
                        </div>
                    `).join('');
                    
                    $('#search-results').html(resultsHTML);
                }
                
                $('#search-results').addClass('active');
            }, 300); // 300ms debounce
        });
        
        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-input-stocks, #search-results').length) {
                $('#search-results').removeClass('active');
            }
        });
        
        // Insert into table on click
        $(document).on('click', '.result-item', function () {
            $('#nofilter').hide();
            let parts_id = $(this).data('item_parts_id');
            let name = $(this).data('name');
            let desc = $(this).data('desc');
            let cost = $(this).data('cost') || "0";

            // Check if item is already in the table
            let alreadyExists = false;
            $('#order-items-body tr').each(function () {
                let existingName = $(this).find('h3').text().trim();
                if (existingName === name) {
                    alreadyExists = true;
                    return false; // break loop
                }
            });

            if (alreadyExists) {
                Swal.fire({
                    icon: 'info',
                    title: 'Reminders',
                    html: `Item already added to the table, Duplicate item <br> is not allowed.`,
                    showCancelButton: false,
                    confirmButtonText: 'Okay, Got it',
                });
                $('#search-results').removeClass('active');
                $('#product-search').val('');
                return;
            }

            let rawCost = parseFloat(cost.replace(/,/g, '')) || 0;
            let formattedCost = rawCost.toLocaleString('en-PH', { minimumFractionDigits: 2 });

            let newRow = `
                <tr>
                    <td>
                        <div class="product-item">
                            <div class="product-icon">📦</div>
                            <div class="product-details">
                                <h3>${name}</h3>
                                <p>${desc}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <input type="number" name="parts_item_qty[]" id="parts_item_qty" class="quantity-input" min="1" value="1">
                        <input type="hidden" name="parts_item_id[]" id="parts_item_id" value="${parts_id}">
                    </td>
                    <td>
                        <input type="text" class="price-input" value="${formattedCost}">
                    </td>
                    <td class="total-cost">
                        ₱${formattedCost}
                    </td>
                    <td>
                        <button class="remove-btn">×</button>
                    </td>
                </tr>
            `;

            $('#order-items-body').append(newRow);
            $('#search-results').removeClass('active');
            $('#product-search').val('');
        });
        
        // Add keyboard navigation
        $('#product-search').on('keydown', function(e) {
            const items = $('#search-results .result-item');
            let selectedItem = $('#search-results .result-item.selected');
            let selectedIndex = selectedItem.length ? items.index(selectedItem) : -1;
            
            switch(e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    if (selectedIndex < items.length - 1) {
                        items.removeClass('selected');
                        $(items[selectedIndex + 1]).addClass('selected');
                        $(items[selectedIndex + 1])[0].scrollIntoView({block: 'nearest'});
                    }
                    break;
                    
                case 'ArrowUp':
                    e.preventDefault();
                    if (selectedIndex > 0) {
                        items.removeClass('selected');
                        $(items[selectedIndex - 1]).addClass('selected');
                        $(items[selectedIndex - 1])[0].scrollIntoView({block: 'nearest'});
                    }
                    break;
                    
                case 'Enter':
                    e.preventDefault();
                    if (selectedItem.length) {
                        selectedItem.click();
                    }
                    break;
                    
                case 'Escape':
                    e.preventDefault();
                    $('#search-results').removeClass('active');
                    break;
            }
        });
        
        // Handle remove row
        $(document).on('click', '.remove-btn', function () {
            $(this).closest('tr').remove();
            if ($('#order-items-body tr').length <= 1) {
                $('#nofilter').show();
            }
        });
        
        // Update total cost on quantity/price change
        $(document).on('input', '.quantity-input, .price-input', function () {
            let row = $(this).closest('tr');
            let qty = parseFloat(row.find('.quantity-input').val()) || 0;
            
            let rawPriceStr = row.find('.price-input').val().replace(/,/g, '');
            let price = parseFloat(rawPriceStr) || 0;
            
            let total = qty * price;
            
            row.find('.total-cost').text(`₱${total.toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            })}`);
        });
    });

    function disposeStocks(button) {
        let disposal_memo = $('#disposal_memo').val();
        let allParts = [];

        $('input[name="parts_item_id[]"]').each(function(index) {
            const partId = $(this).val();
            const qtyInput = $('input[name="parts_item_qty[]"]').eq(index);
            const partQty = qtyInput.val();

            allParts.push({
                id: partId,
                qty: partQty
            });
        });

        if (allParts.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Requirements',
                text: 'Empty, Please add items for stock disposal.',
                confirmButtonText: 'Okay, Got it',
                showConfirmButton: true,
            });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently remove the specified quantity from stock.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Dispose!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $(button).prop('disabled', true).text('Processing...');

                $.ajax({
                    url: '{{ route("dispose-stocks") }}',
                    type: 'POST',
                    data: {
                        disposal_memo: disposal_memo,
                        parts: allParts,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success === true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 2000,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            $(button).prop('disabled', false).html(`<i class="fa fa-trash"></i> Dispose`);
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseText,
                            showConfirmButton: false,
                        });
                        $(button).prop('disabled', false).html(`<i class="fa fa-trash"></i> Dispose`);
                    }
                });
            }
        });
    }

</script>
@endpush
