<?php
	require_once('lib.inc.php');
	$PHP_SELF_ARRAY = explode('/',$_SERVER['PHP_SELF']);
	array_pop($PHP_SELF_ARRAY);
	$PHP_SELF = join('/',$PHP_SELF_ARRAY);
	$http = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."".$PHP_SELF;

	//selectSql = "select * from flow_process where functionID not in (" + 
	//$funcList     = array();
	//$processList  = array(); //���ϵͳ�д��ڵ����̲���
	//$hrefList     = array(); //������̲����Ӧ��hrefLink��
	////�����û�id��ȡ���з���Ȩ�޵�func_id��
	//$sql = "select func_id_str from td_oa.user_priv,td_oa.user where user_priv.user_priv=user.user_priv and user.user_name='admin'";
	//$rs = $db->Execute($sql);
	//$rs_a = $rs->GetArray();print_R($rs_a);
	//����û��ķ�� select theme from user where user_id='admin' 
	//�������̵�ID�Ż�ȡ���е����̲��� 

	//����û��ķ��
	$theme = "1";
	$flowid = $_GET['flowid']; if($flowid=='') $flowid = 7 ;
	$sql = "select * from flow_process where flowID='$flowid'";
	$rs = $db->Execute($sql);
	$rsEA = $rs->GetArray();//print_R($sql);print "<HR>";
	$processList = array();
	$hrefList = array();
	for($i=0;$i<sizeof($rsEA);$i++)				{
		$functionID = $rsEA[$i]['functionID'];
		$selectSql = "select * from sys_function where FUNC_ID='".$functionID."'";
		//print $selectSql;	
		$rsOA = $db->Execute($selectSql);
		$rsOA_a = $rsOA->GetArray();//print_R($rsOA_a);print "<HR>";
		if($rsOA_a[0]['MENU_ID']!=0)	{
			$MENU_ID = $rsOA_a[0]['MENU_ID'];
			//print $MENU_ID."<BR>";
			//$MENU_ID = substr($MENU_ID,0,4);
			//$selectSql2 = "select * from sys_function where MENU_ID='".$MENU_ID."'";
			//$rsOA2 = $db->Execute($selectSql2);
			//$rsOA_a2 = $rsOA2->GetArray();print_R($selectSql2);print "<HR>";
			//if(sizeof($rsOA_a2)>0)	{
				$processID = $rsEA[$i]['processID'];
				$func_code = $rsOA_a[0]['FUNC_CODE'];
				array_push($processList,$processID);
				//print_R($_SERVER['SERVER_NAME']);
				//print strlen($FUNC_LINK);
				$FUNC_LINK = $rsOA_a[0]['FUNC_LINK'];
				//print substr($FUNC_LINK,3,strlen($FUNC_LINK))."<BR>";
				$FUNC_LINK_SHORT = substr($FUNC_LINK,0,2);
				if($FUNC_LINK_SHORT=="..")	{
					$FUNC_LINK = "$http/".substr($FUNC_LINK,17,strlen($FUNC_LINK));
				}
				else	{
					$FUNC_LINK = $http."../../Framework/".$FUNC_LINK;
				}
				$URL_LINK[$processID] = $FUNC_LINK;
				array_push($hrefList,$func_code);
			//}
		}
	}
	//print_R($URL_LINK);
	//print_R($hrefList);

//���ɲ���

?>

<html xmlns:vml="urn:schemas-microsoft-com:vml">
	<head>
		<title>ҵ������ͼ</title>
		<script language="javascript" src="flowgraph/flowgraph.js"></script>
		<link rel="stylesheet" type="text/css" href="../../theme/3/style.css">
		<OBJECT id="vmlRender" classid="CLSID:10072CEC-8CC1-11D1-986E-00A0C955B42E" VIEWASTEXT></OBJECT>
		<style>vml\:* { FONT-SIZE: 15px; BEHAVIOR: url(#VMLRender);} </style>
	</head>
	<body  class='bodycolor' topmargin="5" leftmargin="5">
		<form>
		<table>
		<tr>
		<td>
		<vml:group ID="FlowVML"  style="left:100;top:50;width:800px;height:500px;position:relative;" coordsize="800,800">
		<?php
		//hrefLink hasLink
		//print_R($rsEA);
		for($i=0;$i<sizeof($rsEA);$i++)			{
			$processID = $rsEA[$i]['processID'];
			if(in_array($processID,$processList))	{
			$fromX = $rsEA[$i]['locationX'];
			$fromY = $rsEA[$i]['locationY'];
			$processName = $rsEA[$i]['processName'];
			$functionID = $rsEA[$i]['functionID'];
			$toProcess = $rsEA[$i]['toProcess'];
			$text = "'".$rsEA[$i]['processName']."'";
			$hrefLink = $URL_LINK[$processID];//�˴�Ϊ��Ҫ���ӵĵ�ַ
			//boolean hasLink  = funcList.contains(rsEA.getString("functionID"));
			$hasLink = true;

			?>
					<script language="javascript">
					//������ͼ����ؾ��ο�
					document.write(getRectHTML(100, 50, <?php echo $fromX?>, <?php echo $fromY?>, <?php echo $text?>,'<?php echo $hrefLink?>',true)); 
					</script>
					
			<?php
			//�ֽ�toProcess�õ�ÿ�������߶�Ӧ�����̲���ID�ź������ߵ���������
			//toProcess�ĸ�ʽΪP_C;P_C;...,����PΪ�������̲����ID��,CΪ�����ߵ��������У�ÿ����֮����;����
			$startPos = 0;
			$endPos   = -1;
			$toProcess = $rsEA[$i]['toProcess'];
			if($toProcess!="")				{
				$toProcessArray1 = explode(';',$toProcess);
				for($k=0;$k<sizeof($toProcessArray1);$k++)			{
					$Element = $toProcessArray1[$k];

					$toProcessArray = explode('_',$Element);
					$line = $toProcessArray[1];
					print "<script language=\"javascript\">document.write(getLineHTML('$line',true));</script>\n";
				}
			}

			}//end processID

			/*
						endPos  = toProcess.indexOf(";", startPos);
							if (endPos != -1)
							{
								line = toProcess.substring(startPos, endPos);
								processID = line.substring(0,line.indexOf("_"));
								line = line.substring(line.indexOf("_") + 1, line.length());
							}
							else
							{
								line = toProcess.substring(startPos, toProcess.length());
								processID = line.substring(0,line.indexOf("_"));
								line = line.substring(line.indexOf("_") + 1, line.length());
							}
							if (processList.contains(processID)) {
			*/
		}

		?>

		</vml:group>
		</td>
		</tr>
		<table>
		</form>
	</body>
</html>