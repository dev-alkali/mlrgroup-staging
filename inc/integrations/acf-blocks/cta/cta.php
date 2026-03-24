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
?>

    <section id="<?php echo esc_attr($id); ?>"
      class="<?php echo esc_attr($className); ?> flex w-full h-[700px] min-[600px]:h-[855px] "
      style="
    background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>');
    background-position: 50% 38%;
    background-size: cover;
    background-repeat: no-repeat;
  ">
      <div class="flex flex-col items-center w-full h-full justify-end gap-[40px] min-[600px]:gap-[100px] min-[767px]:gap-[162px] pl-4 min-[600px]:pl-10 lg:pl-[140px] pr-4 min-[600px]:pr-10 md:pr-20 lg:pr-[140px] pt-10 pb-[60px] min-[600px]:pb-[100px] [background:linear-gradient(222deg,rgba(0,0,0,0)_4.72%,rgba(0,0,0,1)_79.68%)]">

        <div class="flex flex-col items-start gap-10 min-[600px]:gap-[60px] w-full max-w-[1920px]">
          <div class="flex flex-col items-start gap-5 w-full">
            <?php if($title_row_1 || $title_row_2): ?>
            <h2 class="max-w-[622px] w-full text-[clamp(36px,6vw,80px)] tracking-[-0.02em] leading-[clamp(44px,6.1vw,92px)] text-white font-heading">
              <?php if($title_row_1): ?>
                  <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
              <?php endif; ?>

              <?php if($title_row_2): ?>
                  <span class="font-light"><?= wp_kses_post($title_row_2) ?></span>
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