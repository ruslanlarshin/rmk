<?
\Bitrix\Main\Loader::includeModule('iblock');

if($_REQUEST['clear']!='yes'){//кэширование по времени заданному в параметрах, так как сложн оотследить изменение пользователей, то массив опций останется пустым
	$time=0;//выводим без кэша при стандартном сбросе
}else{
	if($arParams['TIME']){
		$time=$arParams['TIME'];//если параметр кэша хадан, то считаывем его
	}else{
		$time=360000;//иначе стандартное время жизни кэша
	}
}
$time=0;


$arError='';//здесь не используется , но почти всегда необходим при масштабировании-отключаем выполнения кэша при ошибка
if($this->StartResultCache($time, array())){ 
	$arResult=array();
	$arResult['ITEM']=array();
	$arResult['PARAM']=$arParams;
	//получим абсолютно все отзывы
	$arSort=array('NAME'=>'asc');
	$arFilter=array("IBLOCK_ID"=>14, "ACTIVE"=>"Y");
	$arSelect=array('ID',"NAME",'PREVIEW_TEXT','PROPERTY_AUTOR','PROPERTY_TOVARI');
	$res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
	while($obRes = $res->GetNextElement()){
		$arRes = $obRes->GetFields();
		$arResult['ITEMS'][]=$arRes;
		$rsUser = CUser::GetByID($arRes['PROPERTY_AUTOR_VALUE']);
		$arUser = $rsUser->Fetch();
	echo '<pre>'; print_r($arUser); echo "</pre>";  
	}
	echo '<pre>'; print_r($arResult); echo "</pre>";  
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