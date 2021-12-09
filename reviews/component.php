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
	$arResult['PAGE']=$arParams['PAGE'];
	$arResult['COUNT']=$arParams['COUNT'];
	$arResult['ITEM']=array();
	$arResult['PARAM']=$arParams;
	//получим абсолютно все отзывы
	$arSort=array('NAME'=>'asc');
	$arFilter=array("IBLOCK_ID"=>14, "ACTIVE"=>"Y");
	$arSelect=array('ID',"NAME",'PREVIEW_TEXT','PROPERTY_AUTOR','PROPERTY_ELEMENT','PROPERTY_WHO_IS');
	$arNav=array(
		'nPageSize'=>$arParams['COUNT'],
		"iNumPage"=>$arParams['PAGE'],
	);
	$res = CIBlockElement::GetList($arSort, $arFilter, false, $arNav, $arSelect); 
	if(($res->SelectedRowsCount())*1-$arParams['PAGE']*$arParams['COUNT']<0)
		$arResult['STOP']="Y";
	$arResult["ALL"]=$res->SelectedRowsCount();
	while($obRes = $res->GetNextElement()){
		$arRes = $obRes->GetFields();
		//$arResult['ITEMS'][]=$arRes;
		$rsUser = CUser::GetByID($arRes['PROPERTY_AUTOR_VALUE']);
		$arUser = $rsUser->Fetch();
		$resIBlock = CIBlockElement::GetByID($arRes["PROPERTY_ELEMENT_VALUE"]);
		if($ar_res = $resIBlock->GetNext()){
		  $element=explode(" ",$ar_res['NAME']); 
 
		}
		$element=$element[1];   
		if(iconv_strlen($arRes["PREVIEW_TEXT"])>300){
			$text=mb_strimwidth($arRes["PREVIEW_TEXT"], 0, 300, "...");
		}else{
			$text=$arRes["PREVIEW_TEXT"];
		}
		$element1=explode(" ",$arUser["NAME"]);  
		$element2=explode(" ",$arUser["LAST_NAME"]);		
		$arResult['ITEMS'][]=array(
			"USER"=>$arUser['LAST_NAME'].' '.$arUser['NAME'].' '.$arUser['SECOND_NAME'],
			"TEXT"=>$text,
			"NAME"=>$arRes["NAME"],
			"AUTOR_ID"=>$arRes["PROPERTY_AUTOR_VALUE"],
			"PROPERTY_ELEMENT"=>$arRes["PROPERTY_ELEMENT_VALUE"],
			"ELEMENT"=>$element,
			"DOLJNOST"=>$arRes["PROPERTY_WHO_IS_VALUE"],
		); 
		//echo '<pre>'; print_r($arRes); echo "</pre>";  
	}
	//echo '<pre>'; print_r($arResult['ITEMS']); echo "</pre>";  
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