<?
//CModule::IncludeModule("iblock");
\Bitrix\Main\Loader::includeModule('iblock'); //d7 есть уже хорошо!


if($_REQUEST['clear_cache']=='Y'){//кэширование по времени заданному в параметрах, так как сложн оотследить изменение пользователей, то массив опций останется пустым
	$time=0;//выводим без кэша при стандартном сбросе
}else{
	if($arParams['TIME']){
		$time=$arParams['TIME'];//если параметр кэша хадан, то считаывем его
	}else{
		$time=360000;//иначе стандартное время жизни кэша
	}
}$time=0;
$arParams['PAGE_COUNT']=10;
//$time=0;//для разработки
if($this->StartResultCache($time, array($arOption))){ //кеш берется по значению $arParams и $arOption-если таковых ранее не загружалось-начнется загрузка компонента
	if($arError){ //если шаблон ошибочен-то кеш не запишется
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	$arResult=array();
	if($arParams['SEARCH']){
		$arResult['SEARCH']=$arParams['SEARCH'];
	}else{
		$arResult['SEARCH']=$_REQUEST['search'];
	}
	$arResult['PARAM']=$arParams;
	//Первым деклом попробуем получить все разделы всех твоаров, что -то они разбросаны по всем инфоблокам..бардак..
	if(!$_REQUEST['search']){
		$_REQUEST['search']=$arParams['SEARCH'];
	}
	$arFilter = array(
		'ACTIVE' => 'Y',
		'IBLOCK_ID' => 12,
		'GLOBAL_ACTIVE' => 'Y',
	);
	if($_REQUEST['search']){
		$arFilter['NAME']='%'.$_REQUEST['search'].'%';
		//echo '<pre>'; print_r($_REQUEST); echo "</pre>"; 
	}
	$arSelect = array('IBLOCK_ID', 'ID', 'NAME', 'DEPTH_LEVEL', 'IBLOCK_SECTION_ID', "SECTION_PAGE_URL", "UF_ICON",'CODE');
	$arOrder = array('DEPTH_LEVEL' => 'ASC', 'SORT' => 'ASC');
	$rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, $arSelect);
	$sectionLinc = array();
	while ($arSection = $rsSections->GetNext()) {
		$arResult['SECTIONS'][]=array(
			'NAME'=>$arSection['NAME'],
			"ID"=>$arSection['ID'],
			"CODE"=>$arSection['CODE'],
			"URL"=>$arSection['SECTION_PAGE_URL'],
			'IMG'=>$arSection['UF_ICON'],
		);
		//echo '<pre>'; print_r($arSection); echo "</pre>"; 
	}

	//с разделами мы справились, тенперь пройдемся по элементам
	$arSort=array('NAME'=>'asc');

	$arFilter=array("IBLOCK_ID"=>12, array("LOGIC"=>"OR",array("NAME"=>'%'.$_REQUEST['search'].'%'),array("PROPERTY_list_anchor"=>'%'.$_REQUEST['search'].'%')));
	$arNav=array(
		"nPageSize" => 10,
		'iNumPage' => 1,
	);
	$arSelect=array('ID',"NAME",'PROPERTY_list_anchor','DETAIL_PAGE_URL','PREVIEW_TEXT','PROPERTY_MORE_PHOTO');
	$res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
	//echo '<pre>'; print_r($_REQUEST); echo "</pre>";  
	while($obRes = $res->GetNextElement()){
		$arRes = $obRes->GetFields();
		//echo '<pre>'; print_r($arRes); echo "</pre>";  
		$arPhotoSmall = CFile::ResizeImageGet(
		   $arRes['PROPERTY_MORE_PHOTO_VALUE'], 
		   array(
			  'width'=>100,
			  'height'=>100
		   ), 
		   BX_RESIZE_IMAGE_PROPORTIONALDETAIL_PICTURE,
		   Array(
			  "name" => "sharpen", 
			  "precision" => 0
		   )
		);
		//echo '<pre>'; print_r($arPhotoSmall); echo "</pre>"; 
		$arResult['ITEMS'][]=array(
			'NAME'=>$arRes['PROPERTY_LIST_ANCHOR_VALUE'].' '.$arRes['NAME'],
			'URL'=>$arRes['DETAIL_PAGE_URL'],
			'PREVIEW'=>$arRes['PREVIEW_TEXT'],
			'PHOTO'=>$arRes['PROPERTY_MORE_PHOTO_VALUE'],
			'IMG'=>$arPhotoSmall['src'],
		);
	} 
	
	//постраничная навигация
	if(count($arResult['ITEMS'])>$arParams['PAGE_COUNT']){
		If(!$_REQUEST['PAGE']){//какая сейчас страница считываем
			$arResult['PAGE_NUM']=1;
		}else{
			$arResult['PAGE_NUM']=$_REQUEST['PAGE'];
		}
		$arResult['COUNT']=floor(count($arResult['ITEMS'])/$arParams['PAGE_COUNT'])+1;
		$arResult["ITEMS_NAV"]=array();
		//echo '<pre>'; print_r($arResult['PAGE_NUM']*$arParams['PAGE_COUNT']-1); echo "</pre>"; 
		$max=$arParams['PAGE_COUNT']*$arResult['PAGE_NUM'];
		for($i=($arResult['PAGE_NUM']-1)*$arParams['PAGE_COUNT']*1;$i<$max;$i++){
			if($arResult['ITEMS'][$i])
				$arResult["ITEMS_NAV"][$i]=$arResult['ITEMS'][$i];
			//echo '<pre>'; print_r($i); echo "</pre>";  
		}
	}else{
		$arResult["ITEMS_NAV"]=$arResult["ITEMS"];
	}
	
	//префикс товаров
	$ost=count($arResult['ITEMS'])*1-floor(count($arResult['ITEMS'])/10)*10;
	if($ost==0 || $ost==5 || $ost==6 || $ost==7 || $ost==8 || $ost==9 )$arResult['TOVARI']='товаров';
	if($ost==1)$arResult['TOVARI']='товар';
	if($ost==2 || $ost==3 || $ost==4 )$arResult['TOVARI']='товара';

	//echo '<pre>'; print_r(floor(count($arResult['ITEMS'])/10)*10); echo "</pre>"; 
	//echo '<pre>'; print_r(count($arResult['ITEMS'])); echo "</pre>"; 
	/*$arSort=array('NAME'=>'asc');
	$arFilter=array("IBLOCK_ID"=>12,"PROPERTY_list_anchor"=>'%'.$_REQUEST['search'].'%');
	$res = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
	while($obRes = $res->GetNextElement()){
		$arRes = $obRes->GetFields();
		$arPhotoSmall = CFile::ResizeImageGet(
		   $arRes['PROPERTY_MORE_PHOTO_VALUE'], 
		   array(
			  'width'=>100,
			  'height'=>100
		   ), 
		   BX_RESIZE_IMAGE_PROPORTIONALDETAIL_PICTURE,
		   Array(
			  "name" => "sharpen", 
			  "precision" => 0
		   )
		);
		$arResult['ITEMS'][]=array(
			'NAME'=>$arRes['PROPERTY_LIST_ANCHOR_VALUE'].' '.$arRes['NAME'],
			'URL'=>$arRes['DETAIL_PAGE_URL'],
			'PREVIEW'=>$arRes['PREVIEW_TEXT'],
			'PHOTO'=>$arRes['PROPERTY_MORE_PHOTO_VALUE'],
			'IMG'=>$arPhotoSmall['src'],
		);
	}
*/

	$this->IncludeComponentTemplate();
	//echo 'Загрузился весь шаблон и сохранился в кеш';
	if($arError)
	{
		$this->AbortResultCache();
		ShowError("ERROR");
		@define("ERROR_404", "Y");
		if($arParams["SET_STATUS_404"]==="Y")
			CHTTP::SetStatus("404 Not Found");
	}
}else{
	//echo 'Шаблон взят и кеша!<BR>';// происходит тогда, когда загружен кеш-эффективно для проверки работы кеша и скорости без него!!
}
?>