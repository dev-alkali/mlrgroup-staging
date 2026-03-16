<?php

/**
 * Client Logos Block Template.
 */

$id = 'client_logos-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'client_logos';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>


<?php if (have_rows('client_logos')) :  while (have_rows('client_logos')) : the_row(); 
?>
  <?php echo get_sub_field('title_row_1')?>

<?php endwhile;
endif; ?>