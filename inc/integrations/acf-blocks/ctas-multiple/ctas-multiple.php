<?php

/**
 * CTA Multiple Block Template.
 */

$id = 'cta-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'c-cta';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
 

$title_row_1 = get_field('title_row_1');
$title_row_2 = get_field('title_row_2');

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex c-cta w-full bg-black pt-12 md:pt-17 xl:pt-25">
  
  <div class="flex flex-col items-center w-full space-between gap-[40px] c-cta__wrap max-w-[1170px]">
    <h2 class="c-cta__title font-heading text-white text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em]">
      <?php if($title_row_1): ?>
        <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
      <?php endif; ?>
      <?php if($title_row_2): ?>
        <span class="font-light"><?= wp_kses_post($title_row_2) ?></span>
      <?php endif; ?>
    </h2>
    <?php if( have_rows('cta_items') ): ?>
      <div class="flex flex-col gap-[22px] c-cta__buttons-wrap">
        <?php while( have_rows('cta_items') ): the_row(); ?>
          <?php $cta_item = get_sub_field('cta_item'); ?>
            <?php if( $cta_item ): 
                $url = $cta_item['url'];
                $title = $cta_item['title'];
                $target = $cta_item['target'] ? $cta_item['target'] : '_self';
            ?>
              <a class="c-cta__button btn-primary" href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>"><?php echo esc_html($title); ?></a>
            <?php endif; ?>
        <?php endwhile; ?>
      </div>
    <?php endif; ?>
  </div>
</section>