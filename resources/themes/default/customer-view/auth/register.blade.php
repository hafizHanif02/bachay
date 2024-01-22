{{-- @extends('layouts.front-end.app') --}}
@extends('layouts.front-end.sample-app')

@section('title', translate('register'))

@section('content')
<div class="register_text ">
    <div class="container _inline-7 custom-form-width-sm register" style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};">
        <div class="login-card shadow p-4">
            <div class="mx-auto __max-w-760">
                <h2 class="text-center h4 mb-4 font-bold text-capitalize fs-18-mobile">{{ translate('sign_up') }}</h2>
                <form class="needs-validation_" id="form-id" action="{{ route('customer.auth.sign-up') }}" enctype="multipart/form-data" method="post"
                    id="sign-up-form">
                    @csrf
                    <div class="row">
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label font-semibold">{{ translate('first_name') }}</label>
                                <input class="form-control" value="{{ old('f_name') }}" type="text" name="f_name"
                                    style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                    placeholder="{{ translate('Ex') }}: Jhone" required>
                                <div class="invalid-feedback">{{ translate('please_enter_your_first_name') }}!</div>
                            </div>
                        </div> --}}
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label font-semibold">{{ translate('last_name') }}</label>
                                <input class="form-control" type="text" value="{{ old('l_name') }}" name="l_name"
                                    style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                    placeholder="{{ translate('Ex') }}: Doe" required>
                                <div class="invalid-feedback">{{ translate('please_enter_your_last_name') }}!</div>
                            </div> --}}
                        </div>
                        <div class="">
                            <div class="form-group border-bottom border-secondary">
                                <label class="form-label font-semibold">{{ translate('email_address') }}</label>
                                <input class="form-control border-0" type="email" value="{{ old('email') }}" name="email"
                                    style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                    placeholder="{{ translate('enter_email_address') }}" autocomplete="off" required>
                                <div class="invalid-feedback">{{ translate('please_enter_valid_email_address') }}!</div>
                            </div>
                        </div>
                        <div class="border-bottom border-secondary">
                            <div class="form-group mt-2">
                                <label class="form-label font-semibold">{{ translate('phone_number') }}
                                    <small class="text-primary">( * {{ translate('country_code_is_must_like_for_BD') }} 880
                                        )</small></label>
                                        <div class="custom-input-group d-flex">
                                            <span class="custom-input-group-prepend mt-1 ms-2">+92</span>
                                            <input class="form-control with-icon border-0" type="tel" value="{{ old('phone') }}" name="phone"
                                                style="text-align : {{ Session::get('direction') === 'rtl' ? 'right' : 'left'}};"
                                                placeholder="{{ translate('enter_phone_number') }}" required>
                                        </div>
                                <div class="invalid-feedback">{{ translate('please_enter_your_phone_number') }}!</div>
                            </div>
                        </div>
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label font-semibold">{{ translate('image') }}</label>
                                <input class="form-control" type="file" value="{{ old('image') }}" name="image"
                                    style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                    placeholder="{{ translate('Enter_image') }}" autocomplete="off" required>
                                <div class="invalid-feedback">{{ translate('please_enter_valid_image') }}!</div>
                            </div>
                        </div> --}}
                        <div class="">
                            <div class="form-group border-bottom border-secondary mt-2">
                                <label class="form-label font-semibold">{{ translate('password') }}</label>
                                <div class="password-toggle rtl">
                                    <input class="form-control border-0" name="password" type="password" id="si-password"
                                        style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                        placeholder="{{ translate('minimum_8_characters_long') }}" required>
                                    <label class="password-toggle-btn mt-2">
                                        <input class="custom-control-input me-1" type="checkbox"><i
                                            class="tio-hidden password-toggle-indicator"></i><span
                                            class="sr-only">{{ translate('show_password') }} </span>
                                    </label>
                                </div>
                            </div>

                        </div>
                        {{-- <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label font-semibold">{{ translate('confirm_password') }}</label>
                                <div class="password-toggle rtl">
                                    <input class="form-control" name="con_password" type="password"
                                        style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"
                                        placeholder="{{ translate('minimum_8_characters_long') }}" id="si-password"
                                        required>
                                    <label class="password-toggle-btn mt-2">
                                        <input class="custom-control-input me-1" type="checkbox"
                                            style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};"><i
                                            class="tio-hidden password-toggle-indicator"></i><span
                                            class="sr-only">{{ translate('show_password') }} </span>
                                    </label>
                                </div>
                            </div>

                        </div> --}}

                        @if ($web_config['ref_earning_status'])
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label font-semibold">{{ translate('refer_code') }} <small
                                            class="text-muted">({{ translate('optional') }})</small></label>
                                    <input type="text" id="referral_code" class="form-control" name="referral_code"
                                        placeholder="{{ translate('use_referral_code') }}">
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="">
                                <div class="rtl mt-2">
                                    <label class="custom-control custom-checkbox m-0 d-flex">
                                        <input type="checkbox" class="custom-control-input me-1" name="remember"
                                            id="inputCheckd">
                                        <span class="custom-control-label">
                                            <span>{{ translate('i_agree_to_Your') }}</span> <a class="font-size-sm"
                                                
                                                href="{{ route('terms') }}">{{ translate('terms_and_condition') }}</a>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6">
                                @php($recaptcha = \App\CPU\Helpers::get_business_settings('recaptcha'))
                                @if (isset($recaptcha) && $recaptcha['status'] == 1)
                                    <div id="recaptcha_element" class="w-100" data-type="image"></div>
                                @else
                                    <div class="row mt-2">
                                        <div class="col-6 pr-2">
                                            <input type="text" class="form-control border __h-40"
                                                name="default_recaptcha_value_customer_regi" value=""
                                                placeholder="{{ translate('enter_captcha_value') }}" autocomplete="off">
                                        </div>
                                        <div class="col-6 input-icons mb-2 rounded bg-white">
                                            <a onclick="re_captcha();"
                                                class="d-flex align-items-center align-items-center">
                                                <img src="{{ URL('/customer/auth/code/captcha/1?captcha_session_id=default_recaptcha_id_customer_regi') }}"
                                                    class="input-field rounded __h-40" id="default_recaptcha_id">
                                                <i class="tio-refresh icon cursor-pointer p-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div> --}}
                        </div>
                    </div>
                    <div style="direction: {{ Session::get('direction') }}">
                        <div class="mx-auto mt-4 __max-w-356">
                            <button style="background: var( --greadient-normal, linear-gradient( 270deg, #845dc2 -0.09%, #d55fad 36.37%, #fc966c 72.82%, #f99327 100.48%, #ffc55d 145.17% ) );" class= "col-12 text-light border-0 ps-5 pe-5 pt-2 pb-2 rounded-pill" id="sign-up" type="submit">
                                {{ translate('sign_up') }}
                            </button>
                        </div>
                        <div class="text-center m-3 text-black-50">
                            <small>{{ translate('or_continue_with') }}</small>
                        </div>
                        <div class="d-flex justify-content-center my-3 gap-2">
                            @foreach (\App\CPU\Helpers::get_business_settings('social_login') as $socialLoginService)
                                @if (isset($socialLoginService) && $socialLoginService['status'] == true)
                                    <div>
                                        <a class="d-block"
                                            href="{{ route('customer.auth.service-login', $socialLoginService['login_medium']) }}">
                                            <img src="{{ asset('/public/assets/front-end/img/icons/' . $socialLoginService['login_medium'] . '.png') }}"
                                                alt="">
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="text-black-50 mt-3 text-center">
                            <small>
                                {{ translate('Already_have_account ') }}?
                                <a class="text-primary text-underline" href="{{ route('customer.auth.login') }}">
                                    {{ translate('sign_in') }}
                                </a>
                            </small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

    <script>
        $('#inputCheckd').change(function() {
            // console.log('jell');
            if ($(this).is(':checked')) {
                $('#sign-up').removeAttr('disabled');
            } else {
                $('#sign-up').attr('disabled', 'disabled');
            }

        });
    </script>

    {{-- recaptcha scripts start --}}
    @if (isset($recaptcha) && $recaptcha['status'] == 1)
        <script type="text/javascript">
            var onloadCallback = function() {
                grecaptcha.render('recaptcha_element', {
                    'sitekey': '{{ \App\CPU\Helpers::get_business_settings('recaptcha')['site_key'] }}'
                });
            };
        </script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
        <script>
            $("#form-id").on('submit', function(e) {
                var response = grecaptcha.getResponse();

                if (response.length === 0) {
                    e.preventDefault();
                    toastr.error("{{ translate('please_check_the_recaptcha') }}");
                }
            });
        </script>
    @else
        <script type="text/javascript">
            function re_captcha() {
                $url = "{{ URL('/customer/auth/code/captcha') }}";
                $url = $url + "/" + Math.random() + '?captcha_session_id=default_recaptcha_id_customer_regi';
                document.getElementById('default_recaptcha_id').src = $url;
                console.log('url: ' + $url);
            }
        </script>
    @endif
    {{-- recaptcha scripts end --}}
@endpush
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var passwordToggleInputs = document.querySelectorAll('.password-toggle-btn input');
        passwordToggleInputs.forEach(function(input) {
            input.addEventListener('change', function() {
                var passwordField = this.closest('.password-toggle').querySelector(
                    'input[type="password"]');
                passwordField.type = this.checked ? 'text' : 'password';
            });
        });
    });
</script>
