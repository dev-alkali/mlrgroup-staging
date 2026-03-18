(function ($) {
   'use strict';

   if (typeof PortfolioConfig === 'undefined') {
       console.error('PortfolioConfig is not defined. Check wp_localize_script.');
       return;
   }

   $(document).on('click', '#load-more-portfolio', function (e) {
     
      
       e.preventDefault();

       var button  = $(this);
       var termId  = parseInt(button.attr('data-term'), 10) || 0;
       var paged   = parseInt(button.data('paged'), 10) || PortfolioConfig.init_page;

       button.css({ opacity: '0.5', pointerEvents: 'none' });

       $.ajax({
           url:      PortfolioConfig.ajax_url,
           type:     'POST',
           dataType: 'json',        
           data: {
               action:   'load_more_portfolio',
               term_id:  termId,
               paged:    paged,     
               security: PortfolioConfig.nonce
           },
           success: function (response) {
            console.log(response);
               if (response.success && response.data.html) {
                   $('#portfolio-grid').append(response.data.html);

                   if (response.data.has_more) {

                       button.data('paged', paged + 1);
                       button.css({ opacity: '1', pointerEvents: 'auto' });
                   } else {

                       button.remove();
                   }
               } else {

                   button.remove();
               }
           },
           error: function (xhr, status, error) {
               console.error('AJAX Error:', status, error);
               button.css({ opacity: '1', pointerEvents: 'auto' });
               alert('An error occurred while loading more items. Please try again.');
           }
       });
   });

})(jQuery);