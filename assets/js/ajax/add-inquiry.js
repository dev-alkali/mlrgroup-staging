(function ($) {
   $(".tab-button").on("click", function () {
      //  console.log($(this).attr("value"));
  
      jQuery.ajax({
        url: changeRecurringAjax.ajaxurl,
        type: "POST",
        data: {
          action: "change_recurring_items",
          category: $(this).attr("value"),
          nonce: changeRecurringAjax.nonce,
        },
        success: function (response) {
          console.log(response);
          
           if (!response || !response.success) {
              console.log("Server returned error:", response);
              return;
            }
    
            const html = response.data && response.data.html ? response.data.html : "";
            $('#subscriptionsList').html(html);
  
             let activatedBtn = $(".tab-button.active");
             let nextBtn = $(`.tab-button[value='${response.data.category}']`);
             activatedBtn.removeClass('active');
             nextBtn.addClass('active');
             const raw = response?.data?.total ?? 0;
  
             // normaliza string pt-BR / en-US -> Number
             const num = typeof raw === "number"
               ? raw
               : Number(String(raw).replace(/\./g, "").replace(",", "."));
             
             const total = num.toLocaleString("pt-BR", {
               minimumFractionDigits: 2,
               maximumFractionDigits: 2,
             });
             
             $(".recurring-inpact .test-value").text(total);
             $(".recurring-count").text(response.data.count);
        },
        error: function (xhr, status, error) {
          console.log("AJAX Error:", xhr, status, error);
        },
      });
    });

})(jQuery);