/**
 * Inquiry List Manager
 */

(function ($) {
  "use strict";

  /* ─────────────────────────────────────────────
   * CONFIG
   * ───────────────────────────────────────────── */
  var COOKIE_NAME = "inquiry_list";
  var COOKIE_DAYS = 7;
  var MAX_ITEMS = 50; 
  var MAX_ID_VALUE = 2147483647; 
  var IS_HTTPS = location.protocol === "https:"; 

  /* ─────────────────────────────────────────────
   * COOKIE HELPERS
   * ───────────────────────────────────────────── */

  function setCookie(name, value, days) {
    var expires = "";
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
    }

    var estimatedSize = name.length + value.length + 60;
    if (estimatedSize > 4000) {
      console.warn("[InquiryList] Cookie payload too large, write aborted.");
      return false;
    }
 
    var cookieStr =
      name +
      "=" +
      value +
      expires +
      "; path=/" +
      "; SameSite=Strict" +
      (IS_HTTPS ? "; Secure" : "");

    document.cookie = cookieStr;
    return true;
  }

  function getCookie(name) {
    var nameEQ = name + "=";
    var parts = document.cookie.split(";");
    for (var i = 0; i < parts.length; i++) {
      var part = parts[i].replace(/^\s+/, "");
      if (part.indexOf(nameEQ) === 0) {
        return part.substring(nameEQ.length);
      }
    }
    return null;
  }

  function deleteCookie(name) {
    document.cookie =
      name +
      "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; SameSite=Strict";
  }

  /* ─────────────────────────────────────────────
   * INQUIRY LIST — READ / WRITE
   * ───────────────────────────────────────────── */

  function getList() {
    var raw = getCookie(COOKIE_NAME);
    if (!raw) return [];

    var parsed;
    try {
      parsed = JSON.parse(decodeURIComponent(raw));
    } catch (e) {
      console.warn("[InquiryList] Corrupt cookie detected, resetting.", e);
      deleteCookie(COOKIE_NAME);
      return [];
    }

    if (!Array.isArray(parsed)) {
      console.warn("[InquiryList] Cookie was not an array, resetting.");
      deleteCookie(COOKIE_NAME);
      return [];
    }

    var clean = parsed.filter(function (id) {
      return isValidId(id);
    });

    if (clean.length !== parsed.length) {
      console.warn("[InquiryList] Stripped invalid IDs from cookie.");
      saveList(clean);
    }

    return clean;
  }

  function saveList(list) {
    var encoded = encodeURIComponent(JSON.stringify(list));
    return setCookie(COOKIE_NAME, encoded, COOKIE_DAYS);
  }

  /* ─────────────────────────────────────────────
   * VALIDATION
   * ───────────────────────────────────────────── */

  function isValidId(id) {
    var n = parseInt(id, 10);
    return (
      !isNaN(n) &&
      isFinite(n) &&
      String(n) === String(id).trim() &&
      n > 0 &&
      n <= MAX_ID_VALUE
    );
  }

  /* ─────────────────────────────────────────────
   * UI — COUNTER BADGE
   * ───────────────────────────────────────────── */

  function updateCounterUI(count) {
    $(".inquiry-list-quantity").each(function () {
      var $badge = $(this);
      var $ariaParent = $badge.closest("[aria-label]");

      $badge.text(count);

      if ($ariaParent.length) {
        $ariaParent.attr(
          "aria-label",
          "View inquiry list, " + count + (count === 1 ? " item" : " items"),
        );
      }
    });
  }

  /* ─────────────────────────────────────────────
   * UI — TOAST NOTIFICATION
   * ───────────────────────────────────────────── */

  var $toast = null;
  var toastTimer = null;

  function initToast() {
    if ($toast) return;

    $toast = $("<div>", {
      id: "inquiry-toast",
      role: "status",
      "aria-live": "polite",
      "aria-atomic": "true",
    }).css({
      position: "fixed",
      bottom: "24px",
      right: "24px",
      padding: "12px 20px",
      background: "#1a1a1a",
      color: "#fff",
      borderRadius: "8px",
      fontFamily: "inherit",
      fontSize: "14px",
      fontWeight: "500",
      lineHeight: "1.4",
      boxShadow: "0 4px 20px rgba(0,0,0,0.3)",
      zIndex: 99999,
      opacity: 0,
      transform: "translateY(8px)",
      transition: "opacity 0.22s ease, transform 0.22s ease",
      pointerEvents: "none",
      maxWidth: "300px",
    });

    $("body").append($toast);
  }

  var TOAST_COLORS = {
    info: "#1a1a1a",
    success: "#1a6e3c",
    error: "#c0392b",
    warning: "#b45309",
  };

  function showToast(message, type) {
    initToast();
    clearTimeout(toastTimer);

    $toast
      .css("background", TOAST_COLORS[type] || TOAST_COLORS.info)
      .text(message)
      .css({ opacity: 1, transform: "translateY(0)" });

    toastTimer = setTimeout(function () {
      $toast.css({ opacity: 0, transform: "translateY(8px)" });
    }, 3200);
  }

  /* ─────────────────────────────────────────────
   * UI — BUTTON STATE (Show/Hide separate buttons)
   * ───────────────────────────────────────────── */

  function refreshButtonStates(list) {
    $(".add-inquiry").each(function () {
      var $btn = $(this);
      var rawId = $btn.attr("item-id");
      if (!isValidId(rawId)) return;

      var id = parseInt(rawId, 10);
      var inList = list.indexOf(id) !== -1;

      if (inList) {
        $btn.hide();
        $btn.siblings().find(".inquiry-tooltip-icon").hide();
      } else {
        $btn.show();
        $btn.siblings().find(".inquiry-tooltip-icon").show();
      }
    });

    $(".remove-inquiry").each(function () {
      var $btn = $(this);
      var rawId = $btn.attr("item-id");
      if (!isValidId(rawId)) return;

      var id = parseInt(rawId, 10);
      var inList = list.indexOf(id) !== -1;

      if (inList) {
        $btn.show();
      } else {
        $btn.hide();
      }
    });

    $(".added-badge").each(function () {
      var $badge = $(this);
      var rawId = $badge.attr("item-id");
      if (!isValidId(rawId)) return;

      var id = parseInt(rawId, 10);
      var inList = list.indexOf(id) !== -1;

      if (inList) {
        $badge.removeClass("hidden").addClass("flex");
      } else {
        $badge.removeClass("flex").addClass("hidden");
      }
    });
  }

  /* ─────────────────────────────────────────────
   * CORE ACTIONS — ADD / REMOVE ITEMS
   * ───────────────────────────────────────────── */

  function addInquiryItem(rawId) {
    if (!isValidId(rawId)) {
      showToast("Invalid item. Please try again.", "error");
      return;
    }

    var id = parseInt(rawId, 10);
    var list = getList();

    if (list.indexOf(id) !== -1) {
      showToast("This item is already in your inquiry list.", "warning");
      return;
    }

    if (list.length >= MAX_ITEMS) {
      showToast(
        "Your list is full (" +
          MAX_ITEMS +
          " items max). Remove an item first.",
        "warning",
      );
      return;
    }

    list.push(id);

    if (!saveList(list)) {
      showToast("Could not save item — list storage limit reached.", "error");
      return;
    }

    //showToast("Item added to your inquiry list!", "success");

    updateCounterUI(list.length);
    refreshButtonStates(list);
  }

  function removeInquiryItem(rawId) {
    if (!isValidId(rawId)) {
      showToast("Invalid item. Please try again.", "error");
      return;
    }

    var id = parseInt(rawId, 10);
    var list = getList();
    var idx = list.indexOf(id);

    if (idx !== -1) {
      list.splice(idx, 1);

      if (!saveList(list)) {
        showToast("Could not update your list. Please try again.", "error");
        return;
      }

      //showToast("Item removed from your inquiry list.", "info");

      updateCounterUI(list.length);
      refreshButtonStates(list);
      if (getList().length === 0) {
        $("#inquiry-pop-up").addClass("hidden").removeClass("flex");
        $("#normal-content").addClass("hidden").removeClass("flex");
        $("#list-content").addClass("hidden").removeClass("flex");

        $(".pop-up").removeClass("hidden").addClass("flex");
        $("#inquiry-empty-pop-up").removeClass("hidden").addClass("flex");
      }
    }
  }
  /* ─────────────────────────────────────────────
   * IS SAFE URL — TEST IF URL IS SAFE
   * ───────────────────────────────────────────── */
  function isSafeUrl(url) {
    if (typeof url !== "string" || url.trim() === "") return false;
    try {
      var parsed = new URL(url, window.location.origin);
      return parsed.protocol === "https:" || parsed.protocol === "http:";
    } catch (e) {
      return false;
    }
  }

  function syncListFormPortfolioTitles() {
    var titles = [];
    $("#inquiry-list-content .inquiry-item-pop-up").each(function () {
      if (!$(this).is(":visible")) return;
      var t = $.trim($(this).find(".inquiry-item-pop-up-title").text());
      if (t) titles.push(t);
    });
    $("#inquiry-list-form")
      .find('input[name="input_12"]')
      .val(titles.join(" | "));
  }

  /* ─────────────────────────────────────────────
   * FETCH INQUIRY LIST — SHOW POP-UP WITH LIST
   * ───────────────────────────────────────────── */
  function fetchInquiryListItems() {
    var list = getList();

    if (list.length === 0) {
      $("#inquiry-empty-pop-up").addClass("hidden").removeClass("flex");
      $("#inquiry-pop-up").addClass("hidden").removeClass("flex");
      $("#normal-content").addClass("hidden").removeClass("flex");
      $("#list-content").addClass("hidden").removeClass("flex");

      $(".pop-up").removeClass("hidden").addClass("flex");
      $("#inquiry-empty-pop-up").removeClass("hidden").addClass("flex");
		    $("body").addClass("menu-open");
    } else {
      var idsString = list.join(",");
      var apiUrl = "/wp-json/mrlgroup/v1/cpt-items?ids=" + idsString;

      $.ajax({
        url: apiUrl,
        method: "GET",
        success: function (data) {
          let listContent = $("#inquiry-list-content");

          listContent.empty();
          $("#inquiry-list-form .inquiry-field input").val("");
          $("#inquiry-list-form").find('input[name="input_12"]').val("");

          $.each(data, function (i, inquiryItem) {
            if (!isValidId(inquiryItem.id)) {
              console.warn(
                "[InquiryList] Skipping item with invalid id:",
                inquiryItem.id,
              );
              return true; 
            }
            var safeId = parseInt(inquiryItem.id, 10);
            let article = $("<article></article>").addClass(
              "inquiry-item-pop-up",
            );
            let div = $("<div></div>").addClass("inquiry-item-pop-up-content");
            let img = $("<img/>").addClass("inquiry-item-pop-up-img");

            if (
              inquiryItem.featured_image &&
              isSafeUrl(inquiryItem.featured_image.url)
            ) {
              img.attr("src", inquiryItem.featured_image.url);
              if (typeof inquiryItem.featured_image.alt === "string") {
                img.attr("alt", inquiryItem.featured_image.alt);
              }
            }

            let p = $("<p></p>").addClass("inquiry-item-pop-up-title");
            $(p).text(inquiryItem.title);
            $(div).append(img);
            $(div).append(p);
            $(article).append(div);

            let span = $("<span></span>").addClass(
              "inquiry-item-pop-up-remove remove-inquiry",
            );
            $(span).attr("item-id", safeId);
            $(span).text("Remove");
            $(article).append(span);

            $(listContent).append(article);

            let line = $("<div></div>").addClass("inquiry-item-pop-up-line");
            $(listContent).append(line);

            let fieldVal = $("#inquiry-list-form .inquiry-field input").val();
            let newVal = fieldVal ? fieldVal + "," + safeId : safeId;
            $("#inquiry-list-form .inquiry-field input").val(newVal);
          });

          $("#inquiry-empty-pop-up").addClass("hidden").removeClass("flex");
          $("#inquiry-pop-up").addClass("hidden").removeClass("flex");
          $("#normal-content").addClass("hidden").removeClass("flex");
          $("#list-content").addClass("hidden").removeClass("flex");

          $(".pop-up").removeClass("hidden").addClass("flex");
          $("#inquiry-pop-up").removeClass("hidden").addClass("flex");
          $("#list-content").removeClass("hidden").addClass("flex");
          syncListFormPortfolioTitles();
			    $("body").addClass("menu-open");
        },
        error: function (xhr, status, error) {
          console.error("Failed to fetch inquiry items:", error);
          showToast("Could not load inquiry list. Please refresh.", "error");
        },
      });
    }
  }

  /* ─────────────────────────────────────────────
   * BOOTSTRAP
   * ───────────────────────────────────────────── */

  $(document).ready(function () {
    var list = getList();
    updateCounterUI(list.length);
    refreshButtonStates(list);

    $(document).on("click", ".add-inquiry", function (e) {
      e.preventDefault();
      e.stopPropagation();

      var $btn = $(this);
      if ($btn.data("processing")) return;
      $btn.data("processing", true);
      setTimeout(function () {
        $btn.data("processing", false);
      }, 400);

      addInquiryItem($btn.attr("item-id"));
    });

    $(document).on("click", ".remove-inquiry", function (e) {
      e.preventDefault();
      e.stopPropagation();

      var $btn = $(this);
      if ($btn.data("processing")) return;
      $btn.data("processing", true);
      setTimeout(function () {
        $btn.data("processing", false);
      }, 400);

      removeInquiryItem($btn.attr("item-id"));

      if ($btn.hasClass("inquiry-item-pop-up-remove")) {
        $btn.closest(".inquiry-item-pop-up").hide();
        $btn
          .closest(".inquiry-item-pop-up")
          .next(".inquiry-item-pop-up-line")
          .hide();
        var idToRemove = $btn.attr("item-id");
        var input = $("#inquiry-list-form .inquiry-field input");

        if ($(input).val()) {
          var currentIds = $(input).val().split(",");
          var updatedIds = currentIds.filter(function (id) {
            return id !== idToRemove;
          });

          $(input).val(updatedIds.join(","));
          syncListFormPortfolioTitles();
        }
      }
    });

    $(document).on("click", "#view-inquery-list", function () {
      fetchInquiryListItems();
    });
    $(document).on("click", ".view-inquery", function (e) {
      e.preventDefault();
      e.stopPropagation();

      var clickedId = parseInt($(this).attr("item-id"), 10);
      var $btn = $("#normal-content").find(".add-inquiry");
      var currentList = getList();

      if (currentList.indexOf(clickedId) !== -1) {
        $btn.hide();
        $btn.siblings().find(".inquiry-tooltip-icon").hide();
      } else {
        $btn.show();
        $btn.siblings().find(".inquiry-tooltip-icon").show();
      }
    });
  });
})(jQuery);
