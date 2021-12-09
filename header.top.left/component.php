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
	$arResult['PARAM']=$arParams;
	$arSelect = array("ID", "NAME", "DATE_ACTIVE_FROM");
	$arFilter = array("IBLOCK_ID" => 15, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
	$res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	$arResult['COUNT']=intval($res->SelectedRowsCount());
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