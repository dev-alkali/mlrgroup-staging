<?php get_header() ?>
<main id="content" class="bg-white w-full  relative overflow-hidden">

  <?php if (have_rows('hero_portfolio', 'option')) :  while (have_rows('hero_portfolio', 'option')) : the_row(); ?>
      <section
        class="relative w-full" style="
    background-image: url('<?php echo esc_url(get_sub_field('bg_image')); ?>');
    background-position: 50% 38%;
    background-size: cover;
    background-repeat: no-repeat;
  ">
        <div class="w-full min-h-[420px] md:min-h-[560px] lg:min-h-[670px] flex flex-col [background:linear-gradient(0deg,rgba(0,0,0,0.35)_0%,rgba(0,0,0,0.35)_100%)]">
          <div class="flex flex-col items-center justify-end h-full pt-6 pb-10 md:pt-8 md:pb-14 lg:pb-15 px-5 sm:px-8 md:px-12 lg:px-20 gap-10 md:gap-16 lg:gap-[162px] flex-1">

            <!-- Hero Content -->
            <div class="flex flex-col w-full  items-start justify-center gap-6 md:gap-10 max-w-[1920px]">
              <div class="flex flex-col max-w-4xl items-start justify-center gap-4 md:gap-5 w-full">
                <h1 class="font-heading  text-white text-[70px] tracking-[-2%] leading-[88px] m-0">
                  <strong class="font-bold"><?= wp_kses_post(get_sub_field('title_row_1')) ?> </strong>
                  <span class="font-light"><?= wp_kses_post(get_sub_field('title_row_2')) ?> </span>
                </h1>
                <p class="font-body font-normal text-gray-50 text-base md:text-lg lg:text-xl tracking-[0] leading-7 max-w-[45rem] m-0">
                  <?= wp_kses_post(get_sub_field('paragraph')) ?>
                </p>
              </div>
            </div>
          </div>
        </div>

      </section>
  <?php endwhile;
  endif; ?>
  <section
    class="w-full flex flex-col items-center  gap-10 md:gap-[60px]  pt-10 md:pt-[60px] pb-16 md:pb-[120px] bg-white"
    aria-label="Portfolio gallery">
    <div class="flex flex-col lg:flex-row items-start gap-6 lg:gap-10 w-full max-w-[1920px] mx-auto">
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