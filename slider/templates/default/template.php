<div class="catalog-view_images" id="catalogItemImagesSlider">
    <div class="slider-gallery swiper-container">
        <div class="swiper-wrapper">
			<?$i=0;
			foreach ($arParams['GALLERY'] as $arPhoto): ?>
				<a href="<?= $arPhoto["BIG"] ?>" 
				   data-fancybox="gallery" 
				   class="swiper-slide<? if ($i == 0): ?> open-img<? endif ?>" 
				   data-num="<?=$i?>">
					<img src="<?= $arPhoto['SRC'] ?>"/>
				</a>
			<? $i++; 
		endforeach ?>
        </div>
	<div class="swiper-pagination"></div>
    </div>
    <div class="slider-thumbs"> 
        <div class="slider-arrow arrow-up"><i></i></div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <? $i=0; 
				foreach ($arParams['GALLERY'] as  $arPhoto): ?>
					<? /* <div class="gallery-thumb br7 <?= ($i == 0) ? ' active' : '' ?>">
						<img src="<?= $arPhoto['THUMB'] ?>" alt="<?= $productTitle, $i ?>">
					</div>  */ ?>
					<div class="swiper-slide<?= ($i == 0) ? ' open-img' : '' ?>" data-num="<?=$i?>"><img src="<?= $arPhoto['THUMB'] ?>" alt="<?= $arParams['TITLE'], $i ?>"/></div>
					<?$i++; 
				endforeach ?>        
            </div>
        </div>
        <div class="slider-arrow arrow-down"><i></i></div>
    </div>
</div>