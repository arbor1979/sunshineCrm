<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
error_reporting(E_WARNING | E_ERROR);
header("Content-type:text/html;charset=gb2312");
session_start();
require_once("lib.inc.php");
print "
<head>
<style type=\"text/css\">
body {margin:0px;padding:0px;font-size:12px;text-align:center;background:#D8F9FE;}
.comments {
 width:100%;
 overflow:auto;
 word-break:break-all;
 margin:0px;
 padding:0px;
 background:#FFFDC8;
 }
</style>
<LINK href=\"../../../theme/3/images/style.css\" rel=stylesheet>
</head>
<body>
";
$user_id = $_SESSION['LOGIN_USER_ID'];

$MAX_COUNT= "6";
$module_desc = "CRM�����ǩ";
$module_body = "";
//if ( $MODULE_FUNC_ID == "" || find_id( $USER_FUNC_ID_STR, $MODULE_FUNC_ID ) )
//{
				$query = "select * from crm_mytable_notes where ������ID='".$user_id."';";
				$rs = $db->CacheExecute(2,$query);
				$rs_a = $rs->GetArray();
                if(count($rs_a)>0){
					for($i=0;$i<count($rs_a);$i++){
						$MY_NOTES .= $rs_a[$i]['��ǩ����'];
						//$MY_NOTES .= "[";
						//$MY_NOTES .= $rs_a[$i]['����ʱ��'];
						//$MY_NOTES .= "]";
					}
				}
				$module_body .= "<script type=\"text/javascript\" src=\"mytable.js\"></script>";
				$module_body .= "<script type=\"text/javascript\" src=\"utility.js\"></script>";
         
				$module_body .= "<div style=\"width:100%\">
				<textarea id=\"update\" class='comments' onblur=\"save_notes()\"  rows=10>".htmlspecialchars( $MY_NOTES )."</textarea>
				</div>
				<script language=\"JavaScript\">
                var timeout=60000;
                function save_notes()
				{
					var req = getXMLHttpObj();
					req.open(\"POST\", \"crm_config_notes.php\",true);
					req.setRequestHeader(\"Method\", \"POST crm_config_notes.php HTTP/1.1\");
					req.setRequestHeader(\"Content-Type\", \"application/x-www-form-urlencoded\");
					req.onreadystatechange = function() {
						if (req.readyState == 4){
							var s;
							try {
								   s = req.status;
								}catch (ex){
								   alert(ex.description);
							    }
								if (s == 200){
								   if(req.responseText.substr(0,3)!=\"+OK\"){
										alert(\"�����ǩ���ݴ��󣬴�����Ϣ��\\n\"+req.responseText);
										window.setTimeout(\"save_notes()\", timeout);
										timeout = timeout*2;
									}
									else
									{
										timeout=60000;
									}
								}
								else
								{
									alert(\"�����ǩ���ݴ��󣬴�����룺\"+s);
									window.setTimeout(\"save_notes()\", timeout);
									timeout = timeout*2;
								}
						}
					}
					req.send(\"CONTENT=\"+encodeURIComponent(\$(\"update\").value));
                }
				</script>";
				//encodeURIComponent()

echo $module_body;
//}
?>
</body>
</html>
<?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>
