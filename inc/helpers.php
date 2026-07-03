<?php
if (!defined('ABSPATH')) exit;

/**
 * Helper Functions.
 */

/**
 * Whether the portfolio grid should show the Featured Items section.
 *
 * Uses ACF filter groups as the source of truth: parent categories show featured
 * items even when the same term is also listed as a child. Child-only terms do not.
 */
function mlr_portfolio_show_featured_section($term_id = 0) {
    $term_id = absint($term_id);

    if ($term_id === 0) {
        return true;
    }

    $filter_groups = function_exists('get_field')
        ? get_field('portfolio_filter_groups', 'option')
        : null;

    if (empty($filter_groups)) {
        $term = get_term($term_id, 'portfolio-category');
        return $term && ! is_wp_error($term) && (int) $term->parent === 0;
    }

    foreach ($filter_groups as $group) {
        $parent = $group['parent_category'] ?? null;
        if (! empty($parent) && ! is_wp_error($parent) && (int) $parent->term_id === $term_id) {
            return true;
        }
    }

    return false;
}

