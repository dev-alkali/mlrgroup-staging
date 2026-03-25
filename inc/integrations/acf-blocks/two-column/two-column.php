<?php

/**
 * Two Column Block Template.
 */

$id = 'two-col' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'two-col';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

$row_index = get_row_index();
?>
<?php if (have_rows('two_column')) :  while (have_rows('two_column')) : the_row();

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$description = get_sub_field('description');
//$left_image_or_right_image = get_sub_field('left_image_or_right_image');
$layout = get_sub_field('left_image_or_right_image'); // left / right
// Desktop layout
$desktopFlex = ($layout === 'Right Image') ? 'md:flex-row-reverse' : 'md:flex-row';

// Mobile: always content first, image bottom
$mobileFlex = 'flex-col-reverse';

$content_width = get_sub_field('content_width');

if ( $content_width ){
  echo '<style>
    .layout-'.$row_index.' .two-col-sec .content-width {
      max-width: ' . $content_width . ';
    }
  </style>';
}

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> two-col-sec px-4 md:px-10 py-[60px] md:py-[120px] layout-<?php echo $row_index; ?>">
      <!-- <div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col md:flex-row items-center flex-wrap"> -->
      <div class="gap-[30px] md:gap-[60px] w-full wrapper flex flex-col <?php echo $mobileFlex . ' ' . $desktopFlex; ?> items-center">

        <div class="w-full flex-1">
          <figure class="!m-0 flex"><?php echo wp_get_attachment_image(get_sub_field('image'), 'full', false, ['class' => 'w-full h-auto']); ?></figure>
        </div>

        <div class="w-full flex-1">
          <div class="">
            <?php if($title_row_1 || $title_row_2): ?>
            <h2 class="text-[clamp(32px,6vw,68px)] leading-[clamp(40px,7vw,76px)] tracking-[-4%] text-[#262626] font-heading mb-[20px]">
              <?php if($title_row_1): ?>
                  <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
              <?php endif; ?>
              <?php if($title_row_2): ?>
                  <span class="font-light text-[#737373]"><?= wp_kses_post($title_row_2) ?></span>
              <?php endif; ?>
            </h2>
            <?php endif; ?>
            <?php if($description): ?>
              <div class="w-full text-[clamp(16px,3vw,18px)] leading-[28px] text-[#525252] font-body flex flex-col gap-[30px] <?php echo $content_width_class; ?>"><?= wp_kses_post($description) ?></div>
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