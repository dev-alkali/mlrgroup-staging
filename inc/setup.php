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



/** -------------------------------------------------------
 * Gravity Forms — Dynamic Item Table in Notification Email
 * Add this to your theme's functions.php
 *
 * Field IDs (update these to match your form):
 *   Field 11  → Item Codes     (comma-separated)  e.g. 39033,38864,39553
 *   Field 12  → Product Names  (pipe-separated)   e.g. Item A | Item B | Item C
 *   Field XX  → Image URLs     (comma-separated)  e.g. https://.../a.jpg, https://.../b.jpg
 */

add_filter( 'gform_notification', 'gf_build_inquiry_item_table', 10, 3 );

function gf_build_inquiry_item_table( $notification, $form, $entry ) {

    // ── Field IDs ─────────────────────────────────────────────
    $form_id      = 2;    // Your form ID
    $codes_id     = '11'; // Hidden field: item codes (comma-separated)
    $names_id     = '12'; // Hidden field: product names (pipe-separated)
    $images_id    = '13'; // Hidden field: image URLs (comma-separated) ← update this
    // ──────────────────────────────────────────────────────────

    // Only run for this specific form
    if ( absint( $form['id'] ) !== $form_id ) {
        return $notification;
    }

    // Get raw field values
    $codes  = array_map( 'trim', explode( ',', rgar( $entry, $codes_id ) ) );
    $names  = array_map( 'trim', explode( '|', rgar( $entry, $names_id ) ) );
    $images = array_map( 'trim', explode( ',', rgar( $entry, $images_id ) ) );

    // Build table rows
    $rows = '';
    $count = max( count( $codes ), count( $names ) );

    for ( $i = 0; $i < $count; $i++ ) {
        $code  = isset( $codes[ $i ] )  ? esc_html( $codes[ $i ] )  : '—';
        $name  = isset( $names[ $i ] )  ? esc_html( $names[ $i ] )  : '—';
        $img   = isset( $images[ $i ] ) ? esc_url( $images[ $i ] )  : '';

        $img_html = $img
            ? "<img src='{$img}' width='70' height='70' style='display:block;object-fit:cover;border-radius:4px;border:1px solid #ddd;'>"
            : "<div style='width:70px;height:70px;background:#f0f0f0;border:1px solid #ddd;border-radius:4px;display:flex;align-items:center;justify-content:center;'><span style='color:#ccc;font-size:20px;'>&#128247;</span></div>";

        $bg = ( $i % 2 === 0 ) ? '#ffffff' : '#fafafa';

        $rows .= "
        <tr style='background:{$bg};'>
            <td style='padding:10px 12px;border-bottom:1px solid #eee;vertical-align:middle;width:90px;'>
                {$img_html}
            </td>
            <td style='padding:10px 12px;border-bottom:1px solid #eee;vertical-align:middle;width:130px;'>
                <span style='font-family:monospace;background:#f0f0f0;border:1px solid #e0e0e0;padding:2px 8px;border-radius:3px;font-size:12px;color:#444;'>
                    {$code}
                </span>
            </td>
            <td style='padding:10px 12px;border-bottom:1px solid #eee;vertical-align:middle;font-size:14px;color:#222;'>
                {$name}
            </td>
        </tr>";
    }

    // Full table HTML
    $table = "
    <table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;border:1px solid #ddd;border-radius:4px;overflow:hidden;margin-top:8px;'>
        <thead>
            <tr style='background:#111111;'>
                <th style='padding:10px 12px;color:#ffffff;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;width:90px;'>Image</th>
                <th style='padding:10px 12px;color:#ffffff;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;width:130px;'>Item Code</th>
                <th style='padding:10px 12px;color:#ffffff;text-align:left;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;'>Item Name</th>
            </tr>
        </thead>
        <tbody>
            {$rows}
        </tbody>
    </table>";

    // Replace placeholder {item_table} in your notification message
    $notification['message'] = str_replace( '{item_table}', $table, $notification['message'] );

    return $notification;
}