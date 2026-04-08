(function ($) {
    'use strict';

    if (typeof PortfolioConfig === 'undefined') {
        console.error('PortfolioConfig is not defined. Check wp_localize_script.');
        return;
    }

    var root     = document.getElementById('portfolio-infinite-root');
    var grid     = document.getElementById('portfolio-grid');
    var sentinel = document.getElementById('portfolio-infinite-sentinel');
    var loadingEl = document.getElementById('portfolio-loading-more');

    if (!root || !grid || !sentinel || typeof IntersectionObserver === 'undefined') {
        return;
    }

    var totalPages  = parseInt(root.getAttribute('data-max-pages'), 10);
    var currentPage = parseInt(root.getAttribute('data-current-page'), 10) || 1;
    var termId      = parseInt(root.getAttribute('data-term'), 10) || 0;
    var isLoading   = false;
    var observer    = null;

    function setLoading(visible) {
        if (loadingEl) {
            loadingEl.classList.toggle('hidden', !visible);
        }
    }

    function disconnectObserver() {
        if (observer) {
            observer.disconnect();
            observer = null;
        }
    }

    function connectObserver() {
        disconnectObserver();
        if (currentPage >= totalPages) {
            return;
        }
        observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting && !isLoading && currentPage < totalPages) {
                        loadNextPage();
                    }
                });
            },
            { rootMargin: '300px 0px 0px 0px', threshold: 0 }
        );
        observer.observe(sentinel);
    }

    function loadNextPage() {
        if (isLoading || currentPage >= totalPages) {
            return;
        }

        isLoading = true;
        setLoading(true);

        $.ajax({
            url:      PortfolioConfig.ajax_url,
            type:     'POST',
            dataType: 'json',
            data: {
                action:   'load_more_portfolio',
                term_id:  termId,
                paged:    currentPage + 1,
                security: PortfolioConfig.nonce
            },
            success: function (response) {
                if (response.success && response.data.html) {
                    $('#portfolio-grid').append(response.data.html);
                    currentPage++;
                    root.setAttribute('data-current-page', currentPage);

                    // Refresh inquiry badge/button states for newly loaded cards
                    if (window.InquiryList && typeof window.InquiryList.refresh === 'function') {
                        window.InquiryList.refresh();
                    }

                    if (!response.data.has_more || currentPage >= totalPages) {
                        disconnectObserver();
                    } else {
                        connectObserver();
                    }
                } else {
                    disconnectObserver();
                }
            },
            error: function (xhr, status, error) {
                console.error('Portfolio AJAX Error:', status, error);
            },
            complete: function () {
                isLoading = false;
                setLoading(false);
            }
        });
    }

    $(document).ready(function () {
        connectObserver();
    });

})(jQuery);
