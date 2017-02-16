<?php

if($_GET['action']==''||$_GET['action']=='init_default')		{
	$PrintText = '';
	$PrintText .= "<BR><table  class=TableBlock align=center width=100%>";
	$PrintText .= "<TR class=TableContent><td ><font color=green >
消息中心提醒规则设定部分说明：<BR>
&nbsp;&nbsp;1 支持新增数据,更改数据,删除数据时的触发类型<BR>
&nbsp;&nbsp;2 每一种触发类型支持自主选择对象数据源,提醒对象(表字段存储提醒对象),提醒人员(手工指定提醒人员),以及提醒消息的内容模板(支持变量)<BR>
&nbsp;&nbsp;3 同时增加是否启用,可设置提醒消息的目标(OA短消息,电子邮件,消息中心等),支持跳转路径信息设置<BR>
&nbsp;&nbsp;4 同时增加判断功能,如某一数据字段等于某一判断值等才会触发等规则等<BR>
&nbsp;&nbsp;5 同时支持消息提醒的发送源设置,可设置该消息的发送人,如不设置,则会进行默认<BR>
&nbsp;&nbsp;6 支持消息规则分组功能,便于管理众多提醒消息规则<BR>
<font color=red >&nbsp;&nbsp;7 消息中心运行可能会增加一些系统开销,为加快系统运行速度,你可以在'提醒周期'菜单中关闭消息中心的运行<BR></font>


</font></td></table>";
	print $PrintText;
}


?>