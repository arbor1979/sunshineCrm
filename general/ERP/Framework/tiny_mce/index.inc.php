<!-- TinyMCE -->
<?php 
	$jsfilename=ROOT_DIR."general/ERP/Framework/tiny_mce/tiny_mce.js";
	$cssfilename=ROOT_DIR."general/ERP/Framework/tiny_mce/css/content.css";
	
?>

<script type="text/javascript" src="<?php echo $jsfilename?>"></script>
<script type="text/javascript">
tinyMCE.init({
	language: "ch",
	mode : "exact",
	elements : "elm1", 
	// General options
	theme : "advanced",
	plugins : "advimage,advlink,insertdatetime,preview,contextmenu,paste,advlist,autoresize,autosave,fullscreen",
	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "forecolor,backcolor,|,cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,image,cleanup,code,|,insertdate,inserttime,preview,|,fullscreen",
	
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	content_css : "<?php echo $cssfilename?>"


});
</script>
<!-- /TinyMCE -->
<div>
	<textarea id="elm1" name="<?php echo $var?>" rows="15" cols="70" style="width:585px; ">
	<?php echo $var_value?>
	</textarea>
</div>