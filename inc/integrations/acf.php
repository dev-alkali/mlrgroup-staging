<?php

/**
 * Recursively walk parsed blocks and force mode='edit' on all ACF blocks.
 */
function mlrgroup_force_acf_edit_mode_recursive(&$blocks) {
  foreach ($blocks as &$block) {
    if (!empty($block['blockName']) && strpos($block['blockName'], 'acf/') === 0) {
      $block['attrs']['mode'] = 'edit';
    }
    if (!empty($block['innerBlocks'])) {
      mlrgroup_force_acf_edit_mode_recursive($block['innerBlocks']);
    }
  }
}

/**
 * Before any post/pattern is saved, parse its block content and rewrite
 * every ACF block's mode attribute to 'edit' so it always opens in edit mode.
 */
add_filter('wp_insert_post_data', function ($data) {
  if (empty($data['post_content'])) {
    return $data;
  }

  $blocks = parse_blocks($data['post_content']);
  if (empty($blocks)) {
    return $data;
  }

  mlrgroup_force_acf_edit_mode_recursive($blocks);
  $data['post_content'] = serialize_blocks($blocks);

  return $data;
});

add_action('init', 'register_acf_blocks');
function register_acf_blocks()
{
  register_block_type(__DIR__ . '/acf-blocks/hero');
  register_block_type(__DIR__ . '/acf-blocks/services');
  
  register_block_type(__DIR__ . '/acf-blocks/services-solutions');
  register_block_type(__DIR__ . '/acf-blocks/performance');
  register_block_type(__DIR__ . '/acf-blocks/collection');
  register_block_type(__DIR__ . '/acf-blocks/cta');
  register_block_type(__DIR__ . '/acf-blocks/our-work-grid');
  register_block_type(__DIR__ . '/acf-blocks/inner-hero');
  register_block_type(__DIR__ . '/acf-blocks/two-column');  
  register_block_type(__DIR__ . '/acf-blocks/trusted-brand');
  register_block_type(__DIR__ . '/acf-blocks/client-logos');
  register_block_type(__DIR__ . '/acf-blocks/counter-section');
  register_block_type(__DIR__ . '/acf-blocks/map');
  register_block_type(__DIR__ . '/acf-blocks/award-winning-logo');
  register_block_type(__DIR__ . '/acf-blocks/how-it-works');
  register_block_type(__DIR__ . '/acf-blocks/contact-form');
  register_block_type(__DIR__ . '/acf-blocks/reviews-slider');
  register_block_type(__DIR__ . '/acf-blocks/partnership');
  register_block_type(__DIR__ . '/acf-blocks/case-studies');  
  register_block_type(__DIR__ . '/acf-blocks/faq');
  register_block_type(__DIR__ . '/acf-blocks/our-values');
  register_block_type(__DIR__ . '/acf-blocks/faq-columns');
  register_block_type(__DIR__ . '/acf-blocks/content');  
  register_block_type(__DIR__ . '/acf-blocks/spacing');  
  register_block_type(__DIR__ . '/acf-blocks/lookbooks-list');  
  register_block_type(__DIR__ . '/acf-blocks/multiple-images');  
  register_block_type(__DIR__ . '/acf-blocks/quote-block');  
  register_block_type(__DIR__ . '/acf-blocks/case-studies-grid');  
  register_block_type(__DIR__ . '/acf-blocks/ctas-multiple');  
  register_block_type(__DIR__ . '/acf-blocks/two-column-with-icon');  

}