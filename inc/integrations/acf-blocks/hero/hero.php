<?php
/**
 * Hero Block Template.
 */

$id = 'hero-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'hero';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>

<?php if (have_rows('hero')) : while (have_rows('hero')) : the_row(); ?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> c-hero flex flex-col w-full items-center p-0 lg:pt-5 lg:pb-0 lg:px-5 bg-white h-screen">

  <?php if (have_rows('main')) : while (have_rows('main')) : the_row();

    $bg_image = get_sub_field('bg_image');
    $subtitle = get_sub_field('subtitle');
    $btn_path  = get_sub_field('btn_path');
    $btn_label = get_sub_field('btn_label');

  ?>

    <div class="max-w-[1920px] flex-1 w-full"
      <?php if (!empty($bg_image)) : ?>
        style="background-image:url('<?php echo esc_url($bg_image); ?>'); background-position:50% 20%; background-size:cover; background-repeat:no-repeat;"
      <?php endif; ?>
    >
      <div class="w-full h-full flex flex-col items-start gap-[162px] px-4 min-[600px]:px-10 min-[767px]:px-20 relative [background:linear-gradient(0deg,rgba(0,0,0,0.35)_0%,rgba(0,0,0,0.35)_100%)]">
        <div class="flex flex-col items-start justify-end pt-8 pb-20 md:pb-16 flex-1 w-full">
          <div class="flex flex-col items-start justify-center gap-10 w-full">
            <div class="flex flex-col items-start justify-center gap-5 w-full">
              <?php if (have_rows('title_group')) : while (have_rows('title_group')) : the_row();
                $title_row_2 = get_sub_field('title_row_2');
                $has_titles_row1 = have_rows('titles_row_1_change'); // store result
              ?>
                <?php if ($has_titles_row1 || !empty($title_row_2)) : ?>
                  <h1 class="c-hero__title rotating-anim max-w-[936px] font-bold text-[44px] md:text-[64px] min-[767px]:text-[70px] min-[1200px]:text-[90px] text-white font-heading anim" data-delay="0.1" data-anim="up">
                    <?php if ($has_titles_row1) : ?>
                      <span class="flex items-center">
                        <?php
                        $is_first = true;
                        while (have_rows('titles_row_1_change')) : the_row();
                          $title = get_sub_field('title');
                          if (!empty($title)) :
                        ?>
                            <span class="rotate-text title" style="display: <?php echo $is_first ? 'inline-block' : 'none'; ?>;">
                              <?php echo esc_html($title); ?>
                            </span>
                        <?php
                            $is_first = false;
                          endif;
                        endwhile;
                        ?>
                      </span>
                    <?php endif; ?>

                    <?php if (!empty($title_row_2)) : ?>
                      <span>
                        <?php echo esc_html($title_row_2); ?><span class="text-accent">.</span>
                      </span>
                    <?php endif; ?>
                  </h1>
                <?php endif; ?>
              <?php endwhile; endif; ?>

              <?php if (!empty($subtitle)) : ?>
                <p class="c-hero__subtitle max-w-[800px] text-[18px] md:text-xl text-gray-50 anim" data-delay="1.2" data-anim="up" data-start="top 100%">
                  <?php echo wp_kses_post($subtitle); ?>
                </p>
              <?php endif; ?>

            </div>

            <?php if (!empty($btn_path) && !empty($btn_label)) : ?>
              <a href="<?php echo esc_url($btn_path); ?>" class="c-hero__button btn-primary anim" data-delay="2" data-anim="up" data-start="top 100%">
                <?php echo esc_html($btn_label); ?>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endwhile; endif; ?>
</section>


<?php if (have_rows('brands')) : while (have_rows('brands')) : the_row(); ?>

  <?php 
    $brand_title = get_sub_field('title');
    $images = get_sub_field('images_brands');
  ?>

  <section class="c-brands flex items-center gap-2 px-4 py-6 lg:pl-[58px]">
    <div class="wrapper flex flex-col min-[890px]:flex-row items-center gap-6 w-full">

      <?php if (!empty($brand_title)) : ?>
        <div class="flex items-center gap-2">
          <img class="w-4 md:w-5" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/Arrow-blue-brands.svg" alt="arrow">
          <p class="c-brands__desc text-[16px] md:text-2xl text-black font-heading">
            <?php echo esc_html($brand_title); ?>
          </p>
        </div>
      <?php endif; ?>

      <?php if (!empty($images)) : ?>
        <div class="flex-1 overflow-hidden relative">
          <div class="marquee-wrapper overflow-hidden w-full">
            <div class="marquee-track">

              <?php for ($i = 0; $i < 2; $i++) : ?>
                <div class="marquee-group" <?php if ($i === 1) echo 'aria-hidden="true"'; ?>>

                  <?php foreach ($images as $row): 
                    $img = $row['image'];
                    if (!empty($img)) :
                  ?>
                    <img class="c-brands__logo h-[91px] w-auto" src="<?php echo esc_url($img); ?>" alt="Brand logo" />
                  <?php endif; endforeach; ?>

                </div>
              <?php endfor; ?>

            </div>
          </div>
        </div>
      <?php endif; ?>

    </div>
  </section>

<?php endwhile; endif; ?>
   

 

<?php endwhile; endif; ?>

