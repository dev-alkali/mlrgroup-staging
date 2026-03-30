<?php get_header() ?>
<main id="content" class="bg-white w-full  relative overflow-hidden">

  <?php if (have_rows('hero_portfolio', 'option')) :  while (have_rows('hero_portfolio', 'option')) : the_row(); ?>

      <section id="" class="w-full px-4 min-[600px]:px-10 min-[767px]:px-20 lg:px-[100px] bg-center bg-cover bg-no-repeat bg-[rgba(0,0,0,0.5)] bg-blend-overlay" style="  background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>');
    background-position: 50% 38%;
    background-size: cover;
    background-repeat: no-repeat;">
      <div class="gap-10 w-full wrapper min-h-screen md:min-h-[670px] pt-[80px] md:pt-[118px] pb-[80px] md:pb-[60px] flex items-end !px-0 ">
        <div class="max-w-[800px]">
          
          <h2 class="text-[clamp(44px,6vw,70px)] leading-[clamp(56px,7vw,88px)] tracking-[-0.02em] text-white font-heading anim" data-delay="0.1" data-anim="up">            
            <?php if(get_sub_field('title_row_1')): ?>
                <span class="font-bold"><?= wp_kses_post(get_sub_field('title_row_1')) ?></span>
            <?php endif; ?>
            <?php if(get_sub_field('title_row_2')): ?>
                <span class="font-light"><?= wp_kses_post(get_sub_field('title_row_2')) ?> </span>
            <?php endif; ?>
          </h2>
          
          <?php if(get_sub_field('paragraph')): ?>
            <p class="w-full text-[clamp(18px,3vw,20px)] leading-[28px] text-gray-50 font-body anim mt-[12px]" data-delay="1.2" data-anim="up" data-start="top 100%"><?= wp_kses_post(get_sub_field('paragraph')) ?></p>
          <?php endif; ?>
        </div>
      </div>
    </section>

<?php endwhile;
  endif; ?>

  <section class="w-full flex flex-col items-center gap-10 md:gap-[60px] pt-10 md:pt-[60px] px-4 md:px-10">
  <div class="flex flex-col md:flex-row items-start gap-[20px] md:gap-10 w-full max-w-[1920px] mx-auto max-[768px]:border-b border-[#CCCCCC] max-[768]:pb-[28px]">
     <div class="md:border-b border-[#CCCCCC] md:pb-[20px] md:mb-[10px] w-full md:w-[220px] lg:w-[280px] xl:w-[380px]">
      <p class="text-[#525252] font-[Poppins] font-medium text-[16px] leading-[24px] md:text-[16px] md:leading-[24px]">Get inspired: Browse our portfolio, filter by category, add elements you like to your Inquiry List.</p>
     </div>
     <div class="flex items-center justify-end w-full">
        <button type="button" id="view-inquery-list" class="btn-primary relative inline-flex items-center gap-2 cursor-pointer" aria-label="View inquiry list, 3 items">
          <div class="inline-flex items-center gap-2 justify-center">
              <div class="relative w-[17px] h-4 mt-[-2px]">
                  <img src="<?= esc_url(get_template_directory_uri() . '/assets/imgs/Arrow-white-large.svg'); ?>" alt="arrow">
              </div>
              <span class="font-heading font-semibold text-white text-sm md:text-base tracking-[0] leading-7 whitespace-nowrap">
                  VIEW INQUIRY LIST
              </span>
          </div>
          <span aria-label="3 items in list" class="inline-flex items-center justify-center w-[26px] h-[26px] absolute -top-1 -right-1 bg-black rounded-full">
              <span class="inquiry-list-quantity font-heading font-normal text-white text-[16px] text-center leading-none mb-[-1px]" aria-hidden="true">
                  0
              </span>
          </span>
      </button>
    </div>
  </div>
</section>

  <section
    class="w-full flex flex-col items-center gap-10 md:gap-[60px] pt-10 md:pt-[60px] pb-16 md:pb-[120px] bg-white px-4 md:px-10"
    aria-label="Portfolio gallery">
    <div class="flex flex-col md:flex-row items-start gap-6 md:gap-10 w-full max-w-[1920px] mx-auto">
      <?php get_template_part('template-parts/portfolio/sidebar'); ?>

      <?php get_template_part('template-parts/portfolio/content-grid'); ?>
    </div>
  </section>
  <!-- ===================== CTA SECTION ===================== -->

  <?php if (have_rows('cta_portfolio', 'option')) :  while (have_rows('cta_portfolio', 'option')) : the_row(); ?>

      <section
        class=" flex w-full h-[700px] min-[600px]:h-[855px] "
        style="
    background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>');
    background-position: 50% 38%;
    background-size: cover;
    background-repeat: no-repeat;
  ">
        <div class="flex flex-col items-center w-full h-full justify-end gap-[40px] min-[600px]:gap-[100px] min-[767px]:gap-[162px] pl-4 min-[600px]:pl-10 min-[767px]:pl-[140px] pr-4 min-[600px]:pr-10 min-[767px]:pr-20 pt-10 pb-[60px] min-[600px]:pb-[100px] [background:linear-gradient(222deg,rgba(0,0,0,0)_4.72%,rgba(0,0,0,1)_79.68%)]">

          <div class="flex flex-col items-start gap-10 min-[600px]:gap-[60px] w-full max-w-[1920px]">
            <div class="flex flex-col items-start gap-5 w-full">
              <h2 class="max-w-[622px] w-full text-[44px] tracking-[-2%] min-[767px]:text-[65px] min-[1024px]:text-[80px] leading-[50px] min-[767px]:leading-[65px] min-[1024px]:leading-[92px] text-white font-heading">
                <span class="font-bold"> <?= wp_kses_post(get_sub_field('title_row_1')) ?> </span>
                <span class="font-light"> <?= wp_kses_post(get_sub_field('title_row_2')) ?></span>
              </h2>
              <p class="max-w-[622px] w-full text-[18px]  min-[767px]:text-xl leading-[26px] min-[767px]:leading-7 text-gray-50 font-body">
                <?= wp_kses_post(get_sub_field('description')) ?>
              </p>
            </div>

            <a href=" <?= wp_kses_post(get_sub_field('btn_path')) ?>" class="btn-primary"> <?= wp_kses_post(get_sub_field('btn_label')) ?></a>
          </div>
        </div>

      </section>
  <?php endwhile;
  endif; ?>
</main>


<?php get_template_part('template-parts/portfolio/popup-inquiry'); ?>
<?php get_footer() ?>