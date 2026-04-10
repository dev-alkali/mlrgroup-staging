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
             <div class="mb-[40px]">
                <div class="flex justify-between w-full mb-3 border-b border-[#CCCCCC] md:border-0 pb-[20px] md:pb-0">
                   <h2 class="inquiry-title text-[28px] leading-[36px] tracking-[-2%] font-heading font-bold hidden md:block"><?php the_title(); ?></h2>               
                </div>
                <div class="inquiry-categories hidden md:flex">
                </div>
             </div>
             <div class="flex flex-col md:flex-row gap-[40px] md:gap-[60px]">
                <section class="w-full flex flex-col gap-[20px] md:gap-10">
                   <?php if (has_post_thumbnail()) : ?>
                          <?php the_post_thumbnail('full', ['class' => 'inquiry-img w-full max-h-[546px] h-full object-cover object-center']); ?>
                    <?php endif; ?>
                   
                   <div class="mt-4 mb-4 block md:hidden">
                      <div class=" flex justify-between w-full mb-3">
                         <h2 class="inquiry-title text-[28px] leading-[36px] tracking-[-2%] font-heading font-bold "><?php the_title(); ?></h2>
                         
                      </div>
                      <div class="inquiry-categories">
                      </div>
                   </div>

                </section>
                <section id="inquiry-normal-form" class="w-full">
                   <?= do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]'); ?>
                </section>
             </div>
        </div>
      </section>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
