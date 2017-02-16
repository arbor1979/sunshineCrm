<?php
	ini_set('display_errors', 1);
	ini_set('error_reporting', E_ALL);
	error_reporting(E_WARNING | E_ERROR);
	require_once('lib.inc.php');
	$GLOBAL_SESSION=returnsession();

	include("erp_mytable/crm_config_mytable.php");
?>

<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/3/style.css">
<html>
<head>
<title>模块管理</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link rel="stylesheet" type="text/css" href="<?php echo ROOT_DIR?>theme/3/dialog.css" />

<script type="text/javascript" src="<?php echo ROOT_DIR?>inc/js/utility.js"></script>
<script type="text/javascript" src="<?php echo ROOT_DIR?>inc/js/module.js"></script>
<script src="<?php echo ROOT_DIR?>inc/js/dialog.js"></script>

<script Language="JavaScript">
function delete_url(MODULE_ID)
{
 msg='确认要暂停该模块吗？';
 if(window.confirm(msg))
 {
  URL="delete.php?MODULE_ID=" + MODULE_ID;
  window.location=URL;
 }
}

//显示“用我的设置更新其他用户”窗口 by dq 090613
function set_mine_to_others()
{
   ShowDialog("optionBlock");
}

function set_others_submit() {
   var statc_str = document.getElementById("statc_str").value;

   mytop=(screen.availHeight-430) / 2;
   myleft=(screen.availWidth-600) / 2;
   window.open("/module/feedback/?FEED_BACK_CONTENT=" + statc_str,"","height=430,width=600,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top="+mytop+",left="+myleft+", resizable=yes");
}

function set_success()
{
   alert("更新成功！");
   HideDialog('optionBlock');
}

function CheckForm()
{
   if(document.form2.COPY_TO_ID.value=="")
   {
   	 alert("请指定要更新的人员！");
     return (false);
   }

   return (true);
}

</script>
</head>

<body class="bodycolor" topmargin="5">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
  <tr>
    <td class="Big"><span class="big3">&nbsp;CRM桌面参数设置</span>
    </td>
  </tr>
</table>
<table class="TableBlock" width="500" align="center">
  <form action="crm_mytable_set.php?check=upd"  method="post" name="form1">
   <tr class="TableHeader">
    <td colspan="2">CRM桌面全局设置</td>
   </tr>
   <tr class="TableData">
    <td>CRM桌面设置：</td>
    <td>
      <input type="checkbox" name="mokuaiweizhi" id="mokuaiweizhi" checked/><label for="mokuaiweizhi">允许用户调整各桌面模块位置</label><br>
	  <input type="checkbox" name="xianshitiaoshu" id="xianshitiaoshu" checked/><label for="xianshitiaoshu">允许用户调整各桌面模块显示条数</label><br>
      <input type="checkbox" name="lanmukuandu" id="lanmukuandu" <?phpif($左右栏目宽度 == 'on'){ echo "checked";}?>/><label for="lanmukuandu">允许用户调整左右栏目宽度</label><br>
      <input type="checkbox" name="shangxiagundong" id="shangxiagundong" <?phpif($上下滚动显示 == 'on'){ echo "checked";}?>/><label for="shangxiagundong">允许用户设置列表上下滚动显示</label><br>
      <input type="checkbox" name="zhankaizhedie" id="zhankaizhedie" <?phpif($展开折叠模块 == 'on'){ echo "checked";}?>/><label for="zhankaizhedie">允许用户展开/折叠桌面模块</label><br>
    </td>
   </tr>
   <tr class="TableData">
    <td>左侧栏目宽度：</td>
    <td><input type="text" name="left_width" class="BigInput" size="5" <?phpif($左侧栏目宽度 != ''){ echo "value='".$左侧栏目宽度."'";}else{echo "value=60";}?>>%</td>
   </tr>
   <tr class="TableData">
    <td>各模块显示行数：</td>
    <td><input type="text" name="hanshu" class="BigInput" size="5" <?phpif($各模块显示行数 != ''){ echo "value='".$各模块显示行数."'";}else{echo "value=5";}?>>行 注：不要>4</td>
   </tr>
   <tr class="TableData">
    <td width="130">桌面模块默认值<br>批量设置</td>
    <td>
      <input type="checkbox" name="gongdun" id="gongdun" <?phpif($列表上下滚动显示 == 'on'){ echo "checked";}?>/><label for="gongdun">列表上下滚动显示</label><br>
      <input type="checkbox" name="hanshu_gundong_all" id="hanshu_gundong_all" <?phpif($批量应用 == 'on'){ echo "checked";}?>/><label for="hanshu_gundong_all">确认把每模块显示行数、滚动显示设置批量应用到所有模块</label><br>
    </td>
   </tr>
   <tr>
    <td nowrap  class="TableControl" colspan="2" align="center">
       <input type="submit" value="确定" class="BigButton">&nbsp;&nbsp;
       <input type="reset" value="重置" class="BigButton">
                  <!-- <a href="javascript:;" onClick="set_mine_to_others();">用我的设置更新其他用户(与我当前桌面看到的一致)</a> -->
    </td>
   </tr>
  </form>


<!-- 隐藏帧，用我的设置更新其他用户时使用 by dq 090617
<iframe name="hiddenFrame" id="hiddenFrame" width=0 height=0 frameborder=0 scrolling=no></iframe>
-->

</body>
</html>

<?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>