<?
\Bitrix\Main\Loader::includeModule('iblock');

if($_REQUEST['clear_cache']=='Y'){//кэширование по времени заданному в параметрах, так как сложн оотследить изменение пользователей, то массив опций останется пустым
	$time=0;//выводим без кэша при стандартном сбросе
}else{
	if($arParams['TIME']){
		$time=$arParams['TIME'];//если параметр кэша хадан, то считаывем его
	}else{
		$time=360000;//иначе стандартное время жизни кэша
	}
}

$arError='';//здесь не используется , но почти всегда необходим при масштабировании-отключаем выполнения кэша при ошибка
if($this->StartResultCache($time, array())){ 
	$arResult=array();
	$arResult['ITEM']=array();
	$arResult['PARAM']=$arParams;
	//Делаем выборку записей для блока похожих товаров
	$arSort=array('NAME'=>'asc');
	$arFilter=array("IBLOCK_ID"=>12, "ACTIVE"=>"Y",'SECTION_ID'=>$arParams["SECTION_ID"]);
	$arSelect=array('ID',"NAME",'IBLOCK_SECTION','IBLOCK_SECTION_ID','DETAIL_PAGE_URL','PREVIEW_TEXT','PROPERTY_list_anchor','PROPERTY_SELLER','PROPERTY_AUTOR','PROPERTY_DATE','PROPERTY_PRICE','PROPERTY_PRICE_FROM','PROPERTY_CAN_BUY','PROPERTY_ELEMENT','PROPERTY_MORE_PHOTO','PROPERTY_rating','PROPERTY_EXCL_TXT','PROPERTY_EXCL','PROPERTY_AKCIYA_TXT','PROPERTY_AKCIYA','PROPERTY_HIT_TXT','PROPERTY_HIT','PROPERTY_ANONS',"PROPERTY_CHARACTERISTICS",'PROPERTY_BRAND');
	$arNav=array('nTopCount'=>3);
	$res = CIBlockElement::GetList($arSort, $arFilter, false, $arNav, $arSelect); 
	//$item=array();//пока не перенесем базу -совйства раскиданы на множество-считываем без дублей! когдла перепишем все компоненты-исправить
	while($obRes = $res->GetNextElement()){
		$arRes = $obRes->GetFields(); 
		$arResult['ITEMS'][$arRes['ID']]=array(
			'CAN_BUY'=>$arRes['PROPERTY_CAN_BUY_VALUE'],
			'DATE'=>$arRes['PROPERTY_DATE_VALUE'],
			'AKCIYA'=>$arRes['PROPERTY_AKCIYA_VALUE'],
			'HIT'=>$arRes['PROPERTY_HIT_VALUE'],
			'DETAIL_PAGE_URL'=>$arRes['DETAIL_PAGE_URL'],
			'list_anchor'=>$arRes['ROPERTY_LIST_ANCHOR_VALUE'],
			'NAME'=>$arRes['NAME'],
			'ID'=>$arRes['ID'],
			'rating'=>$arRes['PROPERTY_RATING_VALUE'],
			'PREVIEW_TEXT'=>$arRes['PREVIEW_TEXT'],
		);
		/*$arResult['ITEMS'][$arRes['ID']]['CHARACTERISTICS'][]=$arRes['PROPERTY_CHARACTERISTICS_VALUE'];
		if(!$arResult['ITEMS'][$arRes['ID']]['GALLERY'][0] && $arRes['PROPERTY_MORE_PHOTO_VALUE']) {
			$arResult['ITEMS'][$arRes['ID']]['GALLERY'][0]['src'] = CFile::ResizeImageGet($arRes['PROPERTY_MORE_PHOTO_VALUE'], array('width'=>233, 'height'=>218), BX_RESIZE_IMAGE_PROPORTIONAL, true); 
		}

		echo '<pre>'; print_r($arRes); echo "</pre>";  */
	}
	
	$this->IncludeComponentTemplate();
	//шаблон загружен в кэш
	if($arError)
	{ 
		$this->AbortResultCache();
		ShowError("ERROR");
		@define("ERROR_404", "Y");
		if($arParams["SET_STATUS_404"]==="Y")
			CHTTP::SetStatus("404 Not Found");
	}
}else{
	//echo 'Ўаблон вз€т и кеша!<BR>';// происходит тогда, когда загружен кеш-эффективно дл€ проверки работы кеша и скорости без него!!
}
?>