<?php
/**
 * Single Blog Post template.
 */
get_header();
?>

<main class="overflow-hidden">
  <section class="px-4 md:px-10 pt-[40px] md:pt-[80px] xl:pt-[120px] pb-[60px] lg:pb-[60px]">
    <div class="wrapper">
      <?php while (have_posts()) : the_post(); ?>
        <p class="font-body font-normal text-[18px] leading-[28px] tracking-[0] text-[#525252] mb-[10px]">
          <?php echo esc_html(get_the_date()); ?>
        </p>

        <h1 class="font-heading font-bold max-w-[1125px] text-[clamp(34px,5vw,56px)] leading-[1.1] tracking-[-0.02em] text-[#262626]">
          <?php the_title(); ?>
        </h1>

        <?php if (has_post_thumbnail()) : ?>
          <div class="mt-[28px] overflow-hidden">
            <div class="aspect-[16/9] bg-[#F5F5F5]">
              <?php the_post_thumbnail('full', ['class' => 'w-full h-full object-cover']); ?>
            </div>
          </div>
        <?php endif; ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('md:pt-[120px] pt-[60px] xl:px-[120px] md:px-[60px] md:pb-[60px]'); ?> >
          <div class="">
            <h2 class="font-heading font-bold text-[clamp(28px,4vw,40px)] leading-[clamp(36px,4.5vw,48px)] tracking-[-2%] text-[#262626]">Summary:</h2>       
          </div>
          <div class="blog-content">
            <?php the_content(); ?>
          </div>

          <?php
            $categories = get_the_category();
            $tags       = get_the_tags();
          ?>

          <?php if (!empty($categories)) : ?>
            <div class="mt-[28px]">
              <p class="font-heading font-semibold text-[#262626] mb-[10px]"><?php esc_html_e('Categories', 'mrl-site'); ?></p>
              <div class="flex flex-wrap gap-[8px]">
                <?php foreach ($categories as $cat) : ?>
                  <a
                    href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
                    class="inline-flex items-center rounded-full border border-[#525252] px-[17px] py-[5px] text-[14px] leading-[20px] text-[#525252] hover:opacity-80 transition-opacity"
                  >
                    <?php echo esc_html($cat->name); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <?php if (!empty($tags) && !is_wp_error($tags)) : ?>
            <div class="mt-[20px]">
              <p class="font-heading font-semibold text-[#262626] mb-[10px]"><?php esc_html_e('Tags', 'mrl-site'); ?></p>
              <div class="flex flex-wrap gap-[8px]">
                <?php foreach ($tags as $tag) : ?>
                  <a
                    href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                    class="inline-flex items-center rounded-full border border-[#CFCFCF] px-[17px] py-[5px] text-[14px] leading-[20px] text-[#525252] hover:opacity-80 transition-opacity"
                  >
                    <?php echo esc_html($tag->name); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
        </article>
      <?php endwhile; ?>
    </div>
  </section>

  <?php get_template_part('template-parts/cta/cta'); ?>
</main>

<?php get_footer(); ?>
