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
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">

            <?php 
            $posts = get_sub_field('case_studies'); 

            if ($posts) :
                foreach ($posts as $post) :
                    setup_postdata($post);

                    $image_url = get_the_post_thumbnail_url($post->ID, 'full');
                    $cs_logo = get_field('cs_logo', $post->ID);
                    $custom_card_title = get_field('custom_card_title', $post->ID);
            ?>

            <a href="<?php the_permalink(); ?>"
               class="relative group h-[420px] flex items-end p-6 bg-cover bg-center transition-all duration-300 hover:scale-[1.02]"
               style="background-image:url('<?php echo esc_url($image_url); ?>')">

                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>

                <!-- Content -->
                <div class="relative z-10 w-full">

                    <?php if ($cs_logo): ?>
                        <div class="mb-4">
                            <img src="<?php echo esc_url($cs_logo['url']); ?>" 
                                 alt="<?php echo esc_attr($cs_logo['alt']); ?>" 
                                 class="max-h-10">
                        </div>
                    <?php endif; ?>

                    <h3 class="text-white uppercase font-heading font-semibold text-lg md:text-xl">
                        <?php echo $custom_card_title ?: get_the_title(); ?>
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
            </a>
        <?php endif; ?>

    </div>

</section>

<?php endwhile; endif; ?>