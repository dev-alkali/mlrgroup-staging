```php
<?php

/**
 * Trusted Brand Block Template.
 */


$id = 'trusted_brand-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}


$className = 'trusted_brand';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>
