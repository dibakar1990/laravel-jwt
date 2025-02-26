@extends('layouts.admin.app')

@section('title')
    Setting
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/bs-stepper/bs-stepper.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/toastr/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/animate-css/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/sweetalert2/sweetalert2.css')}}" />
    <link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
       <div class="col-12">
          <h5>Settings</h5>
       </div>
       
       <!-- Vertical Wizard -->
       <div class="col-12 mb-6">
          <div class="bs-stepper wizard-vertical vertical wizard-vertical-icons-example wizard-vertical-icons mt-2">
             <div class="bs-stepper-header">
                <div class="step" data-target="#general-setting">
                   <button type="button" class="step-trigger">
                   <span class="avatar">
                   <span class="avatar-initial rounded-2">
                   <i class="ri-settings-fill ri-24px"></i>
                   </span>
                   </span>
                   <span class="bs-stepper-label flex-column align-items-start ms-2">
                   <span class="bs-stepper-title">General Setting</span>
                   </span>
                   </button>
                </div>
                <div class="step" data-target="#payment-setting">
                   <button type="button" class="step-trigger">
                   <span class="avatar">
                   <span class="avatar-initial rounded-2">
                   <i class="ri-secure-payment-fill ri-24px"></i>
                   </span>
                   </span>
                   <span class="bs-stepper-label flex-column align-items-start ms-2">
                   <span class="bs-stepper-title">Payment Setting</span>
                   </span>
                   </button>
                </div>
                <div class="step" data-target="#mail-setting">
                   <button type="button" class="step-trigger">
                   <span class="avatar">
                   <span class="avatar-initial rounded-2">
                   <i class="ri-mail-settings-line ri-24px"></i>
                   </span>
                   </span>
                   <span class="bs-stepper-label flex-column align-items-start ms-2">
                   <span class="bs-stepper-title">Mail Setting</span>
                   </span>
                   </button>
                </div>
                <div class="step" data-target="#seo-setting">
                    <button type="button" class="step-trigger">
                    <span class="avatar">
                    <span class="avatar-initial rounded-2">
                    <i class="ri-seo-line ri-24px"></i>
                    </span>
                    </span>
                    <span class="bs-stepper-label flex-column align-items-start ms-2">
                    <span class="bs-stepper-title">SEO Setting</span>
                    </span>
                    </button>
                </div>
             </div>
             <div class="bs-stepper-content">
                <form id="settingForm" method="post" action="{{route('admin.settings.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div id="general-setting" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">General Setting</h6>
                        </div>
                        <div class="row g-6">
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                <input type="text" id="app_name" name="app_name" value="{{ $data['app_name'] ?? '' }}" class="form-control" placeholder="Company Name" />
                                <label for="app_name">App Title</label>
                                @error('app_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                <input type="email" id="email" name="email" value="{{ $data['email'] ?? '' }}" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe" />
                                <label for="email">Email</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="phone" name="phone" value="{{ $data['phone'] ?? '' }}" class="form-control" placeholder="01234567890" aria-describedby="password2-vertical" />
                                    <label for="phone">Phone Number</label>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="developed_by" name="developed_by" value="{{ $data['developed_by'] ?? '' }}" class="form-control"/>
                                    <label for="phone">Developed By</label>
                                    @error('developed_by')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                  <select id="timezone" class="select2 form-select" name="timezone" data-allow-clear="true">
                                    <option value="">Select</option>
                                    @foreach ($allTimezones as $timezone)
                                        <option value="{{$timezone->name}}" @if($data['timezone'] ?? '' == $timezone->name){{ 'selected' }}@endif>{{$timezone->diff_from_gtm.' - '.$timezone->name }}</option>
                                    @endforeach
                                  </select>
                                  <label for="timezone">Time Zone</label>
                                  @error('timezone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating form-floating-outline">
                                  <textarea name="address" class="form-control" id="address" rows="5" placeholder="700059, Newtown Kolkata" style="height:60px;">{{ $data['address'] ?? '' }}</textarea>
                                  <label for="address">Address</label>
                                  @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating form-floating-outline">
                                    <textarea name="description" class="form-control" id="description" rows="5" placeholder="lorem ipsum some text" style="height:60px;">{{ $data['app_description'] ?? '' }}</textarea>
                                    <label for="description">Description</label>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                  <input class="form-control" type="file" id="file" name="file" accept="image/*" onchange="document.getElementById('logo_img_preview').src = window.URL.createObjectURL(this.files[0]);">
                                  <label for="file">Logo</label>
                                </div>
                                <br>
                                @if(isset($data['logo']))
                                <img class="img-fluid rounded mb-4" id="logo_img_preview" src="{{asset('storage/'.$data['logo'])}}" height="120" width="120" alt="logo">
                                @else   
                                <img class="img-fluid rounded mb-4" id="logo_img_preview" src="{{asset('backend/assets/img/no-image.jpg')}}" height="120" width="120" alt="logo">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                  <input class="form-control" type="file" id="fav_file" name="fav_file" accept="image/*" onchange="document.getElementById('fav_img_preview').src = window.URL.createObjectURL(this.files[0]);">
                                  <label for="fav_file">Fav Icon</label>
                                </div>
                                <br>
                                @if (isset($data['fav_icon']))
                                    <img class="img-fluid rounded mb-4" id="fav_img_preview" src="{{asset('storage/'.$data['fav_icon'])}}" height="120" width="120" alt="Fav Icon">
                                @else
                                    <img class="img-fluid rounded mb-4" id="fav_img_preview" src="{{asset('backend/assets/img/no-image.jpg')}}" height="120" width="120" alt="Fav Icon">
                                @endif
                                
                              </div>
                            
                                <div class="col-12 justify-content-between">
                                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                                </div>
                        </div>
                    </div>
                </form>
                <!-- Personal Info -->
                <form id="paymentSettingForm" method="post" action="{{route('admin.payment.settings')}}" enctype="multipart/form-data">
                    @csrf
                   
                    <div id="payment-setting" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Payment Setting</h6>
                        </div>
                        <div class="content-header mb-4">
                            <h6 class="mb-0"><strong>Stripe Credentials</strong></h6>
                        </div>
                        <div class="row g-6">
                            <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="publishable_key" name="publishable_key" value="{{ $stripe['publishable_key'] ?? '' }}" class="form-control" placeholder="Publishable Key" />
                                <label for="publishable_key">Publishable Key</label>
                                @error('publishable_key')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="secret_key" name="secret_key" value="{{ $stripe['secret_key'] ?? '' }}" class="form-control" placeholder="Secret key" />
                                    <label for="secret_key">Secret key</label>
                                    @error('secret_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="currency" name="currency" value="{{ $stripe['currency'] ?? '' }}" class="form-control" placeholder="usd" />
                                    <label for="currency">Currency</label>
                                    @error('currency')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="content-header mb-4">
                                <h6 class="mb-0"><strong>Paypal Credentials</strong></h6>
                            </div>
                            @php
                                if(isset($paypal['paypal_mode'])){
                                     $mode = $paypal['paypal_mode'];
                                }else{
                                     $mode = null;
                                }
                            @endphp
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                  <select id="paypal_mode" class="select2 form-select" name="paypal_mode" data-allow-clear="true">
                                    <option value="">Select</option>
                                    <option value="Sandbox" {{ $mode == 'Sandbox' ? 'selected' : '' }}>Sandbox</option>
                                    <option value="Live" {{ $mode == 'Live' ? 'selected' : '' }}>Live</option>
                                  </select>
                                  <label for="paypal_mode">Paypal Mode</label>
                                  @error('paypal_mode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="paypal_currency" name="paypal_currency" value="{{ $paypal['paypal_currency'] ?? '' }}" class="form-control" placeholder="usd" />
                                    <label for="paypal_currency">Currency</label>
                                    @error('paypal_currency')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="app_id" name="app_id" value="{{ $paypal['app_id'] ?? '' }}" class="form-control" placeholder="Paypal app id" />
                                    <label for="app_id">Paypal App Id(only for live)</label>
                                    @error('app_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="paypal_client_secret" name="paypal_client_secret" value="{{ $paypal['paypal_client_secret'] ?? '' }}" class="form-control" placeholder="Paypal Client Secret" />
                                    <label for="paypal_client_secret">Paypal Client Secret</label>
                                    @error('paypal_client_secret')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="paypal_client_id" name="paypal_client_id" value="{{ $paypal['paypal_client_id'] ?? '' }}" class="form-control" placeholder="Paypal Client ID" />
                                    <label for="paypal_client_id">Paypal Client ID</label>
                                    @error('paypal_client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="content-header mb-4">
                                <h6 class="mb-0"><strong>Razorpay Credentials</strong></h6>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="razorpay_key" name="razorpay_key" value="{{ $razorpay['razorpay_key']}}" class="form-control" placeholder="Razorpay key" />
                                    <label for="razorpay_key">Razorpay Key</label>
                                    @error('razorpay_key')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="razorpay_secret" name="razorpay_secret" value="{{ $razorpay['razorpay_secret']}}" class="form-control" placeholder="Razorpay secret" />
                                    <label for="razorpay_secret">Razorpay Secret</label>
                                    @error('razorpay_secret')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 justify-content-between">
                                <button type="submit" class="btn btn-primary float-end">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- Social Links -->
                <form>
                    <div id="mail-setting" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Mail Setting</h6>
                        </div>
                        <div class="row g-6">
                            <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="twitter-vertical" class="form-control" placeholder="https://twitter.com/abc" />
                                <label for="twitter-vertical">Twitter</label>
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="facebook-vertical" class="form-control" placeholder="https://facebook.com/abc" />
                                <label for="facebook-vertical">Facebook</label>
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="google-vertical" class="form-control" placeholder="https://plus.google.com/abc" />
                                <label for="google-vertical">Google+</label>
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="linkedin-vertical" class="form-control" placeholder="https://linkedin.com/abc" />
                                <label for="linkedin-vertical">LinkedIn</label>
                            </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form>
                    <div id="seo-setting" class="content">
                        <div class="content-header mb-4">
                            <h6 class="mb-0">Mail Setting</h6>
                        </div>
                        <div class="row g-6">
                            <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="twitter-vertical" class="form-control" placeholder="https://twitter.com/abc" />
                                <label for="twitter-vertical">Twitter</label>
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="facebook-vertical" class="form-control" placeholder="https://facebook.com/abc" />
                                <label for="facebook-vertical">Facebook</label>
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="google-vertical" class="form-control" placeholder="https://plus.google.com/abc" />
                                <label for="google-vertical">Google+</label>
                            </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="linkedin-vertical" class="form-control" placeholder="https://linkedin.com/abc" />
                                <label for="linkedin-vertical">LinkedIn</label>
                            </div>
                            </div>
                        </div>
                    </div>
                </form>
             </div>
          </div>
       </div>
       <!-- /Vertical Wizard -->
    </div>
 </div>
@endsection

@section('js')
    <script src="{{ asset('backend/libs/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/libs/jquery-validation/additional-methods.min.js') }}"></script>
    <script src="{{asset('backend/assets/vendor/libs/bs-stepper/bs-stepper.js')}}"></script>
    <script src="{{asset('backend/assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
    <script src="{{asset('backend/assets/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('backend/assets/js/form-wizard-icons.js')}}"></script>
    <script src="{{asset('backend/assets/vendor/libs/toastr/toastr.js')}}"></script>
    <script src="{{asset('backend/assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
    <script src="{{asset('backend/js/loader.js')}}"></script>
    <script src="{{asset('backend/js/coustom.js')}}"></script>
    {{-- <script src="{{asset('backend/js/pages/setting.js')}}"></script> --}}
    <x-layouts.admin.toast-swal-alert/>
@endsection