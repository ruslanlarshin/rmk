<?//echo '<pre>'; print_r($arParams); echo "</pre>"; ?>
 <div class="catalog-view_offer">
	<?if($arParams['PRICE']>0){?>
		<div class="offer-price"><?if($arParams['PRICE_FROM']=='Y'){?>от <?}?><?=number_format($arParams['PRICE'], 0, ',', ' ')?> ₽</div>
	<?}else{?>
		<div class="offer-price">По запросу</div>
	<?}?>
	<div class="offer-btn">
		<a rel="nofollow" href="#modal-order-product" data-id="<?=$arParams['ID'];?>" data-name="<?=$arParams['NAME'];?>" class="btn" data-toggle="modal" onclick="ym(47745763,'reachGoal','click_cart_kp'); return true;">Получить КП</a>
	</div>

	<div class="offer-link">
		<a onclick="ym(47745763,'reachGoal','click_cart_allkp'); return true;" href="#modal-order-product" data-id="<?=$arParams['ID'];?>" data-name="<?=$arParams['NAME'];?>"  data-toggle="modal" data-seller = "all" >Запросить КП всех продавцов</a>
	</div>

	<div class="offer-list">
		<div class="list-item">
			<div class="item-icon"><img src="/bitrix/templates/romza_upro_1.1.72/img/block-price_list-ico-1.png"></div>
			<p><b>В наличии</b> со склада</p>
		</div>
		<div class="list-item">
			<div class="item-icon"><img src="/bitrix/templates/romza_upro_1.1.72/img/block-price_list-ico-2.png"></div>
			<p><b>От 12 месяцев</b> гарантии</p>
		</div>
		<div class="list-item">
			<div class="item-icon"><img src="/bitrix/templates/romza_upro_1.1.72/img/block-price_list-ico-3.png"></div>
			<p>Ввод в эксплуатацию <br>и обучение персонала</p>
		</div>
		<div class="list-item">
			<div class="item-icon"><img src="/bitrix/templates/romza_upro_1.1.72/img/block-price_list-ico-4.png"></div>
			<p>Лизинг. Рассрочка. Trade-in</p>
		</div>
	</div>
</div>