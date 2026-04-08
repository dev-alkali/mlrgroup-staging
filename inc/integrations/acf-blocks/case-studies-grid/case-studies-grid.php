<?php

/**
 * Case Studies Grid Block Template.
 */

$id = 'case-studies-grid-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'case-studies-grid';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('case_studies_grid')) :  while (have_rows('case_studies_grid')) : the_row(); ?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>  py-20 md:py-30 px-6 md:px-10 bg-black">    
         
    <div class="flex flex-col gap-5 xl:gap-10 xl:gap-15"> 
        <!-- Heading -->
        <div class="w-full">            
            <h2 class="flex flex-col max-w-[660px] font-heading text-white tracking-[-0.02em] text-[clamp(36px,5vw,68px)] leading-[clamp(44px,6vw,78px)]">
                <span class="font-bold">
                    <?= wp_kses_post(get_sub_field('title_row_1')) ?>
                </span>
                <span class="font-light">
                    <?= wp_kses_post(get_sub_field('title_row_2')) ?>
                </span>
            </h2>
        </div>

        <!-- Case Studies Grid -->
        <div class="w-full flex cs-cards flex-col py-24px md:py-38px xl:py-60px)] <?php echo count(get_sub_field('works_rows')) ?>">
            <?php if (have_rows('works_rows')) : while (have_rows('works_rows')) : the_row(); ?>
                <?php if (have_rows('works_rows')) : while (have_rows('works_rows')) : the_row(); ?>
                
                    <a href="<?php echo esc_url(get_sub_field('item_path')); ?>"
                    class="cs-card w-full"
                    style="
                            background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>');
                            background-position: 50% 50%;
                            background-size: cover;
                            background-repeat: no-repeat;">
                            
                        <div class="gradient-box h-full w-full">
                            
                            <img class="arrow relative w-24px md:w-32px xl:w-40px h-24px md:h-32px xl:h-40px" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow.svg" alt="Arrow">

                            <div class="cs-card__content w-full">
                                <?php if(get_sub_field('logo_image')): ?>
                                    <div class="cs-card__logo">
                                        <img src="<?php echo get_sub_field('logo_image'); ?>" alt="">
                                    </div>
                                <?php endif; ?>
                                <div class="cs-card__text text-white uppercase font-heading font-semibold text-[clamp(16px,1.64vw,24px)] leading-[clamp(22px,2.25vw,32px)] ">                                    
                                    <?= wp_kses_post(get_sub_field('title')) ?>
                                </div>
                            </div>
                        </div>
                        
                    </a>
                <?php endwhile; endif; ?>
            <?php endwhile; endif; ?>
        </div>

        <?php
            $view_more_link = get_sub_field('view_more_link');
            if($view_more_link):
        ?>
        <a class="flex case-studies-grid-link items-center text-[16px] leading-[24px] font-heading font-semibold " href="<?php echo $view_more_link['url']; ?>" target="<?php echo $view_more_link['target']; ?>">
            <span><?php echo $view_more_link['title']; ?></span>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="#FD4338" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.26562 2.47656H13.407V13.9386" stroke-miterlimit="10"/><path d="M13.3351 2.54688L2.33789 13.8605" stroke-miterlimit="10"/> </svg></a>
        <?php endif; ?>
    </div>
     
</section>


<?php endwhile;
endif; ?>


<?php 

    jQuery(function($){

        $('body').on('click', '.cs-card', function(){
            $(this).addClass('is-open').siblings().removeClass('is-open');
        });

        function cscardsMgt() {
            if( $(window).width() < 1199 ) {
         
            }
        }
        
        $(window).on('resize', function(){
            cscardsMgt();
        });

    });

?>