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
    'privacy-menu' => __('Privacy Menu', 'mlrgroup'),
    
  ));
}
add_action('init', 'register_my_menus');

function mrlgroup_register_portfolio_cpt()
{
  register_post_type('portfolio', array(
    'labels' => array(
      'name'           => 'Portfolio',
      'singular_name'  => 'Portfolio Item',
      'add_item'       => 'New Portfolio Item',
      'add_new_item'   => 'Add New Portfolio Item',
      'edit_item'      => 'Edit Portfolio Item',
    ),
    'public'        => true,
    'has_archive'   => true,
    'rewrite'       => array('slug' => 'portfolio'),
    'menu_position' => 5,
    'show_ui'       => true,
    'show_in_rest'  => true,
    'supports'      => array('author', 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'comments'),
    'menu_icon'     => 'dashicons-portfolio',
  ));

  register_taxonomy('portfolio-category', array('portfolio'), array(
    'hierarchical'    => true,
    'show_in_rest'    => true,
    'labels'          => array(
      'name'              => 'Portfolio Categories',
      'singular_name'     => 'Portfolio Category',
      'search_items'      => 'Search Portfolio Categories',
      'all_items'         => 'All Portfolio Categories',
      'parent_item'       => 'Parent Portfolio Category',
      'parent_item_colon' => 'Parent Portfolio Category:',
      'edit_item'         => 'Edit Portfolio Category',
      'update_item'       => 'Update Portfolio Category',
      'add_new_item'      => 'Add New Portfolio Category',
      'new_item_name'     => 'New Portfolio Category Name',
      'menu_name'         => 'Portfolio Categories',
    ),
    'show_ui'          => true,
    'query_var'        => true,
    'show_admin_column' => true,
    'rewrite'          => array('slug' => 'portfolio-category'),
  ));

  register_taxonomy('portfolio-tag', array('portfolio'), array(
    'hierarchical'    => false,
    'show_in_rest'    => true,
    'labels'          => array(
      'name'              => 'Portfolio Tags',
      'singular_name'     => 'Portfolio Tag',
      'search_items'      => 'Search Portfolio Tags',
      'all_items'         => 'All Portfolio Tags',
      'edit_item'         => 'Edit Portfolio Tag',
      'update_item'       => 'Update Portfolio Tag',
      'add_new_item'      => 'Add New Portfolio Tag',
      'new_item_name'     => 'New Portfolio Tag Name',
      'menu_name'         => 'Portfolio Tags',
    ),
    'show_ui'          => true,
    'query_var'        => true,
    'show_admin_column' => true,
    'rewrite'          => array('slug' => 'portfolio-tag'),
  ));
}
add_action('init', 'mrlgroup_register_portfolio_cpt');

