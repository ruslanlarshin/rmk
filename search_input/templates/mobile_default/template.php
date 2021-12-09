<?//$APPLICATION->SetAdditionalCSS($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/style.css',true);?>
<link rel="stylesheet" type="text/css" href="<?=$this->GetFolder()?>/style.css">
<div class='search_component' data-template='<?=$this->GetFolder()?>'>
	<?if(!in_array($this->GetFolder().'/script_my.js',$_SESSION['script'])){
		$_SESSION['script'][]=$this->GetFolder().'/script_my.js';
		?>
		<script type='text/javascript' src='<?=$this->GetFolder()?>/script_my.js'></script>
	<?}?>
	<?
		$arSearchOption=array(
			array("NAME"=>'Группировать по книгам',"CLASS"=>'sort_book'),
			array("NAME"=>'Включить углубленный поиск',"CLASS"=>'hight_search'),
			array("NAME"=>'Поиск по определенным книгам',"CLASS"=>'in_book_search'),
			array("NAME"=>'Показывать маловероятные результаты',"CLASS"=>'all_result')
		);
	?>
	<table class='serach_table'>
		<tr>
			<td>
				<div class='search'><input type='text' value='<?=$_REQUEST['text']?>'/><img src='/images/Loupe.png' /></div>
			</td></tr><tr>
			<td class='td_setting' style='display:none;'>
				<div class='setting_name'>
					<img src='/images/setting.png' />
					<span>Настройки поиска</span>
				</div>
				<div class='setting_window'>
					<table>
					<?foreach($arSearchOption as $option){?>
					<tr><td class='no_select'>
						<div class="shadow">
							<div class='checkbox <?=$option['CLASS']?> <?if($_REQUEST[$option["CLASS"]]){ echo 'active';}?>' data-checkbox='<?=$option['CLASS']?>'></div>
						</div>
					</td><td>
						<div class='group_by_book checkbox_name ' data-checkbox='<?=$option['CLASS']?>'>
							<?=$option['NAME']?>
						</div>
					</td></tr>
					<?}?>
					</table>
				</div>
			</td>
		</tr>
	</table>

	<div class='search_result'>
		<?if($_REQUEST['text']){?>
			<?$APPLICATION->IncludeComponent("larshin:search_result",
				"mobile_default", 
				array(
					'text'=>$_REQUEST['text'],
					'hight_search'=>$_REQUEST['hight_search'],
					'all_result'=>$_REQUEST['all_result'],
					'sort_book'=>$_REQUEST['sort_book'],
					'in_book_search'=>$_REQUEST['in_book_search'],
				),
				false
			);?>
		<?}?>
	</div>
</div>
<style>
.search input {
    width: 300px !important;
}
</style>