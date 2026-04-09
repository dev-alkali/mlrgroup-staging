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

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex c-cta w-full bg-black text-white">
  
  <div class="flex flex-col items-center w-full space-between gap-[40px] c-cta__wrap">
    
    <h2 class="font-heading">
      <?php if($title_row_1): ?>
        <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
      <?php endif; ?>

      <?php if($title_row_2): ?>
        <span class="font-light"><?= wp_kses_post($title_row_2) ?></span>
      <?php endif; ?>
    </h2>


    <?php if( have_rows('cta_items') ): ?>
        <?php while( have_rows('cta_items') ): the_row(); ?>
          <?php $cta_item = get_sub_field('cta_item'); ?>
            <?php if( $cta_item ): 
                $url = $cta_item['url'];
                $title = $cta_item['title'];
                $target = $cta_item['target'] ? $cta_item['target'] : '_self';
            ?>
              <a class="btn-primary" href="<?php echo esc_url($url); ?>" target="<?php echo esc_attr($target); ?>"><?php echo esc_html($title); ?></a>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>



