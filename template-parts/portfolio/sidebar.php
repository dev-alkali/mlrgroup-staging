<?php
$taxonomy       = 'portfolio-category';
$current_term   = get_queried_object();
$active_term_id = (isset($current_term->term_id) && $current_term->term_id) ? absint($current_term->term_id) : 0;
$active_ancestor_ids = $active_term_id > 0
    ? array_map('absint', get_ancestors($active_term_id, $taxonomy, 'taxonomy'))
    : array();

// Read curated filter groups from ACF Options
$filter_groups = get_field('portfolio_filter_groups', 'option');
?>

<aside id="sidebar-filter" class="flex flex-col w-full md:w-[220px] lg:w-[280px] xl:w-[360px] flex-shrink-0 gap-4 mt-[25px]" aria-label="Filter categories">
   <div class="flex justify-between items-center w-full mb-[15px]">
     <h3 class="font-[Poppins] font-medium text-[24px] leading-[32px] tracking-[-0.02em] text-[#262626] filter-heading">Filters</h3>
     <a href="/work/" class="hidden md:inline-block font-[Poppins] font-medium text-[16px] leading-[24px] text-[#525252] underline hover:no-underline hover:text-accent transition-colors">Reset</a>
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

       <?php if (!empty($filter_groups)) : ?>
          <ul class="space-y-[28px]">
            <?php foreach ($filter_groups as $group) :
              $parent_text = !empty($group['parent_text']) ? $group['parent_text'] : '';
              $parent      = $group['parent_category'];
              $children    = !empty($group['child_categories']) ? $group['child_categories'] : array();
              $has_children = !empty($children);

              // If no alternate text, we need a valid taxonomy term to render
              if (empty($parent_text) && (empty($parent) || is_wp_error($parent))) continue;

              $parent_id          = (!empty($parent) && !is_wp_error($parent)) ? absint($parent->term_id) : 0;
              $parent_link        = ($parent_id > 0) ? get_term_link($parent) : '';
              $parent_active      = ($parent_id > 0 && $active_term_id === $parent_id);
              $parent_is_ancestor = ($parent_id > 0 && in_array($parent_id, $active_ancestor_ids, true));
              $is_open            = $parent_active || $parent_is_ancestor;

              $label_class = 'font-[Poppins] font-bold text-[18px] leading-[28px] text-[#262626] no-underline transition-colors';
              if (!$parent_text) {
                $label_class .= ' hover:text-[#FD4338]';
                if ($is_open) $label_class .= ' text-[#FD4338]';
              }
            ?>
              <li class="<?php echo $has_children ? 'has-child' : ''; ?>">
                <div class="flex items-start justify-between space-y-[28px]">

                  <?php if ($parent_text) : ?>
                    <span class="<?php echo esc_attr($label_class); ?>">
                      <?php echo esc_html($parent_text); ?>
                    </span>
                  <?php else :
                    if (is_wp_error($parent_link)) continue;
                    if (!$has_children) {
                      $label_class = 'group relative inline-block font-body font-normal text-[18px] leading-[20px] text-[#525252] hover:text-[#FD4338] no-underline hover:underline transition-all duration-300 pl-0 hover:pl-6';
                      if ($parent_active) $label_class .= ' text-[#FD4338] pl-6 underline';
                    }
                  ?>
                    <a href="<?php echo esc_url($parent_link); ?>" class="<?php echo esc_attr($label_class); ?>">
                      <?php if (!$has_children) :
                        $p_svg_class = 'absolute left-0 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-200';
                        if ($parent_active) $p_svg_class .= ' opacity-100';
                      ?>
                        <svg class="<?php echo esc_attr($p_svg_class); ?>" width="16" height="16" viewBox="0 0 16 16" fill="none">
                          <path d="M2.26562 2.47461H13.407V13.9366" stroke="#FD4338"/>
                          <path d="M13.3351 2.54785L2.33789 13.8615" stroke="#FD4338"/>
                        </svg>
                      <?php endif; ?>
                      <?php echo esc_html($parent->name); ?>
                    </a>
                  <?php endif; ?>

                  <?php if ($has_children) :
                    $arrow_class = 'arrow cursor-pointer ml-2 transition-transform duration-300 mt-[9px]' . ($is_open ? '' : ' rotate-180');
                  ?>
                    <span class="<?php echo esc_attr($arrow_class); ?>" data-toggle>
                      <svg width="14" height="9" viewBox="0 0 14 9" fill="none">
                        <path d="M6.75 0.00019455L13.5 6.7502L11.925 8.3252L6.75 3.15019L1.575 8.3252L0 6.7502L6.75 0.00019455Z" fill="#525252"/>
                      </svg>
                    </span>
                  <?php endif; ?>
                </div>

                <?php if ($has_children) : ?>
                  <ul class="child-list space-y-[28px] overflow-hidden transition-all duration-300 pl-0 pr-[20px] <?php echo $is_open ? 'is-open' : ''; ?>">
                    <?php foreach ($children as $child) :
                      if (empty($child) || is_wp_error($child)) continue;
                      $child_id   = absint($child->term_id);
                      $child_link = get_term_link($child);
                      if (is_wp_error($child_link)) continue;
                      $child_active = ($active_term_id === $child_id);
                      $c_class = 'group relative inline-block font-body font-normal text-[18px] leading-[20px] text-[#525252] hover:text-[#FD4338] no-underline hover:underline transition-all duration-300 pl-0 hover:pl-6';
                      if ($child_active) $c_class .= ' text-[#FD4338] pl-6 underline';
                      $c_svg_class = 'absolute left-0 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-200';
                      if ($child_active) $c_svg_class .= ' opacity-100';
                    ?>
                      <li>
                        <div class="flex items-start justify-between space-y-[28px]">
                          <a href="<?php echo esc_url($child_link); ?>" class="<?php echo esc_attr($c_class); ?>">
                            <svg class="<?php echo esc_attr($c_svg_class); ?>" width="16" height="16" viewBox="0 0 16 16" fill="none">
                              <path d="M2.26562 2.47461H13.407V13.9366" stroke="#FD4338"/>
                              <path d="M13.3351 2.54785L2.33789 13.8615" stroke="#FD4338"/>
                            </svg>
                            <?php echo esc_html($child->name); ?>
                          </a>
                        </div>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

   </div>
</aside>