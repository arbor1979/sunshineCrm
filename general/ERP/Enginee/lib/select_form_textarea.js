<script Language="JavaScript">
function LoadWindow(to_id,to_name)
{
  URL="./frame_user.php?TO_ID="+to_id+"&TO_NAME="+to_name;
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX-100;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+140;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:320px;dialogHeight:265px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
}

function clear_user()
{
  document.form1.TO_ID.value="";
  document.form1.TO_NAME.value="";
}

</script>