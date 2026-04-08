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
 
 <?php if (have_rows('case_studies_grid')) : while (have_rows('case_studies_grid')) : the_row(); ?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> py-20 md:py-30 px-6 md:px-10 bg-black">    

    <div class="flex flex-col gap-8 xl:gap-12"> 

        <!-- Heading -->
        <div class="w-full">            
            <h2 class="flex flex-col max-w-[660px] font-heading text-white tracking-tight text-[clamp(36px,5vw,68px)] leading-[clamp(44px,6vw,78px)]">
                <span class="font-bold">
                    <?= wp_kses_post(get_sub_field('title_row_1')) ?>
                </span>
                <span class="font-light">
                    <?= wp_kses_post(get_sub_field('title_row_2')) ?>
                </span>
            </h2>
        </div>

        <!-- Grid -->
        <div class="flex flex-col gap-10 md:gap-8 cs-cards">

            <?php 
            $posts = get_sub_field('case_studies'); 

            if ($posts) :
                foreach ($posts as $post) :
                    setup_postdata($post);

                    $image_url = get_the_post_thumbnail_url($post->ID, 'full');
                    $cs_logo = get_field('cs_logo', $post->ID);
                    $custom_card_title = get_field('custom_card_title', $post->ID);
            ?>

            <a href="<?php the_permalink($post->ID); ?>"
               class="relative flex items-end px-6 py-8 bg-cover bg-center"
               style="background-image:url('<?php echo esc_url($image_url); ?>')">

                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>

                <!-- Content -->
                <div class="relative z-10 w-full">
                     <img class="arrow relative w-24px md:w-32px xl:w-40px h-24px md:h-32px xl:h-40px" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow.svg" alt="Arrow">

                    <?php if ($cs_logo): ?>
                        <div class="cs-card__logo default-logo">
                            <img src="<?php echo esc_url($cs_logo['url']); ?>" 
                                 alt="<?php echo esc_attr($cs_logo['alt']); ?>" 
                                 class="max-h-10">
                        </div>
                    <?php endif; ?>


                    <?php if ($cs_logo): ?>
                        <div class="cs-card__logo mb-4 md:mb-5 hover-logo">
                            <img src="<?php echo esc_url($cs_logo['url']); ?>" 
                                 alt="<?php echo esc_attr($cs_logo['alt']); ?>" 
                                 class="max-h-10">
                        </div>
                    <?php endif; ?>
                    <h3 class="cs-card__text text-white uppercase font-heading font-semibold text-[clamp(16px,1.64vw,24px)] leading-[clamp(22px,2.25vw,32px)] text-white uppercase font-heading font-semibold text-lg md:text-xl">
                        <?php echo $custom_card_title ?: get_the_title($post->ID); ?>
                    </h3>
                </div>
            </a>

            <?php endforeach; wp_reset_postdata(); endif; ?>

        </div>

        <!-- View More -->
        <?php 
        $view_more_link = get_sub_field('view_more_link');
        if ($view_more_link): ?>
            <a class="inline-flex items-center gap-2 text-white font-semibold"
               href="<?php echo esc_url($view_more_link['url']); ?>"
               target="<?php echo esc_attr($view_more_link['target']); ?>">
                <span><?php echo esc_html($view_more_link['title']); ?></span>
                <svg width="115" height="24" viewBox="0 0 115 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.136 6.832L7.04 18H4.32L0.224 6.832H2.624L5.696 15.712L8.752 6.832H11.136ZM14.719 6.832V18H12.479V6.832H14.719ZM19.1721 8.64V11.44H22.9321V13.216H19.1721V16.176H23.4121V18H16.9321V6.816H23.4121V8.64H19.1721ZM40.3758 6.832L37.2558 18H34.6158L32.5198 10.048L30.3278 18L27.7038 18.016L24.6958 6.832H27.0958L29.0638 15.504L31.3358 6.832H33.8318L35.9758 15.456L37.9598 6.832H40.3758ZM57.8269 6.832V18H55.5869V10.736L52.5949 18H50.8989L47.8909 10.736V18H45.6509V6.832H48.1949L51.7469 15.136L55.2989 6.832H57.8269ZM65.2255 18.112C64.1802 18.112 63.2202 17.8667 62.3455 17.376C61.4708 16.8853 60.7775 16.208 60.2655 15.344C59.7535 14.4693 59.4975 13.4827 59.4975 12.384C59.4975 11.296 59.7535 10.32 60.2655 9.456C60.7775 8.58133 61.4708 7.89867 62.3455 7.408C63.2202 6.91733 64.1802 6.672 65.2255 6.672C66.2815 6.672 67.2415 6.91733 68.1055 7.408C68.9802 7.89867 69.6682 8.58133 70.1695 9.456C70.6815 10.32 70.9375 11.296 70.9375 12.384C70.9375 13.4827 70.6815 14.4693 70.1695 15.344C69.6682 16.208 68.9802 16.8853 68.1055 17.376C67.2308 17.8667 66.2708 18.112 65.2255 18.112ZM65.2255 16.112C65.8975 16.112 66.4895 15.9627 67.0015 15.664C67.5135 15.3547 67.9135 14.9173 68.2015 14.352C68.4895 13.7867 68.6335 13.1307 68.6335 12.384C68.6335 11.6373 68.4895 10.9867 68.2015 10.432C67.9135 9.86667 67.5135 9.43467 67.0015 9.136C66.4895 8.83733 65.8975 8.688 65.2255 8.688C64.5535 8.688 63.9562 8.83733 63.4335 9.136C62.9215 9.43467 62.5215 9.86667 62.2335 10.432C61.9455 10.9867 61.8015 11.6373 61.8015 12.384C61.8015 13.1307 61.9455 13.7867 62.2335 14.352C62.5215 14.9173 62.9215 15.3547 63.4335 15.664C63.9562 15.9627 64.5535 16.112 65.2255 16.112ZM78.364 18L75.9 13.648H74.844V18H72.604V6.832H76.796C77.66 6.832 78.396 6.98667 79.004 7.296C79.612 7.59467 80.0653 8.00533 80.364 8.528C80.6733 9.04 80.828 9.616 80.828 10.256C80.828 10.992 80.6147 11.6587 80.188 12.256C79.7613 12.8427 79.1267 13.248 78.284 13.472L80.956 18H78.364ZM74.844 11.968H76.716C77.324 11.968 77.7773 11.824 78.076 11.536C78.3747 11.2373 78.524 10.8267 78.524 10.304C78.524 9.792 78.3747 9.39733 78.076 9.12C77.7773 8.832 77.324 8.688 76.716 8.688H74.844V11.968ZM85.094 8.64V11.44H88.854V13.216H85.094V16.176H89.334V18H82.854V6.816H89.334V8.64H85.094Z" fill="#FD4338"/>
                <path d="M101.266 6.47656H112.407V17.9386" stroke="#FD4338" stroke-miterlimit="10"/>
                <path d="M112.335 6.54688L101.338 17.8605" stroke="#FD4338" stroke-miterlimit="10"/>
                </svg>

            </a>
        <?php endif; ?>

    </div>

</section>

<?php endwhile; endif; ?>