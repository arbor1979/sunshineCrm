function getRectHTML(width,height,locationX,locationY,text,hrefLink,hasLink){
   var styleHTML = 'style="position:relative;width:'+width+';height:'+height+';left:'+locationX+';top:'+locationY+';"';
   var textStyleHTML = 'style="text-align:center; font-size:10pt;"';
   var shadowHTML = '<vml:shadow on="T" type="single" color="#b3b3b3" offset="5px,5px"/>';
   var hrefHTML ="";
   var gradientHTML = "";
   
   if (hasLink) {
	  hrefHTML     = 'href="' + hrefLink + '"';
	  gradientHTML = '<vml:fill type="gradient" color="#73c7d8" color2="#d6edf3" />';
   }
   else {
	  gradientHTML = "";
   }
   var step3DHTML = '<vml:extrusion on="T" backdepth="5pt" />';
   rectHTML = '<vml:RoundRect '+styleHTML+hrefHTML+'>'+gradientHTML+step3DHTML + shadowHTML + '<vml:TextBox inset="2pt,4pt,2pt,2pt" '+textStyleHTML+'>'+text+'</vml:TextBox></vml:RoundRect>';

   return rectHTML;
}

function getLineHTML(line,hasLink){
  strokeHTML = '<vml:stroke EndArrow="Block"/>';
  if (hasLink)
  {
	  actionHTML='<vml:PolyLine style="position:relative" strokecolor="green" ';
  }
  else {
      actionHTML='<vml:PolyLine style="position:relative" strokecolor="#717171" ';
  }
  actionHTML += 'strokeweight="2px" filled="false" Points="' +line+ '">' + strokeHTML + '</vml:PolyLine>';
  return actionHTML;
}

