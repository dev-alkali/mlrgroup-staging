<?php get_header() ?>
<main id="content" class="bg-white w-full  relative is-work-page">
  <section class="w-full pt-10 md:pt-[60px] px-4 md:px-10">
  <div class="flex flex-col md:flex-row items-start gap-[20px] md:gap-10 w-full wrapper mx-auto max-[768px]:border-b border-[#CCCCCC] max-[768]:pb-[28px]">
     <div class="md:border-b border-[#CCCCCC] md:pb-[20px] md:mb-[10px] w-full md:w-[220px] lg:w-[280px] xl:w-[380px]">
      <div class="search-form-parent mb-[20px]" data-term="0">
        <form action="<?php echo esc_url(home_url('/work/')); ?>" method="get" role="search" class="relative">
          <input type="text" name="s_portfolio" autocomplete="off" placeholder="Search Our Portfolio" value="<?php echo esc_attr(isset($_GET['s_portfolio']) ? sanitize_text_field(wp_unslash($_GET['s_portfolio'])) : ''); ?>" class="border-b border-[#cccc] w-full py-[5px]">
          <button type="submit" aria-label="Search" class="search-submit absolute right-0 bottom-[10px]">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
              <circle cx="7.75" cy="7.75" r="6.25" stroke="#FD4338" stroke-width="1.5"/>
              <path d="M12.5 12.5L16.5 16.5" stroke="#FD4338" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            <span class="sr-only">Search</span>
          </button>
        </form>
      </div>
      <p class="text-[#525252] font-[Poppins] font-medium text-[16px] leading-[24px] md:text-[16px] md:leading-[24px]">Get inspired: Browse our portfolio, filter by category, add elements you like to your Inquiry List.</p>
     </div>
     <div class="flex items-center justify-end max-[768px]:ml-auto md:w-full">
        <button type="button" id="view-inquery-list" class="btn-primary relative inline-flex items-center gap-2 cursor-pointer pt-[9.5px] px-[20px] pb-[6.5px] md:pt-[16px] md:px-[25px] md:pb-[15px]" aria-label="View inquiry list, 3 items">
          <div class="inline-flex items-center gap-2 justify-center">
              <div class="relative w-[17px] h-4 mt-[-2px]">
                  <img src="<?= esc_url(get_template_directory_uri() . '/assets/imgs/Arrow-white-large.svg'); ?>" alt="arrow">
              </div>
              <span class="font-heading font-semibold text-white text-sm md:text-base tracking-[0] leading-7 whitespace-nowrap">VIEW INQUIRY LIST</span>
          </div>
          <span aria-label="3 items in list" class="inline-flex items-center justify-center w-[26px] h-[26px] absolute -top-2 -right-2 md:-top-1 md:-right-1 bg-black rounded-full">
              <span class="inquiry-list-quantity font-heading font-normal text-white text-[14px] md:text-[16px] text-center leading-none mb-[-1px]" aria-hidden="true">0</span>
          </span>
      </button>
    </div>
  </div>
</section>

  <section
    id="work-list"
    class="w-full flex flex-col items-center gap-10 md:gap-[60px] pt-10 md:pt-[0px] pb-16 md:pb-[60px] bg-white px-4 md:px-10"
    aria-label="Portfolio gallery">
    <div class="flex flex-col md:flex-row items-start gap-6 md:gap-10 w-full wrapper">
      <?php get_template_part('template-parts/portfolio/sidebar'); ?>

      <?php get_template_part('template-parts/portfolio/content-grid'); ?>
    </div>
  </section>
  <!-- ===================== CTA SECTION ===================== -->

  <?php if (have_rows('cta_portfolio', 'option')) :  while (have_rows('cta_portfolio', 'option')) : the_row(); ?>
      <section id="cta-block_ea44063c95ea7a4325cd10b208f2f7541" class="c-cta flex c-cta w-full bg-black py-12 md:py-17 xl:py-25 px-4 sm:px-10">
        <div class="c-cta__wrap flex flex-col align-center w-full gap-[40px] wrapper mx-auto">
          <div class="c-cta__content max-w-[850px] gap-5 flex flex-col">
            <h2 class="flex flex-col align-start c-cta__title font-heading text-white text-[clamp(36px,5vw,68px)] leading-[clamp(44px,5.5vw,78px)] tracking-[-0.02em]">
              <span class="font-bold"><?= wp_kses_post(get_sub_field('title_row_1')) ?></span>
              <span class="font-bold"><?= wp_kses_post(get_sub_field('title_row_2')) ?></span>
            </h2>
            <p class="max-w-[685px] w-full text-[18px]  min-[600px]:text-xl leading-[26px] min-[600px]:leading-7 text-gray-50 font-body pb-[10px]"><?= wp_kses_post(get_sub_field('description')) ?></p>
            <div class="c-cta__buttons-wrap flex flex-col gap-[22px] max-w-[277px]"><a class="c-cta__button btn-primary" href="<?= wp_kses_post(get_sub_field('btn_path')) ?>" target="_self"><?= wp_kses_post(get_sub_field('btn_label')) ?></a></div>
          </div>         
        </div>
      </section>
  <?php endwhile; endif; ?>
</main>

<?php get_template_part('template-parts/portfolio/popup-inquiry'); ?>
<?php get_footer() ?>