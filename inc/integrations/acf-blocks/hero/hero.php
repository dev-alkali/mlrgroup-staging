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

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> c-hero flex flex-col w-full items-center p-0 lg:pt-5 lg:pb-0 lg:px-5 bg-white h-[calc(100vh-185px)]">

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
            <div class="flex flex-col items-start justify-center gap-[10px] w-full">
              <?php if (have_rows('title_group')) : while (have_rows('title_group')) : the_row();
                $title_row_2 = get_sub_field('title_row_2');
                $has_titles_row1 = have_rows('titles_row_1_change'); // store result
              ?>
                <?php if ($has_titles_row1 || !empty($title_row_2)) : ?>
                  <h1 class="c-hero__title rotating-anim max-w-[936px] text-white font-heading font-bold tracking-[-0.02em] text-[clamp(44px,6vw,90px)] leading-[clamp(56px,7vw,106px)] anim" data-delay="0.1" data-anim="up">
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

  <section class="c-brands py-[40px]">
    <div class="wrapper flex flex-col lg:flex-row items-center gap-[20px] lg:gap-[105px] w-full ">

      <?php if (!empty($brand_title)) : ?>
        <div class="flex items-center gap-2 lg:pl-[75px]">
          <img class="w-4 md:w-5" src="<?php echo get_template_directory_uri(); ?>/assets/imgs/Arrow-blue-brands.svg" alt="arrow">
          <p class="c-brands__desc font-heading text-[#404040] font-medium text-[clamp(16px,2.2vw,24px)] leading-[clamp(24px,2.8vw,32px)] tracking-[clamp(0em,-0.2vw,-0.02em)]">            
            <?php echo esc_html($brand_title); ?>
          </p>
        </div>
      <?php endif; ?>

      <?php if (!empty($images)) : ?>
        <div class="flex-1 overflow-hidden  relative h-[91.15px] md:h-auto">
          <div class="absolute -top-4 left-[-7%] w-[133px] max-[890px]:hidden h-[139px] bg-white z-20 blur-[16px]"></div>
          <div class="absolute -top-4 right-[-5%] w-[133px] h-[139px] max-[890px]:hidden bg-white z-20  blur-[16px]"></div>

          <div class="marquee-wrapper overflow-hidden w-full max-w-full ">
            <div class="marquee-track relative">
              <div class="marquee-group">
                <?php if (have_rows('images_brands')) : while (have_rows('images_brands')) : the_row(); ?>
                    <img class="h-[91.15px] gray-icon w-auto max-w-none block" src="<?= esc_url(get_sub_field('image')) ?>" alt="Brand logos" />
                <?php endwhile;
                endif; ?>
              </div>

              <div class="marquee-group" aria-hidden="true">
                <?php if (have_rows('images_brands')) : while (have_rows('images_brands')) : the_row(); ?>
                    <img class="h-[91.15px] gray-icon w-auto max-w-none block" src="<?= esc_url(get_sub_field('image')) ?>" alt="Brand logos" />
                <?php endwhile;
                endif; ?>
              </div>
            </div>
          </div>
            <svg style="width:0; height:0; position:absolute;" aria-hidden="true" focusable="false"><filter id="gray-color"><feColorMatrix type="matrix" values="0 0 0 0 0.5 0 0 0 0 0.5 0 0 0 0 0.5 0 0 0 1 0" /></filter></svg>       
        </div>
      <?php endif; ?>
    </div>
  </section>
<?php endwhile; endif; ?>

<?php endwhile; endif; ?>