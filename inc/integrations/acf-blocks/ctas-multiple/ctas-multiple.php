<?php

/**
 * CTA Block Template.
 */

$id = 'cta-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'c-cta';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('cta')) :  while (have_rows('cta')) : the_row(); 

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$description = get_sub_field('description'); 
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


      </div>
    
    </section>
<?php endwhile;
endif; ?>