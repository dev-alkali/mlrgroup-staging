<?php

/**
 * Two Column Block Template.
 */

$id = 'inner-hero-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'inner-hero';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>
<?php if (have_rows('two_column')) :  while (have_rows('two_column')) : the_row();

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$description = get_sub_field('description');

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> w-full px-4 min-[600px]:px-10 pt-[118px] pb-[120px]">
      <div class="gap-[60px] w-full max-w-[1920px] mx-auto flex flex-col min-[767px]:flex-row items-center flex-wrap">
        <div class="w-full flex-1">
          <figure><?php echo wp_get_attachment_image(get_sub_field('image'), 'full', false, ['class' => 'w-full h-auto']); ?></figure>
        </div>
        <div class="w-full flex-1">
          <div class="max-w-[600px]">
            <?php if($title_row_1 || $title_row_2): ?>
            <h2 class="text-[clamp(32px,6vw,68px)] leading-[clamp(40px,7vw,76px)] tracking-[-4%] text-[#262626] font-heading mb-[20px]">
              <?php if($title_row_1): ?>
                  <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
              <?php endif; ?>
              <?php if($title_row_2): ?>
                  <span class="font-light"><?= wp_kses_post($title_row_2) ?></span>
              <?php endif; ?>
            </h2>
            <?php endif; ?>
            <?php if($description): ?>
              <div class="w-full text-[clamp(16px,3vw,18px)] leading-[28px] text-[#525252] font-body flex flex-col gap-[30px]"><?= wp_kses_post($description) ?></div>
            <?php endif; ?>

            <?php 
              $link = get_sub_field('button');
              if( $link ): 
                  $link_url = $link['url'];
                  $link_title = $link['title'];
                  $link_target = $link['target'] ? $link['target'] : '_self';
                  ?>
                  <a class="btn-primary" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
              <?php endif; ?>
          </div>
        </div>

      </div>
    </section>
<?php endwhile;
endif; ?>