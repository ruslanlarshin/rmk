<div class='review_component'>
<?if($arResult['PAGE']==1){?>
	<div class='review_title_Main'>
		<span>Отзывы<span>
		<span  class='all_result'><?=$arResult["ALL"]?> отзывов</span>
	</div>
	
	<?/*<div class='review_sort'> сортировать по</div>
	<div class='review_all'><?=$arResult['ALL']?></div>*/?>
<?}?>
<?foreach($arResult['ITEMS'] as $item){?>
		<div class='review_item'>
			<div class='review_title'>Отзыв о <?=$item['ELEMENT']?></div>
			<div class='review_autor'><?=$item['USER']?></div>
			<div class='review_preview'><?=$item['TEXT']?></div>
			<div class='review_works'><?=$item['DOLJNOST']?></div> 
		</div>
<?	}?>
	<?if(!$arResult['STOP']){?>
		<div class='ajax_result'>
			<div class='review_button_parent'>
				<div class='review_more' data-templates="<?=$this->GetFolder()?>" data-page="<?=($arResult['PAGE']*1+1) ?>" data-count="<?=$arResult['COUNT']?>">Больше отзывов</div>
			</div>
		</div>
	<?}?>
</div>
<script>
$(document).ready(function(){
	$('body').on('click', '.review_more', function(){
		var urls=$('.review_more').attr('data-templates');
		var page=$(this).attr('data-page');
		var counts=$(this).attr('data-count');
		data='PAGE='+page+'&COUNT='+counts;
		$.ajax({
			type: "POST", 
			url: urls+"/ajax.php", 
			data: data,
				success: function(html){ 
					$(".ajax_result").html(html); 
					//history.pushState(null, null, '/search/test.php?'+data);
				}
		});/**/
	});
	
});
</script>
<Style>
@media (max-width: 767px) {
		.review_title_Main{
			max-width: 430px !important;
		}
		.review_item{
			width: 450px  !important;
		}
		.all_result{
			display:block !important;
			float: none !important;
		}
}
.all_result{
	float: right;
	color: #888888;
	font-size: 12px;
	font-weight: normal;
    text-decoration: underline;
}
.review_title_Main{
	font-size:24px;
	font-weight: bold;
	text-align: left;
	max-width: 1050px;
    margin: 0 auto; 
}
.review_sort{
	text-align: left;
	margin-left: 100px;
}
.review_all{
	text-align: right;
	margin-right: 100px;
}
.review_button_parent{
	width:100%;
	text-align: center;
}
.review_component{
	width: 100%;
	text-align: center;
}
.review_item{
	text-align: left;
	width: 320px;
	display: inline-block;
	height:300px;
	margin: 20px;
    padding: 20px;
    font-size: 14px;
    line-height: 28px;
    color: #000000;
    background: #f7f7f7;
    border-radius: 15px;
    border: none;
    text-decoration: none;
	vertical-align: top;
	
}
.review_title{
	height: 20px;
	font-weight: bold;
	font-family: "Montserrat", sans-serif !important;
}
.review_autor{
	height: 20px;
	font-size: 14px;
	margin-top: -1px;
	margin-bottom: 20px; 
}
.review_preview{
	font-size: 13px;
    line-height: 20px;
    color: #000000;
	height: 180px;
	overflow: hidden;
}
.review_works{
	font-weight: bold;
	font-size: 14px;
	height: 25px;
    overflow: hidden;
}
.review_more{
	margin:0 auto;
	display: block;
    height: 40px;
    font-size: 14px;
    font-weight: bold;
    letter-spacing: 0;
	color: #ffffff;
	background: #0e9bd4;
	width: 250px;
	border-radius: 20px;
	padding-top: 8px;
	margin-top: 20px;
	cursor: pointer;
}
</style>