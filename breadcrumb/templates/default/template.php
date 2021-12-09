
<div class="breadcrumb-block" itemscope itemtype="http://schema.org/BreadcrumbList">
	<?foreach($arResult['PARAM'] as $name=>$value){?>
		<?if($value){?>
			<a href="<?=$value?>" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?=$name?></a>
		<?}else{?>
			<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><?=$name?><span>
		<?}?>
	<?}?>
</div>
<style>
.page-header{
	display: none;
}
</style>