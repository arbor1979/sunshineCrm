<?php

	require_once("../../Enginee/lib/utility_file.php");
	function uploadFile()
	{
		global $_POST;
		global $_FILES;
		global $ATTACHMENT_ID_OLD;
		global $ATTACHMENT_NAME_OLD;
		if($_POST['ͨ���ʽ�ϴ��ļ�']!="")		{

			
			if(count($_FILES)>1)
			{
			   $ATTACHMENTS		=	upload();
			   $CONTENT			=	ReplaceImageSrc($CONTENT, $ATTACHMENTS);
			   $ATTACHMENT_ID	=	$ATTACHMENT_ID_OLD.$ATTACHMENTS["ID"];
			   $ATTACHMENT_NAME	=	$ATTACHMENT_NAME_OLD.$ATTACHMENTS["NAME"];
			   
			}
			else
			{
			   $ATTACHMENT_ID	=	$ATTACHMENT_ID_OLD;
			   $ATTACHMENT_NAME	=	$ATTACHMENT_NAME_OLD;
			}
			$ATTACHMENT_ID		.=	copy_sel_attach($ATTACH_NAME,$ATTACH_DIR,$DISK_ID);
			$ATTACHMENT_NAME	.=	$ATTACH_NAME;
			$�ϴ������ֶ����� = $_POST['ͨ���ʽ�ϴ��ļ�'];
			//�Ը����ϴ��ֶ����¸�ֵ
			$_POST[$�ϴ������ֶ�����] = $ATTACHMENT_NAME."||".$ATTACHMENT_ID;
			
			//print_R($_POST);print_R($_FILES);print_R($ATTACHMENT_NAME);print_R($ATTACHMENT_ID);exit;
		}
			//ͨ���ʽ�ϴ��ļ��������
	}
	function deleteFile($tablename,$primarykey_index,$element,$fujian)
	{
			$fujianValue=returntablefield($tablename, $primarykey_index, $element, $fujian);
			$fujianValueArray = explode('||',$fujianValue);
			delete_attach($fujianValueArray[1],$fujianValueArray[0]);	
	}
?>