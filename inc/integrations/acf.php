<?php

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
  
}