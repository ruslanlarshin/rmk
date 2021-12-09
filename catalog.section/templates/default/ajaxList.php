<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>	
<?
//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
$arFilter=array();
foreach($_REQUEST as $key=>$value){
	$buf=explode('__',$key);
	if($buf[1]){
		$arFilter[$buf[0]][$value]='Y';
		//$arFilter['PROPERTY_'.]
	}
	//echo '<pre>'; print_r($buf); echo '</pre>'; 
}
//echo '<pre>'; print_r($_REQUEST); echo '</pre>'; 
if($_REQUEST["SECTION_ID"])
	$arParams["SECTION_ID"]=$_REQUEST["SECTION_ID"];
$APPLICATION->IncludeComponent("larshin:catalog.list",
		".default", 
		array(
			"SECTION_ID"=>$arParams["SECTION_ID"],
			"FILTER"=>$arFilter,
		),
		false 
	);
?>	 