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
$background_color = get_sub_field('background_color');

//$left_image_or_right_image = get_sub_field('left_image_or_right_image');
//$layout = get_sub_field('left_image_or_right_image'); // left / right
// Desktop layout
//$desktopFlex = ($layout === 'Right Image') ? 'md:flex-row-reverse' : 'md:flex-row';

// Mobile: always content first, image bottom
//$mobileFlex = 'flex-col-reverse';

// Background & text color classes based on selected background color
if ($background_color == 'black') {
  $bgclassName  = 'bg-black';
  $textClass    = 'text-white';
  $titleClass   = 'text-white';
  $subtitleClass = 'text-white';
  $descClass    = 'text-[#E5E5E5]';
  $cardTitleClass = 'text-white';
  $cardTextClass  = 'text-[#E5E5E5]';
} else {
  // Default: white
  $bgclassName  = 'bg-white';
  $textClass    = 'text-[#262626]';
  $titleClass   = 'text-[#262626]';
  $subtitleClass = 'text-[#737373]';
  $descClass    = 'text-[#525252]';
  $cardTitleClass = 'text-[#262626]';
  $cardTextClass  = 'text-[#525252]';
}

?>
    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> two-col-sec <?php echo $bgclassName; ?> px-4 md:px-10 py-[60px] md:py-[120px]">
      <div class="wrapper flex flex-col gap-[60px]">
        <div class="top-title-sec flex flex-wrap">
          <div class="top_title md:max-w-[750px] max-md:w-full md:pr-[20px]">
            <?php if($title_row_1 || $title_row_2): ?>
            <h2 class="text-[clamp(36px,6vw,68px)] leading-[clamp(44px,7vw,76px)] tracking-[-4%] <?php echo $titleClass; ?> font-heading mb-[20px]">
              <?php if($title_row_1): ?>
                  <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
              <?php endif; ?>
              <?php if($title_row_2): ?>
                  <span class="font-light <?php echo $subtitleClass; ?>"><?= wp_kses_post($title_row_2) ?></span>
              <?php endif; ?>
            </h2>
            <?php endif; ?>
            <?php if($description): ?>
              <div class="max-md:w-full "><p class="font-body font-normal text-[18px] leading-[26px] tracking-[0em] <?php echo $descClass; ?>"><?php echo $description; ?></p></div>
            <?php endif; ?>
          </div>
          
        </div>



<?php if (have_rows('partnership_list')) : ?>
  
  <div class="partnership-list flex flex-wrap min-[1199px]:flex-nowrap justify-center gap-6">
    
    <?php 
    $i = 1;
    while (have_rows('partnership_list')) : the_row();         
      $image   = get_sub_field('p_image');
      $title   = get_sub_field('p_title');
      $content = get_sub_field('p_content');
    ?>

      <div class="flex flex-col gap-[20px] justify-between min-[1199px]:w-[20%] md:w-[31%]">

        <!-- Index -->
        <div class="flex flex-col gap-[20px]">
          <h3 class="font-[Poppins] font-bold text-[clamp(28px,4vw,40px)] leading-[clamp(36px,5vw,48px)] tracking-[-0.02em] <?php echo $cardTitleClass; ?> flex gap-[20px]"><span><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?> </span> <svg width="41" height="40" viewBox="0 0 41 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.80347 6.1875H34.3533V34.8426" stroke="#4A78FF" stroke-miterlimit="10"/><path d="M34.1687 6.36914L5.9884 34.6532" stroke="#4A78FF" stroke-miterlimit="10"/></svg></h3>
          <!-- Title -->
          <h4 class="font-[Poppins] font-medium text-[24px] leading-[32px] tracking-[-0.02em] md:text-[28px] md:leading-[36px] <?php echo $cardTitleClass; ?>"><?php echo esc_html($title); ?></h4>
          <!-- Content -->
          <p class="font-body font-normal text-[18px] leading-[26px] <?php echo $cardTextClass; ?>"><?php echo esc_html($content); ?></p>
        </div>

        <!-- Image -->
        <?php if ($image) : ?>
          <figure class="aspect-[256/340]">
            <img 
              src="<?php echo esc_url($image['url']); ?>" 
              alt="<?php echo esc_attr($image['alt']); ?>" 
              class="w-full w-full h-full object-cover"
            >
          </figure>
        <?php endif; ?>
      </div>
    <?php 
      $i++; 
      endwhile; ?>
  </div>
<?php endif; ?>

      </div> 
    </section>
<?php endwhile;
endif; ?>