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

  <section
    class="w-full flex flex-col items-center gap-10 md:gap-[60px] pt-10 md:pt-[60px] pb-16 md:pb-[120px] bg-white px-4 md:px-10"
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