<?php

/**
 * CTA Multiple Block Template.
 */

 if (have_rows('cta')) : 
 
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex w-full bg-black text-white">
  
  <div class="flex flex-col items-center w-full gap-[40px] c-cta__wrap">
    
    <?php while (have_rows('cta')) : the_row(); 

      $title_row_1 = get_sub_field('title_row_1');
      $title_row_2 = get_sub_field('title_row_2');
      $description = get_sub_field('description'); 
    ?>

      <div class="c-cta__item text-center">

        <h2 class="font-heading">
          <?php if ($title_row_1): ?>
            <span class="font-bold"><?php echo wp_kses_post($title_row_1); ?></span>
          <?php endif; ?>

          <?php if ($title_row_2): ?>
            <span class="font-light"><?php echo wp_kses_post($title_row_2); ?></span>
          <?php endif; ?>
        </h2>

        <?php if ($description): ?>
          <p class="mt-4"><?php echo wp_kses_post($description); ?></p>
        <?php endif; ?>

      </div>

    <?php endwhile; ?>

  </div>

</section>
<?php endif; ?>