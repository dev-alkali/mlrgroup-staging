<?php

/**
 * CTA Block Template.
 */

$id = 'cta-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'cta';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('cta')) :  while (have_rows('cta')) : the_row(); 

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$description = get_sub_field('description');

$section_remove_top_padding    = get_sub_field('section_remove_top_padding');
$section_remove_bottom_padding = get_sub_field('section_remove_bottom_padding');

$pt_class = '';
if ( ! empty( $section_remove_top_padding ) ) {
    $pt_class = ' ' . 'pt0';
}

$pb_class = '';
if ( ! empty( $section_remove_bottom_padding ) ) {
    $pb_class = ' ' . 'pb0';
}
?>

    <section id="<?php echo esc_attr($id); ?>"
      class="<?php echo esc_attr($className); ?> flex w-full h-[700px] min-[600px]:h-[855px]<?php echo $pt_class; ?><?php echo $pb_class; ?> "
      style="
    background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>');
    background-position: 50% 38%;
    background-size: cover;
    background-repeat: no-repeat;
  ">
      <div class="flex flex-col items-center w-full h-full justify-end gap-[40px] min-[600px]:gap-[100px] min-[767px]:gap-[162px] pl-4 min-[600px]:pl-10 lg:pl-[140px] pr-4 min-[600px]:pr-10 lg:pr-[140px] pt-10 pb-[60px] min-[600px]:pb-[100px] [background:linear-gradient(222deg,rgba(0,0,0,0)_4.72%,rgba(0,0,0,1)_79.68%)] cta-wrapper">

        <div class="flex flex-col items-start gap-10 min-[600px]:gap-[50px] w-full wrapper cta-content">
          <div class="flex flex-col items-start gap-5 w-full">
            <?php if($title_row_1 || $title_row_2): ?>
            <h2 class="max-w-[622px] w-full xl:text-[80px] xl:leading-[92px] md:text-[68px] md:leading-[78px] sm:text-[45px] sm:leading-[56px] text-[36px] leading-[44px] tracking-[-0.02em] text-white font-heading">
              <?php if($title_row_1): ?>
                  <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
              <?php endif; ?>

              <?php if($title_row_2): ?>
                  <span class="font-bold"><?= wp_kses_post($title_row_2) ?></span>
              <?php endif; ?>
            </h2>
            <?php endif; ?>
            <?php if($description): ?>
              <p class="max-w-[622px] w-full text-[18px]  min-[600px]:text-xl leading-[26px] min-[600px]:leading-7 text-gray-50 font-body"><?= wp_kses_post($description) ?></p>
            <?php endif; ?>
          </div>
          
          <?php if(get_sub_field('btn_label')): ?>
            <a href=" <?= wp_kses_post(get_sub_field('btn_path')) ?>" class="btn-primary"> <?= wp_kses_post(get_sub_field('btn_label')) ?></a>
          <?php endif; ?>
        </div>
      </div>

    </section>
<?php endwhile;
endif; ?>