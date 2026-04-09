<?php

$title_row_1 = get_field('title_row_1', 'options');
$title_row_2 = get_field('title_row_2', 'options');

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> flex c-cta w-full bg-black py-12 md:py-17 xl:py-25 px-6 md:px-12">
  
  <div class="c-cta__wrap flex flex-col items-center w-full gap-[40px] max-w-[1220px]">
    
    <div class="c-cta__content max-w-[850px]">
      <h2 class="flex flex-col items-start c-cta__title font-heading text-white text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em]">
        
        <?php if ($title_row_1): ?>
          <span class="font-bold"><?php echo wp_kses_post($title_row_1); ?></span>
        <?php endif; ?>

        <?php if ($title_row_2): ?>
          <span class="font-light"><?php echo wp_kses_post($title_row_2); ?></span>
        <?php endif; ?>

      </h2>
    </div>

    <?php if (have_rows('cta_items', 'options')): ?>
      <div class="c-cta__buttons-wrap flex flex-col gap-[22px] max-w-[277px]">

        <?php while (have_rows('cta_items', 'options')): the_row(); ?>

          <?php if ($cta_item = get_sub_field('cta_item')): 

            $url = !empty($cta_item['url']) ? $cta_item['url'] : '#';
            $title = !empty($cta_item['title']) ? $cta_item['title'] : '';
            $target = !empty($cta_item['target']) ? $cta_item['target'] : '_self';

            if ($title):
          ?>

            <a class="c-cta__button btn-primary"
               href="<?php echo esc_url($url); ?>"
               target="<?php echo esc_attr($target); ?>">
               <?php echo esc_html($title); ?>
            </a>

          <?php 
            endif;
          endif; ?>

        <?php endwhile; ?>

      </div>
    <?php endif; ?>

  </div>
</section>