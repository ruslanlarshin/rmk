<?//$APPLICATION->SetAdditionalCSS($_SERVER["DOCUMENT_ROOT"].$this->GetFolder().'/style.css',true);?>
<link rel="stylesheet" type="text/css" href="<?=$this->GetFolder()?>/style.css">
<div class="header-block_search"> 
	<div class='search_input_form' data-template='<?=$this->GetFolder()?>' action="/search/" method="get">
		<input class='search_input_form_text' type="text" name="text" value="<?=$_REQUEST['search']?>">
		<input type="hidden" name="searchid" value="2470892">
		<button type="button" class='search_button'><i class="fas fa-search"></i>Найти</button>
	</div>
</div>
<style>
.search_input_form{
	max-width: 700px;
    margin-bottom: 30px;
	isplay: block;
    position: relative;
}
</style>
<script>
var Search = {};
Search.get_option=function(text){
	var data='search='+text;
	return data;
}
Search.load_light_result=function(data){
	$(".search_result").html('<div style="width: 98%; position: absolute; text-align:center; vertical-align: middle; top: 45%;"<img src="/images/load.gif" /</div'); 
	var url=$('.search_input_form').attr('data-template');
	$(".search_result").addClass('load');
	$.ajax({
		type: "POST", 
		url: url+"/ajax.php", 
		data: data,
			success: function(html){ 
				$(".search_result").html(html); 
				$(".search_result").removeClass('load');
				history.pushState(null, null, '/search/test.php?'+data);
			}
	});
}
Search.load_search_from_enter=function(){
		var keyCode = event.keyCode ? event.keyCode :
		event.charCode ? event.charCode :
		event.which ? event.which : void 0;
		if(keyCode == 13)
		{
			if($('.search_input_form_text').val()!=''){
			//alert(Search.get_option($('.search input').val()));
				Search.load_light_result(Search.get_option($('.search_input_form_text').val()));
			}
		}
}
$(document).ready(function(){
	$('body').on('keypress', '.search_input_form_text', function(event){
		Search.load_search_from_enter();
	});
	$('body').on('click', '.search_button', function(){
		Search.load_light_result(Search.get_option($('.search_input_form_text').val()));
			//alert(Search.get_option($('.search_input_form_text').val()));
	});
});
</script>