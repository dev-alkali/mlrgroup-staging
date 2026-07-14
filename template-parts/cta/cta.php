<?php

/**
 * Global CTA Template.
 */
?>
<?php if (have_rows('cta_global', 'option')) : while (have_rows('cta_global', 'option')) : the_row();

$title_row_1 = get_sub_field('cta_title_row1');
$title_row_2 = get_sub_field('cta_title_row2');
$description = get_sub_field('cta_content');
$link = get_sub_field('cta_button');
?>
  
<section id="cta-block_ea44063c95ea7a4325cd10b208f2f7541" class="c-cta flex c-cta w-full bg-black py-12 md:py-17 xl:py-25 px-4 sm:px-10">
  <div class="c-cta__wrap flex flex-col align-center w-full gap-[40px] wrapper mx-auto">
    <div class="c-cta__content max-w-[850px] gap-5 flex flex-col">
      <?php if($title_row_1 || $title_row_2): ?>
      <h2 class="flex flex-col align-start c-cta__title font-heading text-white text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em]">

        <?php if($title_row_1): ?>
            <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
        <?php endif; ?>

        <?php if($title_row_2): ?>
            <span class="font-bold"><?= wp_kses_post($title_row_2) ?></span>
        <?php endif; ?>
      </h2>
      <?php endif; ?>
      <?php if($description): ?>
      <p class="max-w-[685px] w-full text-[18px]  min-[600px]:text-xl leading-[26px] min-[600px]:leading-7 text-gray-50 font-body pb-[10px]"><?= wp_kses_post($description) ?></p>
      <?php endif; ?>
      <?php 
      if( $link ): 
          $link_url = $link['url'];
          $link_title = $link['title'];
          $link_target = $link['target'] ? $link['target'] : '_self';
          ?>
      <div class="c-cta__buttons-wrap flex flex-col gap-[22px] max-w-[277px]"><a class="c-cta__button btn-primary" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
      <?php endif; ?>
    </div>         
  </div>
</section>
<?php endwhile; endif; ?>