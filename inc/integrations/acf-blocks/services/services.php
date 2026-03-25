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
$select_3_column_grid = get_sub_field('select_3_column_grid');

// $wrapper_class = $select_3_column_grid
//     ? "grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-2 w-full"
//     : "grid grid-cols-[repeat(auto-fit,minmax(280px,1fr))] gap-4 md:gap-2 w-full";



// $wrapper_class = $select_3_column_grid
//     ? "grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-2 w-full [&>article:last-child:nth-child(odd)]:md:col-span-2 [&>article:last-child:nth-child(odd)]:xl:col-span-1"
//     : "grid grid-cols-[repeat(auto-fit,minmax(280px,1fr))] gap-4 md:gap-2 w-full";    

// $article_class = $select_3_column_grid
//     ? "source-card relative overflow-hidden w-full aspect-[16/15] h-[420px] xl:h-auto"
//     : "source-card relative overflow-hidden w-full aspect-[334/420] ";


// $wrapper_class = $select_3_column_grid
//     ? "grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 [&:has(>article:nth-child(2):last-child)]:xl:grid-cols-2 gap-4 md:gap-2 w-full [&>article:last-child:nth-child(odd)]:md:col-span-2 [&>article:last-child:nth-child(odd)]:xl:col-span-1"
//     : "grid grid-cols-[repeat(auto-fit,minmax(280px,1fr))] gap-4 md:gap-2 w-full";

// $article_class = $select_3_column_grid
//     ? "source-card relative overflow-hidden w-full aspect-[16/15] h-[420px] max-h-[420px] xl:h-auto"
//     : "source-card relative overflow-hidden w-full aspect-[334/420]";

$wrapper_class = $select_3_column_grid
    ? "grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-4 md:gap-2 w-full [&>article]:xl:col-span-2 [&:has(>article:nth-child(2):last-child)>article]:xl:col-span-3 [&:has(>article:nth-child(5):last-child)>article:nth-child(n+4)]:xl:col-span-3 [&>article:last-child:nth-child(odd)]:md:col-span-2"
    : "grid grid-cols-[repeat(auto-fit,minmax(280px,1fr))] min-[767px]:grid-cols-2 min-[1280px]:grid-cols-4 gap-4 md:gap-2 w-full";

$article_class = $select_3_column_grid
    ? "source-card relative overflow-hidden w-full aspect-[16/15] h-[420px] max-h-[420px] xl:h-auto"
    : "source-card relative overflow-hidden w-full aspect-[334/420]";


$width = get_sub_field('select_short_content_width');
$max_width_class = ($width === 'Full') ? '' : 'max-w-[526px]';
?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className . ' ' . $bg_class); ?> <?php echo esc_attr($overlay_class); ?> px-4 md:px-[40px] py-[60px] md:py-[120px]">      
      <?php if (have_rows('header_content')) :  while (have_rows('header_content')) : the_row(); 
      $heading_and_content = get_sub_field('heading_and_content');
      ?>

          <div class="flex flex-col items-center gap-8 md:gap-[60px] wrapper">
            <div class="flex flex-col gap-[20px] lg:gap-[50px] self-stretch w-full <?php echo $heading_and_content === 'Single Row' ? 'lg:flex-row lg:items-center' : ''; ?>">
              <?php if (have_rows('title_group')) :  while (have_rows('title_group')) : the_row(); 
                    $title1 = get_sub_field('title_row_1');
                    $title2 = get_sub_field('title_row_2');
                    ;
              ?>
                 <?php if ($title1 || $title2) : ?>
                  <div class="serve-heading">
                    <h2 class="max-w-[500px] w-full flex flex-col font-heading font-bold text-[clamp(36px,5vw,68px)] leading-[clamp(44px,6vw,78px)] tracking-[-0.02em]">
                      <span class="font-bold text-neutral-800"><?= wp_kses_post($title1) ?></span>
                      <span class="font-light text-neutral-500"><?= wp_kses_post($title2) ?></span>
                    </h2>
                  </div>

                <?php endif; ?>

              <?php endwhile;
              endif; ?>

              <div class="flex flex-col items-start gap-8 flex-1 serve-content">
                <?php if (get_sub_field('subtitle')) : ?>
                <p class="<?= $max_width_class; ?> font-body font-normal text-[#525252] text-[clamp(18px,2.2vw,20px)] leading-[clamp(26px,2.6vw,28px)]">
                  <?= wp_kses_post(get_sub_field('subtitle')) ?>
                </p>
                <?php endif; ?>
                <?php 
                  $btn_path = get_sub_field('btn_path');
                  $btn_label = get_sub_field('btn_label');
                ?>
                <?php if ($btn_label) : ?>
                  <a href="<?= esc_url($btn_path) ?>" class="btn-primary max-lg:hidden"><?= wp_kses_post($btn_label) ?></a>
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
                        <a href="<?= esc_url(get_sub_field('link_path')) ?>" class="gradient-box absolute flex flex-col flex-1 justify-between px-5 md:px-6 py-7 w-full h-full">
                          <img class="arrow absolute w-10 z-10" src="<?= get_template_directory_uri() ?>/assets/imgs/Arrow.svg" alt="" />
                          <div class="flex flex-col gap-3 md:gap-4 content z-10">
                            <h3 class="text-white card-title"><?= wp_kses_post(get_sub_field('title')) ?></h3>
                            <p class="text-white text-[16px] md:text-lg leading-[26px] md:leading-7 font-body card-text"><?= wp_kses_post(get_sub_field('paragraph')) ?></p>
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
          <?php if (get_sub_field('btn_path')) : ?>
            <div class="lg:hidden max-w-[358px] md:max-w-[334px] w-full flex justify-center">
              <a href="<?= esc_url(get_sub_field('btn_path')) ?>" class="btn-primary "><?= wp_kses_post(get_sub_field('btn_label')) ?></a>
            </div>
          <?php endif; ?>

        <?php endwhile;
        endif; ?>
          </div>
    </section>
<?php endwhile;
endif; ?>