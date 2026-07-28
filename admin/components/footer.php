<footer class="admin-footer">
    <div class="container-fluid px-3 px-lg-4">
        <span>Copyright 2026 adminHMD. <br> Developed by <a target="_blank" class="fw-bold text-success" href="https://github.com/HasanMahmudDev">Md. Hasan Mahmud</a> • Distributed by <a target="_blank" class="fw-bold text-success" href="https://themewagon.com">ThemeWagon</a> </span>
        <span>Professional dashboard template.</span>
    </div>
</footer>
</div>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
<script>
    window.history.forward();

    function noBack() {
        window.history.forward();
    }
    window.onload = noBack;
    window.onpageshow = function(evt) {
        if (evt.persisted) noBack();
    };
    window.onunload = function() {};
</script>
</body>

</html>