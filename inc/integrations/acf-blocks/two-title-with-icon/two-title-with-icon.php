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
<?php if (have_rows('two_title_with_icon')) :  while (have_rows('two_title_with_icon')) : the_row();

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



// Mobile: always content first, image bottom
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
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> two-col-sec px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px] <?php echo $bg_color_class; ?><?php echo $pt_class; ?><?php echo $pb_class; ?>">
      
      <div class="gap-[30px] md:gap-[0px] w-full wrapper flex flex-col md:flex-row two-column-wrapper">

        <!-- Left -->
        <?php if( have_rows('left_column') ): ?>
        <?php while( have_rows('left_column') ): the_row(); 

          $left_title_row_1 = get_sub_field('left_title_row_1');
          $left_title_row_2 = get_sub_field('left_title_row_2');
          $left_content = get_sub_field('left_content');
          $left_lists = get_sub_field('left_icon_list');

        ?>
        <div class="w-full md:w-1/2 two-column-content">
          <div class="">
            <?php if($left_title_row_1 || $left_title_row_2): ?>
            <h2 class="text-[clamp(26px,5vw,50px)] leading-[clamp(34px,6vw,60px)] tracking-[-4%] <?php echo $text_262626_class; ?> font-heading mb-[20px] md:mb-[30px]">
              <?php if($left_title_row_1): ?>
                  <span class="font-bold"><?php echo $left_title_row_1; ?></span>
              <?php endif; ?>
              <?php if($left_title_row_2): ?>
                  <span class="font-bold"><?php echo $left_title_row_2; ?></span>
              <?php endif; ?>
            </h2>
            <?php endif; ?>

            <?php if($left_content): ?>
              <div class="w-full text-[clamp(16px,3vw,18px)] leading-[28px] <?php echo $text_525252_class; ?> font-body flex flex-col gap-[15px] description-content mb-[20px]"><p><?php echo $left_content; ?></p></div>
            <?php endif; ?>

              <?php if($left_lists): ?>
              <div class="flex flex-col gap-[20px]">
                <?php foreach($left_lists as $left_list): 
                  $heading = $left_list['i_title'];
                  $content = $left_list['i_content'];
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
          </div>
        </div>
        <?php endwhile; ?>
        <?php endif; ?>


        <!-- Right -->
        <?php if( have_rows('right_column') ): ?>
        <?php while( have_rows('right_column') ): the_row(); 

          $right_title_row_1 = get_sub_field('right_title_row_1');
          $right_title_row_2 = get_sub_field('right_title_row_2');
          $right_lists = get_sub_field('right_icon_list');
          $right_content = get_sub_field('right_content');

        ?>
         <div class="w-full md:w-1/2 two-column-content">
          <div class="">
            <?php if($right_title_row_1 || $right_title_row_2): ?>
            <h2 class="text-[clamp(26px,5vw,50px)] leading-[clamp(34px,6vw,60px)] tracking-[-4%] <?php echo $text_262626_class; ?> font-heading mb-[20px] md:mb-[30px]">
              <?php if($right_title_row_1): ?>
                  <span class="font-bold"><?php echo $right_title_row_1; ?></span>
              <?php endif; ?>
              <?php if($right_title_row_2): ?>
                  <span class="font-bold"><?php echo $right_title_row_2; ?></span>
              <?php endif; ?>
            </h2>
            <?php endif; ?>

            <?php if($right_content): ?>
              <div class="w-full text-[clamp(16px,3vw,18px)] leading-[28px] <?php echo $text_525252_class; ?> font-body flex flex-col gap-[15px] description-content mb-[20px]"><?php echo $right_content; ?></div>
            <?php endif; ?>

              <?php if($right_lists): ?>
              <div class="flex flex-col gap-[20px]">
                <?php foreach($right_lists as $right_list): 
                  $heading2 = $right_list['i_title'];
                  $content2 = $right_list['i_content'];
                  ?>
                  <div class="flex flex-row gap-[15px] w-full">
                    <div class="flex w-[24px] h-[24px] relative">
                      <img src="<?php echo get_template_directory_uri() ?>/assets/imgs/list-icon.svg" alt="" class="w-full">
                    </div>
                    <div class="flex flex-col flex-1">
                      <?php if($heading2): ?>
                        <h3 class="text-[clamp(18px,2.6vw,20px)] leading-[clamp(22px,3.2vw,24px)] tracking-[-2%] text-[#262626] font-heading font-bold mb-[10px]"><?php echo $heading2; ?></h3>
                      <?php endif; ?>
                      <?php if($content2): ?>
                        <div class="text-[18px] leading-[26px] text-[#525252] font-body tracking-[0px]"><?php echo $content2; ?></div>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <?php endwhile; ?>
<?php endif; ?>


      </div>
    </section>
<?php endwhile;
endif; ?>