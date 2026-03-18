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
<?php 
if (have_rows('inner_hero')) :  while (have_rows('inner_hero')) : the_row(); 
  $title_row_1 = get_sub_field('title_row_1');
  $title_row_2 = get_sub_field('title_row_2');
  $description = get_sub_field('description');
?>

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> w-full px-4 md:px-10" style="background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>');background-position: center;background-size: cover;background-repeat: no-repeat;background-color: rgba(0, 0, 0, 0.5);background-blend-mode: overlay;">
      <div class="gap-10 w-full wrapper min-h-screen py-[80px] md:py-[118px] flex items-end">
        <div class="max-w-[800px]">
          <?php if($title_row_1 || $title_row_2): ?>
          <h2 class="text-[clamp(35px,6vw,70px)] leading-[clamp(46px,7vw,88px)] tracking-[-0.02em] text-white font-heading">            
            <?php if($title_row_1): ?>
                <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
            <?php endif; ?>
            <?php if($title_row_2): ?>
                <span class="font-light"><?= wp_kses_post($title_row_2) ?></span>
            <?php endif; ?>
          </h2>
          <?php endif; ?>
          <?php if($description): ?>
            <p class="w-full text-[clamp(16px,3vw,20px)] leading-[28px] text-gray-50 font-body"><?= wp_kses_post($description) ?></p>
          <?php endif; ?>

          <?php 
            $link = get_sub_field('button');
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                <a class="btn-primary mt-[20px] md:mt-[40px]" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            <?php endif; ?>
        </div>

      </div>
    </section>
<?php endwhile;
endif; ?>