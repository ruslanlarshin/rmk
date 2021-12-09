var Search = {};
Search.load_light_result=function(data){
	$(".search_result_add_verse_compomemt").html('<div style="width: 98%; position: absolute; text-align:center; vertical-align: middle; top: 45%;"<img src="/images/load.gif" /</div'); 
	var url=$('.search_component').attr('data-template');
	$.ajax({
		type: "POST", 
		url: url+"/ajax.php", 
		data: data,
			success: function(html){ 
				$(".search_result_add_verse_compomemt").html(html); 
				//history.pushState(null, null, '/search/?'+data);
			}
	});
}
Search.get_option=function(text){
	var data='text='+text;
	$('.request_options div').each(function(){
		if($(this).text()!='' && $(this).attr('data-class')!='text'){
			data=data+'&'+$(this).attr('data-class')+'='+$(this).text();
		}
    });
	return data;
}
Search.load_search_from_enter=function(){
		var keyCode = event.keyCode ? event.keyCode :
		event.charCode ? event.charCode :
		event.which ? event.which : void 0;
		if(keyCode == 13)
		{
			if($('.search input').val()!=''){
			//alert(Search.get_option($('.search input').val()));
				Search.load_light_result(Search.get_option($('.search input').val()));
			}
		}
}
Search.checkbox_from_name_checked=function(){
	$('body').on('click', '.checkbox_name', function(){
		var clas=$(this).attr('data-checkbox');
		if(clas!='' && clas!='undefined'){
			$('.'+clas).click();
			
		}
	});
}
Search.checkbox_click=function(clas){
	var text='';
	if($('.request_options .'+clas).text()!="Y"){
		text='Y';
	}
	$('.request_options .'+clas).text(text);	
	$('.serach_table').addClass('load');
}
Search.setting_change=function(){
	if($('.td_setting').hasClass('active')){
		$('.td_setting').removeClass('active');
	}else{
		$('.td_setting').addClass('active');
	}
	if($('.serach_table').hasClass('load')){
		Search.load_light_result(Search.get_option($('.search input').val()));
		$('.serach_table').removeClass('load');
	}
}
$(document).ready(function(){
	$('body').on('keypress', '.search input', function(event){
		Search.load_search_from_enter();
	});
	$('body').on('click', '.search img', function(){
		Search.load_light_result(Search.get_option($('.search input').val()));
	});
	$('body').on('mouseenter', '.setting_name', function(){
		Search.setting_change();
	});
	$('body').on('mouseleave', '.setting_window', function(){
		Search.setting_change();
	});
	$('body').on('click', '.setting_window .checkbox', function(){
		var clas=$(this).attr('data-checkbox');
		Search.checkbox_click(clas);
	});
	Search.checkbox_from_name_checked();
	$('body').on('click', '.checkbox', function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			$(this).parent('.shadow').removeClass('active');
		}else{
			$(this).addClass('active');
			$(this).parent('.shadow').addClass('active');
		}
	});
	
});