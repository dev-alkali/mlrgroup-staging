<?php
if (!defined('ABSPATH')) exit;

/**
 * Theme Setup.
 */

add_theme_support('post-thumbnails');

function title_page_setup()
{
  add_theme_support('title-tag');
}
add_action('after_setup_theme', 'title_page_setup');

function add_logo_setup()
{
  add_theme_support('custom-logo', array(
    'height'      => 50,
    'width'       => 280,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array('site-title', 'site-description'),
  ));
}
add_action('after_setup_theme', 'add_logo_setup');

function register_my_menus()
{
  register_nav_menus(array(
    'header-menu' => __('header menu', 'mlrgroup'),
    'about-us-menu' => __('about us menu', 'mlrgroup'),
    'contacts-menu' => __('Contacts menu', 'mlrgroup'),
    'services-menu' => __('services menu', 'mlrgroup'),
    'work-menu' => __('work menu', 'mlrgroup'),
  ));
}
add_action('init', 'register_my_menus');
