<?php
$taxonomy = 'portfolio-category';
$current_term = get_queried_object();

$parent_terms = get_terms(array(
   'taxonomy'   => $taxonomy,
   'parent'     => 0,
   'hide_empty' => false,
   'orderby'    => 'term_id',
   'order'      => 'DESC',
));
?>

<aside id="sidebar-filter" class="hidden lg:flex flex-col w-full lg:w-[280px] xl:w-[360px] flex-shrink-0 items-start gap-4 bg-white" aria-label="Filter categories">
   <div class="border-b border-[#CCCCCC] pb-[24px] mb-[24px]">
      <p class="text-[#525252] font-[Poppins] font-medium text-[16px] leading-[24px] md:text-[16px] md:leading-[24px]">Get inspired: Browse our portfolio, filter by category, add elements you like to your Inquiry List.</p>
   </div>

   <div class="flex justify-between items-center w-full">
     <h3 class="font-[Poppins] font-medium text-[24px] leading-[32px] tracking-[-0.02em] text-[#262626]">Filters</h3>
     <a href="javascript:void(0);" class="font-[Poppins] font-medium text-[16px] leading-[24px] text-[#525252] underline hover:no-underline hover:text-accent transition-colors">Reset</a>
   </div>

   <div class="sidebar-cat">

      <div class="items-center gap-2 px-5 py-3 self-stretch w-full flex-[0_0_auto] flex relative cursor-pointer">
         <div class="flex items-center gap-2 relative flex-1 grow">
            <a href="<?php echo esc_url(home_url('/work')); ?>" class="relative flex-1 font-heading font-medium text-neutral-700 text-lg tracking-[0] leading-7">
               All Industries
            </a>
         </div>
      </div>

     <?php
if (!empty($parent_terms) && !is_wp_error($parent_terms)) :

    echo '<ul>';

    foreach ($parent_terms as $parent) :

        // ✅ FIX: use parent instead of child_of
        $child_terms = get_terms([
            'taxonomy'   => $taxonomy,
            'parent'     => $parent->term_id,
            'hide_empty' => false,
            'orderby'    => 'term_id',
            'order'      => 'DESC',
        ]);

        $parent_link = get_term_link($parent);

        // Active check
        $is_active = (isset($current_term->term_id) && $current_term->term_id === $parent->term_id);

        // Check if any child is active
        $is_child_active = false;
        if (!empty($child_terms)) {
            foreach ($child_terms as $child) {
                if (isset($current_term->term_id) && $current_term->term_id === $child->term_id) {
                    $is_child_active = true;
                    break;
                }
            }
        }

        $has_child = !empty($child_terms);

        echo '<li class="'. ($has_child ? 'has-child' : '') .'">';

        // Parent link
        echo '<a href="'. esc_url($parent_link) .'" class="'. ($is_active ? 'text-accent underline' : 'text-neutral-700') .'">';
        echo esc_html($parent->name);
        echo '</a>';

        // Arrow
        if ($has_child) {
            echo '<span class="arrow"></span>';

            echo '<ul class="'. ($is_child_active ? 'block' : 'hidden') .'">';

            foreach ($child_terms as $child) :

                $child_link = get_term_link($child);
                $child_active = (isset($current_term->term_id) && $current_term->term_id === $child->term_id);

                echo '<li>';

                echo '<a href="'. esc_url($child_link) .'" class="'. ($child_active ? 'text-accent underline' : 'text-neutral-600') .'">';
                echo esc_html($child->name);
                echo '</a>';

                echo '</li>';

            endforeach;

            echo '</ul>';
        }

        echo '</li>';

    endforeach;

    echo '</ul>';

endif;
?>




      <?php
function render_taxonomy_tree($taxonomy, $parent = 0, $current_term = null) {

    $terms = get_terms([
        'taxonomy'   => $taxonomy,
        'parent'     => $parent,
        'hide_empty' => false,
        'orderby'    => 'term_id',
        'order'      => 'DESC',
    ]);

    if (!empty($terms) && !is_wp_error($terms)) {
        echo '<ul>';

        foreach ($terms as $term) {

            $term_link = get_term_link($term);

            // Check active
            $is_active = (isset($current_term->term_id) && $current_term->term_id === $term->term_id);

            // Check children
            $children = get_terms([
                'taxonomy'   => $taxonomy,
                'parent'     => $term->term_id,
                'hide_empty' => false,
            ]);

            $has_child = !empty($children) && !is_wp_error($children);

            echo '<li class="'. ($has_child ? 'has-child' : '') .'">';

            // Link
            echo '<a href="'. esc_url($term_link) .'" class="'. ($is_active ? 'active text-accent underline' : '') .'">';
            echo esc_html($term->name);
            echo '</a>';

            // Arrow if child
            if ($has_child) {
                echo '<span class="arrow"></span>';

                // Recursive call for children
                render_taxonomy_tree($taxonomy, $term->term_id, $current_term);
            }

            echo '</li>';
        }

        echo '</ul>';
    }
}
?>


   </div>
</aside>