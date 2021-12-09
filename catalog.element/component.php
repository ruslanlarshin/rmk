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
if($_REQUEST['clear_cache']=="Y")
	$time=0;
//echo '<pre>'; print_r($_REQUEST); echo "</pre>";  
$arError='';//здесь не используется , но почти всегда необходим при масштабировании-отключаем выполнения кэша при ошибка
if($this->StartResultCache($time, array())){ 
	$arResult=array();
	$arResult['PARAM']=$arParams;

	$arSort=array('NAME'=>'asc');
	$arFilter=array("IBLOCK_ID"=>12, "ACTIVE"=>"Y",'CODE'=>$arParams["CODE3"]);
	$arSelect=array('ID',"NAME",'DETAIL_TEXT','IBLOCK_SECTION','IBLOCK_SECTION_ID','PREVIEW_TEXT','PROPERTY_AUTOR',"PROPERTY_SELLER","PROPERTY_SELLER.PREVIEW_PICTURE","PROPERTY_SELLER.NAME","PROPERTY_SELLER.PREVIEW_TEXT","PROPERTY_SELLER.DETAIL_TEXT","PROPERTY_SELLER.DETAIL_PICTURE","PROPERTY_SELLER.PROPERTY_NAME_SURNAME",'PROPERTY_PRICE','PROPERTY_PRICE_FROM','PROPERTY_CAN_BUY','PROPERTY_ELEMENT','PROPERTY_MORE_PHOTO','PROPERTY_rating','PROPERTY_EXCL_TXT','PROPERTY_EXCL','PROPERTY_AKCIYA_TXT','PROPERTY_AKCIYA','PROPERTY_HIT_TXT','PROPERTY_HIT','PROPERTY_ANONS',"PROPERTY_CHARACTERISTICS",'PROPERTY_BRAND');

	$res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect); 
	//$item=array();//пока не перенесем базу -совйства раскиданы на множество-считываем без дублей! когдла перепишем все компоненты-исправить
	while($obRes = $res->GetNextElement()){
		$arRes = $obRes->GetFields(); 
		$arResult['NAME']=$arRes['NAME'];
		$arResult['DETAIL_TEXT']=$arRes['DETAIL_TEXT'];
		$arResult['PRICE']=$arRes['PROPERTY_PRICE_VALUE'];
		$arResult['PRICE_FROM']=$arRes['PROPERTY_PRICE_FROM_VALUE'];
		$arResult['CAN_BUY']=$arRes['PROPERTY_CAN_BUY_VALUE'];
		$arResult['NAME']=$arRes['NAME'];
		$arResult['ID']=$arRes['ID'];
		$arResult['SECTION_ID']=$arRes['IBLOCK_SECTION_ID'];
		$arResult['BRAND']=$arRes['PROPERTY_BRAND_VALUE'];
		$arResult['PREVIEW_TEXT']=$arRes['PREVIEW_TEXT'];
		$arResult['ANONS']=$arRes['PROPERTY_ANONS_VALUE'];
		$arResult['CHARACTERISTICS'][]=$arRes['PROPERTY_CHARACTERISTICS_VALUE'];
		$arResult['SELLER'][$arRes['PROPERTY_SELLER_VALUE']]=array(
			"ID"=>$arRes['PROPERTY_SELLER_VALUE'],
			"NAME"=>$arRes['PROPERTY_SELLER_NAME'],
			"NAME_SURNAME"=>$arRes['PROPERTY_SELLER_PROPERTY_NAME_SURNAME_VALUE'],
			"DETAIL_PICTURE"=>CFile::GetPath($arRes['PROPERTY_SELLER_DETAIL_PICTURE']),
			"PREVIEW_PICTURE"=>CFile::GetPath($arRes['PROPERTY_SELLER_PREVIEW_PICTURE']),
			"PREVIEW_TEXT"=>$arRes['~PROPERTY_SELLER_PREVIEW_TEXT'],
			"DETAIL_TEXT"=>$arRes['~PROPERTY_SELLER_DETAIL_TEXT'],
		);
	/*	$arResult['PHOTO'][]=array(
			"ID"=>$arRes['PROPERTY_MORE_PHOTO_VALUE_ID'],
			"PATH"=>CFile::GetPath($arRes['PROPERTY_MORE_PHOTO_VALUE']),
		);*/
		$arResult['RATING']=round($arRes['PROPERTY_RATING_VALUE']); 
		if(!$arResult['GALLERY'][$arRes['PROPERTY_MORE_PHOTO_VALUE']]){
			$file1 = CFile::ResizeImageGet($arRes['PROPERTY_MORE_PHOTO_VALUE'], array('width'=>1200, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL, true); 
			$file2 = CFile::ResizeImageGet($arRes['PROPERTY_MORE_PHOTO_VALUE'], array('width'=>1200, 'height'=>70), BX_RESIZE_IMAGE_PROPORTIONAL, true); 
			if(!$file1['src'])$file1['src']=CFile::GetPath($arRes['PROPERTY_MORE_PHOTO_VALUE']);
			if(!$file2['src'])$file2['src']=CFile::GetPath($arRes['PROPERTY_MORE_PHOTO_VALUE']);
			$arResult['GALLERY'][$arRes['PROPERTY_MORE_PHOTO_VALUE']]=array(
				"THUMB"=>$file2['src'],
				"SRC"=>CFile::GetPath($arRes['PROPERTY_MORE_PHOTO_VALUE']),
				"BIG"=>$file1['src'],
		);
		}
		$arResult['OPTIONS']=array(
			'EXCL'=>$arRes['PROPERTY_EXCL_VALUE'],
			'EXCL_TEXT'=>$arRes['PROPERTY_EXCL_TXT_VALUE'],
			'HIT'=>$arRes['PROPERTY_HIT_VALUE'],
			'HIT_TEXT'=>$arRes['PROPERTY_HIT_TXT_VALUE'],
			'AKCIYA'=>$arRes['PROPERTY_AKCIYA_VALUE'],
			'AKCIYA_TEXT'=>$arRes['PROPERTY_AKCIYA_TXT_VALUE'],
		);
		
		//$file = CFile::ResizeImageGet($arRes['PROPERTY_MORE_PHOTO_VALUE'], array('width'=>150, 'height'=>150), BX_RESIZE_IMAGE_PROPORTIONAL, true); 
		//echo '<pre>'; print_r($arRes); echo "</pre>";  
	} 
	$res = CIBlockSection::GetByID($arResult['SECTION_ID']);
	if($ar_res = $res->GetNext())
		$arResult['SECTION_PAGE_URL']=$ar_res['SECTION_PAGE_URL'];
	//echo '<pre>'; print_r($arResult); echo "</pre>";   
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
	echo 'Ўаблон вз€т и кеша!<BR>';// происходит тогда, когда загружен кеш-эффективно дл€ проверки работы кеша и скорости без него!!
}
?>