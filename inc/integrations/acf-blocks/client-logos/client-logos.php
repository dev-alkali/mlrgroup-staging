<?php

/**
 * Client Logos Block Template.
 */

$id = 'client-logos-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'client-logos';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('client-logos')) :  while (have_rows('client-logos')) : the_row(); ?>

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex justify-center">
      <div class="flex flex-col w-full items-start gap-8 min-[600px]:gap-[60px] max-w-[1920px]">
        
      </div>
    </section>
<?php endwhile;
endif; ?>