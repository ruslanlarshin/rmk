 <div class="catalog-view_similar">
	<h2 class="similar-title">Похожие товары</h2>
	<div class="similar-list">
		<? foreach($arResult['ITEMS'] as &$arItem){ 
		$i++;
		$count++;
		?>
		 <? $arItem['CAN_BUY'] = $arItem['PROPERTIES']['CAN_BUY']['VALUE'] === 'Да' ?>
		<div class="catalog-list_item">
			<div class="item-inner">
				<div class="item-labels">
					<?if ($arItem['PROPERTIES']['AKCIYA']['VALUE']=='Y'){?>
						<span class="red-l">%</span>
					<?}?>
					<?if ($arItem['PROPERTIES']['HIT']['VALUE']=='Y'){?>
						<span class="blue-l">ХИТ</span>
					<?}?>
				</div>
				<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="item-img">
					<img src="<?= $arItem['GALLERY'][0]['SRC'] ?>" alt="<?= $arResult['NAME'].' '.$arItem['NAME'] ?>">
				</a>
				<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="item-title">
					<?if (strlen($arItem['PROPERTIES']['list_anchor']['VALUE'])>0){
						?>
							<?= $arItem['PROPERTIES']['list_anchor']['VALUE'] ?><br>
						<?                            
						}?>
					<?= $arItem['NAME'] ?></a><?
					if($CHARACTERISTICS){?>
						<div class="item-text">
							<ul><?
								foreach ($arItem['PROPERTIES']['CHARACTERISTICS']['VALUE'] as $key => $value) {?>
									<li><?=strip_tags($value)?></li><?
								}?>
							</ul>
						</div><?
					} else {
						$sentences = explode(".", $arItem['PREVIEW_TEXT']);
						$str="";
						foreach($sentences as $value) {
							if(!strlen(trim($value))){ continue; }
							$str.=str_replace(".","",$value).".";
							if (strlen($str)>300){ break; }
						}?>
						<!--noindex--><p class="item-text"><?=strip_tags($str);?></p><!--/noindex--><?
					}?>
				<?
				if(!$arItem['PROPERTIES']['rating']['VALUE']){
					$arItem['PROPERTIES']['rating']['VALUE']=4;
				}
				?>
				<div class="item-rating">
					<?
					for ($i=0; $i <round($arItem['PROPERTIES']['rating']['VALUE'])*1 ; $i++) {
						?>
						<i class="star-full"></i>
						<?
					}
					$k=5-round($arItem['PROPERTIES']['rating']['VALUE'])*1;
					for ($i=0; $i < $k; $i++) {
						?>
						<i></i>
						<?
					}
					?>
					
				</div>
				<p class="item-available">
					<i class="fas fa-check"></i><b><?= $arItem['CAN_BUY'] ? GetMessage('RZ_ITEM_IN_STOCK') : GetMessage('RZ_ITEM_FOR_ORDER') ?></b> 
					<?if($arItem['PROPERTIES']['DATE']['VALUE']){?>(от <?=$arItem['PROPERTIES']['DATE']['VALUE']?>)<?}?>
				</p>
				<div class="item-btn">
					<a href="#" class="btn btn-bordered" data-toggle="modal" data-id="<?= $arItem['ID'] ?>"
					data-name="<?= $arItem['NAME'] ?>"
					data-target="#modal-order-product">Получить КП</a>
				</div>
				<p class="item-delivery">
					<?
					if(true){
						foreach($arItem['PROPERTIES']['SELLER']['VALUE'] as $key=>$seller){
							$res = CIBlockElement::GetList([],["IBLOCK_ID"=>55, "ID"=>$seller],false,false,["NAME"])->GetNext();
							if(!$res) { continue; }
							if($key>0) { ?><br><? }
							?><b><?=$res['NAME']?></b>, <?=$arItem['PROPERTIES']['BOT_DELIVERY']['VALUE']?:"Доставка со склада в Москве"?><?
						}
					} else {
						/*$comp = 'РМК';/**/
						$comp = '';
						
						if($arItem['PROPERTIES']['SELLER']['VALUE'][0]>0){
							$res = CIBlockElement::GetByID($arItem['PROPERTIES']['SELLER']['VALUE'][0]);
							if($ar_res = $res->GetNext())
							  $comp = $ar_res['NAME'];
						}
						if($comp) {
							if (strlen($arItem['PROPERTIES']['BOT_DELIVERY']['VALUE'])>0){?>
								<b><?=$comp?></b>, <?=$arItem['PROPERTIES']['BOT_DELIVERY']['VALUE']?><?
							}else{?>
								<b><?=$comp?></b>, Доставка со склада в Москве<?
							}
						}
					}?>
				</p>
			</div>
		</div>
		<? }?>
       
	</div>
</div>