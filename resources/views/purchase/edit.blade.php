@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Edit Purchase</h4>
                <h6>Update purchase information</h6>
            </div>
        </div>
    </div>
    <div class="barcode-content-list">
        <form action="{{ route('purchases.update', $purchase->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="input-blocks">
                        <label>Supplier Name</label>
                        <select class="select" name="contact_id" required>
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ $purchase->contact_id == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="input-blocks">
                        <label>Pay From Account</label>
                        <select class="select" name="account_id">
                            <option value="">Select Account (optional)</option>
                            @foreach (\App\Models\Account::forUserBusiness()->where('is_active', true)->orderByDesc('is_default')->orderBy('name')->get() as $account)
                                <option value="{{ $account->id }}" {{ $purchase->account_id == $account->id ? 'selected' : '' }}>
                                    {{ $account->name }} ({{ number_format($account->current_balance,2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="input-blocks">
                        <label>Purchase Date </label>
                        <div class="input-groupicon">
                            <input name="date" type="text" placeholder="Select Purchase Date" class="datetimepicker" 
                                   value="{{ $purchase->date ? Carbon\Carbon::parse($purchase->date)->format('d-m-Y') : '' }}" required>
                            <div class="addonset">
                                <img src="{{ asset('assets/img/icons/calendars.svg') }}" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="input-blocks">
                        <label>Reference No.</label>
                        <input name="reference_no" type="text" placeholder="Enter your reference No" 
                               value="{{ $purchase->reference_no }}">
                    </div>
                </div>
                <div class="col-lg-12 col-sm-6 col-12">
                    <div class="input-blocks">
                        <label>Product</label>
                        <div class="input-groupicon">
                            <input type="text" class="form-control" onkeyup="searchProducts(event)" id="product-search-input" placeholder="Scan/Search Product by code and select">
                            <div class="addonset">
                                <img src="{{ asset('assets/img/icons/scanners.svg') }}" alt="img">
                            </div>
                            <div id="resultBox" class="search-results"></div>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="col-lg-12 col-sm-6 col-1">
                <div class="modal-body-table">
                    <div class="table-fixed">
                        <table class="table datanews">
                            <thead>
                                <tr>
                                    <th width="20%">Product<br> Name</th>
                                    <th width="10%">Purchase  <br> Quantity</th>
                                    <th width="20%">Unit Purchase Price <br>(Before Discount)</th>
                                    <th width="10%">Discount<br> Amount</th>
                                    <th width="10%">Unit Cost <br> (Before Tax)</th>
                                    <th width="20%">Unit Selling Price <br>  (Inc. tax)</th>
                                    <th width="10%" class="text-center no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody id="selectedProductsForPurchase">
                                @foreach($purchaseDetails as $detail)
                                    <tr data-product-id="{{ $detail->product_id }}">
                                        <td>
                                            <input type="hidden" name="product_id[]" value="{{ $detail->product_id }}" />
                                            <div>
                                                <span>{{ $detail->product->name }}</span>
                                                <br />
                                                <small>Current stock: {{ $detail->product->total_unsell ?? 0 }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <input name="quantity[]" type="number" min="1" class="form-control" 
                                                   placeholder="Purchase Quantity" value="{{ $detail->quantity }}" required>
                                        </td>
                                        <td>
                                            <input name="purchase_price[]" type="number" min="0" step="any" class="form-control" 
                                                   placeholder="Purchase price" value="{{ $detail->purchase_price }}" required>
                                        </td>
                                        <td>
                                            <input name="discount[]" type="number" min="0" step="any" class="form-control" 
                                                   placeholder="Discount amount" value="{{ $detail->discount ?? 0 }}">
                                        </td>
                                        <td>
                                            <input name="tax[]" type="number" min="0" step="any" class="form-control" 
                                                   placeholder="Tax amount" value="{{ $detail->tax ?? 0 }}">
                                        </td>
                                        <td>
                                            <input name="selling_price[]" type="number" min="0" step="any" class="form-control" 
                                                   placeholder="Selling price" value="{{ $detail->selling_price }}" required>
                                        </td>
                                        <td class="action-table-data justify-content-center">
                                            <div class="edit-delete-action">
                                                <a class="confirm-text barcode-delete-icon" href="javascript:void(0);" 
                                                   onclick="removeProduct({{ $detail->product_id }})">
                                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
            <div class="col-lg-12 col-sm-6 col-12">
                <div class="input-blocks">
                    <label>Additional Notes</label>
                    <textarea name="note" class="form-control">{{ $purchase->note }}</textarea>
                </div>
            </div>

            <div class="search-barcode-button">
                <button type="submit" class="btn btn-primary">
                    <span><i class="fas fa-save me-2"></i></span>
                    Update Purchase
                </button>
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary ms-2">
                    <span><i class="fas fa-arrow-left me-2"></i></span>
                    Back to List
                </a>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script>
        (function ($) {
            'use strict';
            $(document).ready(function () {
                let searchTimeout;
                let selectedProducts = [];

                // Initialize existing products in selectedProducts array
                @foreach($purchaseDetails as $detail)
                    selectedProducts.push({
                        id: {{ $detail->product_id }},
                        name: '{{ $detail->product->name }}',
                        sku: '{{ $detail->product->sku ?? "" }}',
                        image: '{{ $detail->product->image ?? "" }}',
                        quantity: {{ $detail->quantity }},
                        total_unsell: {{ $detail->product->total_unsell ?? 0 }}
                    });
                @endforeach

                // Initialize datetime picker
                $('.datetimepicker').datetimepicker({
                    format: 'DD-MM-YYYY',
                    useCurrent: false
                });

                // Initialize select2
                $('.select').select2();

                window.searchProducts = function (event) {
                    const query = event.target.value;
                    clearTimeout(searchTimeout);

                    if (query.length < 2) {
                        $('#resultBox').hide();
                        return;
                    }

                    searchTimeout = setTimeout(function () {
                        searchProductsFunction(query);
                    }, 300);
                };

                // Search products function
                function searchProductsFunction(query) {
                    $.ajax({
                        url: '{{ route("product.search-for-barcode") }}',
                        method: 'POST',
                        data: {
                            query: query,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            displaySearchResults(response.products);
                        },
                        error: function (xhr) {
                            console.error('Search failed:', xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Search Failed',
                                text: 'Unable to search products. Please try again.'
                            });
                        }
                    });
                }

                // Display search results
                function displaySearchResults(products) {
                    const resultBox = $('#resultBox');

                    if (products.length === 0) {
                        resultBox.html('<div class="search-result-item">No products found</div>');
                    } else {
                        let html = '';
                        products.forEach(function (product) {
                            html += `
                                <div class="search-result-item" data-product='${JSON.stringify(product)}'>
                                    <img src="${product.image}" alt="${product.name}" onerror="this.src='{{ asset('assets/img/products/noimage.png') }}'">
                                    <div class="product-info">
                                        <div class="product-name">${product.name}</div>
                                        <div class="product-sku">SKU: ${product.sku}</div>
                                    </div>
                                </div>
                            `;
                        });
                        resultBox.html(html);
                    }

                    resultBox.show();
                }

                // Handle product selection
                $(document).on('click', '.search-result-item', function () {
                    const product = $(this).data('product');

                    // Check if product is already selected
                    if (selectedProducts.find(p => p.id === product.id)) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Product Already Added',
                            text: 'This product is already in the list.'
                        });
                        return;
                    }

                    // Add product to selected list
                    selectedProducts.push({
                        ...product,
                        quantity: 1
                    });

                    // Add to table
                    addProductToTable(product);

                    // Clear search
                    $('#product-search-input').val('');
                    $('#resultBox').hide();
                });

                // Add product to table
                function addProductToTable(product) {
                    const row = `
                    <tr data-product-id="${product.id}">
                        <td>
                            <input type="hidden" name="product_id[]" value="${product.id}" />
                            <div>
                                <span>${product.name}</span>
                                <br />
                                <small>Current stock: ${product.total_stock ?? 0}</small>
                            </div>
                        </td>
                        <td>
                            <input name="quantity[]" type="number" min="1" class="form-control" placeholder="Purchase Quantity" required>
                        </td>
                        <td>
                            <input name="purchase_price[]" type="number" min="0" step="any" class="form-control" placeholder="Purchase price" required>
                        </td>
                        <td>
                            <input name="discount[]" type="number" min="0" step="any" class="form-control" placeholder="Discount amount" value="0">
                        </td>
                        <td>
                            <input name="tax[]" type="number" min="0" step="any" class="form-control" placeholder="Tax amount" value="0">
                        </td>
                        <td>
                            <input name="selling_price[]" type="number" min="0" step="any" class="form-control" placeholder="Selling price" required>
                        </td>
                        <td class="action-table-data justify-content-center">
                            <div class="edit-delete-action">
                                <a class="confirm-text barcode-delete-icon" href="javascript:void(0);" onclick="removeProduct(${product.id})">
                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    `;

                    $('#selectedProductsForPurchase').append(row);
                    const searchInput = document.getElementById('product-search-input');
                    searchInput.value = '';
                    searchInput.focus();
                    
                    // Initialize feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                }

                // Remove product function
                window.removeProduct = function (productId) {
                    Swal.fire({
                        title: 'Remove Product',
                        text: 'Are you sure you want to remove this product?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, remove it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectedProducts = selectedProducts.filter(p => p.id !== productId);
                            $(`tr[data-product-id="${productId}"]`).remove();

                            Swal.fire(
                                'Removed!',
                                'Product has been removed from the list.',
                                'success'
                            );
                        }
                    });
                };

                // Form validation before submission
                $('form').on('submit', function(e) {
                    const productRows = $('#selectedProductsForPurchase tr');
                    
                    if (productRows.length === 0) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Products Selected',
                            text: 'Please add at least one product to the purchase.'
                        });
                        return false;
                    }

                    // Validate all required fields
                    let isValid = true;
                    productRows.each(function() {
                        const quantity = $(this).find('input[name="quantity[]"]').val();
                        const purchasePrice = $(this).find('input[name="purchase_price[]"]').val();
                        const sellingPrice = $(this).find('input[name="selling_price[]"]').val();

                        if (!quantity || !purchasePrice || !sellingPrice) {
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validation Error',
                            text: 'Please fill in all required fields for all products.'
                        });
                        return false;
                    }
                });

                // Initialize feather icons
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            });

        })(jQuery);
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <style>
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 4px 4px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }

        .search-result-item {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
        }

        .search-result-item img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }

        .search-result-item .product-info {
            flex: 1;
        }

        .search-result-item .product-name {
            font-weight: 500;
            margin-bottom: 2px;
        }

        .search-result-item .product-sku {
            font-size: 12px;
            color: #666;
        }

        .searchInput {
            position: relative;
        }

        .table-fixed {
            overflow-x: auto;
        }

        .table th {
            white-space: nowrap;
            vertical-align: top;
        }

        .action-table-data {
            text-align: center;
        }

        .edit-delete-action {
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .barcode-delete-icon {
            color: #dc3545;
            cursor: pointer;
        }

        .barcode-delete-icon:hover {
            color: #c82333;
        }
    </style>
@endsection
