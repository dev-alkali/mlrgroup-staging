<?php

/**
 * Inner Hero Block Template.
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
<?php if (have_rows('inner_hero')) :  while (have_rows('inner_hero')) : the_row(); 

$title_row_1 = get_sub_field('title_row_1');
$title_row_2 = get_sub_field('title_row_2');
$description = get_sub_field('description'); ?>

    <section id="<?php echo esc_attr($id); ?>"
      class="<?php echo esc_attr($className); ?> flex w-full h-[700px] min-[600px]:h-[855px] "
      style="
    background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>');
    background-position: 50% 38%;
    background-size: cover;
    background-repeat: no-repeat;
  ">
      <div class="flex flex-col items-center w-full h-full justify-end gap-[40px] min-[600px]:gap-[100px] min-[767px]:gap-[162px] pl-4 min-[600px]:pl-10 min-[767px]:pl-[140px] pr-4 min-[600px]:pr-10 min-[767px]:pr-20 pt-10 pb-[60px] min-[600px]:pb-[100px] [background:linear-gradient(222deg,rgba(0,0,0,0)_4.72%,rgba(0,0,0,1)_79.68%)]">

        <div class="flex flex-col items-start gap-10 min-[600px]:gap-[60px] w-full max-w-[1920px]">
          <div class="flex flex-col items-start gap-5 w-full">
            <?php if($title_row_1 || $title_row_2): ?>
            <h2 class="max-w-[622px] w-full text-[44px] tracking-[-2%] min-[600px]:text-[65px] min-[767px]:text-[80px] leading-[50px] min-[600px]:leading-[65px] min-[767px]:leading-[92px] text-white font-heading">
              <?php if($title_row_1): ?>
                  <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
              <?php endif; ?>

              <?php if($title_row_2): ?>
                  <span class="font-light"><?= wp_kses_post($title_row_2) ?></span>
              <?php endif; ?>
            </h2>
            <?php endif; ?>
            <?php if($description): ?>
              <p class="max-w-[622px] w-full text-[18px]  min-[600px]:text-xl leading-[26px] min-[600px]:leading-7 text-gray-50 font-body"><?= wp_kses_post($description) ?></p>
            <?php endif; ?>
          </div>
          
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

    </section>
<?php endwhile;
endif; ?>