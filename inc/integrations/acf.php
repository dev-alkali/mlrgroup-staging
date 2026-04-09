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

}