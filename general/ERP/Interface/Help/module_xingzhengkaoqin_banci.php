<?

if($_GET['action']==''||$_GET['action']=='init_default')		{
		$PrintText  = "<BR><table class=TableBlock align=center width=100%>";
		$PrintText .= "<TR class=TableContent><td ><font color=green >
		备注：<BR>
&nbsp;&nbsp;班次管理一和班次管理二两个字段，设置完成以后主要用于限定该班次下面所属考勤记录的管理权限。<BR>
		示例：<BR>
&nbsp;&nbsp;早操是学生科负责管理,晚督修是教务科负责管理，其他班次是人事科负责管理等。<BR>

		班次：<BR>
&nbsp;&nbsp;①就是日常上班中的班次信息，常见的如上午班，下午班，不是很常见的如例行会议班，早操班等。<BR>
&nbsp;&nbsp;②一个班次对应一个开始时间和结束时间。<BR>
&nbsp;&nbsp;③不同班次的起止时间应当不要有冲突现象，如从早上到晚上按时间线进行设置班次。<BR>
&nbsp;&nbsp;④如果有时间重叠的班次存在，那么在排班的时候需要注意，一个人员在同一时间段内不要同时拥有两个班次（这个不是强制的，也可以这样安排）。
		</font></td></table>";
		print $PrintText;
}

?>