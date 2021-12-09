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
	
	$arFilter = array(
		'ACTIVE' => 'Y',
		'IBLOCK_ID' => 12,
		'GLOBAL_ACTIVE' => 'Y',
	);
	$arSelect = array('IBLOCK_ID', 'ID', 'NAME', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID', "SECTION_PAGE_URL", "UF_ICON");
	$arOrder = array('DEPTH_LEVEL' => 'ASC', 'SORT' => 'ASC');
	$rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);
	$sectionLinc = array();
	while ($arSection = $rsSections->GetNext()) {
		//echo '<pre>'; print_r($arSection); echo '</pre>';
		$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']] = $arSection;
		$sectionLinc[$arSection['ID']] = &$sectionLinc[intval($arSection['IBLOCK_SECTION_ID'])]['CHILD'][$arSection['ID']];
	}
	$arResult['SECTION_LIST']=$sectionLinc;
	foreach ($arResult['SECTION_LIST'] as $key => $value) {
		if ($value['DEPTH_LEVEL'] == 1 && $value['ID'] != '303') {
				$arResult['SECTION_LIST'][$key]['SRC']=CFile::GetPath($value["UF_ICON"]);
			}
	}
	//echo '<pre>'; print_r($sectionLinc); echo '</pre>';
									
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