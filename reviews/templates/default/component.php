<?
\Bitrix\Main\Loader::includeModule('iblock');

if($_REQUEST['clear']!='yes'){//����������� �� ������� ��������� � ����������, ��� ��� ����� ���������� ��������� �������������, �� ������ ����� ��������� ������
	$time=0;//������� ��� ���� ��� ����������� ������
}else{
	if($arParams['TIME']){
		$time=$arParams['TIME'];//���� �������� ���� �����, �� ��������� ���
	}else{
		$time=360000;//����� ����������� ����� ����� ����
	}
}
$time=0;


$arError='';//����� �� ������������ , �� ����� ������ ��������� ��� ���������������-��������� ���������� ���� ��� ������
if($this->StartResultCache($time, array())){ 
	$arResult=array();
	$arResult['ITEM']=array();
	$arResult['PARAM']=$arParams;
	//������� ��������� ��� ������
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
	//������ �������� � ���
	if($arError)
	{
		$this->AbortResultCache();
		ShowError("ERROR");
		@define("ERROR_404", "Y");
		if($arParams["SET_STATUS_404"]==="Y")
			CHTTP::SetStatus("404 Not Found");
	}
}else{
	//echo '������ ���� � ����!<BR>';// ���������� �����, ����� �������� ���-���������� ��� �������� ������ ���� � �������� ��� ����!!
}
?>