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
}	$time=0;

$arError='';//здесь не используется , но почти всегда необходим при масштабировании-отключаем выполнения кэша при ошибка
if($this->StartResultCache($time, array())){ 
	$arResult=array();
	$arResult['PARAM']=$arParams;
	$arGroup=array(
		'BRAND'=>array(
			'NAME'=>'Бренд',
			'CODE'=>'BRAND',
			'UF_NAME'=>1,
		),
		'CATEGORY'=>array(
			'NAME'=>'Категория',
			'CODE'=>'CATEGORY',
			'UF_NAME'=>3,
		),
		'YEAR'=>array(
			'NAME'=>'Год изготовления',
			'CODE'=>'YEAR',
			'UF_NAME'=>"N",
		),
		'VAR_DELIVERY'=>array(
			'NAME'=>'Доставка',
			'CODE'=>'VAR_DELIVERY',
			'UF_NAME'=>"N",
		),
		'strana_proizvodstva'=>array(
			'NAME'=>'Страна', 
			'CODE'=>'STRANA_PROIZVODSTVA',
			'UF_NAME'=>7,
		),
	); 
	
	//выберем текущий фильтр
	$arResult=array();
	$arFilterRequest=array();
	$arFilterRequestList='';
	if($arParams['FILTER']){
		foreach($arParams['FILTER'] as $cat => $list){
			$arFilterRequest["PROPERTY_".$cat]=array();
			foreach($list as $name=>$value){
				$arFilterRequest["PROPERTY_".$cat][]=$name;
				$arFilterRequestList=$arFilterRequestList.$cat.'='.$name.'&';
			}
		}
	}
	
	$arResult['REQUEST_FILTER']=$arFilterRequestList; 
	CModule::IncludeModule('highloadblock');
	foreach($arGroup as $key=> $item){
		$bufResult=array();
		$arFilter=array("IBLOCK_ID"=>12,'ACTIVE'=>'Y','SECTION_ID'=>$arParams['SECTION_ID'],"INCLUDE_SUBSECTIONS"=>'Y');//здесь мы получаем список фильтра по категории, необходим для заблокированных элеементов
		$res = CIBlockElement::GetList(false, $arFilter, Array("PROPERTY_".$item['CODE']));
		while($ar_fields = $res->GetNextElement())
		{
			$arRes = $ar_fields->GetFields();
			if($arRes['PROPERTY_'.$item['CODE'].'_VALUE'] && !$arResult['ITEM'][$item['CODE']][$arRes['PROPERTY_'.$item['CODE'].'_VALUE']]){
				if($item['UF_NAME']!="N"){//вынимаем имена из справочников для тех, где это нужно
					$hldata = Bitrix\Highloadblock\HighloadBlockTable::getById($item['UF_NAME'])->fetch();
					$hlentity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hldata);
					$hlDataClass = $hldata["NAME"] . "Table";
					$result = $hlDataClass::getList(array(
								"select" => array("ID", "UF_NAME", "UF_XML_ID","UF_FILE"), // Поля для выборки
								"order" => array("UF_SORT" => "ASC"),
								"filter" => array('UF_XML_ID' => $arRes['PROPERTY_'.$item['CODE'].'_VALUE'])
					));
					while ($res2 = $result->fetch()) {
						$name=$res2['UF_NAME'];
					}
				}else{
					$name=$arRes['PROPERTY_'.$item['CODE'].'_VALUE'];
					
				}
				$bufResult[$name]=$arRes['PROPERTY_'.$item['CODE'].'_VALUE'];
				$arResult['ITEM'][$item['CODE']][$arRes['PROPERTY_'.$item['CODE'].'_VALUE']]=array(
					'NAME'=>$name,
					'CNT'=>$arRes['CNT'],
				);
			}
		}
		$bufResultNew=array();
		$arFilter=array("IBLOCK_ID"=>12,'ACTIVE'=>'Y','SECTION_ID'=>$arParams['SECTION_ID'],"INCLUDE_SUBSECTIONS"=>'Y');//здесь мы получаем список фильтра по категории, необходим для заблокированных элеементов
		$arFilter = array_merge($arFilter, $arFilterRequest);
		$arFilter["PROPERTY_".$item['CODE']]=array();
		$res = CIBlockElement::GetList(false, $arFilter, Array("PROPERTY_".$item['CODE']));
		while($ar_fields2 = $res->GetNextElement())
		{
			$arRes2 = $ar_fields2->GetFields();
			if($arResult['ITEM'][$item['CODE']][$arRes2['PROPERTY_'.$item['CODE'].'_VALUE']])
				$arResult['ITEM'][$item['CODE']][$arRes2['PROPERTY_'.$item['CODE'].'_VALUE']]['CNT_NEW']=$arRes2['CNT'];
			//echo '<pre>'; print_r($arResult['ITEM'][$item['CODE']][$arRes2['PROPERTY_'.$item['CODE'].'_VALUE']]); echo '</pre>'; 
			//
		}//echo '<pre>'; print_r($arResult); echo '</pre>'; 
		ksort($bufResult);
		$arGroup[$key]['SORT']=$bufResult;
	}	
	$arResult['GROUPE']=$arGroup;
	$arResult['FILTER']=$arFilterRequest;
	$arResult['FILTER_VIEW']=$arParams['FILTER'];
	//echo '<pre>'; print_r($arResult['FILTER_VIEW']); echo '</pre>'; 
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