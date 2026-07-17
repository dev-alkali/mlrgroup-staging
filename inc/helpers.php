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

/**
 * Weighted portfolio search.
 *
 * Returns portfolio post IDs ordered by relevance. Weighting follows the
 * client guidance: item name (title) outranks item code, which outranks
 * category name. Brand names typically live in the title (e.g. "818"), so the
 * title weight naturally covers brand searches.
 *
 * @param string $search Raw search string.
 * @return int[] Ordered list of matching post IDs (highest relevance first).
 */
function mlr_portfolio_search_ordered_ids($search) {
    $search = trim((string) $search);

    if ($search === '') {
        return array();
    }

    $scores = array();

    $add = function ($ids, $points) use (&$scores) {
        foreach ((array) $ids as $id) {
            $id = (int) $id;
            if ($id <= 0) {
                continue;
            }
            $scores[$id] = isset($scores[$id]) ? $scores[$id] + $points : $points;
        }
    };

    // 1. Item name (title) — highest weight. WP core relevance ranks title
    //    matches above content matches for the `s` query.
    $title_query = new WP_Query(array(
        'post_type'              => 'portfolio',
        'post_status'            => 'publish',
        'posts_per_page'         => -1,
        'fields'                 => 'ids',
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        's'                      => $search,
    ));
    $add($title_query->posts, 3);

    // 2. Item code (ACF meta) — high weight for SKU-style lookups.
    $code_query = new WP_Query(array(
        'post_type'              => 'portfolio',
        'post_status'            => 'publish',
        'posts_per_page'         => -1,
        'fields'                 => 'ids',
        'no_found_rows'          => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'meta_query'             => array(
            array(
                'key'     => 'item_code',
                'value'   => $search,
                'compare' => 'LIKE',
            ),
        ),
    ));
    $add($code_query->posts, 2);

    // 3. Category name — lowest weight.
    $term_ids = get_terms(array(
        'taxonomy'   => 'portfolio-category',
        'name__like' => $search,
        'hide_empty' => true,
        'fields'     => 'ids',
    ));

    if (! empty($term_ids) && ! is_wp_error($term_ids)) {
        $cat_query = new WP_Query(array(
            'post_type'              => 'portfolio',
            'post_status'            => 'publish',
            'posts_per_page'         => -1,
            'fields'                 => 'ids',
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'tax_query'              => array(
                array(
                    'taxonomy' => 'portfolio-category',
                    'field'    => 'term_id',
                    'terms'    => $term_ids,
                ),
            ),
        ));
        $add($cat_query->posts, 1);
    }

    if (empty($scores)) {
        return array();
    }

    arsort($scores);

    return array_keys($scores);
}

