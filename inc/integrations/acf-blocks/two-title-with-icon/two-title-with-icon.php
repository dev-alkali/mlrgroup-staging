<?php

/**
 * Two Title With Icon Block Template.
 */

$id = 'two-col' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'two-col';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}


?>
<?php if (have_rows('two_column_with_icon')) :  while (have_rows('two_column_with_icon')) : the_row();

$section_remove_top_padding    = get_sub_field('section_remove_top_padding');
$section_remove_bottom_padding = get_sub_field('section_remove_bottom_padding');

$pt_class = '';
if ( ! empty( $section_remove_top_padding ) ) {
    $pt_class = ' ' . 'pt0';
}

$pb_class = '';
if ( ! empty( $section_remove_bottom_padding ) ) {
    $pb_class = ' ' . 'pb0';
}

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

$lists = get_sub_field('icon_list');
$image  = get_sub_field('image');
$has_image = !empty($image);

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
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> two-col-sec px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px] <?php echo $bg_color_class; ?><?php echo $pt_class; ?><?php echo $pb_class; ?>">
      
      <div class="gap-[30px] md:gap-[0px] w-full wrapper flex flex-col <?php echo $has_image ? $mobileFlex . ' ' . $desktopFlex : ''; ?> items-center two-column-wrapper">

        <?php if ($has_image): ?>
        <div class="w-full md:w-1/2 lg:w-[47%] two-column-image">
          <figure class="!m-0 flex"><?php echo wp_get_attachment_image($image, 'full', false, ['class' => 'w-full h-auto']); ?></figure>
        </div>
        <?php endif; ?>

        <div class="w-full <?php echo $has_image ? 'md:w-1/2 lg:w-[53%]' : ''; ?> two-column-content">
          <div class="<?php echo $has_image ? ($layout === 'Right Image' ? 'pl-[0px] md:pr-[30px] lg:pr-[60px]' : 'pr-[0px] md:pl-[30px] lg:pl-[60px]') : ''; ?>">
            <?php if($title_row_1 || $title_row_2): ?>
            <h2 class="text-[clamp(32px,5vw,68px)] leading-[clamp(40px,6vw,76px)] tracking-[-4%] <?php echo $text_262626_class; ?> font-heading mb-[20px] md:mb-[30px]">
              <?php if($title_row_1): ?>
                  <span class="font-bold"><?php echo $title_row_1; ?></span>
              <?php endif; ?>
              <?php if($title_row_2): ?>
                  <span class="font-bold"><?php echo $title_row_2; ?></span>
              <?php endif; ?>
            </h2>
            <?php endif; ?>
            <?php if($description): ?>
              <div class="w-full text-[clamp(16px,3vw,18px)] leading-[28px] <?php echo $text_525252_class; ?> font-body flex flex-col gap-[15px] description-content mb-[20px]"><?php echo $description; ?></div>
            <?php endif; ?>


              <?php if($lists): ?>
              <?php $list_count = count($lists); ?>
              <div class="<?php echo $has_image ? 'flex flex-col gap-[20px]' : 'grid grid-cols-1 md:grid-cols-2 gap-[20px]'; ?>">
                <?php foreach($lists as $list): 
                  $heading = $list['i_title'];
                  $content = $list['i_content'];
                  ?>
                  <div class="flex flex-row gap-[15px] w-full">
                    <div class="flex w-[24px] h-[24px] relative">
                      <img src="<?php echo get_template_directory_uri() ?>/assets/imgs/list-icon.svg" alt="" class="w-full">
                    </div>
                    <div class="flex flex-col flex-1">
                      <?php if($heading): ?>
                        <h3 class="text-[clamp(18px,2.6vw,20px)] leading-[clamp(22px,3.2vw,24px)] tracking-[-2%] text-[#262626] font-heading font-bold mb-[10px]"><?php echo $heading; ?></h3>
                      <?php endif; ?>
                      <?php if($content): ?>
                        <div class="text-[18px] leading-[26px] text-[#525252] font-body tracking-[0px]"><?php echo $content; ?></div>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
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