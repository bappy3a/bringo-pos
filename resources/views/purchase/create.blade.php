@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Purchases</h4>
                <h6>Add you stock</h6>
            </div>
        </div>
    </div>
    <div class="barcode-content-list">
        <form action="{{ route('purchases.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="input-blocks">
                        <label>Supplier Name</label>
                        <select class="select" name="contact_id" required>
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('contact_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="input-blocks">
                        <label>Pay From Account</label>
                        <select class="select" name="account_id">
                            <option value="">Select Account (optional)</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }} ({{ number_format($account->current_balance,2) }})</option>
                            @endforeach
                        </select>
                        @error('account_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="input-blocks">
                        <label>Purchase Date </label>
                        <div class="input-groupicon">
                            <input name="date" type="text" placeholder="Selete Purchase Date" class="datetimepicker">
                            <div class="addonset">
                                <img src="{{ asset('assets/img/icons/calendars.svg') }}" alt="img">
                            </div>
                        </div>
                        @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="input-blocks">
                        <label>Reference No.</label>
                        <input name="reference_no" type="text" placeholder="Enter you reference No">
                        @error('reference_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
                                    <th white="20%">Product<br> Name</th>
                                    <th white="10%">Purchase  <br> Quantity</th>
                                    <th white="20%">Unit Purchase Price <br>(Before Discount)</th>
                                    <th white="10%">Discount<br> Amount</th>
                                    <th white="10%">Unit Cost <br> (Before Tax)</th>
                                    <th white="20%">Unit Selling Price <br>  (Inc. tax)</th>
                                    <th white="10%" class="text-center no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody id="selectedProductsForPurchase"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        

            <div class="col-lg-12 col-sm-6 col-12">
                <div class="input-blocks">
                    <label>Additional Notes</label>
                    <textarea name="note" id="" class="form-control "></textarea>
                    @error('note')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="search-barcode-button">
                <button type="submit"  class="btn btn-primary">
                    <span><i class="fas fa-save me-2"></i></span>
                    Save
                </button>
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
                    $('#productSearch').val('');
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
                            <input name="purchase_price[]" type="number" min="1" step="any" class="form-control" placeholder="Purchase price" required>
                        </td>
                        <td>
                            <input name="discount[]" type="number" min="1" step="any" class="form-control" placeholder="Discount amount">
                        </td>
                        <td>
                            <input name="tax[]" type="number" min="1" step="any" class="form-control" placeholder="Tax amount">
                        </td>
                        <td>
                            <input name="selling_price[]" type="number" min="1" step="any" class="form-control" placeholder="Selling price" required>
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
                    searchInput.value = null;
                    searchInput.focus();
                    // Initialize feather icons
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                }

                // Global functions for quantity controls
                window.changeQuantity = function (productId, change) {
                    const product = selectedProducts.find(p => p.id === productId);
                    if (product) {
                        const newQuantity = Math.max(1, product.quantity + change);
                        product.quantity = newQuantity;
                        $(`tr[data-product-id="${productId}"] .quntity-input`).val(newQuantity);
                    }
                };

                window.updateQuantity = function (productId, value) {
                    const product = selectedProducts.find(p => p.id === productId);
                    if (product) {
                        product.quantity = Math.max(1, parseInt(value) || 1);
                    }
                };

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

                // Form submission
                $('#barcodeForm').on('submit', function (e) {
                    e.preventDefault();

                    if (selectedProducts.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Products Selected',
                            text: 'Please add at least one product to generate barcodes.'
                        });
                        return;
                    }

                    // Prepare form data
                    const formData = new FormData(this);

                    // Add selected products to form data
                    selectedProducts.forEach(function (product, index) {
                        formData.append(`products[${index}][id]`, product.id);
                        formData.append(`products[${index}][quantity]`, product.quantity);
                    });

                    // Show loading
                    $('#generateBarcodeBtn').prop('disabled', true).html('<span><i class="fas fa-spinner fa-spin me-2"></i></span>Generating...');

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Barcode Generated!',
                                    text: 'Barcode has been generated successfully.',
                                    showCancelButton: true,
                                    confirmButtonText: 'Print Now',
                                    cancelButtonText: 'Close'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        Swal.fire('Printing...', 'Opening print dialog...', 'info');
                                    }
                                });
                            }
                        },
                        error: function (xhr) {
                            let errorMessage = 'Failed to generate barcode. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                errorMessage = xhr.responseJSON.error;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Generation Failed',
                                text: errorMessage
                            });
                        },
                        complete: function () {
                            $('#generateBarcodeBtn').prop('disabled', false).html('<span><i class="fas fa-eye me-2"></i></span>Generate Barcode');
                        }
                    });
                });

                // Reset button
                $('#resetBarcodeBtn').on('click', function () {
                    Swal.fire({
                        title: 'Reset Barcode List',
                        text: 'Are you sure you want to clear all selected products?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, reset it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            selectedProducts = [];
                            $('#selectedProducts').empty();
                            $('#productSearch').val('');
                            $('#resultBox').hide();

                            Swal.fire(
                                'Reset!',
                                'Barcode list has been cleared.',
                                'success'
                            );
                        }
                    });
                });

                // Print button
                $('#printBarcodeBtn').on('click', function () {
                    if (selectedProducts.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Products Selected',
                            text: 'Please add at least one product to print barcodes.'
                        });
                        return;
                    }

                    // Submit form for printing
                    $('#barcodeForm').submit();
                });

            });

        })(jQuery);

    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
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
    </style>
@endsection