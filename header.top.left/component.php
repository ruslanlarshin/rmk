<?
\Bitrix\Main\Loader::includeModule('iblock');

if($_REQUEST['clear_cache']=='Y'){//����������� �� ������� ��������� � ����������, ��� ��� ����� ���������� ��������� �������������, �� ������ ����� ��������� ������
	$time=0;//������� ��� ���� ��� ����������� ������
}else{
	if($arParams['TIME']){
		$time=$arParams['TIME'];//���� �������� ���� �����, �� ��������� ���
	}else{
		$time=360000;//����� ����������� ����� ����� ����
	}
}

$arError='';//����� �� ������������ , �� ����� ������ ��������� ��� ���������������-��������� ���������� ���� ��� ������
if($this->StartResultCache($time, array())){ 
	$arResult=array();
	$arResult['PARAM']=$arParams;
	$arSelect = array("ID", "NAME", "DATE_ACTIVE_FROM");
	$arFilter = array("IBLOCK_ID" => 15, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
	$res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	$arResult['COUNT']=intval($res->SelectedRowsCount());
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