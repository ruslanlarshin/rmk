<div class="catalog-view_heading-rating">
	<?if($arParams['RATING']>0 && $arParams['RATING']<=5){?>
		<?for($i=1;$i<6;$i++){?>
			<?if($i<=$arParams['RATING']){?>
				<i class="star-full"></i>
			<?}else{?>
				<i></i>
			<?}?>
		<?}?>
	<?}?>
</div>