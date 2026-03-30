<?php

/**
 * spacing Block Template.
 */

$id = 'spacing-' . $block['id'];
if (!empty($block['anchor'])) {
    $id = $block['anchor'];
}

$className = 'spacing-block';
if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}

// Get the spacing group field
$spacing       = get_field('spacing');
$desktop_space = !empty($spacing['desktop_space']) ? $spacing['desktop_space'] : '0px';
$tablet_space  = !empty($spacing['tablet_space'])  ? $spacing['tablet_space']  : $desktop_space;
$mobile_space  = !empty($spacing['mobile_space'])  ? $spacing['mobile_space']  : $tablet_space;


?>
  <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>"></div>
  <style>
    #<?php echo esc_attr($id); ?> {
        display: block;
        width: 100%;
        height: <?php echo esc_attr($desktop_space); ?>;
    }

    /* Tablet: max-width 1024px */
    @media (max-width: 1024px) {
        #<?php echo esc_attr($id); ?> {
            height: <?php echo esc_attr($tablet_space); ?>;
        }
    }

    /* Mobile: max-width 767px */
    @media (max-width: 767px) {
        #<?php echo esc_attr($id); ?> {
            height: <?php echo esc_attr($mobile_space); ?>;
        }
    }
</style>
