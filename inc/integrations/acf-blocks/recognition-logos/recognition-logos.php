<?php
/**
 * Recognition Logos Block Template.
 */

$id = 'recognition-logos-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'recognition-logos';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>
<?php if (have_rows('recognition-logos')) : ?>
  <?php while (have_rows('recognition-logos')) : the_row();

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

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> recognition-logos flex justify-center px-4 md:px-10 py-[60px] lg:py-[80px] xl:py-[120px]<?php echo $pt_class; ?><?php echo $pb_class; ?>">
      <div class="w-full wrapper">

        <?php
          $title1   = get_sub_field('title_row_1');
          $title2   = get_sub_field('title_row_2');
          $subtitle = get_sub_field('description');
        ?>
        <?php if ($title1 || $title2 || $subtitle) : ?>
          <div class="mb-[32px] md:mb-[60px]">
            <?php if ($title1 || $title2) : ?>
              <h2 class="text-[clamp(36px,6vw,68px)] leading-[clamp(44px,7vw,76px)] tracking-[-0.02em] font-heading">
                <span class="font-bold text-neutral-800"><?php echo wp_kses_post($title1); ?></span>
                <span class="font-bold text-neutral-800"><?php echo wp_kses_post($title2); ?></span>
              </h2>
            <?php endif; ?>
            <?php if ($subtitle) : ?>
              <p class="font-body font-normal text-[clamp(18px,1.5vw,20px)] leading-[clamp(26px,2vw,28px)] text-neutral-600 mt-[20px]">
                <?php echo wp_kses_post($subtitle); ?>
              </p>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <?php
          $logos = [];
          if (have_rows('logo_lists')) {
              while (have_rows('logo_lists')) : the_row();
                  $logos[] = [
                      'logo'     => get_sub_field('logo_img'),
                      'in_title' => get_sub_field('title'),
                      'in_sub_title' => get_sub_field('sub_title'),
                  ];
              endwhile;
          }
        ?>
    

        <div class="logo-cards gap-2 flex justify-center flex-wrap">
          <?php foreach ($logos as $i => $item) :
            $logo     = $item['logo'];
            $in_title = $item['in_title'];
            $in_sub_title = $item['in_sub_title'];
          ?>
            <div class="rec-card p-6 md:p-7 flex items-center relative sm:w-[calc(33.33%-6px)] w-[calc(50%-6px)] bg-[#f5f5f5]">
              <?php if ($logo) : ?>
                <figure><img
                  src="<?php echo esc_url($logo['url']); ?>"
                  alt="<?php echo esc_attr($logo['alt']); ?>"
                  class="w-[100%] w-[120px] md:w-[140px] lg:w-[150px] lg:h-[90px] xl:w-[120px] 2xl:w-[155px] xl:h-[100px] 2xl:h-[120px] xl:max-h-[100%] object-contain h-auto"/>
                </figure>
                <div class="">
                    <?php if ($in_title) : ?>
                    <h3><b><?php echo $in_title;?></b></h3>
                    <?php endif; ?>
                    <?php if ($in_sub_title) : ?>
                    <h4><?php echo $in_sub_title;?></h4>
                    <?php endif; ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>


        <?php
          $link = get_sub_field('button');
          if ($link) :
            $link_url    = $link['url'];
            $link_title  = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
        ?>
          <div class="text-center mt-[32px] md:mt-[40px] view-more-btn">
            <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"  class="btn-primary blue-btn"><span><?php echo esc_html($link_title); ?></span></a>
          </div>
        <?php endif; ?>


      </div>
    </section>

  <?php endwhile; ?>
<?php endif; ?>
