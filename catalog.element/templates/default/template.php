<?
/**
 * @var CBitrixComponentTemplate $this
 * @var CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

CModule::IncludeModule("highloadblock");

$this->setFrameMode(true);
$arItem = &$arResult;
$detail = true;
if (empty($arItem['ID'])) return;
$productTitle = $arResult["IPROPERTY_VALUES"]["ELEMENT_PAGE_TITLE"] ?: $arResult["NAME"];
$bShowReviews = $arResult['SHOW_REVIEW'];
?>

 <div class="page_main-titling">
    <div itemprop="review" itemscope itemtype="https://schema.org/Review">
        <h1 itemprop="itemReviewed" class="titling-text"><?=$arResult['NAME'];?></h1>
    </div>
</div>
<div class="catalog-view">
    <div class="catalog-view_inner">
        <div class="catalog-view_heading">
            <div class="catalog-view_heading-images">  
				<?$APPLICATION->IncludeComponent("larshin:stars",
						".default", 
						array(
							"RATING"=>$arResult['RATING'],
						),
						false
					);
				?>
               <?$APPLICATION->IncludeComponent("larshin:slider",
						".default", 
						array(
							"GALLERY"=>$arResult['GALLERY'],
							'TITLE'=>$productTitle,
						),
						false
					);
				?>
   
            </div>
            
            <div class="catalog-view_heading-info">
				<?$APPLICATION->IncludeComponent("larshin:options.element",
						".default", 
						array(
							"OPTIONS"=>$arResult['OPTIONS'],
						),
						false
					);
				?> 

                <div class="catalog-view_heading-text">
                    <p><b>Коротко о товаре</b></p>
                    <p><?=strip_tags($arResult['PREVIEW_TEXT'])?></p>
                    <p><?=$arResult['ANONS']?></p>
                </div>
            
                <a href="#blockDetailInfo" class="catalog-view_heading-link">Все характеристики</a>
				<div style='font-size: 14px;'>
					<div>Бренд : <?=$arResult['BRAND']?></div>
					<?foreach($arResult['CHARACTERISTICS'] as $key=>$value){?>
						<?if($key<4){//ограничили вывод до 3 (компонент?натсраиваемый? нужен ли??>
							<div> - <?=$value?></div>
						<?}?>
					<?}?>
				</div>
				<?$APPLICATION->IncludeComponent("larshin:sochial",//просто кнопочки поделится-вынесу в один компонент, чтобы модифицировать ни на каждой страницу
						".default", 
						array(
						),
						false
					);
				?>

               

				 <?

					if($arResult['BRAND']){//переписать по возможности
						$hlblock_id = 1;
						$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
						$entity = HL\HighloadBlockTable::compileEntity($hlblock);
						$entity_data_class = $entity->getDataClass();
							  
						$rsData = $entity_data_class::getList(array(
						   "select" => array("*"),
						   "order" => array("ID" => "ASC"),
						   "filter" => array('UF_XML_ID' => $arResult['BRAND'])
						));

						while($arData = $rsData->Fetch())  
						{
						   $arBRAND = $arData;  
				   
						} 
					
						$res = CIBlockSection::GetByID($arResult['IBLOCK_SECTION_ID']);
						if($ar_res = $res->GetNext())
						  $sect =  $ar_res;
					  
						?>
						<a href="<?=$arResult['SECTION_PAGE_URL']?>filter/brand-is-<?=mb_strtolower($arBRAND["UF_XML_ID"])?>/apply/" class="catalog-view_heading-link">Все товары <?=$arBRAND["UF_NAME"]?></a>

						<div class="catalog-view_heading-brand">
							<img src="<?=CFile::GetPath($arBRAND["UF_FILE"])?>">
							<p><?=$arResult['PROPERTIES']['COUNTRY']['VALUE']?></p>
						</div>
					<?}/**/
				?>
				
             
            </div>
        </div>


        <?if($arResult['SELLER']){?>
        <div class="sellers-offer_block">
            <div class="sellers-offer_titling">
                <h2 class="titling-text">Предложения поставщиков</h2>
                <?/*<a href="#" class="titling-link">Смотреть все цены</a>*/?>
            </div>

            <div class="sellers-offer_list">
            	<?foreach ($arResult['SELLER'] as $key => $value) {
				?>
                <div class="sellers-offer_item">
                    <div class="item-inner">
                        <div class="item-company">
                        	<?if($value["PREVIEW_PICTURE"]){?>
                            <img src="<?=$value["PREVIEW_PICTURE"]?>">
                            <?}?>
                            <p><b><?=$value["NAME"]?></b></p>
                            <!--p>г. Москва</p-->
                        </div>
                        <div class="item-text">
                           <?=$value["PREVIEW_TEXT"]?>
                        </div>
                        <div class="item-person">
                            <div class="item-person_heading">
                               	<?if($value["DETAIL_PICTURE"]){?>
                                <div class="item-person_img">
			                        <img src="<?=$value["DETAIL_PICTURE"]?>">
			                    </div>
                                <?}?>
                                <p><b><?=$value["NAME_SURNAME"]?></b></p>
                            </div>
                            <p><?=$value["DETAIL_TEXT"]?></p>
                        </div>
                        <div class="item-contact">
                            <a href="#modal-order-product" data-id="<?=$arResult['ID'];?>" data-name="<?=$arResult['NAME'];?>" class="btn" data-toggle="modal" data-seller = "<?=$value['ID']?>" onclick="ym(47745763,'reachGoal','click_prov_kp'); return true;">Запросить КП</a>
                            <a href="#modal-ask-question" data-id="<?=$arResult['ID'];?>" data-name="<?=$arResult['NAME'];?>" data-toggle="modal"  class="btn btn-bordered" data-seller = "<?=$value['ID']?>" onclick="ym(47745763,'reachGoal','click_prov_cons'); return true;">Консультироваться</a>
                        </div>
                    </div>
                </div>
                <?}?>
            </div>
        </div>
        <?}?>

        <div class="expert-consult_block full-block">
            <div class="expert-consult_inner">
                <div class="expert-consult_titling">
                    <h3 class="titling-main">Получите консультацию по <i>УЗ-аппаратам</i> <br><span>от Центра клиентского сервиса</span></h3>
                    <p class="titling-sub">Задайте вопрос What's App прямо сейчас!</p>
                </div>
                <div class="expert-consult_img">
                    <img src="https://rusmedcompany.ru/bitrix/templates/romza_upro_1.1.72/img/expert-consult_big.png"> 
                </div>
                <div class="expert-consult_btn">
                    <a href="https://chat.whatsapp.com/5782IZYim0sJnE439bGNwp" class="btn">Задать вопрос</a>
                </div>
            </div>
        </div>
        <?if(strlen($arResult['DETAIL_TEXT'])>0){?>
        <div class="common-block_wrap" id="blockDetailInfo">
            <h2 class="common-block_title">Описание <?=$arResult['NAME']?></h2>
            <div class="common-block_inner">
                <div class="article-text">
                    <?=trim($arResult['DETAIL_TEXT'])?>
                </div>
            </div>
        </div>
        <?}?>
        <?if ($bShowReviews){?>
        <?
    		global $arCommentsFilter;
    		$arCommentsFilter["PROPERTY_OFFER"] = $arResult['ID'];
    	?>
        <div class="common-block_wrap">
            <h2 class="common-block_title">Отзывы</h2>
            <div class="common-block_inner">
        		<?$APPLICATION->IncludeComponent(
        				'bitrix:news.list',
        				'comments',
        				array(
        					'IBLOCK_TYPE' => $arParams['FEEDBACK_IBLOCK_TYPE'],
        					'IBLOCK_ID' => $arParams['FEEDBACK_IBLOCK_ID'],
        					'PROPERTY_CODE' => array('NAME', 'TEXT_MESS', 'RATING'),
        					'ELEMENT_ID' => $arResult['ID'],
        					'IBLOCK_TYPE_CATALOG' => $arParams['IBLOCK_TYPE'],
        					'IBLOCK_ID_CATALOG' => $arParams['IBLOCK_ID'],
        					'PATH_TO_CATALOG' => '/bitrix/templates/romza_upro_1.1.72/components/bitrix/catalog/catalog',
        					'FILTER_NAME' => 'arCommentsFilter',
        					'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
        					'ADD_SECTIONS_CHAIN' => 'N',
        					'SET_TITLE' => 'N',									
        					'SET_BROWSER_TITLE' => 'N',
        					'SET_META_KEYWORDS' => 'N',									
        					'SET_META_DESCRIPTION' => 'N',									
        					'SET_LAST_MODIFIED' => 'N'
        				),
        				false
        		);?>
            </div>
        </div>
		<?}?>
		<?if($arResult['PROPERTIES']['DELIVERY']['VALUE']){?>
        <div class="common-block_wrap">
            <h2 class="common-block_title">Доставка</h2>
            <div class="common-block_inner">
                <div class="article-text">
                	<?=htmlspecialcharsBack($arResult['PROPERTIES']['DELIVERY']['VALUE']["TEXT"])?>
                </div>
            </div>
        </div>
        <?}?>
    </div>

    <div class="catalog-view_aside">
       <?
		$APPLICATION->IncludeComponent("larshin:get.kp.element",
				".default", 
				array(
					'PRICE'=>$arResult['PRICE'],
					'PRICE_FROM'=>$arResult['PRICE_FROM'],
					'CAN_BUY'=>$arResult['CAN_BUY'],  
					"NAME"=>$arResult["NAME"],
					"ID"=>$arResult["ID"],
				),
				false
			);
		?> 
				
        <?
			/*$APPLICATION->IncludeComponent("larshin:similar.products",
				".default", 
				array(
					'SECTION_ID'=>$arResult['SECTION_ID'], 
				),
				false
			);*/
        //if($arItem['PROPERTIES']['RZ_RECOMMENDED']['VALUE']){
			$arrFilterName = 'arrRecommendFilter';
			$arrFilter = &$GLOBALS[$arrFilterName];
			//$arrFilter = array('ID' => $arItem['PROPERTIES']['RZ_RECOMMENDED']['VALUE']);
            $arrFilter = array('!ID' => $arResult['ID'],'SECTION_ID'=>$arResult['SECTION_ID']);
           
			$arSectionParams = $arParams['SECTION_PARAMS'];
			$arSectionParams['FILTER_NAME'] = $arrFilterName;
			$arSectionParams['IBLOCK_ID'] = 12;
			$arSectionParams['SECTION_ID'] = $arResult['SECTION_ID'];
			$arSectionParams['SECTION_CODE'] = null;
			$arSectionParams['PAGE_ELEMENT_COUNT'] = 3;
			$arSectionParams['SET_TITLE'] = 'N';
			$arSectionParams['ADD_SECTION_CHAIN'] = 'N';
			$arSectionParams['TITLE'] = GetMessage('RZ_RECOMMENDED_PRODUCTS');
            $arSectionParams["ELEMENT_SORT_FIELD"] = "RAND";
			
			$arSectionParams['ELEMENT_SORT_ORDER'] = 'ASC';
			$arSectionParams['ELEMENT_SORT_FIELD2'] ='SORT';
			$arSectionParams['ELEMENT_SORT_ORDER2'] ='ASC';
			 $arSectionParams["SECTION_URL"] = '/catalog/#SECTION_CODE_PATH#/';
		//echo '<pre>'; print_r($arSectionParams); echo '</pre>'; 
			?>
			<? $APPLICATION->IncludeComponent(
					'bitrix:catalog.section',
					'Recommend',
					$arSectionParams,
					$component
			); ?>
			<?//}?>
    </div>
</div>

<div class="common-block_wrap">
	    <h2 class="common-block_title">Подборки</h2>
	    <div class="page-listing_tags full-view no-pup">
	        <div class="page-listing_tags-list">
	        	<?
	        	$nav = CIBlockSection::GetNavChain(12,$arResult['SECTION_ID']);
				while($arSectionPath = $nav->GetNext()){
					if($arSectionPath['DEPTH_LEVEL']==1){
						$idPodbor = $arSectionPath['ID'];
					}
				} 

	        	$arFilter = Array('IBLOCK_ID'=>12, 'GLOBAL_ACTIVE'=>'Y', 'SECTION_ID'=>$idPodbor);
			    $db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, false);
			    while($ar_result = $db_list->GetNext())
			    {
					if($ar_result['DEPTH_LEVEL']==2){
						?>
						 <a href="<?=$ar_result['SECTION_PAGE_URL']?>" class="page-listing_tags-item"><?=$ar_result['NAME']?></a>
						<?
					}
				} 

	        	?>
	            <div class="page-listing_tags-more">
	                <a href="#" class="more-link">Показать еще <i class="fas fa-angle-down"></i></a>
	                <div class="more-list"></div>
	            </div>
	        </div>
	    </div>
	</div>	