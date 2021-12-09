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
	$arResult['PARAM']=$arParams['BREACK'];
	if($arParams['DETAIL']){
				$arResult['PARAM']=array(
				'Главная'=>'/',
				'Медицинское оборудование'=>"/catalog/", 
			);
		$arFilter = array('IBLOCK_ID' => 12,'CODE'=>$arParams['ELEMENT_CODE']); // выберет потомков без учета активности
	   $rsSect = CIBlockElement::GetList(array('left_margin' => 'asc'),$arFilter,false,false,array("NAME",'CODE','PROPERTY_list_anchor'));
	   while ($arSect = $rsSect->GetNext())
	   {	   
		   $arResult['NAME']=$arSect['PROPERTY_LIST_ANCHOR_VALUE'].' '.$arSect['NAME'];
		  // echo '<pre>'; print_r($arSect); echo '</pre>';
	   }
	   
		$item=explode('/',$arParams['DETAIL']);
		$url='/catalog/';
		$arFilter = array('IBLOCK_ID' => 12,'CODE'=>array($item[2],$item[3])); // выберет потомков без учета активности
	   $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter,false,array("NAME",'CODE'));
	   while ($arSect = $rsSect->GetNext())
	   {
		  // echo '<pre>'; print_r($arSect); echo '</pre>';
		   if($arSect['CODE']){
			   $url=$url.$arSect['CODE'].'/';
			   $arResult['PARAM'][$arSect['NAME']]=$url;
		   }  
	   }
	   $arResult['PARAM'][$arResult['NAME']]=null;
	}
	//$arResult=$arParams;
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
	//echo 'Ўаблон вз¤т и кеша!<BR>';// происходит тогда, когда загружен кеш-эффективно дл¤ проверки работы кеша и скорости без него!!
}
?>