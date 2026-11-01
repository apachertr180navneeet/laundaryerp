<!-- Core JS -->
<script src="{{asset('theam/assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('theam/assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/node-waves/node-waves.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{asset('theam/assets/vendor/js/menu.js')}}"></script>

<!-- Form Validation Plugins -->
<script src="{{asset('package/jquery.validate.min.js')}}"></script>
<script src="{{asset('package/additional-methods.min.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>

<!-- UI Vendor Plugins -->
<script src="{{asset('theam/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('package/toastr.min.js')}}"></script>
<script src="{{asset('package/bootstrap2-toggle.min.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/moment/moment.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js')}}"></script>
<script src="{{asset('theam/assets/vendor/libs/jquery-timepicker/jquery-timepicker.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Main Theme JS (Single Source of Truth) -->
<script src="{{asset('theam/assets/js/main.js')}}"></script>

<script>
    $(document).ready(function() {
        if ($.fn.select2) {
            $('.js-example-basic-single').select2();
        }
    });
</script>
