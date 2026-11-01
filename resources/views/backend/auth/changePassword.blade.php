@if (!Auth::user())
    @php
        $errorMessage = 'Please contact the superadmin for access.';
        return redirect()->route('login')->withErrors([$errorMessage]);
    @endphp
@else
@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl flex-grow-1 container-p-y">
        @php
            $loginemail = Auth::user()->email;
        @endphp

        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-lock text-primary"></i> Change Password
                </h4>
                <p class="text-muted mb-0 small">Update your account login credentials</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('myProfile') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ti ti-arrow-left me-1"></i> Back to Profile
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md rounded-circle bg-label-warning d-flex align-items-center justify-content-center">
                                <i class="ti ti-shield-lock fs-3 text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Security Credentials</h6>
                                <small class="text-muted">Account: <span class="fw-semibold text-dark">{{ !empty($loginemail) ? $loginemail : '' }}</span></small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="formAuthentication" action="{{ route('change.password.post') }}" method="POST">
                            @csrf
                            
                            <!-- Old Password -->
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label fw-semibold" for="password">Current Password <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light text-muted"><i class="ti ti-key"></i></span>
                                    <input type="password" id="password" class="form-control password" name="password"
                                        placeholder="············" aria-describedby="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                                <span class="password-error text-danger small mt-1 d-block" style="{{ $errors->has('password') ? '' : 'display:none;' }}">
                                    {{ $errors->first('password') }}
                                </span>
                            </div>

                            <!-- New Password -->
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label fw-semibold" for="newpassword">New Password <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light text-muted"><i class="ti ti-lock"></i></span>
                                    <input type="password" id="newpassword" class="form-control newpassword" name="new_password"
                                        placeholder="············" aria-describedby="newpassword" required />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                                <small class="text-muted d-block mt-1">Must be at least 6 characters and different from old password.</small>
                                <span class="newpassword-error text-danger small mt-1 d-block" style="{{ $errors->has('new_password') ? '' : 'display:none;' }}">
                                    {{ $errors->first('new_password') }}
                                </span>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4 form-password-toggle">
                                <label class="form-label fw-semibold" for="confirmpassword">Confirm New Password <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light text-muted"><i class="ti ti-check"></i></span>
                                    <input type="password" id="confirmpassword" class="form-control confirmpassword" name="confirm_password"
                                        placeholder="············" aria-describedby="confirmpassword" required />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                                <span class="confirmpassword-error text-danger small mt-1 d-block" style="{{ $errors->has('confirm_password') ? '' : 'display:none;' }}">
                                    {{ $errors->first('confirm_password') }}
                                </span>
                            </div>

                            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-end gap-2 pt-3 border-top mt-4">
                                <a href="{{ route('myProfile') }}" class="btn btn-outline-secondary w-100 w-sm-auto">Cancel</a>
                                <button class="btn btn-primary w-100 w-sm-auto px-4" type="submit">
                                    <i class="ti ti-shield-check me-1"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extrascript')
<script>
document.addEventListener("DOMContentLoaded", function() {
    $(document).ready(function() {
        if ($.fn.validate) {
            $.validator.addMethod("notSamePasswords", function(value, element) {
                let oldPassword = $('#password').val();
                let newPassword = $('#newpassword').val();
                return oldPassword !== newPassword;
            }, "Old password and new password should not be the same");

            $("#formAuthentication").validate({
                rules: {
                    password: {
                        required: true,
                        minlength: 6,
                    },
                    new_password: {
                        required: true,
                        minlength: 6,
                        notSamePasswords: true
                    },
                    confirm_password: {
                        required: true,
                        minlength: 6,
                        equalTo: "#newpassword",
                    }
                },
                messages: {
                    password: {
                        required: "Please provide your old password",
                        minlength: "Password must be at least 6 characters long",
                    },
                    new_password: {
                        required: "Please provide a new password",
                        minlength: "New password must be at least 6 characters long",
                        notSamePasswords: "Old password and new password should not be the same"
                    },
                    confirm_password: {
                        required: "Please confirm your new password",
                        minlength: "Confirm password must be at least 6 characters long",
                        equalTo: "New password and confirm password should match"
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") === "password") {
                        element.closest('.form-password-toggle').find('.password-error').text(error.text()).show();
                    } else if (element.attr("name") === "new_password") {
                        element.closest('.form-password-toggle').find('.newpassword-error').text(error.text()).show();
                    } else if (element.attr("name") === "confirm_password") {
                        element.closest('.form-password-toggle').find('.confirmpassword-error').text(error.text()).show();
                    } else {
                        error.insertAfter(element);
                    }
                },
                success: function(label, element) {
                    if ($(element).attr("name") === "password") {
                        $(element).closest('.form-password-toggle').find('.password-error').hide();
                    } else if ($(element).attr("name") === "new_password") {
                        $(element).closest('.form-password-toggle').find('.newpassword-error').hide();
                    } else if ($(element).attr("name") === "confirm_password") {
                        $(element).closest('.form-password-toggle').find('.confirmpassword-error').hide();
                    }
                },
                submitHandler: function(form, event) {
                    event.preventDefault();
                    if ($(form).valid()) {
                        form.submit();
                    }
                }
            });

            $(document).on('focusout', '.password, .newpassword, .confirmpassword', function() {
                $(this).valid();
            });
        }

        $(document).on('input', '.password, .newpassword, .confirmpassword', function() {
            if ($(this).val().length > 50) {
                $(this).val($(this).val().substring(0, 50));
            }
        });
    });
});
</script>
@endsection
@endif
