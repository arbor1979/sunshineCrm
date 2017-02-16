<script Language="JavaScript">

function clear_user()
{
  document.form1.departmentid.value="";
  document.form1.name.value="";
}

function LoadWindow(filename)
{
  URL=filename;
  //frame_depart_notify.php?elementid=departmentid&elementname=name
  loc_x=document.body.scrollLeft+event.clientX-event.offsetX-100;
  loc_y=document.body.scrollTop+event.clientY-event.offsetY+200;
  window.showModalDialog(URL,self,"edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:320px;dialogHeight:265px;dialogTop:"+loc_y+"px;dialogLeft:"+loc_x+"px");
}

function CheckSend()
{
  if(event.keyCode==10)
  {
    if(CheckForm())
       document.form1.submit();
  }
}
</script>

