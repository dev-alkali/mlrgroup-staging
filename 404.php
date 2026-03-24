<?php


get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title text-[#262626] text-[clamp(96px,18vw,300px)] leading-[clamp(96px,18vw,300px)] tracking-[-0.02em] text-center">404 <span class="text-accent text-[clamp(64px,12vw,200px)] leading-[clamp(96px,18vw,300px)]">.</span></h1>
			</header><!-- .page-header -->

			<div class="flex flex-col items-center justify-center gap-4">
				<p class="text-[#525252] text-[clamp(18px,2.2vw,24px)] leading-[clamp(26px,2.8vw,32px)] tracking-[-0.02em] text-center">Sorry, we can’t find that page. But don’t worry, if you follow <a href="<?php echo home_url(); ?>" class="text-accent">this link</a> <br> we can get you back to the homepage in no time.</p>
			</div>
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
