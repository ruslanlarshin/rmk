<!-- Новое меню каталога -->
<div class="header_catalog start">
	<div class="page_inner">
		<div class="header-catalog_inner">
			<a href="#" class="mobile_back-btn">Назад</a>
			<div class="catalog_f-part">
				<div class="customScroll">
					<div class="catalog_cat-list">
						<!-- Список разделов каталога. в data-id айди блока для открытия -->
						<?foreach ($arResult['SECTION_LIST'] as $key => $value) {
							if ($value['DEPTH_LEVEL'] == 1 && $value['ID'] != '303') {?>
								<a href="<?= $value['SECTION_PAGE_URL'] ?>"
								   data-id="#catalogSubcat<?= $value['ID'] ?>">
									<span><img src="<?=$value['SRC']?>"/></span><?= $value['NAME'] ?>
								</a>	
							<?}
						}?>	
					</div>
					<div class="catalog_spec-list">
						<ul>
							<li>
								<a class="item-red" href="/catalog/covid-19/">
									<span><img src="https://rusmedcompany.ru/bitrix/templates/romza_upro_1.1.72/img/icons/catalog-icon_covid.png"></span>COVID-19
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="catalog_s-part">
				<div class="customScroll">		
					<?foreach ($arResult['SECTION_LIST'] as $key => $value) {
						if ($value['DEPTH_LEVEL'] == 1 && $value['ID'] != '303') {?>
							<!-- Блок для каждого раздела 1го уровня каталога. в id нужно чтобы совпадало со списком выше -->
							<div class="catalog_subcat-list" id="catalogSubcat<?= $value['ID'] ?>">
								<!-- Список подразделов -->
								<div class="list-item">
								<a href="<?= $value["SECTION_PAGE_URL"] ?>" style="font-weight:600;"
								   class="item-title"><?= $value["NAME"]; ?></a>
								</div>
								<div class="list-column">
									<!-- Если у раздела нет 3 уровня подкатегории, то выводим просто список -->
									<?
									foreach ($value['CHILD'] as $key => $val) { ?>
										<div class="list-item"><?
										if (!empty($val['CHILD']) && false) {
											?><a href="<?= $val['SECTION_PAGE_URL'] ?>"
											   class="item-title"><?= $val['NAME'] ?></a>
											<ul><?
											foreach ($val['CHILD'] as $key => $v) {	
												?><li>
													<a href="<?= $v['SECTION_PAGE_URL'] ?>"><?= $v['NAME'] ?></a>
												</li><?
											} ?>
											</ul><?
										} else {
											?>
											<a href="<?= $val['SECTION_PAGE_URL'] ?>"class="item-title"><?= $val['NAME'] ?></a><?
										} ?>
										</div>
									<?} ?>
								</div>
							</div>
						<?}
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.list-title {
		padding: 0px 30px 20px;
		font-size: 18px;
		font-weight: 600;
		color: #0092c7;
		display: block;
	}

	.list-title:hover {
		text-decoration: none;
	}
</style>