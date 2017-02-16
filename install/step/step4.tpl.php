<?php include 'header.tpl.php';?>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"install",onerror:function(msg){}});
	$("#dbhost").formValidator({onshow:"数据库服务器地址, 一般为 localhost",onfocus:"数据库服务器地址, 一般为 localhost",oncorrect:"数据库服务器地址正确",empty:false}).inputValidator({min:1,onerror:"数据库服务器地址不能为空"});
	$("#dbuser").formValidator({onshow:"用户连接MySQL数据库的账号",onfocus:"用户连接MySQL数据库的账号",empty:false}).inputValidator({min:1,onerror:"数据库账号不能为空"});
	$("#pwdconfirm").formValidator({onshow:"请再次输入密码",onfocus:"请输入确认密码",oncorrect:"两次密码相同"}).compareValidator({desid:"password",operateor:"=",onerror:"两次密码输入不同"});
		
	$("#email").formValidator({onshow:"请输入email",onfocus:"请输入email",oncorrect:"email格式正确"}).regexValidator({regexp:"email",datatype:"enum",onerror:"email格式错误"})
	$("#dbhost").formValidator({onshow:"数据库服务器地址, 一般为 localhost",onfocus:"数据库服务器地址, 一般为 localhost",oncorrect:"数据库服务器地址正确",empty:false}).inputValidator({min:1,onerror:"数据库服务器地址不能为空"});

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
	<legend>填写数据库信息</legend>
	<div class="content">
    	<table width="100%" cellspacing="1" cellpadding="0" >
			<tr>
			<th width="20%" align="right" >数据库主机：</th>
			<td>
			<input name="dbhost" type="text" id="dbhost" value="localhost" class="input-text" />
			</td>
			</tr>
			<tr>
			<th align="right">数据库帐号：</th>
			<td><input name="dbuser" type="text" id="dbuser" value="" class="input-text" /></td>
			</tr>
			<tr>
			<th align="right">数据库密码：</th>
			<td><input name="dbpw" type="password" id="dbpw" value="" class="input-text" /></td>
			</tr>
			<tr>
			<th align="right">数据库名称：</th>
			<td><input name="dbname" type="text" id="dbname" value="" class="input-text" /></td>
			</tr>
		
		
			</table>
    </div>
</fieldset>

<fieldset>
	<legend>填写管理员信息</legend>
	<div class="content">
    	<table width="100%" cellspacing="1" cellpadding="0">
			  <tr>
				<th width="20%" align="right">管理员帐号：</th>
				<td>admin</td>
			  </tr>
			  <tr>
				<th align="right">管理员密码：</th>
				<td><input name="password" type="password" id="password" value="" class="input-text" /></td>
			  </tr>
			  <tr>
				<th align="right">确认密码：</th>
				<td><input name="pwdconfirm" type="password" id="pwdconfirm" value="" class="input-text" /></td>
			  </tr>
			  <tr>
				<th align="right">管理员E-mail：</th>
				<td><input name="email" type="text" id="email" class="input-text" />
					
					<input type="hidden" name="testdata" value="<?php echo $testdata?>" />
					
			  </tr>

			</table>
    </div>
</fieldset>
<fieldset>
	<legend>可选数据</legend>
	<div class="content">
    	<label style="width:auto"><input type="checkbox" name="testdata" value="1" checked>默认测试数据 （用于新手和调试用户）</label>
    </div>
</fieldset>
			</form>
                   </div>
                   </div>
                </div>
                <div class="bg_b"></div>
            </div>
            <div class="btn_box"><a href="javascript:history.go(-1);" class="s_btn pre">上一步</a><a href="javascript:void(0);"  onClick="checkdb();return false;" class="x_btn">下一步</a></div>
        </div>
    </div>
</body>
</html>
<script language="JavaScript">
<!--
var errmsg = new Array();
errmsg[0] = '您已经安装过单点CRM，系统会自动删除老数据！是否继续？';
errmsg[2] = '无法连接数据库服务器，请检查配置！';
errmsg[3] = '成功连接数据库，但是指定的数据库不存在并且无法自动创建，请先通过其他方式建立数据库！';
errmsg[6] = '数据库版本低于Mysql 4.0，无法安装单点CRM，请升级数据库版本！';

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
