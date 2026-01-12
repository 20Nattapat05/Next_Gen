<!-- footer.php -->
<footer class="bg-dark text-light py-4 mt-5">
    <div class="container text-center">
        <hr>
        <p class="mb-0 py-3">&copy; 2025 Next Gen IT. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>

<script>
    // Prevent going back to protected pages after logout
    function preventBack() {
        window.history.forward();
    }
    
    // Call preventBack when user tries to go back
    setTimeout(preventBack, 0);
    
    // Disable back button when pressing back key
    window.onload = function () {
        if (typeof history.pushState === "function") {
            history.pushState(null, null, window.location.href);
            window.onpopstate = function () {
                history.pushState(null, null, window.location.href);
            };
        }
    };
</script>