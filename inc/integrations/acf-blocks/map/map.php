<?php

/**
 * Map Block Template.
 */

$id = 'map-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'map';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>

<?php if (have_rows('map-section')) :  while (have_rows('map-section')) : the_row(); 
$title1 = get_sub_field('title_row_1');
$title2 = get_sub_field('title_row_2');
$map_code = get_sub_field('map_code');

?>
<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className . ' ' . $bg_class); ?> <?php echo esc_attr($overlay_class); ?> map-sec px-4 md:px-10 py-[60px] md:py-[120px]">
  <div class="wrapper">
      <?php if ($title1 || $title2) : ?>
        <div class="serve-heading md:mb-[80px] md-[32px]">
          <h2 class="flex flex-col font-heading font-bold text-[clamp(36px,4.5vw,68px)] leading-[clamp(44px,5.2vw,78px)] tracking-[-0.02em]">
            <span class="font-bold text-neutral-800"><?= wp_kses_post($title1) ?></span>
            <span class="font-light text-neutral-500"><?= wp_kses_post($title2) ?></span>
          </h2>
        </div>
      <?php endif; ?>
    <div class="map__iframe">
      <?php echo $map_code; ?>
    </div>
  </div>
</section>
<?php endwhile; endif; ?>