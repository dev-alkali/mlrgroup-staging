<?php

/**
 * Services Block Template.
 */

$id = 'services-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'services';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>

<?php if (have_rows('services')) :  while (have_rows('services')) : the_row(); ?>
<?php 
$section_background = get_sub_field('section_background');

$bg_class = '';
if ($section_background === 'Black') {
    $bg_class = 'bg-black';
} elseif ($section_background === 'White') {
    $bg_class = 'bg-white';
}
?>

<?php 
$card_overlay = get_sub_field('card_overlay');

$overlay_class = '';

if ($card_overlay === 'Grayscale') {
    $overlay_class = 'overlay-grayscale';
} elseif ($card_overlay === 'Pink Gradient') {
    $overlay_class = 'overlay-pink-gradient';
}

$select_3_column_grid = get_sub_field('select_3_column_grid');

$wrapper_class = $select_3_column_grid
    ? "grid grid-cols-1 min-[600px]:grid-cols-2 min-[1440px]:grid-cols-3 gap-4 min-[600px]:gap-2 self-stretch w-full"
    : "flex items-center justify-center max-[1440px]:flex-wrap gap-4 min-[600px]:gap-2 self-stretch w-full";

$article_class = $select_3_column_grid
    ? "source-card max-[600px]:h-[380px] max-[1440px]:h-[420px] w-full min-[1440px]:aspect-[334/420] relative overflow-hidden"
    : "source-card max-[600px]:h-[380px] max-[1440px]:h-[420px] w-full min-[1440px]:aspect-[334/420] max-[1440px]:max-w-[49%] max-[768px]:max-w-[100%] relative overflow-hidden";
?>






<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className . ' ' . $bg_class); ?> <?php echo esc_attr($overlay_class); ?> flex w-full justify-center px-4 min-[600px]:px-10 py-[60px] min-[600px]:py-[120px]">      
      <?php if (have_rows('header_content')) :  while (have_rows('header_content')) : the_row(); ?>

          <div class="flex flex-col  items-center gap-8 min-[600px]:gap-[60px] w-full max-w-[1920px]">
            <div class="flex flex-col min-[1023px]:flex-row min-[1023px]:items-center  gap-[50px] self-stretch w-full">
              <?php if (have_rows('title_group')) :  while (have_rows('title_group')) : the_row(); 
                    $title1 = get_sub_field('title_row_1');
                    $title2 = get_sub_field('title_row_2');
              ?>
                 <?php if ($title1 || $title2) : ?>
                  <div class="serve-heading">
                    <h2 class="max-w-[426px] w-full text-[44px] flex flex-col min-[600px]:text-[54px] min-[767px]:text-[68px] tracking-[-2%] leading-[56px] min-[600px]:leading-[64px] min-[767px]:leading-[78px] font-heading">
                      <span class="font-bold text-neutral-800"><?= wp_kses_post($title1) ?></span>
                      <span class="font-light text-neutral-500"><?= wp_kses_post($title2) ?></span>
                    </h2>
                  </div>

                <?php endif; ?>

              <?php endwhile;
              endif; ?>

              <div class="flex flex-col items-start gap-8 flex-1 serve-content">
                <?php if (get_sub_field('subtitle')) : ?>
                <p class="max-w-[526px] text-xl leading-7 text-neutral-600 font-body">
                  <?= wp_kses_post(get_sub_field('subtitle')) ?>
                </p>
                <?php endif; ?>
                <?php 
                  $btn_path = get_sub_field('btn_path');
                  $btn_label = get_sub_field('btn_label');
                ?>
                <?php if ($btn_label) : ?>
                  <a href="<?= esc_url($btn_path) ?>" class="btn-primary max-[767px]:hidden"><?= wp_kses_post($btn_label) ?></a>
                <?php endif; ?>
              </div>

            </div>
        <?php endwhile;
      endif; ?>

        <?php if (have_rows('main_content')) :  while (have_rows('main_content')) : the_row(); ?>

            <div class="<?= esc_attr($wrapper_class) ?>">
              <?php if (have_rows('services')) :  while (have_rows('services')) : the_row(); ?>
                  <?php if (have_rows('service')) :  while (have_rows('service')) : the_row(); ?>
                      <article class="<?= esc_attr($article_class) ?>">
                        <div class="bg-image absolute inset-0" style=" background-image: url('<?php echo esc_url(get_sub_field('image')); ?>'); background-position: center center; background-size: cover; background-repeat: no-repeat; filter: grayscale(100%); ">
                        </div>           
                        <a href="<?= esc_url(get_sub_field('link_path')) ?>" class="gradient-box absolute flex flex-col flex-1 justify-between px-5 min-[600px]:px-6 py-7 w-full h-full">
                          <img class="arrow absolute w-10 z-10" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow.svg" alt="" />
                          <div class="flex flex-col gap-3 min-[600px]:gap-4 content z-10">
                            <h3 class="text-white card-title"><?= wp_kses_post(get_sub_field('title')) ?></h3>
                            <p class="text-white text-[16px] min-[600px]:text-lg leading-[26px] min-[600px]:leading-7 font-body"><?= wp_kses_post(get_sub_field('paragraph')) ?></p>
                          </div>
                        </a>
                      </article>

                  <?php endwhile;
                  endif; ?>
              <?php endwhile;
              endif; ?>
            </div>

        <?php endwhile;
        endif; ?>
        <?php if (have_rows('header_content')) :  while (have_rows('header_content')) : the_row(); ?>
            <div class="min-[767px]:hidden max-w-[358px] min-[600px]:max-w-[334px] w-full flex justify-center">

              <a href="<?= esc_url(get_sub_field('btn_path')) ?>" class="btn-primary "><?= wp_kses_post(get_sub_field('btn_label')) ?></a>
            </div>

        <?php endwhile;
        endif; ?>
          </div>
    </section>
<?php endwhile;
endif; ?>