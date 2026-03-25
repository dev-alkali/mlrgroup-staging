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
     <a href="javascript:void(0);" class="font-[Poppins] font-medium text-[16px] leading-[24px] text-[#525252] underline">Reset</a>
   </div>


   <div class="items-center gap-2 px-5 py-3 self-stretch w-full flex-[0_0_auto] flex relative cursor-pointer">
      <div class="flex items-center gap-2 relative flex-1 grow">
         <a href="<?php echo esc_url(home_url('/work')); ?>" class="relative flex-1 font-heading font-medium text-neutral-700 text-lg tracking-[0] leading-7">
            All Industries
         </a>
      </div>
   </div>

   <?php
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
   endif;
   ?>
</aside>