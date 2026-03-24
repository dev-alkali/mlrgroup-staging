<?php


get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found lg:py-[200px] md:py-[140px] py-[80px]">
			<header class="page-header">
				<h1 class="page-title text-[#262626] font-heading text-[clamp(96px,18vw,300px)] leading-[clamp(96px,18vw,300px)] tracking-[-0.02em] text-center font-bold">404<span class="text-accent text-[clamp(64px,12vw,200px)] leading-[clamp(96px,18vw,300px)]">.</span></h1>
			</header><!-- .page-header -->

			
			<div class="flex relative items-center justify-center">
				<div class="absolute top-0 left-0 w-1/2 h-full bg-repeat-x img-position-left" style="background-image: url('<?= get_template_directory_uri() ?>/assets/imgs/404-arrow-imgs-3.svg');"></div>
				<div class="absolute top-0 right-0 w-1/2 h-full bg-repeat-x img-position-right" style="background-image: url('<?= get_template_directory_uri() ?>/assets/imgs/404-arrow-imgs-3.svg');"></div>
				<p class="text-[#525252] text-[clamp(18px,2.2vw,24px)] leading-[clamp(26px,2.8vw,32px)] tracking-[-0.02em] text-center font-heading font-medium bg-white relative px-[10px]">Sorry, we can’t find that page. But don’t worry, if you follow <a href="<?= home_url() ?>" class="text-accent underline">this link</a></p>
			</div>
			<div class="flex relative items-center justify-center">
				<div class="absolute top-0 left-0 w-1/2 h-full bg-repeat-x img-position-left" style="background-image: url('<?= get_template_directory_uri() ?>/assets/imgs/404-arrow-imgs-04.svg');"></div>
				<div class="absolute top-0 right-0 w-1/2 h-full bg-repeat-x img-position-right" style="background-image: url('<?= get_template_directory_uri() ?>/assets/imgs/404-arrow-imgs-04.svg');"></div>
				<p class="text-[#525252] text-[clamp(18px,2.2vw,24px)] leading-[clamp(26px,2.8vw,32px)] tracking-[-0.02em] text-center font-heading font-medium bg-white relative px-[10px]">we can get you back to the homepage in no time.</p>
			</div>
			
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
