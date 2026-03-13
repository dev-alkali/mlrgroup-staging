
<?php
add_action('admin_post_nopriv_add_inquiry', 'trackvest_handle_add_inquiry');
add_action('admin_post_add_inquiry',        'trackvest_handle_add_inquiry');
function add_inquiry()
{
wp_die('workando');
}
