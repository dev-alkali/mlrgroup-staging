(function ($) {
    'use strict';

    if (typeof PortfolioSearchConfig === 'undefined') {
        return;
    }

    var wrap = document.querySelector('.search-form-parent');
    if (!wrap) {
        return;
    }

    var input = wrap.querySelector('input[name="s_portfolio"]');
    var form  = wrap.querySelector('form');
    var grid  = document.getElementById('portfolio-grid');
    var statusEl = document.getElementById('portfolio-search-status');

    if (!input || !grid) {
        return;
    }

    var featuredHeading = document.getElementById('portfolio-featured-heading');
    var featuredDivider = grid.querySelector('.col-span-full.border-t'); // divider inside default grid
    var defaultRoot     = document.getElementById('portfolio-infinite-root'); // may be null

    var MIN_CHARS = 2;
    var DEBOUNCE  = 300;

    var termId        = parseInt(wrap.getAttribute('data-term'), 10) || 0;
    var timer         = null;
    var currentSearch = '';
    var page          = 1;
    var hasMore       = false;
    var isLoading     = false;
    var searchActive  = false;
    var originalGrid  = null;
    var requestId     = 0;

    var observer  = null;
    var sentinel  = null;
    var loadingEl = null;

    function buildSearchUI() {
        if (!sentinel) {
            sentinel = document.createElement('div');
            sentinel.id = 'portfolio-search-sentinel';
            sentinel.className = 'h-px w-full pointer-events-none';
            sentinel.setAttribute('aria-hidden', 'true');
        }
        if (!loadingEl) {
            loadingEl = document.createElement('p');
            loadingEl.id = 'portfolio-search-loading';
            loadingEl.className = 'hidden text-center font-heading font-semibold text-[#fd4338] text-base tracking-[0] leading-6 py-[20px]';
            loadingEl.setAttribute('aria-live', 'polite');
            loadingEl.textContent = 'LOADING...';
        }
        if (loadingEl.parentNode !== grid.parentNode) {
            grid.parentNode.insertBefore(loadingEl, grid.nextSibling);
        }
        if (sentinel.parentNode !== grid.parentNode) {
            grid.parentNode.insertBefore(sentinel, loadingEl.nextSibling);
        }
    }

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
        if (!hasMore || !sentinel) {
            return;
        }
        observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting && hasMore && !isLoading) {
                    loadPage(page + 1, true);
                }
            });
        }, { rootMargin: '300px 0px 0px 0px', threshold: 0 });
        observer.observe(sentinel);
    }

    function pauseDefault() {
        if (defaultRoot) {
            defaultRoot.style.display = 'none';
        }
        if (featuredHeading) {
            featuredHeading.classList.add('hidden');
        }
    }

    function resumeDefault() {
        if (defaultRoot) {
            defaultRoot.style.display = '';
        }
        if (featuredHeading) {
            featuredHeading.classList.remove('hidden');
        }
    }

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function showStatus(text) {
        if (!statusEl) {
            return;
        }
        statusEl.textContent = text;
        statusEl.classList.toggle('hidden', !text);
    }

    function refreshInquiry() {
        if (window.InquiryList && typeof window.InquiryList.refresh === 'function') {
            window.InquiryList.refresh();
        }
    }

    function loadPage(paged, append) {
        isLoading = true;
        var thisRequest = ++requestId;

        if (append) {
            setLoading(true);
        }

        $.ajax({
            url:      PortfolioSearchConfig.ajax_url,
            type:     'POST',
            dataType: 'json',
            data: {
                action:   'search_portfolio',
                search:   currentSearch,
                term_id:  termId,
                paged:    paged,
                security: PortfolioSearchConfig.nonce
            },
            success: function (response) {
                // Ignore stale responses (user kept typing).
                if (thisRequest !== requestId || !response || !response.success) {
                    return;
                }

                var data = response.data || {};

                if (append) {
                    if (data.html) {
                        $(grid).append(data.html);
                    }
                } else {
                    if (data.empty || !data.html) {
                        grid.innerHTML = '<p class="col-span-full py-16 text-center font-[Poppins] font-medium text-[16px] leading-[24px] text-[#525252]">No results found for &ldquo;' + escapeHtml(currentSearch) + '&rdquo;.</p>';
                        showStatus('');
                    } else {
                        grid.innerHTML = data.html;
                        var found = parseInt(data.found, 10) || 0;
                        showStatus(found + ' result' + (found === 1 ? '' : 's') + ' for \u201C' + currentSearch + '\u201D');
                    }
                }

                page    = paged;
                hasMore = !!data.has_more;

                refreshInquiry();
                connectObserver();
            },
            error: function (xhr, status, error) {
                console.error('Portfolio search AJAX error:', status, error);
            },
            complete: function () {
                if (thisRequest === requestId) {
                    isLoading = false;
                    setLoading(false);
                }
            }
        });
    }

    function startSearch(value) {
        if (!searchActive) {
            originalGrid = grid.innerHTML;
            searchActive = true;
            buildSearchUI();
            pauseDefault();
        }
        currentSearch = value;
        page    = 1;
        hasMore = false;
        disconnectObserver();
        loadPage(1, false);
    }

    function endSearch() {
        requestId++; // invalidate any in-flight request
        if (!searchActive) {
            return;
        }
        searchActive = false;
        disconnectObserver();
        setLoading(false);
        showStatus('');
        if (originalGrid !== null) {
            grid.innerHTML = originalGrid;
            featuredDivider = grid.querySelector('.col-span-full.border-t');
        }
        resumeDefault();
        refreshInquiry();
    }

    input.addEventListener('input', function () {
        clearTimeout(timer);
        var value = input.value.trim();
        timer = setTimeout(function () {
            if (value.length < MIN_CHARS) {
                endSearch();
                return;
            }
            startSearch(value);
        }, DEBOUNCE);
    });

    // No page reload: JS owns the search experience.
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            clearTimeout(timer);
            var value = input.value.trim();
            if (value.length < MIN_CHARS) {
                endSearch();
            } else {
                startSearch(value);
            }
        });
    }

    // If the page loaded with a prefilled term (shared URL / GET fallback), run it.
    var initialValue = input.value.trim();
    if (initialValue.length >= MIN_CHARS) {
        startSearch(initialValue);
    }
})(jQuery);
