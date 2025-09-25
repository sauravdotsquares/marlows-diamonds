<!-- Global Loader CSS -->
<style>
    .spinner {
        border: 6px solid #eee;
        border-top: 6px solid #8e2e65;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    #loader-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: none;
        /* hidden by default */
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>


<!-- Global Loader HTML -->
<div id="loader-overlay">
    <div class="spinner"></div>
</div>


<!-- Global Loader JS -->
<script>
    (function() {
        const loader = document.getElementById('loader-overlay');
        let activeRequests = 0;

        function showLoader() {
            loader.style.display = 'flex';
        }

        function hideLoader() {
            loader.style.display = 'none';
        }

        // ✅ Only hide after FULL page load
        // window.addEventListener("load", function() {
        //     hideLoader();
        // });

        // ✅ Show loader on navigation (page unload/redirect)
        // window.addEventListener("beforeunload", function() {
        //     showLoader();
        // });

        // ✅ Track fetch globally
        // const originalFetch = window.fetch;
        // window.fetch = async (...args) => {
        //     activeRequests++;
        //     showLoader();
        //     try {
        //         return await originalFetch(...args);
        //     } finally {
        //         activeRequests--;
        //         if (activeRequests <= 0) {
        //             activeRequests = 0; // safety
        //             hideLoader();
        //         }
        //     }
        // };

        // ✅ Track XHR globally
        // const origOpen = XMLHttpRequest.prototype.open;
        // XMLHttpRequest.prototype.open = function(...args) {
        //     this.addEventListener('loadstart', () => {
        //         activeRequests++;
        //         showLoader();
        //     });
        //     this.addEventListener('loadend', () => {
        //         activeRequests--;
        //         if (activeRequests <= 0) {
        //             activeRequests = 0; // safety
        //             hideLoader();
        //         }
        //     });
        //     return origOpen.apply(this, args);
        // };
    })();
</script>
