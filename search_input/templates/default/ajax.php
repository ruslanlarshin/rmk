<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
/*foreach($_REQUEST as $key=>$value){
	if(iconv('utf-8', 'cp1251', $value)){
		$_REQUEST[$key]=iconv('utf-8', 'cp1251', $value);
	}
}*/

	if($_REQUEST['search']){
		$APPLICATION->IncludeComponent("larshin:search",
			".default", 
			array(
				"TIME"=>'20000',
				'SEARCH'=>$_REQUEST['text'],
				"PAGE"=>$_REQUEST['PAGE'],
			),
			false
		);	
	}else{
		?>Введите запрос!<?
	}

?>