<?php
function summarize_template($infor)		{
global $common_html;
?>
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
  <tr>
    <td class="Small"><img src="images/yesbox.gif" ><b> <?php echo $infor['title']?></b>
    </td>
    </tr>
</table>

<br>

<table border="0" cellspacing="1" width="500" class="small" bgcolor="#000000" cellpadding="3" align="center">
    <tr class="TableHeader">
      <td nowrap align="center" width="200"><?php echo $common_html['common_html']['folder']?></td>
      <td nowrap align="center"><?php echo $common_html['common_html']['num']?></td>
    </tr>
    <tr class="TableData">
      <td nowrap width="200"><img src="images/inbox.gif">&nbsp;&nbsp;<a href="?action=init_inbox"><?php echo $common_html['common_html']['inbox']?></a>
      </td>
      <td>¡¡¡¡¡¡¡¡¡¡<?php echo $infor['inbox']['num']?> £¨<?php echo $infor['inbox']['new']?> <?php echo $common_html['common_html']['notread']?>£©</td>
    </tr>
    <tr class="TableData">
      <td nowrap width="200"><img src="images/outbox.gif">&nbsp;&nbsp;<a href="?action=init_outbox"><?php echo $common_html['common_html']['outbox']?></a></td>
      <td>¡¡¡¡¡¡¡¡¡¡<?php echo $infor['outbox']['num']?></td>
    </tr>
    <tr class="TableControl">
      <td align="center" colspan="3">
       <input type="button" value="¡¡<?php echo $common_html['common_html']['compose']?>¡¡" class="SmallButton" onclick="location='?action=add_outbox'" title="<?php echo $common_html['common_html']['compose']?>">
      </td>
    </tr>
</table>
<?php
}

function summarize_template_mytable($infor)		{
global $common_html;//print_R($infor);
$file_ini=parse_ini_file("Model/mytable_newai.ini",true);
$array_index=array_keys($file_ini);
$modulename='email';
$tablename=$file_ini[$modulename]['tablename'];
$link=$file_ini[$modulename]['link'];
$width=$file_ini[$modulename]['width'];

?>
<table border="0" cellspacing="1" width="<?php echo $width?>" class="small" bgcolor="#000000" cellpadding="3">
<TBODY>
<TR class=TableHeader>
<TD noWrap><?php echo $infor['title']?>&nbsp;</TD>
</TR>
    <tr class="TableData">
      <td nowrap width="200">&nbsp;&nbsp;<a href="<?php echo $link?>?action=init_inbox"><?php echo $common_html['common_html']['inbox']?></a>
      <?php echo $infor['inbox']['num']?> £¨<?php echo $infor['inbox']['new']?> <?php echo $common_html['common_html']['notread']?>£©</td>
    </tr>
    <tr class="TableData">
      <td nowrap width="200">&nbsp;&nbsp;<a href="<?php echo $link?>?action=init_outbox"><?php echo $common_html['common_html']['outbox']?></a>
	  <?php echo $infor['outbox']['num']?></td>
    </tr>
    <tr class="TableControl">
      <td align="right" colspan="3">
       <a href="email_newai.php?action=add_outbox"><?php echo $common_html['common_html']['write']?></a>..
      </td>
    </tr>
</table>
<?php
}

function project_framework($mode='project_framework')		{
	global $menu_top,$common_html,$html_etc,$columns,$primary;
	$primarykey_index=$columns[$primary];
	$linktext=$primarykey_index."=".$_GET[$primarykey_index];
	$menu_top_array=explode(',',$menu_top);
	switch($mode)			{
		case 'project_framework':
			print "<frameset rows='30,*'  cols='*' frameborder='yes' border='0' framespacing='0' id='frame1'>
			<frame name=menu_top scrolling=no src='project_newai.php?action=menutop_default&$linktext' frameborder=0>
			<frame name='menu_main' scrolling='auto' src='project_newai.php?action=view_default&$linktext' frameborder='1'>
			</frameset>\n";
			break;
		case 'project_fw_menu':
			print "<script>
			var menu_id=0;
			function setPointer(theRow, thePointerColor,menu_id_over)
			{
			  if(menu_id!=menu_id_over)
			     theRow.bgColor = thePointerColor;
			}";
			$counter=1;
			foreach($menu_top_array as $list)		{
			$list_array=explode(':',$list);
			print "
			function view_menu".$counter."()
			{
			  if(menu_id!=0)
 			  parent.menu_main.location='".$list_array[2]."?action=".$list_array[3]."&".$linktext."';
 			  menu_id=".$counter.";
			  ";//end print
			  for($i=1;$i<=sizeof($menu_top_array);$i++)	{
				  if($counter==$i)
					  print "menu_$i.bgColor='#D9E8FF';";
				  else	
					  print "menu_$i.bgColor='#DDDDDD';";
			  }
			  $counter++;
			print "}\n";
			}//end foreach
			print " 
			</script>
			</head>

			<body topmargin='0' leftmargin='0' onload='view_menu1()'>

			<TABLE class='Small' cellspacing='0' height='100%' width='100%' bgcolor='#DDDDDD' border='1' cellpadding='1' bordercolorlight='#000000' bordercolordark='#FFFFFF'>
			 <TR>";
			$counter=1;
			foreach($menu_top_array as $list)		{
			$list_array=explode(':',$list);
			print "			
			   <TD width='150' title='".$list_array[0]."' id='menu_".$counter."' onclick='view_menu".$counter."()' onmouseover=\"setPointer(this, '#B3D1FF','$counter')\" onmouseout=\"setPointer(this, '#DDDDDD','$counter')\" style=\"cursor:pointer\">
			       <img src='images/".$list_array[1]."' WIDTH='22' HEIGHT='18'><b><font color='#000000'>".$common_html['common_html'][(string)$list_array[0]]."</span>
			   </TD>";
			$counter++;
			}

			print "   
			   <TD>
			   </TD>

			   </TR>
			</TABLE>";
			break;

	}

}
?>