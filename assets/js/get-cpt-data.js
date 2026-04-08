(function ($) {
  "use strict";
  // Decode HTML entities like &#8217; into real characters (handles double-encoded cases).
  function decodeHtmlEntities(value, maxPasses = 3) {
    if (typeof value !== "string") return "";
    let decoded = value;
    for (let i = 0; i < maxPasses; i++) {
      const textarea = document.createElement("textarea");
      textarea.innerHTML = decoded;
      const next = textarea.value;
      if (next === decoded) break;
      decoded = next;
    }
    return decoded;
  }

  $(document).on("click", ".view-inquery", function () {
    const rawId = $(this).attr("item-id");
    const postId = parseInt(rawId, 10);

    if (!postId || postId <= 0 || isNaN(postId)) {
      console.error("Invalid item ID");
      return;
    }
    const endpointUrl = `${GetCptData.rest_url}mrlgroup/v1/cpt-item/${postId}`;

    fetch(endpointUrl, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",

        "X-WP-Nonce": GetCptData.nonce,
      },
    })
      .then((res) => {
        if (!res.ok) throw new Error("Item not find");
        return res.json();
      })
      .then((data) => {
        const normalContent = $("#normal-content");

        const decodedTitle = decodeHtmlEntities(data.title);
        normalContent.find(".inquiry-title").text(decodedTitle);
        let categories = normalContent.find(".inquiry-categories");
        $(categories).empty();
        $.map(data.portfolio_category, function (category, i) {
          let span = $("<span></span>").addClass("inquiry-category");
          $(span).text(category.name);
          $(categories).append(span);
        });
        let featuredImageUrl = "";
        if (data.featured_image && data.featured_image.url) {
          let imgUrl;
          try {
            const parsed = new URL(data.featured_image.url);
            if (parsed.protocol === "https:" || parsed.protocol === "http:") {
              imgUrl = parsed.href;
            }
          } catch (e) {}

          if (imgUrl) {
            normalContent.find(".inquiry-img").attr("src", imgUrl);
            const safeAlt = data.featured_image.alt
              ? String(data.featured_image.alt).replace(/[<>"'&]/g, "")
              : "";
            if (safeAlt) {
              normalContent.find(".inquiry-img").attr("alt", safeAlt);
            }
            featuredImageUrl = imgUrl;
          }
        }

        if (data.content) {
          normalContent.find(".inquiry-content-tooltip").html(data.content);
          normalContent.find(".inquiry-tooltip-icon").parent().removeClass("hidden");
        } else {
          normalContent.find(".inquiry-content-tooltip").empty();
          normalContent.find(".inquiry-tooltip-icon").parent().addClass("hidden");
        }

        normalContent
          .find(".add-inquiry")
          .attr("item-id", parseInt(data.id, 10));
        $("#inquiry-normal-form .inquiry-field input").val(
          parseInt(data.id, 10),
        );
        $("#inquiry-normal-form")
          .find('input[name="input_12"]')
          .val(typeof decodedTitle === "string" ? decodedTitle : "");

        $("#inquiry-normal-form")
          .find('input[name="input_13"]')
          .val(featuredImageUrl);

        $("#inquiry-empty-pop-up").addClass("hidden").removeClass("flex");
        $("#inquiry-pop-up").addClass("hidden").removeClass("flex");
        $("#normal-content").addClass("hidden").removeClass("flex");
        $("#list-content").addClass("hidden").removeClass("flex");

        $(".pop-up").removeClass("hidden").addClass("flex");

        $("#inquiry-pop-up").removeClass("hidden").addClass("flex");

        $("#normal-content").removeClass("hidden").addClass("flex");
		    $("body").addClass("menu-open");
      })
      .catch((error) => console.error(error));
  });

  $(document).on("click", ".pop-up .close, #add-more-to-list", function (e) {
    if (e.target === this) {
      $(".pop-up").addClass("hidden").removeClass("flex");
      $("#inquiry-empty-pop-up").addClass("hidden").removeClass("flex");
      $("#inquiry-pop-up").addClass("hidden").removeClass("flex");
      $("#normal-content").addClass("hidden").removeClass("flex");
      $("#list-content").addClass("hidden").removeClass("flex");
		    $("body").removeClass("menu-open");
    }
  });
})(jQuery);
