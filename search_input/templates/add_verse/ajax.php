<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
foreach($_REQUEST as $key=>$value){
	if(iconv('utf-8', 'cp1251', $value)){
		$_REQUEST[$key]=iconv('utf-8', 'cp1251', $value);
	}
}
	if($_REQUEST['text']){
		$APPLICATION->IncludeComponent("larshin:search_result",
			"add_verse", 
			array(
				'text'=>$_REQUEST['text'],
				'hight_search'=>$_REQUEST['hight_search'],
				'all_result'=>$_REQUEST['all_result'],
				'sort_book'=>$_REQUEST['sort_book'],
				'in_book_search'=>$_REQUEST['in_book_search'],
			),
			false
		);
	}
?>