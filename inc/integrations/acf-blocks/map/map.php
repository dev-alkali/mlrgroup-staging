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

<?php if (have_rows('map-section')) :  while (have_rows('map-section')) : the_row(); ?>
<section>
  <div class="container">
    <div class="map__content">
      <h2 class="map__title"><?php echo get_sub_field('title_row_1'); ?></h2>
      <div class="map__address"><?php echo get_sub_field('title_row_2'); ?></div>
    </div>
    <div class="map__iframe">
      <?php echo get_sub_field('map_code'); ?>
    </div>
  </div>
</section>
<?php endwhile; endif; ?>