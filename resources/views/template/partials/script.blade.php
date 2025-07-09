<div class="dark-transparent sidebartoggler"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Import Js Files -->
<script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js">
</script>
<script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/libs/simplebar/dist/simplebar.min.js"></script>
<script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/theme/app.init.js"></script>
<script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/theme/theme.js"></script>
<script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/theme/app.min.js"></script>
<script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/theme/sidebarmenu.js"></script>

<!-- solar icons -->
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

<!-- highlight.js (code view) -->
<script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/highlights/highlight.min.js"></script>
<script src="https://bootstrapdemos.adminmart.com/matdash/dist/assets/js/plugins/toastr-init.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('script')

@if (session('loginSuccess'))
    <script>
        toastr.info("{!! session('loginSuccess') !!}", "Login Berhasil", {
            closeButton: true,
        });
    </script>
@endif

<script>
    hljs.initHighlightingOnLoad();


    document.querySelectorAll("pre.code-view > code").forEach((codeBlock) => {
        codeBlock.textContent = codeBlock.innerHTML;
    });

    $('body').on('click', '.single-menu', function() {
        $('body').attr('data-sidebartype', 'mini-sidebar');
        $('#main-wrapper').addClass('show-sidebar')
    });
</script>
