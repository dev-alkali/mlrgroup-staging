<?php

/**
 * Lookbooks List Block Template.
 */

$id = 'lookbooks-list' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'lookbooks-list';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}


?>
<?php if (have_rows('lookbooks-list')) :  while (have_rows('lookbooks-list')) : the_row();

$session = get_sub_field('session');
$title = get_sub_field('title');
$image = get_sub_field('image');

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> two-col-sec px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px]">
      <div class="gap-[30px] md:gap-[0px] w-full wrapper flex flex-col  items-center">
        
        <div class="w-full md:w-1/2 lg:w-[47%]">
          <figure class="!m-0 flex"><?php echo wp_get_attachment_image(get_sub_field('image'), 'full', false, ['class' => 'w-full h-auto']); ?></figure>
        </div>

        <div class="w-full md:w-1/2 lg:w-[53%]">
          <div class="lg:px-[60px] <?php echo $layout === 'Right Image' ? 'pl-[0px] md:pr-[30px]' : 'pr-[0px] md:pl-[30px]'; ?>">
            <?php if($title_row_1 || $title_row_2): ?>
            <h2 class="text-[clamp(32px,6vw,68px)] leading-[clamp(40px,7vw,76px)] tracking-[-4%] <?php echo $text_262626_class; ?> font-heading mb-[20px]">
              <?php if($title_row_1): ?>
                  <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
              <?php endif; ?>
              <?php if($title_row_2): ?>
                  <span class="font-light <?php echo $text_737373_class; ?>"><?= wp_kses_post($title_row_2) ?></span>
              <?php endif; ?>
            </h2>
            <?php endif; ?>
            <?php if($description): ?>
              <div class="w-full text-[clamp(16px,3vw,18px)] leading-[28px] <?php echo $text_525252_class; ?> font-body flex flex-col gap-[30px] description-content "><?= wp_kses_post($description) ?></div>
            <?php endif; ?>

            <?php 
              $link = get_sub_field('link');
              if( $link ): 
                  $link_url = $link['url'];
                  $link_title = $link['title'];
                  $link_target = $link['target'] ? $link['target'] : '_self';
                  ?>
                  <a class="btn-primary mt-[40px]" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
              <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
<?php endwhile;
endif; ?>


