@extends('backend.layouts.app')

@section('content')
<div class="content-wrapper page_content_section_hp">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Page Header -->
        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="ti ti-user-edit text-primary"></i> Edit Profile
                </h4>
                <p class="text-muted mb-0 small">Update your personal account information and avatar</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('myProfile') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="ti ti-arrow-left me-1"></i> Back to Profile
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-md rounded-circle bg-label-primary d-flex align-items-center justify-content-center">
                                <i class="ti ti-user-circle fs-3 text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Account Details</h6>
                                <small class="text-muted">Manage your display name and photo</small>
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

                        <form method="POST" id="formAuthentication" action="{{ url('profile/update/' . $user->id) }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Current Avatar Preview & Uploader -->
                            <div class="d-flex flex-column flex-sm-row align-items-center gap-4 mb-4 p-3 rounded-3" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                                <div class="position-relative">
                                    @if(!empty($user->image) && file_exists(public_path('images/profile_images/' . $user->image)))
                                        <img src="{{ asset('images/profile_images/' . $user->image) }}" alt="Avatar" class="rounded-circle object-fit-cover shadow-sm" style="width: 80px; height: 80px;" id="avatarPreview" />
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-sm fw-bold" style="width: 80px; height: 80px; font-size: 28px;" id="avatarFallback">
                                            {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <img src="" alt="Avatar" class="rounded-circle object-fit-cover shadow-sm d-none" style="width: 80px; height: 80px;" id="avatarPreview" />
                                    @endif
                                </div>
                                <div class="flex-grow-1 text-center text-sm-start">
                                    <label for="image" class="form-label fw-semibold mb-1">Profile Photo</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*" />
                                    </div>
                                    <small class="text-muted d-block mt-1">Allowed JPG, JPEG, PNG, BMP (Max 5MB)</small>
                                    <span class="image-error text-danger small" style="display:none;"></span>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label fw-semibold">Username / Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="ti ti-user"></i></span>
                                    <input type="text" class="form-control" id="username" name="name" placeholder="Enter your username" value="{{ !empty($user->name) ? $user->name : old('name') }}" required autofocus />
                                </div>
                                <span class="name-error text-danger small" style="display:none;"></span>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="ti ti-mail"></i></span>
                                    <input type="email" class="form-control bg-light" id="email" name="email" placeholder="Enter your email" value="{{ !empty($user->email) ? $user->email : old('email') }}" readonly />
                                </div>
                                <small class="text-muted">Email address cannot be changed directly.</small>
                                <span class="email-error text-danger small" style="display:none;"></span>
                            </div>

                            @if (empty($user->id))
                            <div class="mb-4 form-password-toggle">
                                <label class="form-label fw-semibold" for="password">Password <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text bg-light text-muted"><i class="ti ti-lock"></i></span>
                                    <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                                <span class="password-error text-danger small" style="display:none;"></span>
                            </div>
                            @endif

                            <div class="d-flex flex-column flex-sm-row align-items-center justify-content-end gap-2 pt-3 border-top mt-4">
                                <a href="{{ route('myProfile') }}" class="btn btn-outline-secondary w-100 w-sm-auto">Cancel</a>
                                <button class="btn btn-primary w-100 w-sm-auto px-4" type="submit">
                                    <i class="ti ti-device-floppy me-1"></i> {{ !empty($user->id) ? 'Save Changes' : 'Submit' }}
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
        // Image preview before upload
        $('#image').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    $('#avatarPreview').attr('src', evt.target.result).removeClass('d-none');
                    $('#avatarFallback').addClass('d-none');
                }
                reader.readAsDataURL(file);
            }
        });

        if ($.fn.validate) {
            $.validator.addMethod("filesize", function(value, element, param) {
                return this.optional(element) || (element.files[0].size <= param);
            }, "File size must be less than 5 MB");

            $.validator.addMethod("noSpecialChars", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9\s]+$/.test(value);
            }, "Username must not contain special characters");

            $("#formAuthentication").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2,
                        maxlength: 50,
                        noSpecialChars: true
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 50
                    },
                    image: {
                        required: false,
                        extension: "jpg|jpeg|png|bmp",
                        filesize: 5242880 // 5 MB
                    },
                    password: {
                        required: function() {
                            return $('#password').length > 0;
                        },
                        minlength: 6
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your username",
                        minlength: "Username must be at least 2 characters long",
                        maxlength: "Username must be less than 50 characters",
                        noSpecialChars: "Username must not contain special characters"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address",
                        maxlength: "Email must be less than 50 characters"
                    },
                    image: {
                        extension: "Please upload only image files (jpg, jpeg, png, bmp)",
                        filesize: "Image size must be less than 5 MB"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Password must be at least 6 characters long"
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") === "name") {
                        element.closest('.mb-3').find('.name-error').text(error.text()).show();
                    } else if (element.attr("name") === "email") {
                        element.closest('.mb-3').find('.email-error').text(error.text()).show();
                    } else if (element.attr("name") === "image") {
                        element.closest('div').find('.image-error').text(error.text()).show();
                    } else if (element.attr("name") === "password") {
                        element.closest('.form-password-toggle').find('.password-error').text(error.text()).show();
                    } else {
                        error.insertAfter(element);
                    }
                },
                success: function(label, element) {
                    if ($(element).attr("name") === "name") {
                        $(element).closest('.mb-3').find('.name-error').hide();
                    } else if ($(element).attr("name") === "email") {
                        $(element).closest('.mb-3').find('.email-error').hide();
                    } else if ($(element).attr("name") === "image") {
                        $(element).closest('div').find('.image-error').hide();
                    } else if ($(element).attr("name") === "password") {
                        $(element).closest('.form-password-toggle').find('.password-error').hide();
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }

        // Limit input length for username and email
        $('#username, #email').on('input', function() {
            if ($(this).val().length > 50) {
                $(this).val($(this).val().substring(0, 50));
            }
        });
    });
});
</script>
@endsection
