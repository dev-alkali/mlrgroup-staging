<?php

/**
 * How It Works Block Template.
 */

$id = 'services-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'services';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>

<?php if (have_rows('how_it_works')) :  while (have_rows('how_it_works')) : the_row(); ?>
<?php 
$section_background = get_sub_field('section_background');

$bg_class = '';
if ($section_background === 'Black') {
    $bg_class = 'bg-black';
} elseif ($section_background === 'White') {
    $bg_class = 'bg-white';
}
?>

<?php 
$card_overlay = get_sub_field('card_overlay');

$overlay_class = '';

if ($card_overlay === 'Grayscale') {
    $overlay_class = 'overlay-grayscale';
} elseif ($card_overlay === 'Pink Gradient') {
    $overlay_class = 'overlay-pink-gradient';
}

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
?>


<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className . ' ' . $bg_class); ?> <?php echo esc_attr($overlay_class); ?> flex w-full justify-center px-4 min-[600px]:px-10 py-[60px] min-[600px]:py-[120px] how-it-works-sec<?php echo $pt_class; ?><?php echo $pb_class; ?>">      
      <?php if (have_rows('header_content')) :  while (have_rows('header_content')) : the_row(); ?>

          <div class="flex flex-col items-center gap-8 min-[600px]:gap-[60px] w-full max-w-[1920px]">
            <div class="flex flex-col md:flex-row">
              <?php if (have_rows('title_group')) :  while (have_rows('title_group')) : the_row(); 
                    $title1 = get_sub_field('title_row_1');
                    $title2 = get_sub_field('title_row_2');
              ?>
                 <?php if ($title1 || $title2) : ?>
                  <div class="how-heading md:flex-[1] w-full md:pr-[40px]">
                    <h2 class="max-w-[426px] w-full text-[44px] flex flex-col min-[600px]:text-[54px] min-[767px]:text-[68px] tracking-[-2%] leading-[56px] min-[600px]:leading-[64px] min-[767px]:leading-[78px] font-heading">
                      <span class="font-bold text-neutral-800"><?= wp_kses_post($title1) ?></span>
                      <span class="font-light text-neutral-500"><?= wp_kses_post($title2) ?></span>
                    </h2>
                  </div>

                <?php endif; ?>

              <?php endwhile;
              endif; ?>

              <div class="how-content md:flex-[2] w-full">
                <?php if (get_sub_field('subtitle')) : ?>
                <p class="text-xl leading-7 text-neutral-600 font-body">
                  <?= wp_kses_post(get_sub_field('subtitle')) ?>
                </p>
                <?php endif; ?>
              </div>

            </div>
        <?php endwhile;
      endif; ?>

        <?php if (have_rows('main_content')) :  while (have_rows('main_content')) : the_row(); ?>
            <div class="flex items-center justify-center max-[1440px]:flex-wrap  gap-4 min-[600px]:gap-2 self-stretch w-full">
              <?php if (have_rows('works')) : $i = 1; while (have_rows('works')) : the_row(); ?>                  
                  <article class="source-card max-[600px]:h-[380px] max-[1440px]:h-[420px] w-full min-[1440px]:aspect-[334/420] max-[1440px]:max-w-[49%] relative overflow-hidden">                    
                    <div class="bg-image absolute inset-0"
                      style="background-image: url('<?php echo esc_url(get_sub_field('image')); ?>'); background-position: center center; background-size: cover; background-repeat: no-repeat;">
                    </div>
                    <div class="bg-overlay absolute inset-0" style="background-color: <?php echo esc_attr(get_sub_field('overlay_color')); ?>;"></div>                          
                    <a href="<?php echo esc_url(get_sub_field('link_path')); ?>" class="gradient-box absolute flex flex-col flex-1 justify-between px-5 min-[600px]:px-6 py-7 w-full h-full">                      
                      <h3 class="text-3xl md:text-[48px] leading-tight md:leading-[60px] tracking-tight md:tracking-[-0.02em] text-white font-bold"><?php echo $i; ?></h3>                                                
                      <div class="flex flex-col gap-3 min-[600px]:gap-4 content z-10">
                        <h3 class="text-white card-title"><?php echo wp_kses_post(get_sub_field('title')); ?></h3>                        
                        <p class="text-white text-[16px] min-[600px]:text-lg leading-[26px] min-[600px]:leading-7 font-body">
                          <?php echo wp_kses_post(get_sub_field('paragraph')); ?>
                        </p>
                      </div>
                    </a>
                  </article>
                <?php $i++; endwhile; endif; ?>
            </div>
        <?php endwhile;
        endif; ?>

        <?php if (have_rows('header_content')) :  while (have_rows('header_content')) : the_row(); ?>
          <?php 
            $link = get_sub_field('button');
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <div class="text-center"><a class="btn-primary" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
            <?php endif; ?>
          <?php endwhile;
        endif; ?>
        
          </div>
    </section>
<?php endwhile;
endif; ?>