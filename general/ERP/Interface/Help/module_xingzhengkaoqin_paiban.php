<?

	if($_GET['action']==''||$_GET['action']=='init_default')		{
		$PrintText = "<BR><table class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		排班：<BR>
&nbsp;&nbsp;①就是针对人员和组别信息，按照一天内班次信息的设置进行排班。<BR>
&nbsp;&nbsp;②里面会记录某一天，某一班次下面所上班的人员的信息（按组别排班会把该组别下面所有人员加入排班，按人员选取则可以实现按某一人单一排班的条件）。
		</font></td></table>";
		print $PrintText;
	}

?>