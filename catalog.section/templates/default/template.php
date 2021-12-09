
<div class='larshin_left_filter larshin'  data-template='<?=$this->GetFolder()?>' data-section='<?=$arParams["SECTION_ID"]?>'>
	<?
	
	//echo '<pre>'; print_r($_REQUEST); echo '</pre>';
	$APPLICATION->IncludeComponent("larshin:left.filter",
			".default", 
			array(
				"SECTION_ID"=>$arParams["SECTION_ID"],
			),
			false
		);
	?>	
</div>
<div class="catalog-listing_block cataolg_list_result"><?//тут подгружается catalog.list- всегда делаем это через аякс от левого фильтра-это блоок результата?>
	<?$APPLICATION->IncludeComponent("larshin:catalog.list",
			".default", 
			array(
				"SECTION_ID"=>$arCurSection["ID"],
				'TIME'=>0,
			),
			false
		);
	?>	
</div>
<style>
.larshin_left_filter{
	width: 20%;
	float: left;
}
</style>
<script>
var Filter = {};
Filter.getData=function(){
	var data='';
	var i=1;
	data="SECTION_ID="+$('.larshin_left_filter').attr('data-section')+'&';
	$('.larshin_left_filter input:checkbox:checked').each(function(){
		data=data+$(this).attr('data-parent')+'__'+i+'='+$(this).attr('data-code')+'&';	 
		i++;
	});
	return data;
};
Filter.Load=function(data){
	var filter=$('.request_filter').attr('data-filter');
	var url=$('.larshin_left_filter').attr('data-template');
	$.ajax({
		type: "POST", 
		url: url+"/ajax.php", 
		data: data,
			success: function(html){ 
				$(".larshin_left_filter").html(html); 
					$.ajax({
						type: "POST", 
						url: url+"/ajaxList.php", 
						data: data+filter,
							success: function(html){ 
								$(".cataolg_list_result").html(html); 
								
								//$(".search_result").removeClass('load');
								//history.pushState(null, null, '/search/test.php?'+data);
							}
					});
				//$(".search_result").removeClass('load');
				//history.pushState(null, null, '/search/test.php?'+data);
			}
	});
	return data;
};

$(document).ready(function(){
	$('body').on('click', '.filter_checkbox', function(){
		//alert(Filter.getData());
		Filter.Load(Filter.getData());
		//$('.larshin.left.filter .filter_checkbox')
	});
	/*var url=$('.larshin_left_filter').attr('data-template');
	$.ajax({
		type: "POST", 
		url: url+"/ajax.php", 
		data: data,
			success: function(html){ 
				$(".larshin_left_filter").html(html); 
				//$(".search_result").removeClass('load');
				//history.pushState(null, null, '/search/test.php?'+data);
			}
	});*/
});
</script>