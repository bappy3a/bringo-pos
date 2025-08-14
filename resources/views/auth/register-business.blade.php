@extends('layouts.auth')

@section('title', 'Register Business')

@section('content')
<div class="col-xl-8 col-lg-9">
    <article class="card wizard-card rounded-4" aria-labelledby="signupTitle">
        <header class="card-header bg-white border-0 pt-4 px-4 px-md-5">
            <h1 id="signupTitle" class="h3 fw-bold mb-3">Create your account</h1>
            <p class="text-muted mb-0">Step 1: Business settings → Step 2: Owner account</p>
        </header>

        <div class="card-body p-4 p-md-5">
            <!-- Step header / progress -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 wizard-steps" aria-label="Signup steps">
                <div class="step" aria-current="step" id="stepLabel1">
                    <div id="dot1" class="step__dot step__dot--active" aria-hidden="true">1</div>
                    <div class="step__label">
                        <div class="fw-semibold">Business settings</div>
                        <small class="text-muted">Company profile, tax & region</small>
                    </div>
                </div>
                <div class="step text-end" id="stepLabel2">
                    <div class="step__label d-none d-sm-block">
                        <div class="fw-semibold">Owner account</div>
                        <small class="text-muted">Login & contact</small>
                    </div>
                    <div id="dot2" class="step__dot step__dot--muted ms-sm-3" aria-hidden="true">2</div>
                </div>
            </div>

            <div class="progress mb-4" role="progressbar" aria-label="Form progress" aria-valuemin="0" aria-valuemax="100" aria-valuenow="50">
                <div id="progressBar" class="progress-bar" style="width: 50%;"></div>
            </div>

            <!-- Form -->
            <form id="multiForm" action="{{ route('business.postRegister') }}" method="post" novalidate enctype="multipart/form-data">
                @csrf
                <!-- STEP 1: Business -->
                <section id="step1" class="form-section" aria-labelledby="h-step1">
                    <h2 id="h-step1" class="visually-hidden">Business settings</h2>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label" for="business_name">Business name: <span class="text-denger">*</span> </label>
                            <input type="text" required class="form-control @error('name') is-invalid @enderror" id="business_name" name="name" value="{{ old('name') }}" autocomplete="organization" placeholder="e.g., Bringo POS Ltd." />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="industry">Industry</label>
                            <select class="form-select @error('industry') is-invalid @enderror" id="industry" name="industry">
                                <option value="Retail / POS" selected>Retail / POS</option>
                                <option value="Wholesale">Wholesale</option>
                                <option value="Manufacturing">Manufacturing</option>
                                <option value="Services">Services</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('name')
                                <div class="invalid-feedback"> You must agree before submitting. </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="formFile" class="form-label">Business Logo: <span class="text-denger">*</span> </label>
                            <input required name="logo" class="form-control @error('logo') is-invalid @enderror" type="file" id="formFile">
                            @error('logo')
                                <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="start_date">Start Date: <span class="text-denger">*</span> </label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" placeholder="Start Date." required/>
                            @error('start_date')
                                <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="trade_license">Trade license</label>
                            <input type="text" class="form-control" id="trade_license" name="trade_license" value="{{ old('trade_license') }}" placeholder="Trade license" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="tax_id">Tax ID (TIN / VAT)</label>
                            <input type="text" class="form-control" id="tax_id" name="tax_id" value="{{ old('tax_id') }}" placeholder="Tax ID" />
                        </div>
    
                        <div class="col-md-4">
                            <label class="form-label" for="phone_no">Business contact number:</label>
                            <input type="tel" step="any" class="form-control" id="phone_no" name="phone_no"  value="{{ old('phone_no') }}" autocomplete="tel" placeholder="Business contact number:" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="phone_no">Currency: <span class="text-denger">*</span></label>
							<select name="currency_id" class="select2 form-control @error('currency_id') is-invalid @enderror" id="select2-placeholder-single" required>
                                <option value="" selected>Select Currency</option>
                                @foreach ($currencys as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->country }} - {{ $currency->currency }}({{ $currency->code }}) </option>
                                @endforeach
                            </select>
                            @error('currency_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
						</div>
                        <div class="col-md-6">
                            <label class="form-label" for="phone_no">Time zone: <span class="text-denger">*</span></label>
							<select class="select2 form-control @error('time_zone') is-invalid @enderror" name="time_zone">
                                <option value="" selected>Select Currency</option>
                                @foreach ($timezones as $timezone)
                                    <option value="{{ $timezone['zone'] }}">{{ $timezone['zone'] }}</option>
                                @endforeach
                            </select>
                            @error('time_zone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
						</div>

                        <div class="col-md-3">
                            <label class="form-label">Country: <span class="text-denger">*</span> </label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') }}" placeholder="country" required/>
                            @error('country')
                                <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">State: <span class="text-denger">*</span> </label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" placeholder="state" required/>
                            @error('state')
                                <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">City: <span class="text-denger">*</span> </label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old(key: 'city') }}" placeholder="city" required/>
                            @error('city')
                                <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Zip code: <span class="text-denger">*</span> </label>
                            <input type="text" class="form-control @error('zip_code') is-invalid @enderror" name="zip_code" value="{{ old('zip_code') }}" placeholder="zip_code" required/>
                            @error('zip_code')
                                <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2 pt-2">
                            <button type="button" id="toStep2" class="btn btn-brand">Continue to Owner →</button>
                        </div>
                    </div>
                </section>

                <!-- STEP 2: Owner / User -->
                <section id="step2" class="form-section hidden" aria-labelledby="h-step2">
                    <h2 id="h-step2" class="visually-hidden">Owner account</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="first_name">First name</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" autocomplete="name" placeholder="Owner first name" required/>
                            @error('first_name')
                                <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="last_name">Last name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" autocomplete="name" placeholder="Owner last name" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" autocomplete="username" placeholder="username" required/>
                            @error('username')
                                <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="you@example.com" required/>
                            @error('email')
                                <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="new-password" placeholder="••••••••" required/>
                            @error('password')
                                <div class="invalid-feedback"> {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="password_confirmation">Confirm password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="Repeat password" />
                        </div>

                        <div class="col-12 d-flex justify-content-between pt-2">
                            <button type="button" id="backTo1" class="btn btn-outline-secondary">← Back</button>
                            <button type="submit" class="btn btn-brand">Create account</button>
                        </div>
                    </div>
                </section>
            </form>
        </div>

        <footer class="card-footer bg-white border-0 pb-4 px-4 px-md-5">
            <div class="text-muted small">© {{ config('app.name') }}. Built with Bootstrap 5.3.3. No third‑party assets bundled.</div>
        </footer>
    </article>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <style>
        .select2-container .select2-selection--single {
            height: calc(2.5rem + 2px);
            padding: 0.5rem 0.85rem;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear{
            margin-top: -10px !important;
            margin-right: 0 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow{
            display: none !important;
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-select2.js') }}"></script>
@endsection