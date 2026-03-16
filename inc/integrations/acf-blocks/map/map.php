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
<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className . ' ' . $bg_class); ?> <?php echo esc_attr($overlay_class); ?> px-4 min-[600px]:px-10 py-[60px] min-[600px]:py-[120px]">      
  <div class="container">
      <?php if ($title1 || $title2) : ?>
        <div class="serve-heading">
          <h2 class="text-[44px] flex flex-col min-[600px]:text-[54px] min-[767px]:text-[68px] tracking-[-2%] leading-[56px] min-[600px]:leading-[64px] min-[767px]:leading-[78px] font-heading">
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