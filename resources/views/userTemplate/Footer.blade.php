<!-- ======= Footer ======= -->
<footer id="footer" class="footer-page">
    <div class="copyright">
        &copy; Copyright <strong><span>Permission Dashboard</span></strong>.
    </div>
    <div class="credits">
        Designed by <a href="https://www.linkedin.com/in/subhajitnath/">SUBHAJIT NATH</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<!-- coreui.io -->
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@5.0.0-rc.1/dist/js/coreui.bundle.min.js"
    integrity="sha384-lm/gmE8U/6Q0duWGAHKfdf8Q0rLLWtCudgbt9aLBgnb5B+iateMBMTOBGSafJbEe" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/@coreui/coreui-pro@5.0.0-rc.1/dist/js/coreui.bundle.min.js"
    integrity="sha384-KW7wTEji2ZsXsIoA4O34wfu6+kd/92iZmHLLSbrfj3D5JlgAJNWobqk0VRB2UvIK" crossorigin="anonymous">
</script>

<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Additional Scripts from Your Application -->
@yield('script')

<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Custom Script to Automatically Close Alerts -->
<script>
    // Automatically close alerts after 5 seconds
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 5000);
</script>

</body>

</html>
