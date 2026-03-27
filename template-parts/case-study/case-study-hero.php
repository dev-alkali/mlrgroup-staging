<?php
/**
 * Case Studies Archive Hero Section.
 */
if (have_rows('hero_case_study', 'option')) : while (have_rows('hero_case_study', 'option')) : the_row();
  $title_row_1 = get_sub_field('case_study_title_row1');
  $title_row_2 = get_sub_field('case_study_title_row2');
  $description = get_sub_field('case_study_content');
  $bg_desktop_img = get_sub_field('case_study_bg_image');
  $bg_mobile_image = get_sub_field('case_study_bg_mobile_image');
?>
    <section class="case-study-hero w-full px-4 min-[600px]:px-10 min-[767px]:px-20 lg:px-[100px] bg-center bg-cover bg-no-repeat bg-[rgba(0,0,0,0.5)] bg-blend-overlay" style="--bg-desktop: url('<?php echo esc_url($bg_desktop_img); ?>');<?php if($bg_mobile_image): ?>--bg-mobile: url('<?php echo esc_url($bg_mobile_image); ?>');<?php endif; ?>">
      <div class="gap-10 w-full wrapper min-h-screen md:min-h-[670px] pt-[80px] md:pt-[118px] pb-[80px] md:pb-[60px] flex items-end !px-0">
        <div class="max-w-[980px]">
          <?php if ($title_row_1 || $title_row_2): ?>
          <h2 class="text-[clamp(44px,6vw,70px)] leading-[clamp(56px,7vw,88px)] tracking-[-0.02em] text-white font-heading anim" data-delay="0.1" data-anim="up">
            <?php if ($title_row_1): ?>
              <span class="font-bold"><?= wp_kses_post($title_row_1) ?></span>
            <?php endif; ?>
            <?php if ($title_row_2): ?>
              <span class="font-light"><?= wp_kses_post($title_row_2) ?></span>
            <?php endif; ?>
          </h2>
          <?php endif; ?>

          <?php if ($description): ?>
            <p class="w-full text-[clamp(18px,3vw,20px)] leading-[28px] text-gray-50 font-body anim max-w-[630px]" data-delay="1.2" data-anim="up" data-start="top 100%"><?= wp_kses_post($description) ?></p>
          <?php endif; ?>

          <?php
          $link = get_sub_field('button');
          if ($link):
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
          ?>
            <a class="btn-primary mt-[20px] md:mt-[40px] anim" data-delay="2" data-anim="up" data-start="top 100%" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
          <?php endif; ?>
        </div>
      </div>
    </section>

<style>
  .case-study-hero {
    background-image: var(--bg-desktop);
  }
  <?php if($bg_mobile_image): ?>
    @media(max-width: 767px) {
      .case-study-hero {
        background-image: var(--bg-mobile);
      }
    }
  <?php endif; ?>
</style>
<?php endwhile; endif; ?>