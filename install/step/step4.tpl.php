<?php include 'header.tpl.php';?>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"install",onerror:function(msg){}});
	$("#dbhost").formValidator({onshow:"���ݿ��������ַ, һ��Ϊ localhost",onfocus:"���ݿ��������ַ, һ��Ϊ localhost",oncorrect:"���ݿ��������ַ��ȷ",empty:false}).inputValidator({min:1,onerror:"���ݿ��������ַ����Ϊ��"});
	$("#dbuser").formValidator({onshow:"�û�����MySQL���ݿ���˺�",onfocus:"�û�����MySQL���ݿ���˺�",empty:false}).inputValidator({min:1,onerror:"���ݿ��˺Ų���Ϊ��"});
	$("#pwdconfirm").formValidator({onshow:"���ٴ���������",onfocus:"������ȷ������",oncorrect:"����������ͬ"}).compareValidator({desid:"password",operateor:"=",onerror:"�����������벻ͬ"});
		
	$("#email").formValidator({onshow:"������email",onfocus:"������email",oncorrect:"email��ʽ��ȷ"}).regexValidator({regexp:"email",datatype:"enum",onerror:"email��ʽ����"})
	$("#dbhost").formValidator({onshow:"���ݿ��������ַ, һ��Ϊ localhost",onfocus:"���ݿ��������ַ, һ��Ϊ localhost",oncorrect:"���ݿ��������ַ��ȷ",empty:false}).inputValidator({min:1,onerror:"���ݿ��������ַ����Ϊ��"});

  })
</script>
	<div class="body_box">
        <div class="main_box">
            <div class="hd">
            	<div class="bz a4"><div class="jj_bg"></div></div>
            </div>
            <div class="ct">
            	<div class="bg_t"></div>
                <div class="clr">
                    <div class="l"></div>
                    <div class="ct_box nobrd i6v">
                    <div class="nr">
			<form id="install" name="myform" action="install.php?" method="post">	
			<input type="hidden" name="step" value="5">	
            
<fieldset>
	<legend>��д���ݿ���Ϣ</legend>
	<div class="content">
    	<table width="100%" cellspacing="1" cellpadding="0" >
			<tr>
			<th width="20%" align="right" >���ݿ�������</th>
			<td>
			<input name="dbhost" type="text" id="dbhost" value="localhost" class="input-text" />
			</td>
			</tr>
			<tr>
			<th align="right">���ݿ��ʺţ�</th>
			<td><input name="dbuser" type="text" id="dbuser" value="" class="input-text" /></td>
			</tr>
			<tr>
			<th align="right">���ݿ����룺</th>
			<td><input name="dbpw" type="password" id="dbpw" value="" class="input-text" /></td>
			</tr>
			<tr>
			<th align="right">���ݿ����ƣ�</th>
			<td><input name="dbname" type="text" id="dbname" value="" class="input-text" /></td>
			</tr>
		
		
			</table>
    </div>
</fieldset>

<fieldset>
	<legend>��д����Ա��Ϣ</legend>
	<div class="content">
    	<table width="100%" cellspacing="1" cellpadding="0">
			  <tr>
				<th width="20%" align="right">����Ա�ʺţ�</th>
				<td>admin</td>
			  </tr>
			  <tr>
				<th align="right">����Ա���룺</th>
				<td><input name="password" type="password" id="password" value="" class="input-text" /></td>
			  </tr>
			  <tr>
				<th align="right">ȷ�����룺</th>
				<td><input name="pwdconfirm" type="password" id="pwdconfirm" value="" class="input-text" /></td>
			  </tr>
			  <tr>
				<th align="right">����ԱE-mail��</th>
				<td><input name="email" type="text" id="email" class="input-text" />
					
					<input type="hidden" name="testdata" value="<?php echo $testdata?>" />
					
			  </tr>

			</table>
    </div>
</fieldset>
<fieldset>
	<legend>��ѡ����</legend>
	<div class="content">
    	<label style="width:auto"><input type="checkbox" name="testdata" value="1" checked>Ĭ�ϲ������� ���������ֺ͵����û���</label>
    </div>
</fieldset>
			</form>
                   </div>
                   </div>
                </div>
                <div class="bg_b"></div>
            </div>
            <div class="btn_box"><a href="javascript:history.go(-1);" class="s_btn pre">��һ��</a><a href="javascript:void(0);"  onClick="checkdb();return false;" class="x_btn">��һ��</a></div>
        </div>
    </div>
</body>
</html>
<script language="JavaScript">
<!--
var errmsg = new Array();
errmsg[0] = '���Ѿ���װ������CRM��ϵͳ���Զ�ɾ�������ݣ��Ƿ������';
errmsg[2] = '�޷��������ݿ���������������ã�';
errmsg[3] = '�ɹ��������ݿ⣬����ָ�������ݿⲻ���ڲ����޷��Զ�����������ͨ��������ʽ�������ݿ⣡';
errmsg[6] = '���ݿ�汾����Mysql 4.0���޷���װ����CRM�����������ݿ�汾��';

function checkdb() 
{
	var url = '?step=dbtest&dbhost='+$('#dbhost').val()+'&dbuser='+$('#dbuser').val()+'&dbpw='+$('#dbpw').val()+'&dbname='+$('#dbname').val()+'&sid='+Math.random()*5;

    $.get(url, function(data){
        
		if(data > 1) {
			alert(errmsg[data]);
			return false;
		}
		else if(data == 1 || (data == 0 && confirm(errmsg[0]))) {
			$('#install').submit();
		}
	});
    
    return false;
}
//-->
</script>
