
<?use Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss($this->GetFolder().'/style.css');
//Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/myscripts.js");?>
<?//echo '<pre>'; print_r($arResult); echo "</pre>"; ?>
<div class='search_component' style='max-width: 800px; width: 100%;'>
	<?if($arResult["SECTIONS"]){?>
		<span class='inline'>
			<div style=' font-size: 22px;'>
				По запросу <span class='word_search' ><?=$arResult['SEARCH']?></span> найдены разделы:
			</div>
			<img class='sub_button sub_open' data-id='1' src='/images/triangledown.png'/>
			<img class='sub_button sub_close' data-id='1' src='/images/triangleup.png'/>
		</span>
		<div class='sections sub_text sub_text_1' style='display: none;'>
			<?foreach($arResult["SECTIONS"] as $section){?>
				<div class='item' style='width: 100%;margin: 5px 0 0; padding: 5px 0px 5px 20px; font-size: 18px;'>
					<img style='width: 30px;' src="<?= CFile::GetPath($section["IMG"]) ?>"/>
					<a style='border-bottom: none;' href='<?=$section['URL']?>'><?=$section['NAME']?></a>
				</div>
			<?}?>
		</div>
	<?}?>
	<br/>
	<?if($arResult["ITEMS"]){?>
		<div style=' font-size: 22px;'>По запросу <span class='word_search' ><?=$arResult['SEARCH']?></span> найдены <?=count($arResult['ITEMS'])?> <?=$arResult['TOVARI']?>:</div>
			<div class='elements'>
		
					<?foreach($arResult["ITEMS_NAV"] as $element){?>
						<div  class='border'>
							<div class='inline-block' style='width:15%; vertical-align:top;'>
								<div class='img_search_element' style='width: 100px;'><img src="<?=$element["IMG"]?>"/></div>
							</div>
							<div class='inline-block preview_search' style='width:50%;vertical-align:top; margin-right:10px;'>
								<div class='item' style='width: 100%;margin: 5px 0 0; padding: 5px 0px 5px 20px; font-size: 18px;'>
									<a href='<?=$element['URL']?>' style='border-bottom: none;'><?=$element['NAME']?></a>
									<div class='preview' style='border-bottom: none; color: black; font-size: 12px;'><?=$element['PREVIEW']?></div>
								</div>
							</div>
							<div class='inline preview_buttons' style='width:25%;vertical-align:top;'>
								<div class="item-contact" style='width: 195px;'>
									<a href="#modal-order-product" data-id="<?=$element['ID']?>" data-name="<?=$element['NAME']?>" class="btn" data-toggle="modal" data-seller="26064" style='height:40px; margin-bottom: 10px;width: 100%;font-size: 14px;font-family: "Montserrat";font-weight: 600; letter-spacing: 0;'>Запросить КП</a>
									<a href="#modal-ask-question" data-id="<?=$element['ID']?>" data-name="<?=$element['NAME']?>" data-toggle="modal" class="btn btn-bordered" data-seller="26064" style='height:40px;width: 100%;font-size: 14px; font-family: "Montserrat"; font-weight: 600;letter-spacing: 0;font: 600 16px/39px "Roboto Condensed";'>Консультироваться</a>
								</div>
							</div>
						</div>
					<?}?>
				
			</div>
		<?$APPLICATION->IncludeComponent("larshin:pager",
			".default", 
			array(
				"ALL_PAGE"=>$arResult['COUNT'], 
				"PAGE"=>$arResult['PAGE_NUM'],
				'SEARCH'=>$arResult['SEARCH'],
			),
			false
		);
		//echo "<pre>"; print_r($arResult['COUNT']); echo '</pre>';
		//echo "<pre>"; print_r($arResult['PAGE_NUM']); echo '</pre>';
		?>
	<?}else{
		if($arResult['SEARCH']){
			?>
				<div style=' font-size: 22px;'>По запросу <span class='word_search' ><?=$arResult['SEARCH']?></span> ничего не найдено:</div> 
			<?
		}
	}?>
</div>
<style>
@media (max-width: 767px) {
	search_component{
			width: 450px;
	}
	.search_component .inline{
		display: block !important;
	}
	.search_component .preview_search{
		width: 70% !important;
		float: right;
	}
	.search_component .preview_buttons{
		width:100% !important;
		text-align: center;
	}
}
	.border{
		border: 1px solid #e5e5e5;
		border-radius: 15px;
		border-top-left-radius: 0px;
		margin-bottom: 10px;
		padding: 15px;
	}
	.search_component .sub_button{
		width: 20px;
	}
	.search_component .inline,.search_component .inline img,.search_component .inline div{
		display: inline-block ;
	}
	.search_component .inline img{
		cursor : pointer;
	}
	.search_component .item-contact{
		width: 195px;
	}
	.search_component .item-contact .btn{
		display: block;
		width: 100%;
		height: 40px;
		line-height: 40px;
		padding: 0 5px;
		font-size: 14px;
		font-family: "Montserrat";
		font-weight: 600;
		letter-spacing: 0;
	}
	.search_component .sections{
		width : 500px;;
		cursor: pointer;
	}
	.search_component{
		font-size: 22px;
		background: #fff;
		text-decoration: none;
		border-radius: 2px;	
	}
	.search_component .elements{
		display: block;
	}
	.search_component .img_search_element,.search_component .item{
		display: inline-block;
	}
	.search_component .word_search{
		font-weight: bold;
		font-size: 22px;
	}
	.search_component .item{
		font-size: 18px;
		text-decoration: none;
		color: #0092c7;
		margin: 5px 0 0;
		padding: 5px 0px 5px 20px;
		text-align: left; 
		width: 100%;
	}
	.search_component .sections img{
		width: 30px;
	}
	.search_component .elements .img_search_element{
		width: 100px;
	}
	.search_component .sections  .item:hover{
		background: #eef8f8;
		color: #0092c7;
		font-weight: 600;
	}
	.search_component a{
		border-bottom: none !important; 
	}
	.search_component .preview{
		color: black;
		font-size: 12px;
	}

</style>
<script>
$(document).ready(function(){
	subclose();
});
function subclose(){
	$('.sub_text').each(function(){
		$(this).attr('data-height',$(this).height());
		$(this).css({"opacity":"0"});
	});
	$('.sub_button').each(function(){
		var id=$(this).attr('data-id');
			if($(this).hasClass('sub_close')){
				$(this).addClass('sub_close_'+id);
			}
			if($(this).hasClass('sub_open')){
				$(this).addClass('sub_open_'+id);  
			}
		
	});
	//$('.sub_text').attr('data-height',$('.sub_text')attr('height'));
	$('.sub_text').css({"height":"0px"});
	$('.sub_close').css({"display":"none"});
	$('.sub_button').each(function(){
		var id=$(this).attr('data-id');
		if(id==1 || id==2 || id==6){
		//	$(this).click();
		}
	});
} 
$('body').on('click', '.sub_button', function(){
	if(!$(this).hasClass('stop')){
		if($(this).hasClass('sub_open')){
			var id=$(this).attr('data-id');
			$(".sub_text_"+id).css({"display":"block"});
			var height=$(".sub_text_"+id).attr('data-height');
			$('.sub_close_'+id).addClass('stop');
			$('.sub_close_'+id).css({"display":"inline-block"});
			$('.sub_open_'+id).css({"display":"none"});
			//$('.sub_text').css({"height":"auto"});
			$(".sub_text_"+id).css({"opacity":"1"});
			$(".sub_text_"+id).animate({
				height: height+'px'
			},1000, "linear", function(){$('.sub_close_'+id).removeClass('stop');} );
		}else{
			var id=$(this).attr('data-id');
			$(".sub_text_"+id).css({"display":"block"});
			$('.sub_close_'+id).addClass('stop');		
			$('.sub_close_'+id).css({"display":"none"});
			$('.sub_open_'+id).css({"display":"inline-block"});
			$(".sub_text_"+id).animate({
				height: 0+'px'
			},1000, "linear", function(){$(".sub_text_"+id).css({"opacity":"0"});$('.sub_close_'+id).removeClass('stop');});
		}
	}
});
</script>