<?//echo '<pre>'; print_r($arResult); echo '</pre>';?>
<div class="catalog-listing_filter request_filter" data-filter='<?=$arResult['REQUEST_FILTER']?>'>
	<form name="_form" action="/catalog/ultrazvukovye-skanery/filter/clear/apply/?TESTS=Y" class="catalog-filter" id="catalog-filter" method="get" data-ajax="eyJDTVAiOiJiaXRyaXg6Y2F0YWxvZy5zbWFydC5maWx0ZXIiLCJQQUdFIjoiXC9jYXRhbG9nXC91bHRyYXp2dWtvdnllLXNrYW5lcnlcL2ZpbHRlclwvY2xlYXJcL2FwcGx5XC8/VEVTVFM9WSIsIlRNUEwiOiJjYXRhbG9nX25ldyIsIklEIjoic2VjdGlvbl9maWx0ZXI3In0=">
		<input type="hidden" name="TESTS" value="Y">
		<div class="catalog-filter_block">
			<div class="catalog-filter_list">
				<?
				$id=1;
				foreach($arResult['GROUPE'] as $key=>$item){
					?>
					<div class="catalog-filter_item"> 
						<div class="item-title" data-target="#<?=$arResult['GROUPE'][$key]['CODE']?>"><?=$arResult['GROUPE'][$key]['NAME']?></div>
							<div class="item-list collapse  filter_items_<?=$arResult['GROUPE'][$key]['CODE']?>" data-code="<?=$arResult['GROUPE'][$key]['CODE']?>" id="#<?=$arResult['GROUPE'][$key]['CODE']?>">
								<?foreach($arResult['GROUPE'][$key]['SORT'] as $key3=>$key2){
									//echo '<pre>'; print_r($key2); echo '</pre>'; 
									$item2=$arResult['ITEM'][$arResult['GROUPE'][$key]['CODE']][$key2];?>
									<?$checked=''; if($arResult['FILTER_VIEW'][$key][$key2]=='Y'){ $checked='checked';}?>
									<?$disabled=''; if(!$item2['CNT_NEW']){ $disabled='disabled';}
									if(!$item2['CNT_NEW'])$item2['CNT_NEW']=0;?>
									<label class='label_<?=$disabled?>'>
										<input type="checkbox" <?=$checked?> <?=$disabled?> class='filter_checkbox' data-code="<?=$key2?>" data-parent="<?=$arResult['GROUPE'][$key]['CODE']?>"  name="arrFilter_<?=$id?>" value="Y"><?$id++;?>
										<i></i>
										<span><?=$item2['NAME']?> [ <?=$item2['CNT_NEW']?> ]</span>
									</label>	
								<?}?>
							</div>
					</div>
				<?}?>
			</div>
			<input type="hidden" name="set_filter" value="Y">
			<a style="position: absolute;top: -9999px;left: -9999px;" href="<?=$_SERVER['SCRIPT_URL']?>filter/clear/apply/" class="filter-submit btn btn-lg btn-primary">Показать</a>
			<div class="catalog-filter_btn">
				<a href="javascript:;" data-url="<?=$_SERVER['SCRIPT_URL']?>" class="btn-link">Сбросить все</a>
				<button type="submit" class="btn-bordered">Применить</button>
			</div>
			<div class="catalog-filter_mob-heading">
				<div class="mob-heading_title">Фильтры</div>
				<a href="javascript:;" data-url="<?=$_SERVER['SCRIPT_URL']?>" class="btn-link">Сбросить все</a>
				<div class="mob-heading_close" id="filterClose"></div>
			</div>
		</div>
	</form>
</div>
<style>
.label_disabled{
	color: grey;
}
</style>