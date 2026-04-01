<?php
$taxonomy = 'portfolio-category';
$current_term = get_queried_object();
$active_term_id = (isset($current_term->term_id) && $current_term->term_id) ? absint($current_term->term_id) : 0;

$parent_terms = get_terms(array(
   'taxonomy'   => $taxonomy,
   'parent'     => 0,
   'hide_empty' => false,
   'orderby'    => 'term_id',
   'order'      => 'DESC',
));
?>

<aside id="sidebar-filter" class="flex flex-col w-full md:w-[220px] lg:w-[280px] xl:w-[360px] flex-shrink-0 gap-4 mt-[25px]" aria-label="Filter categories">
   <div class="flex justify-between items-center w-full mb-[15px]">
     <h3 class="font-[Poppins] font-medium text-[24px] leading-[32px] tracking-[-0.02em] text-[#262626] filter-heading">Filters</h3>
     <a href="javascript:void(0);" class="hidden md:inline-block font-[Poppins] font-medium text-[16px] leading-[24px] text-[#525252] underline hover:no-underline hover:text-accent transition-colors">Reset</a>
     <div class="filter-toggle-btn block md:hidden">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
      </div>
   </div>

   <div class="sidebar-cat w-full hidden md:block">
      <div class="pb-[18px]">
            <?php $is_all_active = $active_term_id === 0; ?>
            <a href="<?php echo esc_url(home_url('/work')); ?>" class="group relative inline-block font-body font-normal text-[18px] leading-[20px] text-[#525252] hover:text-[#FD4338] no-underline hover:underline transition-all duration-300 pl-0 hover:pl-6 <?php echo $is_all_active ? 'text-[#FD4338] pl-6 underline' : ''; ?>">
               <svg class="absolute left-0 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-200 <?php echo $is_all_active ? 'opacity-100' : ''; ?>" width="16" height="16" viewBox="0 0 16 16" fill="none">
                 <path d="M2.26562 2.47461H13.407V13.9366" stroke="#FD4338"/>
                 <path d="M13.3351 2.54785L2.33789 13.8615" stroke="#FD4338"/>
               </svg> All Industries </a>
      </div>

       <?php if (!empty($parent_terms) && !is_wp_error($parent_terms)) :
          $active_ancestor_ids = $active_term_id > 0
            ? array_map('absint', get_ancestors($active_term_id, $taxonomy, 'taxonomy'))
            : array();

          $render_term_tree = function ($terms, $level = 1, $is_open = true) use (&$render_term_tree, $taxonomy, $active_term_id, $active_ancestor_ids) {
            if (empty($terms) || is_wp_error($terms)) {
              return;
            }

            $ul_class = $level === 1
              ? 'space-y-[28px]'
              : 'child-list space-y-[28px] overflow-hidden transition-all duration-300 pl-0 ' . ($is_open ? 'is-open' : '');
            echo '<ul class="' . esc_attr($ul_class) . '">';

            foreach ($terms as $term) {
              $term_id   = absint($term->term_id);
              $term_link = get_term_link($term);
              if (is_wp_error($term_link)) {
                continue;
              }

              $child_terms = get_terms(array(
                'taxonomy'   => $taxonomy,
                'parent'     => $term_id,
                'hide_empty' => false,
              ));
              $has_child = !empty($child_terms) && !is_wp_error($child_terms);

              $term_active = ($active_term_id > 0 && $term_id === $active_term_id);
              $term_is_open_active = $term_active || in_array($term_id, $active_ancestor_ids, true);

              echo '<li class="' . ($has_child ? 'has-child' : '') . '">';
              echo '<div class="flex items-start justify-between space-y-[28px]">';

              if ($has_child && $level === 1) {
                $term_class = 'font-[Poppins] font-bold text-[18px] leading-[28px] text-[#262626] hover:text-[#FD4338] no-underline transition-colors';
                if ($term_is_open_active) {
                  $term_class .= ' text-[#FD4338]';
                }
              } else {
                $term_class = 'group relative inline-block font-body font-normal text-[18px] leading-[20px] text-[#525252] hover:text-[#FD4338] no-underline hover:underline transition-all duration-300 pl-0 hover:pl-6';
                if ($term_active) {
                  $term_class .= ' text-[#FD4338] pl-6 underline';
                }
              }

              echo '<a href="' . esc_url($term_link) . '" class="' . esc_attr($term_class) . '">';

              if (!$has_child || $level > 1) {
                $term_svg_class = 'absolute left-0 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-200';
                if ($term_active) {
                  $term_svg_class .= ' opacity-100';
                }
                echo '<svg class="' . esc_attr($term_svg_class) . '" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2.26562 2.47461H13.407V13.9366" stroke="#FD4338"/><path d="M13.3351 2.54785L2.33789 13.8615" stroke="#FD4338"/></svg>';
              }

              echo esc_html($term->name);
              echo '</a>';

              if ($has_child) {
                $arrow_rotate_class = $term_is_open_active ? '' : ' rotate-180';
                echo '<span class="arrow cursor-pointer ml-2 transition-transform duration-300 mt-[9px]' . esc_attr($arrow_rotate_class) . '" data-toggle>
                        <svg width="14" height="9" viewBox="0 0 14 9" fill="none">
                          <path d="M6.75 0.00019455L13.5 6.7502L11.925 8.3252L6.75 3.15019L1.575 8.3252L0 6.7502L6.75 0.00019455Z" fill="#525252"/>
                        </svg>
                      </span>';
              }

              echo '</div>';

              if ($has_child) {
                $render_term_tree($child_terms, $level + 1, $term_is_open_active);
              }

              echo '</li>';
            }

            echo '</ul>';
          };

          $render_term_tree($parent_terms, 1, true);
        endif; ?>

   </div>
</aside>