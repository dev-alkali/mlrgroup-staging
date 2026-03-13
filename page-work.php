<?php get_header() ?>
<main id="content" class="bg-white w-full  relative overflow-hidden">
  <section
    class="relative w-full min-h-[420px] md:min-h-[560px] lg:min-h-[670px] flex flex-col [background:linear-gradient(0deg,rgba(0,0,0,0.35)_0%,rgba(0,0,0,0.35)_100%),url(https://c.animaapp.com/mmlwst9rMkgLKu/img/hero.png)_50%_50%_/_cover]">
    <div class="flex flex-col items-start justify-end h-full pt-6 pb-10 md:pt-8 md:pb-14 lg:pb-16 px-5 sm:px-8 md:px-12 lg:px-20 gap-10 md:gap-16 lg:gap-[162px] flex-1">

      <!-- Hero Content -->
      <div class="flex flex-col w-full max-w-4xl items-start justify-center gap-6 md:gap-10">
        <div class="flex flex-col items-start justify-center gap-4 md:gap-5 w-full">
          <h1 class="font-heading font-normal text-white text-[clamp(2.5rem,7vw,4.375rem)] tracking-[-0.02em] leading-[1.2] m-0">
            <strong class="font-bold">Portfolio <br /></strong>
            <span class="font-light">of Work</span>
          </h1>
          <p class="font-body font-normal text-gray-50 text-base md:text-lg lg:text-xl tracking-[0] leading-7 max-w-[45rem] m-0">
            Lorem ipsum dolor sit amet consectetur. Purus enim id odio turpis nisl. Lorem ipsum dolor sit amet
            consectetur. Purus enim id odio turpis nisl.
          </p>
        </div>
      </div>
    </div>
  </section>
  <section
    class="w-full flex flex-col items-center gap-10 md:gap-[60px] px-4 sm:px-6 md:px-8 lg:px-10 pt-10 md:pt-[60px] pb-16 md:pb-[120px] bg-white"
    aria-label="Portfolio gallery">
    <div class="flex flex-col lg:flex-row items-start gap-6 lg:gap-10 w-full max-w-[1360px] mx-auto">
      <!-- Mobile Filter Toggle -->
      <div class="flex items-center justify-between w-full lg:hidden">
        <span class="font-heading font-semibold text-neutral-700 text-base">Filter by Category</span>
        <button
          id="filter-toggle"
          type="button"
          aria-expanded="false"
          aria-controls="sidebar-filter"
          class="inline-flex items-center gap-2 px-4 py-2 bg-[#fd4338] text-white rounded-[30px] font-heading font-semibold text-sm cursor-pointer border-0 hover:opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#fd4338] transition-opacity">
          Filters
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="4" y1="6" x2="20" y2="6" />
            <line x1="8" y1="12" x2="16" y2="12" />
            <line x1="11" y1="18" x2="13" y2="18" />
          </svg>
        </button>
      </div>
      <!-- Sidebar Filter -->
      <?php
      // Define o nome da sua custom taxonomy
      $taxonomy = 'portfolio-category';

      // Pega apenas as categorias principais (parent = 0)
      $parent_terms = get_terms(array(
        'taxonomy'   => $taxonomy,
        'parent'     => 0,
        'hide_empty' => false, // Mude para false se quiser mostrar categorias vazias
      ));

      ?>

      <aside id="sidebar-filter" class="hidden lg:flex flex-col w-full lg:w-[280px] xl:w-[320px] flex-shrink-0 items-start gap-4 bg-white" aria-label="Filter categories">

        <div class="items-center gap-2 px-5 py-3 self-stretch w-full flex-[0_0_auto] flex relative cursor-pointer">
          <div class="flex items-center gap-2 relative flex-1 grow">
            <span class="relative flex-1 mt-[-1.00px] font-heading font-medium text-neutral-700 text-lg tracking-[0] leading-7">
              All Industries
            </span>
          </div>
        </div>

        <?php
        // Loop pelas Categorias Principais
        if (! empty($parent_terms) && ! is_wp_error($parent_terms)) :
          foreach ($parent_terms as $parent) :

            // Pega as subcategorias do termo pai atual
            $child_terms = get_terms(array(
              'taxonomy'   => $taxonomy,
              'child_of'   => $parent->term_id,
              'hide_empty' => false,
            ));
            $parent_link = get_term_link($parent);
            // Verifica se tem subcategorias para renderizar o layout "Expandido" ou "Simples"
            if (! empty($child_terms) && ! is_wp_error($child_terms)) :

        ?>
              <div class="flex flex-col items-start gap-2 pt-0 pb-4 px-0 relative self-stretch w-full flex-[0_0_auto] bg-white-1">
                <div class="flex items-center justify-between px-5 py-3 relative self-stretch w-full flex-[0_0_auto] bg-white-1 cursor-pointer">
                  <div class="flex items-center gap-2 relative flex-1 grow">
                    <!-- text-[#fd4338]   underline-->
                    <a href="<?= $parent_link ?>" class="relative w-fit mt-[-1.00px] font-heading font-medium text-lg tracking-[0] leading-7">
                      <?php echo esc_html($parent->name); ?>
                    </a>
                  </div>
                  <img class="relative w-[18px] h-[18px] rotate-180" alt="" src="<?= get_template_directory_uri() ?>/assets/imgs/arrow-down-black.svg" />
                </div>

                <fieldset class="flex flex-col items-start gap-7 pl-5 pr-3 py-0 relative self-stretch w-full flex-[0_0_auto] border-0 m-0 p-0">
                  <legend class="sr-only"><?php echo esc_html($parent->name); ?> sub-categories</legend>

                  <?php foreach ($child_terms as $child) :
                    $child_link = get_term_link($child);
                  ?>

                    <label class="flex items-center gap-2 relative self-stretch w-full flex-[0_0_auto] cursor-pointer">

                      <a href="<?= $child_link ?>" class="relative w-fit mt-[-1.00px] font-body font-normal text-neutral-600 text-lg tracking-[0] leading-5 whitespace-nowrap">
                        <?php echo esc_html($child->name); ?>
                      </a>
                    </label>
                  <?php endforeach; ?>

                </fieldset>
              </div>

            <?php else : ?>

              <div class="flex items-center justify-between px-5 py-3 relative self-stretch w-full flex-[0_0_auto] bg-white-1 cursor-pointer">
                <a href="<?= $parent_link ?>" class="relative flex-1 mt-[-1.00px] font-heading font-medium text-neutral-700 text-lg tracking-[0] leading-7">
                  <?php echo esc_html($parent->name); ?>
                </a>
                <img class="relative w-[18px] h-[18px] rotate-90" alt="" src="<?= get_template_directory_uri() ?>/assets/imgs/arrow-down-black.svg" />
              </div>

        <?php
            endif; // Fim da verificação de filhos
          endforeach; // Fim do loop de pais
        endif;
        ?>

      </aside>
      <!-- Main Content Area -->

      <div class="flex flex-col items-start gap-5 flex-1 min-w-0 justify-center">
        <!-- Inquiry List Button -->
        <div class="flex items-center justify-end w-full">
          <button
            type="button"
            class="relative inline-flex items-center gap-2 px-5 md:px-6 py-3 md:py-4 bg-[#fd4338] rounded-[30px] cursor-pointer border-0 hover:opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#fd4338] transition-opacity"
            aria-label="View inquiry list, 3 items">
            <div class="inline-flex items-center gap-2 justify-center">
              <div class="relative w-[17px] h-4">
                <img class="absolute w-[69.63%] h-[71.64%] top-[12.34%] left-[14.15%]" alt="" />
                <img class="absolute w-[68.73%] h-[70.71%] top-[13.68%] left-[12.56%]" alt="" />
              </div>
              <span class="font-heading font-semibold text-white text-sm md:text-base tracking-[0] leading-7 whitespace-nowrap">
                VIEW INQUIRY LIST
              </span>
            </div>
            <span
              aria-label="3 items in list"
              class="inline-flex items-center justify-center w-6 h-6 absolute -top-2 -right-2 bg-black rounded-full">
              <span class="font-heading font-normal text-white text-xs text-center leading-none" aria-hidden="true">
                3
              </span>
            </span>
          </button>
        </div>
        <!-- Gallery Grid -->
        <div class="flex flex-col items-center justify-center gap-10 md:gap-[60px] w-full">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3  w-full">

            <?php

            $args = array(
              'post_type'      => 'portfolio',
              'posts_per_page' => -1,
              'post_status'    => 'publish'
            );

            // 2. Faça a consulta
            $meu_query = new WP_Query($args);

            // 3. Inicie o Loop
            if ($meu_query->have_posts()) :
              while ($meu_query->have_posts()) : $meu_query->the_post(); ?>
                <article class="gallery-card group flex flex-col items-start gap-3">
                  <?php
                  $imagem_url = "";
                  if (has_post_thumbnail()) {
                    // Pega a URL do tamanho original ('full'). Você pode trocar por 'medium', 'large', etc.
                    $imagem_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                  }
                  ?>
                  <div class="card-image-wrap relative overflow-hidden h-[220px] sm:h-[280px] lg:h-[360px] w-full " style="
    background-image: url('<?= $imagem_url !== "" ? $imagem_url : "";  ?>');
    background-position: 50% 50%;
    background-size: cover;
    background-repeat: no-repeat;">
                    <!-- overlay -->
                    <div class=" card-overlay absolute inset-0 [background:linear-gradient(312deg,rgba(0,0,0,0.82)_0%,rgba(253,67,56,0.82)_100%)] opacity-0 hover:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center gap-2 px-6">
                      <button type="button" class="bg-black flex items-center justify-center gap-2 px-4 py-3 w-full rounded-[30px] cursor-pointer border-0 hover:bg-neutral-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-colors translate-y-3 card-btn-transition">
                        <span class="font-heading font-medium text-white text-xs md:text-sm tracking-[0] leading-5 whitespace-nowrap">QUICK VIEW</span>
                      </button>
                      <button type="button" class="bg-white flex items-center justify-center gap-2 px-4 py-3 w-full rounded-[30px] cursor-pointer border-0 hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#262626] transition-colors translate-y-3 card-btn-transition">
                        <span class="font-heading font-semibold text-neutral-800 text-xs md:text-sm tracking-[0] leading-5 whitespace-nowrap">ADD TO INQUIRY LIST</span>
                      </button>
                    </div>
                  </div>
                </article>

            <?php
              endwhile;
              wp_reset_postdata();
            endif;
            ?>
          </div>
          <!-- See All Link -->
          <a href="#" class="inline-flex items-center gap-2 no-underline hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#fd4338] transition-opacity rounded">
            <span
              class="font-heading font-semibold text-[#fd4338] text-base tracking-[0] leading-6 whitespace-nowrap">
              SEE ALL
            </span>
            <img class="w-4 h-4" alt="" />
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- ===================== CTA SECTION ===================== -->
  <section
    class="w-full flex flex-col items-start justify-end gap-10 md:gap-[60px] lg:gap-[162px] pt-10 md:pt-12 pb-12 md:pb-16 lg:pb-[100px] px-5 sm:px-8 md:px-12 lg:px-[140px] min-h-[400px] md:min-h-[600px] lg:min-h-[855px] [background:linear-gradient(222deg,rgba(0,0,0,0)_0%,rgba(0,0,0,1)_100%),url(https://c.animaapp.com/mmlwst9rMkgLKu/img/cta-sect.png)_50%_50%_/_cover]"
    aria-label="Call to action">
    <div class="flex flex-col w-full max-w-[1360px] items-start gap-8 md:gap-[60px]">
      <div class="flex flex-col items-start justify-center gap-4 md:gap-5 w-full">
        <h2 class="font-heading font-normal text-white text-[clamp(2rem,6vw,5rem)] tracking-[-0.02em] leading-[1.1] m-0 max-w-[40rem]">
          <strong class="font-bold">A Marketing Partner That </strong>
          <span class="font-light">Moves With You</span>
        </h2>
        <p class="font-body font-normal text-gray-50   text-base md:text-lg lg:text-xl tracking-[0] leading-7 max-w-[40rem] m-0">
          We work as an extension of your team, bringing the expertise and responsiveness needed to turn ambitious
          ideas into real-world impact.
        </p>
      </div>
      <button
        type="button"
        class="all-[unset] box-border inline-flex items-center justify-center gap-2 px-7 py-3 md:px-8 md:py-4 bg-accent rounded-[30px] cursor-pointer whitespace-nowrap hover:opacity-90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-white transition-opacity">
        <span class="font-heading font-semibold text-white text-sm md:text-base text-center tracking-[0] leading-[18px]">
          LET'S GET STARTED
        </span>
      </button>
    </div>
  </section>
</main>
<section class="pup-up flex justify-center items-center w-full h-screen fixed top-0 bg-[#000000CC] backdrop-blur-[20px]  z-50">
  <div id="inquiry-empty-pop-up" class="bg-white hidden max-w-[600px]   flex-col p-10">
    <div class="w-full flex justify-end mb-[28px]">
      <img src="<?= get_template_directory_uri() ?>/assets/imgs/close-pop-up.svg" alt="exit">
    </div>
    <div class="flex flex-col items-center gap-5 px-[54px] py-[72px] border border-neutral-300 mb-20">
      <img src="<?= get_template_directory_uri() ?>/assets/imgs/clipboard.svg" alt="clipboard">
      <div class="flex flex-col items-center gap-3 ">
        <h2>Your Inquiry List is empty</h2>
        <p class="text-center">You currently have no item in the Inquiry List. Expand an image and add it into your inquiry list</p>
      </div>
    </div>
    <button class="btn-primary">
      <img src="<?= get_template_directory_uri() ?>/assets/imgs/plus.svg" alt="plus"> Add to Your Inquiry List
    </button>
  </div>


  <div id="inquiry-pop-up" class="bg-white  max-w-[1200px] w-full flex flex-col p-10 text-neutral-800">
    <section id="normal-content" class="hidden flex-col w-full ">
      <div class="mb-4">
        <div class=" flex justify-between w-full mb-3">
          <h2 class="text-[28px] leading-[36px] tracking-[-2%] font-heading font-bold ">818 Tequila Bottle Shaped Pool Floatie</h2>
          <img src="<?= get_template_directory_uri() ?>/assets/imgs/close-pop-up.svg" alt="exit">
        </div>
        <div class="categories">
          <span class="border border-neutral-600 font-heading text-[16px] text-neutral-600 leading-[24px] px-4 pt-[7px] pb-[5px] rounded-full">Custom Displays</span>
          <span class="border border-neutral-600 font-heading text-[16px] leading-[24px] px-4 pt-[7px] pb-[5px] rounded-full">Brands</span>
        </div>
      </div>
      <div class="flex">
        <section class="w-1/2 flex flex-col gap-10">
          <img class="w-full max-h-[546px] h-full object-cover object-center" src="<?= get_template_directory_uri() ?>/assets/imgs/e27ce88a280d11dbe816c2c00903b5d7d8d82e4b.jpg" alt="">
          <div class="flex gap-2">
            <button class="btn-primary w-full mb-[2px]"><img class="w-[13px]" src="<?= get_template_directory_uri() ?>/assets/imgs/plus.svg" alt="i">Add to Your Inquiry List</button>
            <img class="w-[20px]" src="<?= get_template_directory_uri() ?>/assets/imgs/icon.svg" alt="i">
          </div>
        </section>
        <section class="w-1/2">

        </section>
      </div>
    </section>
    <section id="list-content" class="flex flex-col w-full ">
      <div class="mb-4">
        <div class=" flex justify-between w-full mb-7">
          <h2 class="text-[28px] leading-[36px] tracking-[-2%] font-heading font-bold">818 Tequila Bottle Shaped Pool Floatie</h2>
          <img src="<?= get_template_directory_uri() ?>/assets/imgs/close-pop-up.svg" alt="exit">
        </div>

      </div>
      <div class="flex gap-[60px]">
        <section class="w-full flex flex-col gap-8">
          <div class="w-full flex flex-col gap-6 pb-6">
            <article class="flex items-center gap-2 ">
              <div class="flex gap-3 items-center flex-1">
                <img class="w-[66px] h-[66px] object-cover object-center" src="<?= get_template_directory_uri() ?>/assets/imgs/e27ce88a280d11dbe816c2c00903b5d7d8d82e4b.jpg" alt="">
                <p class="font-heading font-medium flex-1">818 Tequila Bottle Shaped Pool Floatie</p>
              </div>
              <span class="font-heading underline text-[14px] leading-[16px] uppercase">Remove</span>
            </article>
            <div class="line h-px bg-neutral-300 w-full"></div>
            <article class="flex items-center gap-2 ">
              <div class="flex gap-3 items-center flex-1">
                <img class="w-[66px] h-[66px] object-cover object-center" src="<?= get_template_directory_uri() ?>/assets/imgs/e27ce88a280d11dbe816c2c00903b5d7d8d82e4b.jpg" alt="">
                <p class="font-heading font-medium flex-1">818 Tequila Bottle Shaped Pool Floatie</p>
              </div>
              <span class="font-heading underline text-[14px] leading-[16px] uppercase">Remove</span>
            </article>
            <div class="line h-px bg-neutral-300 w-full"></div>
            <article class="flex items-center gap-2 ">
              <div class="flex gap-3 items-center flex-1">
                <img class="w-[66px] h-[66px] object-cover object-center" src="<?= get_template_directory_uri() ?>/assets/imgs/e27ce88a280d11dbe816c2c00903b5d7d8d82e4b.jpg" alt="">
                <p class="font-heading font-medium flex-1">818 Tequila Bottle Shaped Pool Floatie</p>
              </div>
              <span class="font-heading underline text-[14px] leading-[16px] uppercase">Remove</span>
            </article>
          </div>
          <div class="flex gap-2">
            <button class="btn-primary w-full mb-[2px]"><img class="w-[13px]" src="<?= get_template_directory_uri() ?>/assets/imgs/plus.svg" alt="i">Add to Your Inquiry List</button>
          </div>
        </section>
        <section class="w-full">
        <?= do_shortcode('[gravityform id="2" title="false" description="false" ajax="true"]'); ?> 
        </section>
      </div>
    </section>
  </div>
</section>
<?php get_footer() ?>