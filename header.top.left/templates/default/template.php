<div class="header-block_main">
	<a href="/" class="header-block_logo">
		<img src="<?= SITE_TEMPLATE_PATH ?>/img/logo_main.png"><? /**/ ?>
	</a>
	<div class="header-block_main-links">
		<a href="/catalog/" class="header-block_link catalog-btn" onclick="return false;">
			<span>Медицинское оборудование</span>
			<i class="fas fa-angle-down"></i>
		</a>
		<a href="/acksii/" class="header-block_link count-link">
			<span>Акции</span>
			<span class="bl-count"><?=$arResult['COUNT']?></span></a>
	</div>
	<div class="header-block_mob-btn" id="headerMobBtn"><span></span></div>
</div>
