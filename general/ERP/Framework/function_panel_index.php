<?php 


require_once( "lib.inc.php" );
$sessionkey = returnsesskey( );
$GLOBAL_SESSION = returnsession( );
global $smarty;
global $LOGIN_THEME;
global $IE_TITLE;
?>

<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">

<script>
var menu_id=1;

//----------- 设置选择的演示 -----------
function setPointer(element,over_flag,menu_id_over)
{
  if(menu_id!=menu_id_over)                        // 判断当前位置是否已经被选中
  {
     if(over_flag==1)
        element.className='menu_operation_3';      // 鼠标进入显示颜色  
     else
        element.className='menu_operation_2';      // 鼠标离开显示演示  
  }
}

//----------- 初始话显示面板 -------------
var init_flag=0;
function init_menu()
{
 // init_flag++;
 // if(init_flag==2)
     view_menu(<?php echo $PANEL?>);
}

//------------ 查看面板中的页 ------------
function view_menu(id)
{
  //if(menu_id==id)
    // return;
  menu_id=id;


  if(id==1)
  {
     menu_main.location="menu.php";
  }
  else if(id==2)
  {
     //menu_main.location="user_online.php";
     //menu_main.location="general/EDU/Framework/user_online.php";
     parent.parent.table_index.table_main.location="http://www.dandian.net/crm/feedback";
  }
  else if(id==3)
  {
     //menu_main.location="user_online.php";
     //menu_main.location="general/EDU/Framework/user_online.php";
     //parent.parent.table_index.table_main.location="http://www.dandian.net/book";
	  LoadWindow();
  }

}
function LoadWindow()
{
	parent.parent.table_index.table_main.location="../Interface/CRM/message_newai.php";
}

</script>
</head>

<!-- 普通状态登录 -->
<frameset rows="47,*,8"  cols="*" frameborder="NO" border="0" framespacing="0" id="frame1">
<frame name="menu_info" scrolling="no" noresize src="menu_info.php" frameborder="0">
<frame name="menu_main" scrolling="auto" noresize src="menu.php#A" frameborder="0">
<frame name="menu_operation" scrolling="no" noresize src="menu_operation.php" frameborder="0">
</frameset>

</html>
