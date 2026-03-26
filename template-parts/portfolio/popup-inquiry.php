<section class="pop-up hidden justify-center items-center w-full h-screen fixed top-0 bg-[#000000CC] backdrop-blur-[20px] z-50 p-[30px]">
   <div id="inquiry-empty-pop-up" class="bg-white hidden max-w-[600px] flex-col p-10 overflow-auto max-h-[90vh]">
      <div class="w-full flex justify-end mb-[28px]">
         <img class="close" src="<?= get_template_directory_uri() ?>/assets/imgs/close-pop-up.svg" alt="exit">
      </div>
      <div class="flex flex-col items-center gap-5 px-[54px] py-[72px] border border-neutral-300 mb-20">
         <img src="<?= get_template_directory_uri() ?>/assets/imgs/clipboard.svg" alt="clipboard">
         <div class="flex flex-col items-center gap-3 ">
            <h2 class="font-heading font-bold text-[28px] leading-9 tracking-[-2%] text-neutral-800">Your Inquiry List is empty</h2>
            <p class="text-center font-body text-base leading-6 tracking-[0%] text-neutral-600">You currently have no item in the Inquiry List. Expand an image and add it into your inquiry list</p>
         </div>
      </div>
      <button class="btn-primary">
         <img src="<?= get_template_directory_uri() ?>/assets/imgs/plus.svg" alt="plus"> Add to Your Inquiry List
      </button>
   </div>

   <div id="inquiry-pop-up" class="bg-white max-w-[1200px] w-full hidden flex-col p-10 text-neutral-800 overflow-auto max-h-[90vh]">
      <section id="normal-content" class="hidden flex-col w-full ">
         <div class="mb-4">
            <div class=" flex justify-between w-full mb-3">
               <h2 class="inquiry-title text-[28px] leading-[36px] tracking-[-2%] font-heading font-bold "></h2>
               <img class="close cursor-pointer" src="<?= get_template_directory_uri() ?>/assets/imgs/close-pop-up.svg" alt="exit">
            </div>
            <div class="inquiry-categories">
            </div>
         </div>
         <div class="flex flex-col md:flex-row gap-[40px] md:gap-[60px]">
            <section class="w-full flex flex-col gap-10">
               <img class="inquiry-img w-full max-h-[546px] h-full object-cover object-center" src="" alt="">
               <div class="flex justify-end gap-2">
                  <button item-id="" class="add-inquiry btn-primary w-full mb-[2px]"><img class="w-[13px]" src="<?= get_template_directory_uri() ?>/assets/imgs/plus.svg" alt="i">Add to Your Inquiry List</button>

                  <div class="relative group flex items-center justify-center">
                     <img class="w-[20px] cursor-pointer" src="<?= get_template_directory_uri() ?>/assets/imgs/icon.svg" alt="i">

                     <div class="absolute bottom-[calc(100%+12px)] right-[-10px] w-[300px] p-5 bg-white shadow-[0_4px_20px_rgba(0,0,0,0.15)] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">

                        <div class="inquiry-content-tooltip text-[#555] text-[18px] leading-snug"></div>

                        <div class="absolute top-full right-[14px] -mt-[1px] w-0 h-0 border-l-[10px] border-l-transparent border-r-[10px] border-r-transparent border-t-[10px] border-t-white drop-shadow-md"></div>
                     </div>
                  </div>
               </div>
            </section>
            <section id="inquiry-normal-form" class="w-full">
               <?= do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]'); ?>
            </section>
         </div>
      </section>
      <section id="list-content" class="hidden flex-col w-full ">
         <div class="mb-4">
            <div class=" flex justify-between w-full mb-7">
               <h2 class="text-[28px] leading-[36px] tracking-[-2%] font-heading font-bold">Your Inquiry List</h2>
               <img class="close cursor-pointer" src="<?= get_template_directory_uri() ?>/assets/imgs/close-pop-up.svg" alt="exit">
            </div>
         </div>
         <div class="flex flex-col md:flex-row gap-[40px] md:gap-[60px]">
            <section class="w-full flex flex-col gap-8">
               <div id="inquiry-list-content" class="w-full flex flex-col gap-6 pb-6">
               </div>
               <div class="flex gap-2">
                  <button id="add-more-to-list" class="btn-primary w-full mb-[2px]"><img class="w-[13px]" src="<?= get_template_directory_uri() ?>/assets/imgs/plus.svg" alt="plus">Add More to Your Inquiry List</button>
               </div>
            </section>
            <section id="inquiry-list-form" class="w-full">
               <?= do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]'); ?>
            </section>
         </div>
      </section>
   </div>
</section>