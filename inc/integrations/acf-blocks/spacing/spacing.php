<?php

/**
 * spacing Block Template.
 */

$id = 'spacing' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'content';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>
<?php if (have_rows('content')) :  while (have_rows('content')) : the_row();



?>
  <div class="spacing-block"></div>  
<?php endwhile;
endif; ?>