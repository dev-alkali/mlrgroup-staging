<?php
/**
 * Single Portfolio Item template.
 *
 * Post type slug: portfolio
 */
get_header();
?>

<main class="overflow-hidden"> 
    <?php while (have_posts()) : the_post(); ?>
    <section class="px-4 md:px-10 pt-[40px] md:pt-[80px] xl:pt-[120px] pb-[60px] lg:pb-[60px]">
        <div class="wrapper">
             <div class="mb-[60px]">
                <div class=" justify-between w-full mb-[20px] border-b border-[#CCCCCC] md:border-0 pb-[20px] md:pb-0 hidden md:flex">
                   <h2 class="inquiry-title text-[clamp(36px,5vw,48px)] leading-[clamp(44px,5.1vw,60px)] tracking-[-2%] font-heading text-neutral-800 font-bold"><?php the_title(); ?></h2>               
                </div>
                <?php
                $portfolio_terms = get_the_terms(get_the_ID(), 'portfolio-category');
                if (!empty($portfolio_terms) && !is_wp_error($portfolio_terms)) : ?>
                <div class="inquiry-categories hidden md:flex">
                  <?php foreach ($portfolio_terms as $term) : ?>
                    <span class="inquiry-category"><?php echo esc_html($term->name); ?></span>
                  <?php endforeach; ?>
                </div>
                <?php endif; ?>
             </div>
             <div class="flex flex-col md:flex-row gap-[40px] md:gap-[60px]">
                <section class="w-full flex flex-col gap-[20px] md:gap-10">
                   <?php if (has_post_thumbnail()) : ?>
                          <?php the_post_thumbnail('full', ['class' => 'inquiry-img w-full max-h-[546px] h-full object-contain object-center']); ?>
                    <?php endif; ?>
                   
                   <div class="mt-4 mb-4 block md:hidden">
                      <div class=" flex justify-between w-full mb-3">
                         <h2 class="inquiry-title text-[clamp(36px,5vw,48px)] leading-[clamp(44px,5.1vw,60px)] tracking-[-2%] font-heading font-bold text-neutral-800 "><?php the_title(); ?></h2>
                         
                      </div>
                      <?php if (!empty($portfolio_terms) && !is_wp_error($portfolio_terms)) : ?>
                      <div class="inquiry-categories">
                        <?php foreach ($portfolio_terms as $term) : ?>
                          <span class="inquiry-category"><?php echo esc_html($term->name); ?></span>
                        <?php endforeach; ?>
                      </div>
                      <?php endif; ?>
                   </div>

                </section>
                <section id="inquiry-normal-form" class="w-full">
                   <?= do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]'); ?>
                   <script>
                   (function($){
                      var postId    = <?php echo (int) get_the_ID(); ?>;
                      var postTitle = <?php echo wp_json_encode( html_entity_decode( get_the_title(), ENT_QUOTES, 'UTF-8' ) ); ?>;
                      var imgUrl    = <?php echo wp_json_encode( get_the_post_thumbnail_url( null, 'full' ) ?: '' ); ?>;

                      function fillSinglePortfolioFields() {
                         var $form = $('#inquiry-normal-form');
                         $form.find('.inquiry-field input').val(postId);
                         $form.find('input[name="input_12"]').val(postTitle);
                         $form.find('input[name="input_13"]').val(imgUrl);
                      }

                      $(document).ready(fillSinglePortfolioFields);
                      $(document).on('gform_post_render', fillSinglePortfolioFields);
                   })(jQuery);
                   </script>
                </section>
             </div>
        </div>
      </section>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
