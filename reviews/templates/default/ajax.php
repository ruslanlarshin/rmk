<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?

	$APPLICATION->IncludeComponent("larshin:reviews",
		".default", 
		array(
			"TIME"=>'20000',
			'COUNT'=>$_REQUEST['COUNT'],
			'PAGE'=>$_REQUEST['PAGE']
		),
		false
	);	


?>