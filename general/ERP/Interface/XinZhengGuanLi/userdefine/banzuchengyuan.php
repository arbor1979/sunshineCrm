<?php
//##########################################################
//��ʽ��_add _view _Value		˵���Ա�����ʽ
//userDefineInforStatus_add		������༭�ĺ������ƣ�����������ǰ��Ϊ����ͼ������Ϊ�ֶ�����ֵ
//userDefineInforStatus_view	������ͼ����˵��
//userDefineInforStatus_Value	�б���ͼ˵��
//#########################################################
//ѧ�����ಿ�֡�
//#########################################################

function banzuchengyuan_add($fields,$i)		{
	$��Ա���� = $fields['value']['��Ա����'];
	$��Ա����Array = explode(',',$��Ա����);
	for($i=0;$i<sizeof($��Ա����Array);$i++)		{
		$��Ա����TEXT = $��Ա����Array[$i];
		if($��Ա����TEXT!="")			{
			$USER_NAME_TEXT	.= returntablefield("user","USER_ID",$��Ա����TEXT,"USER_NAME").",";
			$USER_ID_TEXT	.= $��Ա����TEXT.",";
		}
		if($USER_NAME_TEXT=="")		{
			$USER_ID_TEXT	.= returntablefield("user","USER_NAME",$��Ա����TEXT,"USER_ID").",";
			$USER_NAME_TEXT	.= $��Ա����TEXT.",";
		}
	}
	//print $USER_ID_TEXT;
	//print $USER_NAME_TEXT;
	if($USER_ID_TEXT==",") $USER_ID_TEXT = '';
	if($USER_NAME_TEXT==",") $USER_NAME_TEXT = '';
	print "<tr>
		  <td nowrap class='TableData' align='center'>��Ȩ��Χ��<br>����Ա��</td>
		  <td class='TableData' colspan=2>
			<input type='hidden' name='COPY_TO_ID' value='$USER_ID_TEXT'>
			<textarea cols=40 name='COPY_TO_NAME' rows=6 class='BigStatic' wrap='yes' readonly>".$USER_NAME_TEXT."</textarea>
			&nbsp;<input type='button' value='�� ��' class='SmallButton' onClick=\"SelectUser('','COPY_TO_ID','COPY_TO_NAME')\" title='ѡ����Ա' name='button'>
			&nbsp;<input type='button' value='�� ��' class='SmallButton' onClick=\"ClearUser('COPY_TO_ID','COPY_TO_NAME')\" title='�����Ա' name='button'>
		  </td>
	   </tr>";
}

?>