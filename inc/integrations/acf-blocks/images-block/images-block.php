<?php

/**
 * Images Block  Template.
 */

$id = 'images-block' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'images-block';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}


?>
<?php if (have_rows('two_column')) :  while (have_rows('two_column')) : the_row();

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$description = get_sub_field('description');
//$left_image_or_right_image = get_sub_field('left_image_or_right_image');
$layout = get_sub_field('left_image_or_right_image'); // left / right
// Desktop layout
$desktopFlex = ($layout === 'Right Image') ? 'md:flex-row-reverse img-right' : 'md:flex-row img-left';

// Mobile: always content first, image bottom
$mobileFlex = 'flex-col-reverse';

$content_width = get_sub_field('content_width');
$section_color = get_sub_field('section_color');

if ( $content_width ){
  echo '<style>
  @media (min-width: 1025px) {
    .two-col-sec .description-content {
      max-width: ' . $content_width . ';
    }
  }
  </style>';
}

if ( $section_color == 'black' ){
  $bg_color_class = 'bg-black';
  $text_262626_class = 'text-white';
  $text_737373_class = 'text-white';
  $text_525252_class = 'text-white';
  $text_e5e5e5_class = 'text-white';
  $text_white_class = 'text-white';
}else {
  $bg_color_class = 'bg-white';
  $text_262626_class = 'text-[#262626]';
  $text_737373_class = 'text-[#737373]';
  $text_525252_class = 'text-[#525252]';
  $text_e5e5e5_class = 'text-[#E5E5E5]';
  $text_white_class = 'text-white';
}

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> two-col-sec px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px] <?php echo $bg_color_class; ?>">
      <!-- <div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col md:flex-row items-center flex-wrap"> -->
      <div class="gap-[30px] md:gap-[0px] w-full wrapper flex flex-col <?php echo $mobileFlex . ' ' . $desktopFlex; ?> items-center">

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
              $link = get_sub_field('button');
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