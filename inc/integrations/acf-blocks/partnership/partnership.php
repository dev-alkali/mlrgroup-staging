<?php

/**
 * Partnership Block Template.
 */

$id = 'partnership' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'partnership';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>
<?php if (have_rows('partnership')) :  while (have_rows('partnership')) : the_row();

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$description = get_sub_field('description');

//$left_image_or_right_image = get_sub_field('left_image_or_right_image');
//$layout = get_sub_field('left_image_or_right_image'); // left / right
// Desktop layout
//$desktopFlex = ($layout === 'Right Image') ? 'md:flex-row-reverse' : 'md:flex-row';

// Mobile: always content first, image bottom
//$mobileFlex = 'flex-col-reverse';

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> two-col-sec px-4 md:px-10 py-[60px] md:py-[120px]">
      <div class="wrapper">
        <div class="top-title-sec">
          <div class="left-title">
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
          </div>
          <?php if($description): ?>
            <div class=""><p class="font-body font-normal text-[18px] leading-[26px] tracking-[0em] text-[#525252]"><?= wp_kses_post($description) ?></p></div>
          <?php endif; ?>
        </div>

        <div class="partnership-list">
          <div class="">
            <h3 class="font-[poppins] font-bold text-[clamp(28px,4vw,40px)] leading-[clamp(36px,5vw,48px)] tracking-[-0.02em] text-[#262626]"><?php echo $i?></h3>
            <h4 class="font-[Poppins] font-medium text-[24px] leading-[32px] tracking-[-0.02em] md:text-[28px] md:leading-[36px] text-[#262626]"><?php echo get_sub_field();?></h4>
            <p><?php echo get_sub_field();?></p>

          </div>
        </div>


      </div> 
    </section>
<?php endwhile;
endif; ?>