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
         echo '<ul class="space-y-[28px]">'; 
    foreach ($parent_terms as $parent) :
        $child_terms = get_terms([
            'taxonomy'   => $taxonomy,
            'parent'     => $parent->term_id,
            'hide_empty' => false,
        ]);

        $parent_link = get_term_link($parent);
        $has_child   = !empty($child_terms) && !is_wp_error($child_terms);

        $parent_active = ($active_term_id > 0 && absint($parent->term_id) === $active_term_id);
        $parent_has_active_child = false;
        if ($has_child && $active_term_id > 0) {
          foreach ($child_terms as $child) {
            if (absint($child->term_id) === $active_term_id) {
              $parent_has_active_child = true;
              break;
            }
          }
        }
        $parent_is_open_active = $parent_active || $parent_has_active_child;

        echo '<li class="'. ($has_child ? 'has-child' : '') .'">';
         echo '<div class="flex items-start justify-between space-y-[28px]">';
        $parent_class = $has_child
            ? 'font-[Poppins] font-bold text-[18px] leading-[28px] text-[#262626] hover:text-[#FD4338] no-underline transition-colors'
            : 'group relative inline-block font-body font-normal text-[18px] leading-[20px] text-[#525252] hover:text-[#FD4338] no-underline hover:underline transition-all duration-300 pl-0 hover:pl-6';

        if ($has_child) {
          if ($parent_is_open_active) {
            $parent_class .= ' text-[#FD4338]';
          }
        } else {
          if ($parent_active) {
            $parent_class .= ' text-[#FD4338] pl-6 underline';
          }
        }

        echo '<a href="'. esc_url($parent_link) .'" class="'. $parent_class .'">';

        if (!$has_child) {
            $parent_svg_class = 'absolute left-0 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-200';
            if ($parent_active) {
              $parent_svg_class .= ' opacity-100';
            }
            echo '<svg class="' . esc_attr($parent_svg_class) . '" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2.26562 2.47461H13.407V13.9366" stroke="#FD4338"/><path d="M13.3351 2.54785L2.33789 13.8615" stroke="#FD4338"/></svg>';
        }

        echo esc_html($parent->name);
        echo '</a>';

        if ($has_child) {
            $arrow_rotate_class = $parent_is_open_active ? '' : ' rotate-180';
            echo '<span class="arrow cursor-pointer ml-2 transition-transform duration-300 mt-[9px]' . esc_attr($arrow_rotate_class) . '" data-toggle>
                    <svg width="14" height="9" viewBox="0 0 14 9" fill="none">
                        <path d="M6.75 0.00019455L13.5 6.7502L11.925 8.3252L6.75 3.15019L1.575 8.3252L0 6.7502L6.75 0.00019455Z" fill="#525252"/>
                    </svg>
                  </span>';
        }

        echo '</div>';

        if ($has_child) {
            echo '<ul class="child-list space-y-[28px] overflow-hidden transition-all duration-300 ' . ($parent_is_open_active ? 'is-open' : '') . '">';
            foreach ($child_terms as $child) :
                $child_link = get_term_link($child);
                echo '<li>';
                $child_active = ($active_term_id > 0 && absint($child->term_id) === $active_term_id);
                $child_class = 'group relative inline-block font-body font-normal text-[18px] leading-[20px] text-[#525252] hover:text-[#FD4338] no-underline hover:underline transition-all duration-300 pl-0 hover:pl-6';
                if ($child_active) {
                    $child_class .= ' text-[#FD4338] pl-6 underline';
                }
                echo '<a href="'. esc_url($child_link) .'" class="'. $child_class .'">';
                $child_svg_class = 'absolute left-0 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-200';
                if ($child_active) {
                    $child_svg_class .= ' opacity-100';
                }
                echo '<svg class="'. esc_attr($child_svg_class) .'"
                        width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M2.26562 2.47461H13.407V13.9366" stroke="#FD4338"/>
                        <path d="M13.3351 2.54785L2.33789 13.8615" stroke="#FD4338"/>
                      </svg>';
                echo esc_html($child->name);
                echo '</a>';
                echo '</li>';
            endforeach;
            echo '</ul>';
        }
        echo '</li>';
    endforeach;
    echo '</ul>';
endif; ?>

   </div>
</aside>