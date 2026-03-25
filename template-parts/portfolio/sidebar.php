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

   <div class="flex justify-between items-center w-full mb-[28px]">
     <h3 class="font-[Poppins] font-medium text-[24px] leading-[32px] tracking-[-0.02em] text-[#262626] filter-heading">Filters</h3>
     <a href="javascript:void(0);" class="font-[Poppins] font-medium text-[16px] leading-[24px] text-[#525252] underline hover:no-underline hover:text-accent transition-colors">Reset</a>
     <div class="filter-toggle-btn">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
      </div>
   </div>

   <div class="sidebar-cat w-full">
      <div class="pb-[28px]">
            <a href="<?php echo esc_url(home_url('/work')); ?>" class="group relative inline-block font-body font-normal text-[18px] leading-[20px] text-[#525252] hover:text-[#FD4338] no-underline transition-all duration-300 pl-0 hover:pl-6">
               <svg class="absolute left-0 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-200" width="16" height="16" viewBox="0 0 16 16" fill="none">
                 <path d="M2.26562 2.47461H13.407V13.9366" stroke="#FD4338"/>
                 <path d="M13.3351 2.54785L2.33789 13.8615" stroke="#FD4338"/>
               </svg> All Industries </a>
      </div>

      <?php /*
      if (! empty($parent_terms) && ! is_wp_error($parent_terms)) :
         foreach ($parent_terms as $parent) :
            $child_terms = get_terms(array(
               'taxonomy'   => $taxonomy,
               'child_of'   => $parent->term_id,
               'hide_empty' => false,
               'orderby'    => 'term_id',
               'order'      => 'DESC',
            ));

            $parent_link = get_term_link($parent);

            $is_active_accordion = false;
            if (isset($current_term->term_id)) {
               if ($current_term->term_id === $parent->term_id) {
                  $is_active_accordion = true;
               } elseif (! empty($child_terms)) {
                  foreach ($child_terms as $child) {
                     if ($current_term->term_id === $child->term_id) {
                        $is_active_accordion = true;
                        break;
                     }
                  }
               }
            }

            $parent_active_class = (isset($current_term->term_id) && $current_term->term_id === $parent->term_id) ? 'text-[#fd4338] underline' : 'text-neutral-700';

            $accordion_content_class = $is_active_accordion ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]';
            $accordion_icon_class    = $is_active_accordion ? 'rotate-180' : 'rotate-90';

            if (! empty($child_terms) && ! is_wp_error($child_terms)) :
      ?>
               <div class="group flex flex-col items-start pt-0 px-0 relative self-stretch w-full flex-[0_0_auto] bg-white-1">
                  <div class="flex items-center justify-between px-5 py-3 relative self-stretch w-full flex-[0_0_auto] bg-white-1 cursor-pointer select-none">
                     <div class="flex items-center gap-2 relative flex-1 grow">
                        <a href="<?= $parent_link ?>" class="relative flex-1 mt-[-1.00px] hover:text-accent hover:underline transition-colors font-heading font-medium <?= $parent_active_class ?> text-lg tracking-[0] leading-7">
                           <?php echo esc_html($parent->name); ?>
                        </a>
                     </div>
                     <img class="transition-transform duration-300 relative w-[18px] h-[18px] mt-[-2px] <?= $accordion_icon_class ?> group-hover:rotate-180" alt="" src="<?= get_template_directory_uri() ?>/assets/imgs/arrow-down-black.svg" />
                  </div>

                  <div class="grid <?= $accordion_content_class ?> group-hover:grid-rows-[1fr] transition-all duration-300 overflow-hidden self-stretch w-full">
                     <fieldset class="min-h-0 flex flex-col items-start gap-7 pl-5 pr-3 py-0 relative self-stretch w-full flex-[0_0_auto] border-0 m-0 p-0">
                        <legend class="sr-only"><?php echo esc_html($parent->name); ?> sub-categories</legend>
                        <div class="flex flex-col gap-7 w-full pb-3 pt-2">
                           <?php foreach ($child_terms as $child) :
                              $child_link = get_term_link($child);
                              $child_active_class = (isset($current_term->term_id) && $current_term->term_id === $child->term_id) ? 'text-accent underline' : 'text-neutral-600';
                           ?>
                              <label class="ml-5 flex items-center gap-2 relative self-stretch w-full flex-[0_0_auto] cursor-pointer ">
                                 <a href="<?= $child_link ?>" class="relative w-fit mt-[-1.00px] font-body font-normal <?= $child_active_class ?> hover:text-accent hover:underline transition-colors text-lg tracking-[0] leading-5 whitespace-nowrap">
                                    <?php echo esc_html($child->name); ?>
                                 </a>
                              </label>
                           <?php endforeach; ?>
                        </div>
                     </fieldset>
                  </div>
               </div>
            <?php else : ?>
               <div class="flex items-center justify-between px-5 py-3 relative self-stretch w-full flex-[0_0_auto] bg-white-1 cursor-pointer">
                  <a href="<?= $parent_link ?>" class="relative flex-1 mt-[-1.00px] font-heading font-medium <?= $parent_active_class ?> text-lg tracking-[0] hover:text-accent hover:underline transition-colors leading-7">
                     <?php echo esc_html($parent->name); ?>
                  </a>
               </div>
      <?php
            endif;
         endforeach;
      endif; */ ?>

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

        echo '<li class="'. ($has_child ? 'has-child' : '') .'">';
         echo '<div class="flex items-start justify-between space-y-[28px]">';
        $parent_class = $has_child
            ? 'font-[Poppins] font-bold text-[18px] leading-[28px] text-[#262626] hover:text-[#FD4338] no-underline transition-colors'
            : 'group relative inline-block font-body font-normal text-[18px] leading-[20px] text-[#525252] hover:text-[#FD4338] no-underline transition-all duration-300 pl-0 hover:pl-6';

        echo '<a href="'. esc_url($parent_link) .'" class="'. $parent_class .'">';

        if (!$has_child) {
            echo '<svg class="absolute left-0 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-200" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2.26562 2.47461H13.407V13.9366" stroke="#FD4338"/><path d="M13.3351 2.54785L2.33789 13.8615" stroke="#FD4338"/></svg>';
        }

        echo esc_html($parent->name);
        echo '</a>';

        if ($has_child) {
            echo '<span class="arrow cursor-pointer ml-2 transition-transform duration-300 mt-[9px] rotate-180" data-toggle>
                    <svg width="14" height="9" viewBox="0 0 14 9" fill="none">
                        <path d="M6.75 0.00019455L13.5 6.7502L11.925 8.3252L6.75 3.15019L1.575 8.3252L0 6.7502L6.75 0.00019455Z" fill="#525252"/>
                    </svg>
                  </span>';
        }

        echo '</div>';

        if ($has_child) {
            echo '<ul class="child-list space-y-[28px] max-h-0 overflow-hidden transition-all duration-300">';
            foreach ($child_terms as $child) :
                $child_link = get_term_link($child);
                echo '<li>';
                echo '<a href="'. esc_url($child_link) .'" class="group relative inline-block font-body font-normal text-[18px] leading-[20px] text-[#525252] hover:text-[#FD4338] no-underline transition-all duration-300 pl-0 hover:pl-6">';
                echo '<svg class="absolute left-0 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-200"
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


<script>
// document.addEventListener("DOMContentLoaded", function () {

//   const toggleBtn = document.querySelector(".filter-toggle-btn");
//   const heading   = document.querySelector(".filter-heading");
//   const sidebar   = document.querySelector(".sidebar-cat");

//   // 👉 CHILD ACCORDION
//   document.querySelectorAll("[data-toggle]").forEach(function (arrow) {
//     arrow.addEventListener("click", function (e) {
//       e.preventDefault();
//       e.stopPropagation();

//       const li = arrow.closest("li");
//       const childList = li.querySelector(".child-list");

//       if (!childList) return;

//       if (childList.classList.contains("open")) {
//         childList.style.maxHeight = "0px";
//         childList.classList.remove("open");
//       } else {
//         childList.style.maxHeight = childList.scrollHeight + "px";
//         childList.classList.add("open");
//       }

//       // rotate arrow
//       arrow.classList.toggle("rotate-180");

//       // ✅ IMPORTANT: update parent height after toggle
//       if (sidebar.classList.contains("open")) {
//         sidebar.style.maxHeight = sidebar.scrollHeight + "px";
//       }
//     });
//   });

//   // 👉 SIDEBAR TOGGLE
//   function toggleFilter() {
//     toggleBtn.classList.toggle("change-btn");
//     sidebar.classList.toggle("open");

//     if (sidebar.classList.contains("open")) {
//       sidebar.style.maxHeight = sidebar.scrollHeight + "px";
//     } else {
//       sidebar.style.maxHeight = "0px";
//     }
//   }

//   toggleBtn.addEventListener("click", toggleFilter);
//   heading.addEventListener("click", toggleFilter);

// });
</script>
<style>
   .sidebar-cat,
.child-list {
  display: none;
}

.arrow {
  display: inline-flex;
  transition: transform 0.3s ease;
}
</style>