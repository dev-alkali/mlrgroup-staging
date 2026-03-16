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
