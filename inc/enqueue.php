<?php
if (!defined('ABSPATH')) exit;

/**
 * Enqueue scripts and styles.
 */
function register_style()
{
  wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
  wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], null);
  wp_enqueue_style('output', get_template_directory_uri() . '/assets/dist/css/output.css', array(), '1.0', 'all');
  wp_enqueue_style('poppins', 'https://use.typekit.net/atb6izc.css', array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'register_style');

function register_script()
{
  wp_enqueue_script('wp-api');
  wp_enqueue_script('jquery-core', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), '3.6.0', true);

  // GSAP Core Library
  wp_enqueue_script(
    'gsap',
    'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
    array(),
    '3.12.5',
    true
  );

  // ScrollTrigger Plugin
  wp_enqueue_script(
    'scrolltrigger',
    'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
    array('gsap'),
    '3.12.5',
    true
  );

  wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11', true);

  // Modular Block Scripts
  wp_enqueue_script(
    'hero-block',
    get_template_directory_uri() . '/assets/js/hero-block.js',
    array('gsap'),
    '1.0.0',
    true
  );

  wp_enqueue_script(
    'performance-block',
    get_template_directory_uri() . '/assets/js/performance-block.js',
    array('gsap', 'scrolltrigger'),
    '1.0.0',
    true
  );

  wp_enqueue_script(
    'solutions-tabs',
    get_template_directory_uri() . '/assets/js/solutions-tabs.js',
    array('jquery-core', 'swiper-js'),
    '1.0.0',
    true
  );

  wp_enqueue_script(
    'mobile-menu',
    get_template_directory_uri() . '/assets/js/mobile-menu.js',
    array('jquery-core'),
    '1.0.0',
    true
  );

  /**
   * ==============================
   * events
   * ==============================
   */
  wp_enqueue_script('add-inquiryJS', get_template_directory_uri() . '/assets/js/ajax/add-inquiry.js', array('jquery-core'), '1.0', true);
  wp_localize_script('add-inquiryJS', 'addInquiryAjax', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce'   => wp_create_nonce('add_inquiry_nonce')
  ));
}
add_action('wp_enqueue_scripts', 'register_script');
