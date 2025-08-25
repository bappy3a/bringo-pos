@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>Edit Product</h4>
            <h6>Update product information</h6>
        </div>
    </div>
    <ul class="table-top-head">
        <li>
            <div class="page-btn">
                <a href="{{ route('products.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                        class="me-2"></i>Back to Products</a>
            </div>
        </li>
    </ul>
</div>

<form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-body add-product pb-0">
            <div class="accordion-card-one accordion" id="accordionExample">
                <div class="accordion-item">
                    <div class="accordion-header" id="headingOne">
                        <div class="accordion-button">
                            <div class="addproduct-icon">
                                <h5><i data-feather="info" class="add-info"></i><span>Product Information</span></h5>
                            </div>
                        </div>
                    </div>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3 add-product">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name', $product->name) }}" required
                                            placeholder="Enter Product Name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="input-blocks add-product list">
                                        <label>SKU</label>
                                        <input type="text" class="form-control list @error('sku') is-invalid @enderror"
                                            name="sku" value="{{ old('sku', $product->sku) }}" placeholder="Enter SKU">
                                        @error('sku')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="input-blocks add-product">
                                        <label>Image</label>
                                        <div class="row">
                                            <div class="col-9">
                                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                            </div>
                                            <div class="col-3">
                                                @if($product->images)
                                                    <img  src="{{ asset($product->images) }}" alt="Current Product Image" class="img-thumbnail product-edit-image">
                                                @endif
                                            </div>
                                        </div>
                                        
                                        
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="addservice-info">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="mb-3 add-product">
                                            <div class="add-newplus">
                                                <label class="form-label">Category</label>
                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#add-units-category"><i data-feather="plus-circle"
                                                        class="plus-down-add"></i><span>Add New</span></a>
                                            </div>
                                            <select class="select @error('category_id') is-invalid @enderror"
                                                name="category_id">
                                                <option value="">Select category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="mb-3 add-product">
                                            <div class="add-newplus">
                                                <label class="form-label">Brand</label>
                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#add-units-brand"><i data-feather="plus-circle"
                                                        class="plus-down-add"></i><span>Add New</span></a>
                                            </div>
                                            <select class="select @error('brand_id') is-invalid @enderror"
                                                name="brand_id">
                                                <option value="">Select brand</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6 col-12">
                                        <div class="mb-3 add-product">
                                            <div class="add-newplus">
                                                <label class="form-label">Unit</label>
                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#add-unit"><i data-feather="plus-circle"
                                                        class="plus-down-add"></i><span>Add New</span></a>
                                            </div>
                                            <select class="select @error('unit_id') is-invalid @enderror"
                                                name="unit_id">
                                                <option value="">Select unit</option>
                                                @foreach($units as $unit)
                                                    <option value="{{ $unit->id }}" {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3 add-product">
                                        <label class="form-label">Barcode Type</label>
                                        <select class="select @error('barcode_type') is-invalid @enderror"
                                            name="barcode_type">
                                            <option value="code_128" {{ old('barcode_type', $product->barcode_type) == 'code_128' ? 'selected' : '' }}>Code 128 (C128)
                                            </option>
                                            <option value="code_39" {{ old('barcode_type', $product->barcode_type) == 'code_39' ? 'selected' : '' }}>Code 39 (C39)
                                            </option>
                                            <option value="ean_13" {{ old('barcode_type', $product->barcode_type) == 'ean_13' ? 'selected' : '' }}>EAN-13</option>
                                            <option value="ean_8" {{ old('barcode_type', $product->barcode_type) == 'ean_8' ? 'selected' : '' }}>EAN-8</option>
                                            <option value="upc_a" {{ old('barcode_type', $product->barcode_type) == 'upc_a' ? 'selected' : '' }}>UPC-A</option>
                                            <option value="upc_e" {{ old('barcode_type', $product->barcode_type) == 'upc_e' ? 'selected' : '' }}>UPC-E</option>
                                        </select>
                                        @error('barcode_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="input-blocks add-product">
                                        <label>Quantity Alert</label>
                                        <input type="number"
                                            class="form-control @error('alert_quantity') is-invalid @enderror"
                                            name="alert_quantity"
                                            value="{{ old('alert_quantity', $product->alert_quantity) }}"
                                            placeholder="Enter Quantity Alert">
                                        @error('alert_quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3 add-product">
                                        <div class="add-newplus">
                                            <label class="form-label">Not For Selling</label>
                                        </div>
                                        <select class="select @error('not_for_selling') is-invalid @enderror"
                                            name="not_for_selling">
                                            <option value="0" {{ old('not_for_selling', $product->not_for_selling) == '0' ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ old('not_for_selling', $product->not_for_selling) == '1' ? 'selected' : '' }}>Yes</option>
                                        </select>
                                        @error('not_for_selling')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3 add-product">
                                        <div class="add-newplus">
                                            <label class="form-label">Selling Price Tax Type</label>
                                        </div>
                                        <select class="select @error('selling_price_tax_type') is-invalid @enderror"
                                            name="selling_price_tax_type">
                                            <option value="inclusive" {{ old('selling_price_tax_type', $product->selling_price_tax_type) == 'inclusive' ? 'selected' : '' }}>
                                                Inclusive</option>
                                            <option value="exclusive" {{ old('selling_price_tax_type', $product->selling_price_tax_type) == 'exclusive' ? 'selected' : '' }}>
                                                Exclusive</option>
                                        </select>
                                        @error('selling_price_tax_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3 add-product">
                                        <div class="add-newplus">
                                            <label class="form-label">Status</label>
                                        </div>
                                        <select class="select @error('status') is-invalid @enderror" name="status">
                                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Editor -->
                            <div class="col-lg-12">
                                <div class="input-blocks summer-description-box transfer mb-3">
                                    <label>Description</label>
                                    <textarea class="form-control h-100 @error('description') is-invalid @enderror"
                                        rows="5" name="description" required
                                        placeholder="Enter Description">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- /Editor -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="btn-addproduct mb-4">
            <button type="button" class="btn btn-cancel me-2" onclick="window.history.back()">Cancel</button>
            <button type="submit" class="btn btn-submit">Update Product</button>
        </div>
    </div>
</form>


<!-- Add Category Modal -->
<div class="modal fade" id="add-units-category" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="categoryModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Create New Category
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="category-form" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="category_name" class="form-label fw-bold">Category Name <span
                                class="text-danger">*</span></label>
                        <input name="name" id="category_name" type="text" class="form-control"
                            placeholder="Enter category name" required maxlength="255" autocomplete="off">
                        <div class="invalid-feedback" id="category_name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="category_code" class="form-label fw-bold">Category Code</label>
                        <input name="code" id="category_code" type="text" class="form-control"
                            placeholder="Enter category code (optional)" maxlength="50" autocomplete="off">
                        <div class="invalid-feedback" id="category_code_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="category_image" class="form-label fw-bold">Category Image</label>
                        <input name="image" id="category_image" class="form-control" type="file" accept="image/*">
                        <div class="form-text">
                            <i class="fas fa-info-circle me-1"></i>
                            Recommended size: 40x40 pixels. Max file size: 2MB
                        </div>
                        <div class="invalid-feedback" id="category_image_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="category_description" class="form-label fw-bold">Description</label>
                        <textarea name="description" id="category_description" class="form-control" rows="3"
                            placeholder="Enter category description (optional)" maxlength="500"></textarea>
                        <div class="invalid-feedback" id="category_description_error"></div>
                    </div>
                    <div class="modal-footer border-0 px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary" id="category_submit_btn">
                            <i class="fas fa-save me-1"></i>Create Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Category Modal -->

<!-- Add Brand Modal -->
<div class="modal fade" id="add-units-brand" tabindex="-1" aria-labelledby="brandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="brandModalLabel">
                    <i class="fas fa-tag me-2"></i>Create New Brand
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="brand-form" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="brand_name" class="form-label fw-bold">Brand Name <span
                                class="text-danger">*</span></label>
                        <input name="name" id="brand_name" type="text" class="form-control"
                            placeholder="Enter brand name" required maxlength="255" autocomplete="off">
                        <div class="invalid-feedback" id="brand_name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="brand_description" class="form-label fw-bold">Description</label>
                        <textarea name="description" id="brand_description" class="form-control" rows="3"
                            placeholder="Enter brand description (optional)" maxlength="500"></textarea>
                        <div class="invalid-feedback" id="brand_description_error"></div>
                    </div>
                    <div class="modal-footer border-0 px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success" id="brand_submit_btn">
                            <i class="fas fa-save me-1"></i>Create Brand
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Brand Modal -->

<!-- Add Unit Modal -->
<div class="modal fade" id="add-unit" tabindex="-1" aria-labelledby="unitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="unitModalLabel">
                    <i class="fas fa-ruler me-2"></i>Create New Unit
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="unit-form" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="unit_name" class="form-label fw-bold">Unit Name <span
                                class="text-danger">*</span></label>
                        <input name="name" id="unit_name" type="text" class="form-control" placeholder="Enter unit name"
                            required maxlength="255" autocomplete="off">
                        <div class="invalid-feedback" id="unit_name_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="unit_allow_decimal" class="form-label fw-bold">Allow Decimal <span
                                class="text-danger">*</span></label>
                        <select name="allow_decimal" id="unit_allow_decimal" class="form-select" required>
                            <option value="">Select option</option>
                            <option value="1">Yes - Allow decimal values</option>
                            <option value="0">No - Only whole numbers</option>
                        </select>
                        <div class="invalid-feedback" id="unit_allow_decimal_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="unit_description" class="form-label fw-bold">Description</label>
                        <textarea name="description" id="unit_description" class="form-control" rows="3"
                            placeholder="Enter unit description (optional)" maxlength="500"></textarea>
                        <div class="invalid-feedback" id="unit_description_error"></div>
                    </div>
                    <div class="modal-footer border-0 px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-info" id="unit_submit_btn">
                            <i class="fas fa-save me-1"></i>Create Unit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Add Unit Modal -->
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>

    <script>
        /**
         * Product Creation - AJAX Modal Forms Handler
         * @author Ahmed Bappy
         * @version 1.0.0
         * @description Handles AJAX form submissions for Category, Brand, and Unit creation
         */

        (function ($) {
            'use strict';

            // Configuration object
            const CONFIG = {
                csrfToken: $('meta[name="csrf-token"]').attr('content'),
                selectors: {
                    categoryForm: '#category-form',
                    brandForm: '#brand-form',
                    unitForm: '#unit-form',
                    categorySelect: 'select[name="category_id"]',
                    brandSelect: 'select[name="brand_id"]',
                    unitSelect: 'select[name="unit_id"]',
                    categoryModal: '#add-units-category',
                    brandModal: '#add-units-brand',
                    unitModal: '#add-unit'
                },
                messages: {
                    success: {
                        category: 'Category created successfully!',
                        brand: 'Brand created successfully!',
                        unit: 'Unit created successfully!'
                    },
                    error: {
                        category: 'An error occurred while creating the category.',
                        brand: 'An error occurred while creating the brand.',
                        unit: 'An error occurred while creating the unit.',
                        validation: 'Please check the form and try again.',
                        network: 'Network error. Please check your connection.'
                    }
                }
            };

            /**
             * Utility functions
             */
            const Utils = {
                /**
                 * Show success notification
                 * @param {string} message - Success message
                 * @param {string} type - Type of entity (category/brand/unit)
                 */
                showSuccess: function (message, type) {
                    Swal.fire({
                        title: 'Success!',
                        text: message,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                },

                /**
                 * Show error notification
                 * @param {string} title - Error title
                 * @param {string} message - Error message
                 */
                showError: function (title, message) {
                    Swal.fire({
                        title: title,
                        text: message,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonClass: 'btn btn-danger',
                        buttonsStyling: false
                    });
                },

                /**
                 * Show validation errors
                 * @param {Object} errors - Validation errors object
                 */
                showValidationErrors: function (errors) {
                    let errorMessage = '';
                    $.each(errors, function (key, value) {
                        errorMessage += `• ${value[0]}\n`;
                    });

                    this.showError('Validation Error!', errorMessage);
                },

                /**
                 * Update select dropdown with new option
                 * @param {string} selectSelector - Select element selector
                 * @param {Object} data - Data object with id and name
                 */
                updateSelect: function (selectSelector, data) {
                    const $select = $(selectSelector);
                    const newOption = new Option(data.name, data.id, true, true);
                    $select.append(newOption).trigger('change');
                },

                /**
                 * Reset form and close modal
                 * @param {string} formSelector - Form selector
                 * @param {string} modalSelector - Modal selector
                 */
                resetFormAndCloseModal: function (formSelector, modalSelector) {
                    $(formSelector)[0].reset();
                    $(modalSelector).modal('hide');

                    // Remove validation classes
                    $(formSelector).find('.is-invalid').removeClass('is-invalid');
                    $(formSelector).find('.invalid-feedback').hide();
                },

                /**
                 * Handle button loading state
                 * @param {jQuery} $button - Button element
                 * @param {boolean} loading - Loading state
                 */
                handleButtonState: function ($button, loading) {
                    if (loading) {
                        $button.prop('disabled', true)
                            .html('<i class="fas fa-spinner fa-spin me-1"></i>Creating...');
                    } else {
                        $button.prop('disabled', false)
                            .html('<i class="fas fa-save me-1"></i>Create');
                    }
                }
            };

            /**
             * AJAX form handler class
             */
            class AjaxFormHandler {
                constructor(formSelector, modalSelector, selectSelector, type) {
                    this.formSelector = formSelector;
                    this.modalSelector = modalSelector;
                    this.selectSelector = selectSelector;
                    this.type = type;
                    this.init();
                }

                init() {
                    this.bindEvents();
                }

                bindEvents() {
                    const self = this;

                    $(this.formSelector).on('submit', function (e) {
                        e.preventDefault();
                        self.handleSubmit.call(self, this);
                    });

                    // Reset form on modal close
                    $(this.modalSelector).on('hidden.bs.modal', function () {
                        $(self.formSelector)[0].reset();
                        $(self.formSelector).find('.is-invalid').removeClass('is-invalid');
                        $(self.formSelector).find('.invalid-feedback').hide();
                    });
                }

                handleSubmit(form) {
                    const $form = $(form);
                    const $submitBtn = $form.find('button[type="submit"]');
                    const formData = new FormData(form);

                    // Validate form
                    if (!this.validateForm($form)) {
                        return;
                    }

                    // Show loading state
                    Utils.handleButtonState($submitBtn, true);

                    // Make AJAX request
                    $.ajax({
                        url: this.getAjaxUrl(),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': CONFIG.csrfToken
                        },
                        success: (response) => this.handleSuccess(response),
                        error: (xhr) => this.handleError(xhr),
                        complete: () => Utils.handleButtonState($submitBtn, false)
                    });
                }

                validateForm($form) {
                    let isValid = true;

                    // Remove previous validation
                    $form.find('.is-invalid').removeClass('is-invalid');
                    $form.find('.invalid-feedback').hide();

                    // Check required fields
                    $form.find('[required]').each(function () {
                        const $field = $(this);
                        const value = $field.val().trim();

                        if (!value) {
                            $field.addClass('is-invalid');
                            $field.siblings('.invalid-feedback').show().text('This field is required.');
                            isValid = false;
                        }
                    });

                    // Validate file size (if file input exists)
                    const $fileInput = $form.find('input[type="file"]');
                    if ($fileInput.length && $fileInput[0].files.length > 0) {
                        const file = $fileInput[0].files[0];
                        const maxSize = 2 * 1024 * 1024; // 2MB

                        if (file.size > maxSize) {
                            $fileInput.addClass('is-invalid');
                            $fileInput.siblings('.invalid-feedback').show().text('File size must be less than 2MB.');
                            isValid = false;
                        }
                    }

                    return isValid;
                }

                getAjaxUrl() {
                    const urls = {
                        category: '{{ route("categories.ajax-store") }}',
                        brand: '{{ route("brands.ajax-store") }}',
                        unit: '{{ route("units.ajax-store") }}'
                    };
                    return urls[this.type];
                }

                handleSuccess(response) {
                    if (response.success) {
                        // Update select dropdown
                        Utils.updateSelect(this.selectSelector, response[this.type]);

                        // Reset form and close modal
                        Utils.resetFormAndCloseModal(this.formSelector, this.modalSelector);

                        // Show success message
                        Utils.showSuccess(response.message, this.type);
                    } else {
                        Utils.showError('Error!', response.message || CONFIG.messages.error[this.type]);
                    }
                }

                handleError(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        if (errors) {
                            Utils.showValidationErrors(errors);
                        } else {
                            Utils.showError('Validation Error!', CONFIG.messages.error.validation);
                        }
                    } else if (xhr.status === 0) {
                        // Network error
                        Utils.showError('Network Error!', CONFIG.messages.error.network);
                    } else {
                        // Server error
                        Utils.showError('Server Error!', CONFIG.messages.error[this.type]);
                    }
                }
            }

            /**
             * Initialize when document is ready
             */
            $(document).ready(function () {
                // Initialize form handlers
                new AjaxFormHandler(
                    CONFIG.selectors.categoryForm,
                    CONFIG.selectors.categoryModal,
                    CONFIG.selectors.categorySelect,
                    'category'
                );

                new AjaxFormHandler(
                    CONFIG.selectors.brandForm,
                    CONFIG.selectors.brandModal,
                    CONFIG.selectors.brandSelect,
                    'brand'
                );

                new AjaxFormHandler(
                    CONFIG.selectors.unitForm,
                    CONFIG.selectors.unitModal,
                    CONFIG.selectors.unitSelect,
                    'unit'
                );

                // Initialize tooltips
                $('[data-bs-toggle="tooltip"]').tooltip();

                // Initialize select2 if available
                if ($.fn.select2) {
                    $('.select').select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });
                }
            });

        })(jQuery);
    </script>
@endsection