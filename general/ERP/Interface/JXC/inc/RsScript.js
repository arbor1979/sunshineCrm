/**
 * �������ڣ�2002/05/22
 *
 * �鵵��������
 *
 * ���ݹ��ɣ�
 *     һ��ȫ�ֱ�������
 *     �������̺�����
 *        2.1  function f_keyenter(str1)
 *		    2.2  function chkInput(obj)
 *		    2.3  function chkInputDown()
 *	   ������굱ǰ�б�ɫ����:
 *        3.1  function MoveOn(res)
 *        3.2  function MoveOut(res)
 3.3  click_tr(res)
 *     �ġ��ַ���������
 *				4.1  function checkSpace(str)
 *				4.2  function parseString(str)
 *				4.3  function absLength(str)
 *			      4.4  function chkLen(strArg,note)
 *				4.5  function URLEncode(myStr)
 *        4.6  function _trim(str)
 *        4.7  function _ltrim(str)
 *        4.8  function _rtrim(str)
 *	   �塢���ִ�����
 *			  5.1  function chkPlus(strArg)
 *				5.2  function chkNegative(strArg)
 *				5.3  function chkDecNegative(strArg,len)
 *				5.4  function chkDecPlus(strArg,len)
 *				5.5  function addComma(myStr,len)
 *				5.6  function round(myStr,len)
 *        5.7  function chkPlusNoZero(strArg)
 *        5.8  function glDecNegative(strArg,len)
 *        5.9  function glNegative(strArg)
 *        5.9.1  function chkDecPlusNoZero(strArg,len)

 *		������������
 *				6.1  function winOpen(hrefStr,winName,width,height)
 *				6.2  function winOpenOnMain(hrefStr,winName,width,height)
 *				6.3  function winOpen_M(hrefStr,winName,width,height)
 *				6.4  function winOpenOnMain_M(hrefStr,winName,width,height)
 *              6.5  function openExcel(args)
 *              6.6  function form_submit(m_form)
 *              6.7  function winOpen_H(hrefStr)
 *
 *      �ߡ����ں�����
 *          7.2  function _isDate(dd,ymdFlag)
 *          7.3  function _chkDate(ob,ymdFlag)
 *          7.4  function _getDate(dateStr,ymdFlag)
 *          7.5  function _cmpDate(date1,date2,ymdFlag)
 *          7.6  function _dateDiff(dateStr1,dateStr2,ymdFlag)
 *          7.7  function _dateAdd(dateStr,add,ymdFlag)
 *
 *
 */



/**
 * ����һ��ȫ�ֱ�������
 */

//���汳��ɫ�������������е���굱ǰ�б�ɫ����MoveOn��MoveOut������
var bgColor;

//һ����¼������� table ��,�����б�ɫ
var nnn = 4;

//ҳ�������б���ǰһ�е��к�
var _LastRowNo = "XXX";

//�����б�����ɫ
var oddBgColor = "#FFFFFF";

//������class
var oddLineClass = "tr1";

//ż���б�����ɫ
var evenBgColor = "#EEEEEE";

//ż����class
var evenLineClass = "tr2";

//�޸��б�����ɫ
var updateBgColor = "#FCF5CB";

//�޸���class
var updateLineClass = "mod_err_Color";

//�����б�����ɫ
var activeBgColor = "#CBDDED";

//������class
var activeLineClass = "cur_tr_Color";

//�û�Esc������,�������Ͷ����̺����е�f_keyenter����
var key_Count = 0;

//�������Ͷ����̺����е�f_keyenter����
var key_Esc = "false";

/**
 * ��������Ϊ�����Excel�ĵ�ʹ��
 * ������fileName ָ����Ҫ����ʱ��ʾ���û����ļ���
 * arg ���ַ�������,���а��������µĲ�����
 *       doc_no     ָ��һ���Ѿ������˵ı������
 *       con        ��ȡ�����������������
 *       sp         ����ȡ��������֮ǰ��Ҫ���е� sp ����
 *       sp_args    ���� sp ����Ĳ���ֵ
 *       prt_name   ǿ��ָ����������ƣ������ȼ����ڱ������б�������
 *       sheet_name ǿ��ָ��Excel��sheet�����ƣ����û��ָ����ȴʡ�� "sheet1"
 *
 *  ���ӣ�
 *       var doc_no="edm1100_e"
 *       var con="item_code like '125%' order by item_code"
 *       var sp="edm1100_sp"
 *       var sp_args= user_unique_id+","+document.item_code.value
 *       var prt_name=year+"/"+month+" �±�"
 *       var sheet_name="�±�"
 *
 *       var arg="doc_no="+doc_no+
 *               "&con="+URLEncode(con)+
 *               "&sp="+sp+
 *               "&sp_args="+URLEncode(sp_args)+
 *               "&prt_name="+URLEncode(prt_name)+
 *               "&sheet_name="+URLEncode(sheet_name)
 *       openExcel(arg)
 *   ע������ֻ�� doc_no �����Ǳ���ģ�����Ķ��ǿ�ѡ������
 */
    var win_handle
function openExcel(fileName,para)
{
    try{
	win_handle.close()
    }catch(e)
    {}
    win_handle=window.open("/excel/"+fileName+"?"+para,
	    "excelwindow",
	    "left=10000,top=10000,width=100,height=100,location=no,scrollbars=no,menubar=no");
    win_handle.focus();
}

/**
 * ���Ͷ������̺���
 */



/**
 * 2.1
 * �������ܣ�   ת��TabΪEnter������Esc�����ù���
 * ����˵����
 1��ת��Enter��ΪTab��
 2��ʹ����Esc�������ù���ʧЧ
 3��ת��Space��ΪEnter��
 4�������м�����������
 4�����������ʹ�ã���ʵ�ֲ�ͬ�����������Ǽ�������ʹ�÷���
 * ʹ�÷���1
 * �Դ����п�ά���Ŀؼ�(��������ѡ��ؼ�������ά���ؼ�)������tabindex���ԣ��������趨������ߵ�˳��
 * ʹ�þ�����//����Enter��ʱ����갴t1��t2��t3��t4��˳������,��굽t4ʱ���ٰ�Enter���������á�
 * <% int tab_no = 1;%>
 * <input type="text" name="t1" tabindex = "<%=tab_no++%>" onkeydown="javascript:return f_keyenter('Y','N','N','N')">
 * <input type="text" name="t2" tabindex = "<%=tab_no++%>" onkeydown="javascript:return f_keyenter('Y','N','N','N')">
 * <input type="text" name="t3" tabindex = "<%=tab_no++%>" onkeydown="javascript:return f_keyenter('Y','N','N','N')">
 * <input type="text" name="t4" tabindex = "<%=tab_no++%>" onkeydown="javascript:return f_keyenter('N','N','N','Y')">
 *
 * ʹ�÷���2
 * �������"ɾ��"��������ʱ����Enter��Tab���������ã�ֻ�������ȥ���
 * <a href="javascript:f_add()" tabindex="-1" onkeydown="javascript:return f_keyenter('N','N','N','Y')">
 *    <img border="0" src="/com/rsc/rs/pub/images/add.gif" width="16" height="16" alt="ɾ��" >
 * </a>
 *
 * ʹ�÷���3
 * ��Space������ѡ����,����Enter������ƶ�����һ��λ��
 * <a href="javascript:selectWarehouse()" tabindex="-1" onkeydown="javascript:return f_keyenter('Y','N','Y','N')">
 *     <img border="0" src="/com/rsc/rs/pub/images/view.gif" width="16" height="16" alt="����" >
 * </a>
 *
 * ʹ�÷���4
 * ������������esc�������ù��ܣ�����Enter������ƶ�����һ��λ��
 * <input type="text" name="t1" tabindex = "<%=tab_no++%>" onkeydown="javascript:return f_keyenter('Y','Y','N','N')">

 * �� �� ֵ��  true��false
 *			   true�� �����ַ���Ч
 *             false�������ַ���Ч
 */
function f_keyenter(enter_key,esc_key,space_key,all_key,eve)
{

    //alert("ddd")
    var array_key_code = "18^33^34^35^36^37^38^39^40^45^46^114^121^122";

    //�����м����������ã���������������Ϊreadonly�Ŀؼ����κμ����䶼��������
    if (all_key == "Y")
	return false

	    //��enter_keyΪ"Y"ʱ��ת��Enter��ΪTab��
	    if (enter_key=="Y")
	    {
		if (event.keyCode == 13)
		    event.keyCode = 9
	    }

    //��enter_keyΪ"Y"ʱ��ת��Space��ΪEnter��
    if (space_key=="Y")
    {
	if (event.keyCode == 32)
	{
	    event.keyCode = 13
		//window.event.button=1
		if(eve!=null)
		    if(checkSpace(eve))
			eval(eve)
	}
    }

    //��esc_keyΪ"Y"ʱ��ʹ����Esc�������ù���ʧЧ������Esc��ʱ���ñ��ؼ�������
    if (esc_key=="Y")
    {
	if (event.keyCode == 27)
	{
	    key_Count = key_Count + 1;
	    if ((key_Count > 1) && (key_Esc == "true"))
	    {
		return false;
	    }
	    key_Esc = "true";
	}else
	{
	    if ((array_key_code.indexOf(event.keyCode.toString()) < 0) || (event.keyCode == 54))
	    {
		key_Count = 0;
		key_Esc = "false";
	    }else
	    {
		return true
	    }
	}
	return true
    }
}

/**
 *2.2
 * �������ܣ�	�ж�������ַ��Ƿ�Ϸ���
 * ����˵����  �ж������Ƿ�Ϸ���input�����ֵ
 * ʹ�þ�����  <input type="text" name="test" maxlength="8" onkeypress="return chkInput(this.value)" >
 * �� �� ֵ��  true��false
 *				true�� �����ַ���Ч
 *             false�������ַ���Ч
 */
function chkInput(obj)
{
    var charCode=event.keyCode
	if(obj.length==0&&charCode==32)
	    return false
		if(charCode==34)//�������ķ����Ƿֺ�(;)
		    return false
			if(charCode==59)//�������ķ�����˫����(")
			    return false
				if(charCode==44)//�������ķ����Ƕ���(,)
				    return false
					if(charCode==39)//�������ķ����ǵ�����(')
					    return false
						if(charCode==92)//�������ķ����ǵ�����(\)
						    return false
							return true

}
/**
 * 2.3
 * �������ܣ�	�ж�������ַ��Ƿ�Ϸ���
 * ʹ�þ�����	<input type="text" name="test" maxlength="8" onkeydown="return chkInputDown()" >
 * ˵    ���� ���������chkInput�����������ǣ�
 * 			�����������onkeydown�¼���
 * 			chkInput��������onkeypress�¼���
 * �� �� ֵ��  true��false
 *			 true�� �����ַ���Ч
 *             false�������ַ���Ч
 */
function chkInputDown()
{
    var charCode=event.keyCode
	if(charCode==186)//�������ķ����Ƿֺ�(;)
	    return false
		if(charCode==16)//�������ķ�����˫����(")
		    return false
			if(charCode==188)//�������ķ����Ƕ���(,)
			    return false
				if(charCode==222)//�������ķ����ǵ�����(')
				    return false
					return true

}



/**
 * ����������굱ǰ�б�ɫ����
 */

/**
 * 3.1
 * �������ܣ�	����Ƶ���ǰ�У������״��Ϊ���Ρ���ǰ�б�ɫ����ʾ�û���ǰ��Ϊ�����С�
 * ����˵����  ����Ƶ��ĵ�ǰ��
 * ʹ�þ�����  <tr onMouseOver="MoveOn(this);" onMouseOut="MoveOut(this);">
 * �� �� ֵ��  �޷�ֵ
 */
function MoveOn(res)//����Ƶ���ǰ��;ԭ�������ƣ�MouseOn
{
    res.style.cursor="hand";
    bgColor = res.style.backgroundColor;
    if(document.all.rows_table_1 == null)//�ɰ汾
    {
	if(!res.contains(event.fromElement))
	{
	    res.style.backgroundColor=activeBgColor;
	    for(var i=0;i<res.childNodes.length;i++)
	    {
		if(res.childNodes[i].nodeName=="TD")
		{
		    var column=res.childNodes[i]
			for(var j=0;j<column.childNodes.length;j++)
			{
			    if(column.childNodes[j].tagName=="INPUT")
			    {
				var input1=column.childNodes[j]
				    input1.style.backgroundColor=activeBgColor
			    }
			}
		}
	    }
	}
    }
    /***************** fzg add BEGIN************************/
    else//�°汾
    {
	for (var i=1; i<=nnn; i++)
	{
	    if(document.all("rows_table_"+i)!=null)
	    {
		if (document.all("rows_table_"+i).rows(res.rowIndex).className != "clickColor")
		{
		    document.all("rows_table_"+i).rows(res.rowIndex).style.backgroundColor= activeBgColor
		}
	    }
	}
    }
    /***************** fzg add END************************/
}


/**
 * 3.2
 * �������ܣ�	����뿪��ǰ��ʱ�������״�͵�ǰ����ɫ��ԭΪ��ʼ״̬��
 * ����˵����  ����Ƴ��ĵ�ǰ��
 * ʹ�þ�����  <tr onMouseOver="MoveOn(this);" onMouseOut="MoveOut(this);">
 * �� �� ֵ��  �޷�ֵ
 */
function MoveOut(res)
{
    res.style.cursor="Default";
    if(document.all.rows_table_1 == null)//�ɰ汾
    {
	res.style.backgroundColor=bgColor;
	for(var i=0;i<res.childNodes.length;i++)
	{
	    if(res.childNodes[i].nodeName=="TD")
	    {
		var column=res.childNodes[i]
		    for(var j=0;j<column.childNodes.length;j++)
		    {
			if(column.childNodes[j].tagName=="INPUT")
			{
			    var input1=column.childNodes[j]
				input1.style.backgroundColor=bgColor
				if(input1.style.backgroundColor==activeBgColor)
				    res.style.backgroundColor=bgColor;
			}
		    }
	    }
	}

    }
    else//�°汾
    {
	for (var i=1; i<=nnn; i++){
	    if(document.all("rows_table_"+i)!=null){
		document.all("rows_table_"+i).rows(res.rowIndex).style.backgroundColor=bgColor
	    }
	}
    }
}

/***************** fzg add BEGIN************************/
/**
 * 3.3
 * �������ܣ�  �������ǰ��ʱ����ǰ����ɫ��Ϊ���ɫ��
 * ����˵����  ������ĵ�ǰ��, ����ʹ�ø÷�����tr��table����IDֵ, ���� rows_table_i iֵ��1��n
 *            ���һ��ҳ��������������������¼�е�tableʱ,���� rows_table_1 ������������Ч
 *
 * ʹ�þ�����  <tr onClick="click_tr(this);" onMouseOver="MoveOn(this);" onMouseOut="MoveOut(this);">
 * �� �� ֵ��  �޷�ֵ
 */
function click_tr(res)//����б�ɫ
{
    res.style.cursor="hand";
    for (var i=1; i<=nnn; i++)
    {
	if(document.all("rows_table_"+i)!=null)
	{
	    for(j=0;j<rows_table_1.rows.length;j++)
	    {
		if (j%2 == 0){document.all("rows_table_"+i).rows(j).className="tr1"}
		else  { document.all("rows_table_"+i).rows(j).className="tr2" }
	    }
	    document.all("rows_table_"+i).rows(res.rowIndex).className="clickColor" ;//����table����ͬ�ж���ɫ
	    document.all("rows_table_"+i).rows(res.rowIndex).style.backgroundColor="";//����onMouseOver�ı�ɫ
	}
    }
}

/***************** fzg add END************************/

/**
 * �����ģ��ַ���������
 */



/**
 * 4.1
 * �������ܣ�	��֤������ַ����Ƿ�Ϊ��
 * ����˵����  ��Ҫ������֤���ַ���
 * �� �� ֵ��  true��false
 *			    true�� ������ַ�����Ϊ��
 *             false��������ַ���Ϊ��
 */
function checkSpace(str)
{
    if(_trim(str)=="")
	return false
    else
	return true
}


/**
 * 4.2
 * �������ܣ�	�����ж��ŷָ������ַ�����ʽתΪ�������ŷָ������ַ�����
 * ����˵����  ��Ҫ����ת�����ַ���
 * �� �� ֵ��  ת���󲻴����ŵ��ַ���
 */
function  parseString(str)
{
    var myStr=_trim(str)
	var retStr=""
	for(var i=0;i<myStr.length;i++)
	{
	    var tmpChar=myStr.charAt(i)
		if(tmpChar!=',')
		    retStr+=tmpChar
	}
    return retStr
}

/**
 * 4.3
 * �������ܣ�	����ַ����ľ��Գ��ȡ���������������Ϊ�����ַ����䷵�ص�ֵ������ƥ�����ݿ���ֶγ���
 * ����˵���� str Ҫ�жϵ��ַ���
 * �� �� ֵ�� �ַ����ľ��Գ���
 */
function absLength(str)
{
    return str.length    //���ݿ���ʹ��NVERCHAR���ͺ󽫲��ٶ�ǰ�˺��ֽ��г��ȼ���
	/*
	   var len=0;
	   if(str!=null) {
	   var c;
	   var l = str.length;
	   for(var i=0;i<l;i++) {
	   c = str.charAt(i)
	   len+= (c>="��") ? 2 : 1;
	   }
	   }
	   return len
	 */
}

/**
 * 4.4
 * �������ܣ�	�ж�������ַ��Ƿ񳬳���
 * ����˵����
 *            strArg:��Ҫ�ж��ַ����ȣ�����Ϊtext�����
 *            note:��Ӣ�ı�ʶ
 * ʹ�þ���:  <input type="text" name="test" maxlength="8" onblur="checkLength(this,'en')" >
 * ˵    ��:  input �����maxlength����Ҫ���ã��������ִ�в���ȷ
 */
function chkLen(strArg,note)
{
    try{
	var  lanFlag=note
	    var note1="������ַ����ȳ��������������󳤶�!"
	    var note2="The length of input field more than the maxlength!"
	    var note3=""
	    note3=lanFlag=="en"?note2:note1
	    var str=strArg.value
	    var length=strArg.maxLength
	    if(absLength(str)>length)
	    {
		alert(note3)
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	return true
    }
    catch(e)
    {

    }
}

/**
 * 4.5
 * �������ܣ�  ���������ַ���ת����IE�ܹ�ʶ��ķ���
 * ����˵����
 *             myStr: �ַ��������л򲻺��������ַ���
 * �� �� ֵ��  ת������ַ���
 */
function URLEncode(myStr)
{
    var translateChar = new Array("%25","%2F","%3F","%3A","%3B",
	    "%26","%40","%3D","%23","%3E",
	    "%3C","%7B","%7D","%5B","%5D",
	    "%60","%27","%5E","%7E","%7C",
	    "%21","%24","%28","%29","%2B",
	    "%2C")
	var newStr=""
	if(myStr!=null)
	{
	    for(var i=0;i<myStr.length;i++)
	    {
		if(charAt(myStr.charAt(i))<0)
		    newStr+=myStr.charAt(i)
		else
		    newStr+=translateChar[charAt(myStr.charAt(i))]
	    }
	}
    return newStr
}

function charAt(str)
{
    var especialChar = new Array(  "%",  "/",  "?",  ":",  ";",
	    "&",  "@",  "=",  "#",  ">",
	    "<",  "{",  "}",  "[",  "]",
	    "`",  "'",  "^",  "~",  "|",
	    "!",  "$",  "(",  ")",  "+",
	    ",")
	for(var i=0;i<especialChar.length;i++)
	{
	    if(str==especialChar[i])
		return i;
	}
    return -1;
}
/**
 *  4.6 ȥ���ҿո���
 *  ���� str ��һ�ַ���
 *  ���� ȥ���ҿո���ַ���
 */
function _trim(str)
{
    var ss=""+str
	return (_ltrim(_rtrim(ss)));
}

/**
 *  4.7 ȥ��ո���
 *  ���� str ��һ�ַ���
 *  ���� ȥ��ո���ַ���
 *
 */
function _ltrim(str)
{
    var ss=""+str;
    if(ss.length==0)
	return (ss);
    if(ss.charAt(0)==' ')
	ss=_ltrim(ss.substring(1,ss.length));
    return (ss);
}

/**
 *  4.8 ȥ�ҿո���
 *  ���� str ��һ�ַ���
 *  ���� ȥ�ҿո���ַ���
 *
 */
function _rtrim(str)
{
    var ss=""+str;
    if(ss.length==0)
	return (ss);
    if(ss.charAt(ss.length-1)==' ')
	ss=_rtrim(ss.substring(0,ss.length-1));
    return (ss);
}

/**
 * �����壺���ִ�����
 */


/**
 * 5.1
 * �������ܣ�	��֤������ַ������Ƿ�Ϊ������
 * ����˵����  ��Ҫ�����жϵ������
 * �� �� ֵ��  true��false
 *			    true�� ������ַ�����������
 *             false��������ַ�������������
 * ʹ��˵����  <input type="text"��name="plus" onblur="chkPlus(this)">
 */

function chkPlus(strArg)
{

    var str=strArg.value
	str=parseString(str)
	for (var i=0; i < str.length; i++)
	{
	    var ch=str.charAt(i);
	    if(ch==' ')
	    {
		alert("��������ո�!")
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	    if (ch <'0' || ch>'9')
	    {
		alert("����������������!")
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	}
    return true
}


/**
 * 5.2
 * �������ܣ�	��֤������ַ������Ƿ�Ϊ����
 * ����˵����  ��Ҫ�����жϵ������
 * �� �� ֵ��  true��false
 *			    true�� ������ַ���������
 *             false��������ַ�����������
 * ʹ��˵����  <input type="text"��name="plus" onblur="chkNegative(this)">
 */
function chkNegative(strArg)
{
    var str=parseString(strArg.value)
	for (var i=0; i < str.length; i++)
	{
	    var ch=str.charAt(i);
	    if ((ch <'0' || ch>'9')&&ch!='-')
	    {
		alert("����������!")
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	   if(ch=='-' && str.length==1)
      {
        alert("����������!")
        strArg.focus()
        strArg.select()
        return false
      }
	}
    return true
}


/**
 * 5.3
 * �������ܣ�	��֤������ַ������Ƿ�Ϊ����
 * ����˵����  ��Ҫ�����жϵ������
 * �� �� ֵ��  true��false
 *			    true�� ������ַ���������
 *             false��������ַ�����������
 * ʹ�þ�����  <input type="text"��name="plus" onblur="chkDecNegative(this)">
 */
function chkDecNegative(strArg,len)
{
    var count=0
	var numberValue=parseString(strArg.value)   //ȥ���ţ��ո�
	var pointLocat=numberValue.indexOf(".")     //�ж�С������λ������
	for (var i=0; i < numberValue.length; i++)
	{
	    var ch=numberValue.charAt(i);
	    if(i==0)
	    {
		if ((ch <'0' || ch>'9')&&ch!='-'&&ch!='.')
		{
		    alert("����������!")
			strArg.focus()
			strArg.select()
			return false
		}
    if((ch=='-'||ch=='.') && numberValue.length==1)
    {
      alert("����������!")
      strArg.focus()
      strArg.select()
      return false
    }
	    }
	    else
	    {
		if(ch=='.')
		    count++
			if(count>1)
			{
			    strArg.focus()
				strArg.select()
				return false
			}
		if ((ch <'0' || ch>'9')&&(ch!='.'))
		{
		    alert("����������!")
			strArg.focus()
			strArg.select()
			return false
		}
	    }
	}
    strArg.value=addComma(strArg.value,len)
	return true
}

/**
 * 5.4
 * �������ܣ�	��֤������ַ������Ƿ�Ϊ����
 * ����˵����  ��Ҫ�����жϵ������
 * �� �� ֵ��  true��false
 *			    true�� ������ַ���������
 *             false��������ַ�����������
 * ʹ�þ�����  <input type="text"��name="plus" onblur="chkDecPlus(this)">
 */
function chkDecPlus(strArg,len)
{
    var count=0
	var numberValue=parseString(strArg.value)
	var pointLocat=numberValue.indexOf(".")//�ж�С������λ������
	for (var i=0; i < numberValue.length; i++)
	{
	    var ch=numberValue.charAt(i);
	    if(i==0)
	    {
		if ((ch <'0' || ch>'9')&&ch!='.')
		{
		    alert("����������!")
			strArg.focus()
			strArg.select()
			return false
		}
    if(ch=='.' && numberValue.length==1)
    {
      alert("����������!")
      strArg.focus()
      strArg.select()
	    return false
    }
	    }
	    else
	    {
		if(ch=='.')
		    count++
			if(count>1)
			{
			    alert("����������!")
				strArg.focus()
				strArg.select()
				return false
			}
		if ((ch <'0' || ch>'9')&&ch!='.')
		{
		    alert("����������!")
			strArg.focus()
			strArg.select()
			return false
		}
	    }
	}
    strArg.value=addComma(strArg.value,len)
	return true
}


/**
 * 5.5
 * �������ܣ�	�Ӷ��ŷָ����������㡢��������
 * ʹ�ñ�����   �������������ۡ�������ı���Ҫ�Ӷ��ŷָ���
 * ����˵����
 *              myStr:  �ַ���
 *              len  :  ��Ҫ������С��λ��
 * �� �� ֵ��   �Ӷ��ź���ַ���
 */
function addComma(myStr,len)
{
    var isNegative=false
	//���myStrΪ�գ��򷵻ظ��ַ���
	if (!checkSpace(myStr))
	{
	    return _trim(myStr)
	}

    //ȥ�����ŷָ���
    myStr = _trim(parseString(myStr))

	//����Ǹ�������ȥ������
	if(myStr.charAt(0)=='-')
	{
	    myStr=myStr.substr(1,myStr.length-1)
		isNegative=true
	}
    //��myStr�в���С����"."����¼��λ��
    var position = myStr.indexOf(".")

	//�����һλ��С���㣬���һλ��0
	if (position==0)
	{
	    myStr = "0" + myStr
	}

    //��������
    myStr = round(myStr,len)

	//����ȡС����λ��
	position = myStr.indexOf(".")

	//�����С���㣬����Ϊ�ַ�������ΪС����λ��
	if (position==-1)
	{
	    position = myStr.length
	}

    //���С����λ�ô���3��ִ��ѭ��
    while (position>3)
    {
	myStr = myStr.substring(0,position-3) + "," + myStr.substring(position-3,myStr.length)
	    position-= 3
    }
    if(isNegative)
	return ("-"+myStr)
    else
	return (myStr)
}


/**
 * 5.6
 * �������ܣ�	�������룬���С�����λ����������0��λ
 * ����˵����
 *              myStr:  �ַ���
 *              len  :  ��Ҫ������С��λ��
 * �� �� ֵ��   �����������ַ���
 */
function round(myStr,len)
{
    //���myStrΪ�գ��򷵻ظ��ַ���
    if (!checkSpace(myStr))
    {
	return myStr
    }

    //��������
    var tmp1 = myStr * Math.pow(10,len)
	var tmp2 = Math.round(tmp1)
	var tmp3 = tmp2 / Math.pow(10,len)

	//��λ
	var tmp4 = tmp3.toString()
	if (parseInt(len)<=0)
	{
	    return tmp4
	}
	else
	{
	    //ȡС����λ��
	    var position = tmp4.indexOf(".")
		//�����С����
		if (position==-1)
		{
		    tmp4+= ".";

		    for (var i=0;i<parseInt(len);i++)
		    {
			tmp4+= "0"
		    }
		    return tmp4
		}
		else
		{
		    var count = parseInt(len) - (tmp4.length - (position + 1))

			for (var j=0;j<count;j++)
			{
			    tmp4+= "0"
			}
		    return tmp4
		}
	}
}

/**
 * 5.7
 * �������ܣ�	��֤������ַ������Ƿ�Ϊ������(��������)
 * ����˵����  ��Ҫ�����жϵ������
 * �� �� ֵ��  true��false
 *			    true�� ������ַ�����������
 *             false��������ַ�������������
 * ʹ��˵����  <input type="text"��name="plus" onblur="chkPlusNoZero(this)">
 */

function chkPlusNoZero(strArg)
{

    var str=parseString(strArg.value)
	if(str.length==0)
	{
	    return true
	}
    var flag=0
	while(flag==0)
	{
	    if(str.length==0)
	    {
		alert("������������!")
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	    var temp=str.charAt(0)
		if(temp=="0")
		    str=str.substring(1,str.length)
		else
		    flag=1
	}

    for (var i=0; i < str.length; i++)
    {
	var ch=str.charAt(i);
	if (ch <'0' || ch>'9')
	{
	    alert("������������!")
		strArg.focus()
		strArg.select()
		return false
	}



    }
    strArg.value=str
	return true
}


/**
 * 5.8
 * �������ܣ�	��֤������ַ������Ƿ�Ϊ���֣���������ֵΪ�����������Զ�������е�ֵ��ʾΪ��ɫ��
 * ����˵����  ��Ҫ�����жϵ������
 * �� �� ֵ��  true��false
 *			    true�� ������ַ���������
 *             false��������ַ�����������
 * ʹ�þ�����  <input type="text"��name="plus" onblur="chkDecNegative(this)">
 */
function glDecNegative(strArg,len)
{
    var count=0
	var numberValue=parseString(strArg.value)   //ȥ���ţ��ո�
	var pointLocat=numberValue.indexOf(".")     //�ж�С������λ������
	for (var i=0; i < numberValue.length; i++)
	{
	    var ch=numberValue.charAt(i);
	    if(i==0)
	    {
		if ((ch <'0' || ch>'9')&&ch!='-'&&ch!='.')
		{
		    alert("����������!")
			strArg.focus()
			strArg.select()
			return false
		}
		if((ch=='-'||ch=='.')&&numberValue.length==1)
    {
      alert("����������!")
      strArg.focus()
      strArg.select()
      return false
    }
	    }
	    else
	    {
		if(ch=='.')
		    count++
			if(count>1)
			{
			    strArg.focus()
				strArg.select()
				return false
			}
		if ((ch <'0' || ch>'9')&&(ch!='.'))
		{
		    alert("����������!")
			strArg.focus()
			strArg.select()
			return false
		}
	    }
	}

    var dec=0.00
	dec=strArg.value
	if(dec<0)
	    strArg.style.color="red"
	else
	    strArg.style.color="black"

		strArg.value=addComma(strArg.value,len)
		return true
}


/**
 * 5.9
 * �������ܣ�	��֤������ַ������Ƿ�Ϊ��������������ֵΪ�����������Զ�������е�ֵ��ʾΪ��ɫ��
 * ����˵����  ��Ҫ�����жϵ������
 * �� �� ֵ��  true��false
 *			    true�� ������ַ���������
 *             false��������ַ�����������
 * ʹ��˵����  <input type="text"��name="plus" onblur="chkNegative(this)">
 */
function glNegative(strArg)
{
    var str=parseString(strArg.value)
	for (var i=0; i < str.length; i++)
	{
	    var ch=str.charAt(i);
	    if ((ch <'0' || ch>'9')&&ch!='-')
	    {
		alert("����������!")
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	     if(ch=='-'&&numberValue.length==1)
      {
        alert("����������!")
        strArg.focus()
        strArg.select()
        return false
      }
	}
    var dec=0
	dec=strArg.value
	if(dec<0)
	    strArg.style.color="red"
	else
	    strArg.style.color="black"
		return true
}


/**
 * 5.91
 * �������ܣ�	��֤������ַ������Ƿ�Ϊ����
 * ����˵����  ��Ҫ�����жϵ������
 * �� �� ֵ��  true��false
 *			    true�� ������ַ���������
 *             false��������ַ�����������
 * ʹ�þ�����  <input type="text"��name="plus" onblur="chkDecPlus(this)">
 */
function chkDecPlusNoZero(strArg,len)
{
    var count=0
	var numberValue=parseString(strArg.value)
	var pointLocat=numberValue.indexOf(".")//�ж�С������λ������
	for (var i=0; i < numberValue.length; i++)
	{
	    var ch=numberValue.charAt(i);
	    if(i==0)
	    {
		if ((ch <'0' || ch>'9')&&ch!='.')
		{
		    alert("����������")
			strArg.focus()
			strArg.select()
			return false
		}
    if(ch=='.' && numberValue.length==1)
    {
      alert("����������")
      strArg.focus()
      strArg.select()
      return false
    }
	    }
	    else
	    {
		if(ch=='.')
		    count++
			if(count>1)
			{
			    alert("����������")
				strArg.focus()
				strArg.select()
				return false
			}
		if ((ch <'0' || ch>'9')&&ch!='.')
		{
		    alert("����������")
			strArg.focus()
			strArg.select()
			return false
		}
	    }
	}
    if(addComma(strArg.value,len)==0&&numberValue.length>0)
    {
	alert("����������")
	    strArg.focus()
	    strArg.select()
	    return false
    }
    strArg.value=addComma(strArg.value,len)

	return true
}

/**
 * 5.10
 * �������ܣ�	��֤������ַ������Ƿ�ΪС��
 * ����˵����  ��Ҫ�����жϵ������
 * �� �� ֵ��  true��false
 *			    true�� ������ַ�����С��
 *             false��������ַ�������С��
 * ʹ�þ�����  <input type="text"��name="plus" onblur="chkDecimal(this)">
 */
function chkDecimal(strArg,len)
{
    var count=0
	var numberValue=parseString(strArg.value)   //ȥ���ţ��ո�
	var pointLocat=numberValue.indexOf(".")     //�ж�С������λ������
	var point_9 = "0."
	for (var i=0; i < numberValue.length; i++)
	{
	    var ch=numberValue.charAt(i);
	    if(i==0)
	    {
		if ((ch <'0' || ch>'9')&&ch!='-'&&ch!='.')
		{
		    alert("�����벻����1������!")
			strArg.focus()
			strArg.select()
			return false
		}
	    }
	    else
	    {
		if(ch=='.')
		    count++
			if(count>1)
			{
			    strArg.focus()
				strArg.select()
				return false
			}
		if ((ch <'0' || ch>'9')&&(ch!='.'))
		{
		    alert("�����벻����1������!")
			strArg.focus()
			strArg.select()
			return false
		}
	    }
	    if ((strArg.value>1)||(strArg.value<0))
	    {
		alert("�����벻����1������!")
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	}
    strArg.value=addComma(strArg.value,len)
	return true
}

/**
 * ����������������
 */




/**
 * 6.1
 * �������ܣ�	����״̬��ʽ���´���
 * ����˵����
 *             hrefStr�� ���ڵ������ַ
 *             winName�� ��������
 *             width  �� ���ڵĿ��
 *             height �� ���ڸ߶�
 * �� �� ֵ��  �޷�ֵ
 */
function winOpen(hrefStr,winName,width,height)
{
    var screenWidth=screen.availWidth
	var screenHeight=screen.availHeight
	var left=(screenWidth-width-6)/2 - 2
	var top=(screenHeight-height-24)/2 - 2
	//����ϸ΢�ĵ�������ʹ���ڴ򿪾��Ծ��У�
	//����ҳ������Ȳ��ɳ���1014�����߶Ȳ��ɳ���740��
	//����left��top���㡣
	if(left<0)
	    left = 0
		if(top<0)
		    top = 0
			var wh=window.open(hrefStr,winName,
				"location=no scrollbars=no menubar=no status=no " +
				"resizable=yes width="+width+" height="+height+" left="+left+" top="+top);
    wh.focus();

    /*
       var screenWidth=screen.availWidth
       var screenHeight=screen.availHeight
       var left=(screenWidth-width)/2
       var top=(screenHeight-height)/2
       window.open(hrefStr,winName,
       "location=no scrollbars=no menubar=no status=no resizable=yes width="+width+" height="+height+" left="+left+" top="+top);
     */
}


/**
 * 6.1.1
 * �������ܣ�	����״̬��ʽ���´���
 * ����˵����
 *             hrefStr�� ���ڵ������ַ
 *             winName�� ��������
 *             width  �� ���ڵĿ��
 *             height �� ���ڸ߶�
 * �� �� ֵ��  �޷�ֵ
 */
function winOpenScro(hrefStr,winName,width,height)
{
    var screenWidth=screen.availWidth
	var screenHeight=screen.availHeight
	var left=(screenWidth-width-6)/2 - 2
	var top=(screenHeight-height-24)/2 - 2
	//����ϸ΢�ĵ�������ʹ���ڴ򿪾��Ծ��У�
	//����ҳ������Ȳ��ɳ���1014�����߶Ȳ��ɳ���740��
	//����left��top���㡣
	if(left<0)
	    left = 0
		if(top<0)
		    top = 0
			var wh=window.open(hrefStr,winName,
				"location=no scrollbars=yes menubar=no status=no " +
				"resizable=yes width="+width+" height="+height+" left="+left+" top="+top);
    wh.focus();

    /*
       var screenWidth=screen.availWidth
       var screenHeight=screen.availHeight
       var left=(screenWidth-width)/2
       var top=(screenHeight-height)/2
       window.open(hrefStr,winName,
       "location=no scrollbars=no menubar=no status=no resizable=yes width="+width+" height="+height+" left="+left+" top="+top);
     */
}





function roundDecimals(number, decimals)
{
    var result1 = number * Math.pow(10, decimals)
	var result2 = Math.round(result1)
	var result3 = result2 / Math.pow(10, decimals)
	return padWithZeros( result3, decimals)
}

function padWithZeros(number, decimals)
{
    //alert(decimals)
    var numberString = number.toString()

	var decimalsLocation = numberString.indexOf(".");
    //alert(decimalsLocation)
    if ( decimalsLocation == -1 )
    {
	decimalsLength = 0

	    //alert(decimals)
	    numberString += decimals > 0 ? "." : ""
	    //alert(numberString)
    }
    else
    {
	decimalsLength = numberString.length - decimalsLocation - 1
    }

    var padTotal = decimals - decimalsLength

	if ( padTotal > 0 )
	{
	    for ( var counter = 1; counter <= padTotal; counter++)
	    {
		numberString += "0"
	    }
	}

    //alert(numberString)
    return numberString
}
/**
 *  6.2  �ж��Ƿ��������ַ���
 *
 *  ���� dateStr �����¸�ʽ��yyyy/mm/dd;yyyymmdd; ��ֵ��Ϊ��������
 *  ���� ymdFlag  �����ڸ�ʽ�ַ��� "ymd" ��ʾ "yyyy/mm/dd"��ʽ��"ym" ��ʾ "yyyy/mm"��ʽ
 *  ���� true ���������ڣ�false ���������
 */
function _isDate(dateStr,ymdFlag)
{
    var d=_getDate(dateStr,ymdFlag)
	if(d=="" || d=="blank")
	    return false
	else
	    return true

}
/**
 *  6.3
 *  ���ؼ��е�ֵ�Ƿ��������ַ�������������ڣ�����ݲ���ymdFlagָ���ĸ�ʽ���ڽ��з��أ�����������ڣ�������ʾ��Ϣ�������۽������ַ��������м�顣
 *  ���� ob �ǿؼ�����
 *  ���� ymdFlag �����ڸ�ʽ�ַ��� "ymd" ��ʾ "yyyy/mm/dd"��ʽ��"ym" ��ʾ "yyyy/mm"��ʽ
 */
function _chkDate(ob,ymdFlag)
{
    var dd=_getDate(ob.value,ymdFlag)
	if(dd=="")
	{
	    alert("���ڴ���")
		ob.select()
		ob.focus()
	}
	else if(dd=="blank")
	    ob.value=""
	else
	    ob.value=dd

}
/**
 * 6.4 ��ȡ��ʽ���������ַ��������������ںϷ��Լ��鹦��
 * �˺������ڲ���������Ҳ����ֱ��ʹ��
 * �����ڷ��� ""
 * �����ڷ��� "blank"
 * �����ͷ��� yyyy/mm/dd ��ʽ�ַ���
 */
function _getDate(dateStr,ymdFlag)
{
    if(dateStr.length==0)
	return "blank"
	    if(ymdFlag=="ymd")
	    {
		if(dateStr.length!=8 && dateStr.length!=10 )
		    return ""
	    }
	    else
	    {
		if(dateStr.length!=6 && dateStr.length!=7 )
		{
		    return ""
		}
	    }
    var len=dateStr.length
	var yy
	var mm
	var dd
	var od
	var nd
	var myDate
	yy=dateStr.substring(0,4)
	if(yy.substring(0,1)=="-")
	{
	    return ""
	}
    mm=((len==10||len==7)?dateStr.substring(5,7):dateStr.substring(4,6))
	if(ymdFlag=="ymd")
	{
	    dd=(len==10||len==7)?dateStr.substring(8,10):dateStr.substring(6,8)
		od=yy+"/"+mm+"/"+dd
	}
	else
	{
	    dd="01"
		od=yy+"/"+mm
	}
    myDate=new Date(Date.UTC(yy,mm-1,dd))
	if(isNaN(myDate))
	    return ""

		if(ymdFlag=="ymd")
		    nd=myDate.getUTCFullYear()+"/"+
			((myDate.getUTCMonth()+1)<10?("0"+(myDate.getUTCMonth()+1)):(myDate.getUTCMonth()+1))+"/"+
			(myDate.getUTCDate()<10?("0"+myDate.getUTCDate()):(myDate.getUTCDate()))
		else
		    nd=myDate.getUTCFullYear()+"/"+
			((myDate.getUTCMonth()+1)<10?("0"+(myDate.getUTCMonth()+1)):(myDate.getUTCMonth()+1))

			if(od==nd)
			    return od
			else
			    return ""
}
/**
 *  6.5 �Ƚ���������
 *
 *  ������date1,date2���������ַ���
 *  ���� ymdFlag  �����ڸ�ʽ�ַ��� "ymd" ��ʾ "yyyy/mm/dd"��ʽ��"ym" ��ʾ "yyyy/mm"��ʽ
 *  ����ֵ��
 *          0��������ȣ�
 *          1��date1>date2;
 *         -1: date1<date2;
 *         11: date1������ȷ����
 *        -11��date2������ȷ����
 */
function _cmpDate(date1,date2,ymdFlag)
{
    if(!_isDate(date1,ymdFlag)) return (11)
	if(!_isDate(date2,ymdFlag)) return (-11)
	    var myDate1=_getDate(date1,ymdFlag);
    var myDate2=_getDate(date2,ymdFlag);
    if(myDate1==myDate2)
    {
	return (0);
    }
    else if(myDate1<myDate2)
    {
	return (-1);
    }
    else
    {
	return (1);
    }
}

/** 6.6  ȡ������������������
 *  ������dateStr1,dateStr2 ��������Ҫ�����ж���ȷ�������ַ��������ɵ��ô˺�����
 *  ������ymdFlag Ŀǰû���õ������ʽӦ���ǣ�'ymd' �� 'ym' �����Ժ����չ��
 *  ���أ��������������������������������Ρ�
 */

function _dateDiff(dateStr1,dateStr2,ymdFlag)
{

    var dd1=new Date(dateStr1)
	var dd2=new Date(dateStr2)
	return (Math.abs(dd2-dd1)/(24*60*60*1000))
}
/**
 *  6.7 ������� ��һ�����������ڼ�����������һ���µ������ַ���
 *  ������dateStr �����������ַ�������Ҫ�����ж�����ȷ�����ڡ�
 *  ������add �������ַ������ͣ���ʾҪ���ӵ�������
 *  ������ymdFlag Ŀǰû���õ������ʽӦ���ǣ�'ymd' �� 'ym' �����Ժ����չ��
 *
 */
function _dateAdd(dateStr,add,ymdFlag)
{
    var dd=new Date(dateStr)
	var ad=parseInt(add)
	var day=dd.getDate()
	dd.setDate(day+ad)
	var nd=dd.getFullYear()+"/"+
	((dd.getMonth()+1)<10?("0"+(dd.getMonth()+1)):(dd.getMonth()+1))+"/"+
	(dd.getDate()<10?("0"+dd.getDate()):(dd.getDate()))
	return nd
}
/**
 * 6.2
 * ����ʽ������RS10�������Ϊ�������о��е�����
 *
 */
function winOpenOnMain(hrefStr,winName,width,height)
{
    var screenWidth=screen.availWidth
	var screenHeight=screen.availHeight
	//205�ǲ˵����Ŀ�ȣ�����17�Ǵ�ֱ�������Ŀ��
	//74�Ǳ������ĸ߶ȣ�����20�Ǵ�������������˵��������߶ȣ�����21��״̬���ĸ߶�
	//height�����20������򿪵Ĵ��ڵı����������˵��������߶ȣ�����8�Ǵ�����ϡ��±߿�ĸ߶Ⱥ�
	var left=(screenWidth-205-17-width)/2+205+17  //����205+17����Ϊǰ���������ֻ�ǵ���֡����ʼ��
	var top=(screenHeight-74-20-21-height-20-8)/2+74+20  //����74+20����Ϊǰ���������ֻ�ǵ���֡����ʼ��

	//������򿪵Ĵ���Ŀ�Ȼ�߶ȸ߳�����֡������ҳ�棩�Ŀ�Ȼ�߶ȵĻ�����ʼ����������Ļ����
	if(width>(screenWidth-205-17-8))
	    left=(screenWidth-width)/2
		if(height>(screenHeight-74-20-21-20-8))
		    top=(screenHeight-height)/2-10

			//������򿪵Ĵ���Ŀ�Ȼ�߶ȸ߳���ʾ�ķֱ��ʵĿ�Ȼ�߶ȵĻ���������ʼ��Ϊ��
			if(width>=screenWidth)
			    left=0
				if(height>=screenHeight)
				    top=0

					var wh=window.open(hrefStr,winName,
						"location=no scrollbars=no menubar=no status=no resizable=yes " +
						"width="+width+" height="+height+" left="+left+" top="+top)
					wh.focus()
}
/**
 *  6.3 ����Ļ�н��о��е���ģ̬����
 *
 *
 */
function winOpen_M(hrefStr,winName,width,height)
{
    var win_name;
    if(winName=="")
	win_name="_blank"
    else
	win_name=winName
	    var vReturnValue = window.showModalDialog(hrefStr
		    ,win_name
		    ,"scrollbars:no;center:yes;status:no;help:no;"+
		    "resizable:yes;dialogWidth:"+width+"px;"+
		    "dialogHeight:"+height+"px;")
	    return vReturnValue

}
/**
 *  6.4 ��main����н��о��е���ģ̬����
 *
 *
 */
function winOpenOnMain_M(hrefStr,winName,width,height)
{
    var screenWidth=screen.availWidth
	var screenHeight=screen.availHeight
	//205�ǲ˵����Ŀ�ȣ�����17�Ǵ�ֱ�������Ŀ��
	//74�Ǳ������ĸ߶ȣ�����20�Ǵ�������������˵��������߶ȣ�����21��״̬���ĸ߶�
	//height�����20������򿪵Ĵ��ڵı����������˵��������߶ȣ�����8�Ǵ�����ϡ��±߿�ĸ߶Ⱥ�
	var left=(screenWidth-205-17-width)/2+205+17  //����205+17����Ϊǰ���������ֻ�ǵ���֡����ʼ��
	var top=(screenHeight-74-20-21-height-20-8)/2+74+20  //����74+20����Ϊǰ���������ֻ�ǵ���֡����ʼ��

	//������򿪵Ĵ���Ŀ�Ȼ�߶ȸ߳�����֡������ҳ�棩�Ŀ�Ȼ�߶ȵĻ�����ʼ����������Ļ����
	if(width>(screenWidth-205-17-8))
	    left=(screenWidth-width)/2
		if(height>(screenHeight-74-20-21-20-8))
		    top=(screenHeight-height)/2-10

			//������򿪵Ĵ���Ŀ�Ȼ�߶ȸ߳���ʾ�ķֱ��ʵĿ�Ȼ�߶ȵĻ���������ʼ��Ϊ��
			if(width>=screenWidth)
			    left=0
				if(height>=screenHeight)
				    top=0

					var win_name;
    if(winName=="")
	win_name="_blank"
    else
	win_name=winName
	    var vReturnValue = window.showModalDialog(hrefStr
		    ,win_name
		    ,"scrollbars:no;center:no;status:no;help:no;"+
		    "resizable:yes;dialogWidth:"+width+"px;"+
		    "dialogHeight:"+height+"px;"+
		    "dialogLeft:"+left+"px;"+
		    "dialogTop:"+top+"px;")
	    return vReturnValue
}
//ʱ�亯��
function chkTime(ob)
{
    var dd=_getTime(ob.value)
	if(dd=="")
	{
	    alert("ʱ�����!")
		ob.select()
		ob.focus()
	}
	else if(dd=="blank")
	{
	    ob.value=""
	}
	else
	{
	    ob.value=dd
	}

}
//ȡʱ��
function _getTime(dateStr)
{
    var len=dateStr.length
	var hh//Сʱ
	var mm//����
	var ss//��
	if(dateStr.length==0)
	{
	    return "blank"
	}
	else  if(len==8 )//��ð��
	{
	    hh=dateStr.substring(0,2)
		mm=dateStr.substring(3,5)
		ss=dateStr.substring(6)
	}
	else if(len==6)//��ð��
	{
	    hh=dateStr.substring(0,2)
		mm=dateStr.substring(2,4)
		ss=dateStr.substring(4)
	}
	else
	{
	    return ""
	}
    if(!chkPlus1(hh,24))
    {
	return ""
    }
    if(hh==24)
    {
	if(mm!=00||ss!=00)
	{
	    return ""
	}
    }
    else
    {
	if(!chkPlus1(mm,60))
	{
	    return ""
	}
	if(!chkPlus1(ss,60))
	{
	    return ""
	}
    }
    return hh+":"+mm+":"+ss
}
//����Ƿ���������&&�Ƿ�С��max
function chkPlus1(str,max)
{
    for (var i=0; i < str.length; i++)
    {
	var ch=str.charAt(i);
	if(ch==' ')
	{
	    return false
	}
	if (ch <'0' || ch>'9')
	{
	    return false
	}
    }
    if(str<max)
    {
	return true
    }
    else
    {
	return false
    }

}

/** 6.6 form_submit(m_form)
 *  ���ܣ���FORM�����ύ����
 *  ���ã����������û���������������ύ����
 *  ������m_form -- �ύ��FORM��
 *  ����ֵ����
 *  ���ߣ�ʩ��
 *  ʱ�䣺2003/07/21
 */
var _is_submit = 0  //�źŵƱ�������ҳ���ڹ��ã���ҳ��ˢ�º��Զ��ָ�

function form_submit(m_form)
{
    //���ҳ�������ύ���򷵻�
    if (_is_submit==1)
	return

	    //�ı��źŵƱ���
	    _is_submit = 1

	    //ִ���ύҳ�����
	    eval("document." + m_form + ".submit()")
}

/**
 *  6.7 ����Ļ���½�ģ̬����������Զ������
 *
 *
*/
function winOpen_H(hrefStr)
{
    var vReturnValue = window.showModalDialog(hrefStr,
                                              "_blank",
                                              "scrollbars:no;center:no;status:no;help:no;resizable:no;" +
                                              "dialogWidth:0px;" +
                                              "dialogHeight:0px;" +
                                              "dialogLeft:2000px;" +
                                              "dialogTop:2000px;"
                                              )
    return vReturnValue
}

/*
   ��������_DataCtrlOnFocus(tr_str, rowno)

   ���ܣ��ָ�ǰһ�����еĵ�ɫ�����õ�ǰ�����еĵ�ɫ

   �������������и��ؼ���onfocus()��onkeypress()�¼��е���

   ������
   tr_str -- ҳ���б��У���tr��id��ǰ׺����ַ�������ǰ׺���Զ��ŷָ�
   rowno  -- ��ǰ�к�

   ʵ����
   �ٶ�ҳ����������������table��ɣ���ǰ׺�ֱ�Ϊ��tr0��tr1��tr2
   ��ǰ��Ϊ5

   �������£�_DataCtrlOnFocus("tr0,tr1,tr2","5")
 */
function _DataCtrlOnFocus(tr_str, rowno)
{
    //�����ǰ�кŵ���ǰһ�кţ����˳�������
    if (rowno == _LastRowNo)
	return

	    //��¼�¸�tr��idǰ׺
	    var m_tr = tr_str.split(",")

	    //�ָ�ǰһ�еĵ�ɫ
	    if (_LastRowNo != "XXX")
	    {
		for (var i=0; i<m_tr.length; i++)
		    eval(_trim(m_tr[i]) + _LastRowNo + ".className = " + eval("document.rs10_form_d.cur_color" + _LastRowNo + ".value"))
	    }

    //���õ�ǰ�е�ɫ
    for (var i=0; i<m_tr.length; i++)
	eval(_trim(m_tr[i]) + rowno + ".className = '" + activeLineClass + "'")

	    //����ǰһ�к�
	    _LastRowNo = rowno
}

/*
   ��������_DataCtrlOnChange(rowno)

   ���ܣ��޸������б����޸ı�ǡ���ǰ��ɫ���ؿؼ���ֵ

   �����������б��У����ؼ�onchange�¼�����Զ��ȡֵ��ԭֵ��ͬʱ����

   ������rowno -- ��ǰ�к�

   ʵ�����ٶ��޸ĵĿؼ�������Ϊ5
   �������£�_DataCtrlOnChange("5")
 */

//ҳ�������б����пؼ�ֵ���޸�
var _dirty = false

function _DataCtrlOnChange(rowno)
{
    eval("document.rs10_form_d.modifyFlag" + rowno + ".value = 'Y'")
	eval("document.rs10_form_d.cur_color" + rowno + ".value = 'updateLineClass'")
	_dirty = true
}

/*
   ��������_form_submit(cmd_name, is_confirm, judge_dirty, divid_str)

   ���ܣ��ж������б��Ƿ񱻸��ģ���ȡ��div������λ�ã��ύҳ��

   �����������б��ҳ�棬�ύҳ��ʱ����

   ������
   cmd_name    -- �����������
   is_confirm  -- �Ƿ���Ҫ�û�ȷ�Ϻ���ύ Y:��Ҫ N:����Ҫ
   judge_dirty -- �Ƿ���Ҫ�ж������б����޸ı� Y:��Ҫ N:����Ҫ
   divid_str   -- ��div��id������ַ������ɶ��ŷָ�

   ʵ����
   �ٶ���ҳ���������б�ҳ�棬������div��id�ֱ�Ϊdiv0��div1
   ��ѯ���ã�_form_submit("��ѯ", "N", "Y", "div0,div1")
   �������ã�_form_submit("����", "N", "Y", "div0,div1")
   ɾ�����ã�_form_submit("ɾ��", "Y", "Y", "div0,div1")
   ���µ��ã�_form_submit("����", "Y", "N", "div0,div1")
   ��ҳ���ã�_form_submit("��ҳ", "N", "Y", "div0,div1")
   ������ã�_form_submit("����", "N", "Y", "div0,div1")

   ע������û��div��ҳ�棬����divid_str���մ�""
 */
function _form_submit(cmd_name, is_confirm, judge_dirty, divid_str)
{
    if (judge_dirty == "Y")
    {
	if (_dirty)
	{
	    if (confirm("�Ƿ񱣴�����ݵ��޸�?\n\nȷ��:����" + cmd_name + "����," +
			"�ȴ��û������޸ģ�\nȡ��:���������ݵ��޸�,����" + cmd_name + "������"))
		return
	}
    }

    if (is_confirm == "Y")
    {
	if (!confirm("ȷ��" + cmd_name + "��?"))
	    return
    }

    //��ȡ��div��id����ȡ��div��������ǰλ��
    if (checkSpace(divid_str))
    {
	var m_div = divid_str.split(",")
	    var m_left = ""

	    for (var i=0; i<m_div.length; i++)
	    {
		if (i == 0)
		    m_left = eval(m_div[i] + ".scrollLeft.toString()")
		else
		    m_left+= "," + eval(m_div[i] + ".scrollLeft.toString()")
	    }

	eval("document.rs10_form_d.div_position.value = '" + m_left + "'")
	    eval("document.rs10_form_d.div_id.value = '" + divid_str + "'")
    }

    //�ύҳ��
    form_submit("rs10_form_d")
}

/*
   ��������_resume_div_scrollbar()

   ���ܣ��ָ���div������λ�õĺ���

   �����������������б�div��ҳ�棬ֱ�ӵ���

   ��������

   ʵ�����ٶ���ҳ���������б���ҳ��
   �������£�_resume_div_scrollbar()
 */
function _resume_div_scrollbar()
{
    if (!checkSpace(document.rs10_form_d.div_id.value))
	return

	    if (!checkSpace(document.rs10_form_d.div_position.value))
		return

		    var m_div = document.rs10_form_d.div_id.value.split(",")
		    var m_left = document.rs10_form_d.div_position.value.split(",")
		    if (m_div.length != m_left.length)
		    {
			alert("div��λ��ֵ������һ�£������Ա�޸�!")
			    return
		    }

    for (var i=0; i<m_div.length; i++)
	eval(m_div[i] + ".scrollLeft=" + m_left[i])
}

/*
   ��������_save_screen_value(max_row, max_col, prefix)

   ���ܣ����������б��и��ؼ��ĳ�ֵ��Ϊ����������׼����

   ������ά���������б�ҳ��ˢ�º�ֱ�ӵ��ã�
   ���ҳ������Զ���ֵ�������Ӧ�ڸ�ֵ����ñ���������֤��¼������������Ҫ�ĳ�ֵ��

   ������
   max_row -- ����к�
   max_col -- ����к�
   prefix  -- �ؼ�id��ǰ׺
 */

var _screen_value = ""
var _old_cur_color = ""

function _save_screen_value(max_row, max_col, prefix)
{
    //�������ݿؼ���ԭֵ
    for (var i=0; i<parseInt(max_row); i++)
    {
	for (var j=0; j<parseInt(max_col); j++)
	{
	    if (i == 0 && j == 0)
		_screen_value = eval("document.all." + prefix + i + "_" + j + ".value")
	    else
		_screen_value+= ";" + eval("document.all." + prefix + i + "_" + j + ".value")
	}
    }

    //���浱ǰ��ɫԭֵ
    for (var i=0; i<parseInt(max_row); i++)
    {
	if (i == 0)
	    _old_cur_color = eval("document.rs10_form_d.cur_color" + i + ".value")
	else
	    _old_cur_color+= "," + eval("document.rs10_form_d.cur_color" + i + ".value")
    }
}

/*
   ��������_update_reset(max_row, max_col, prefix, trid_str, ctr_name, if_select)

   ���ܣ��޸�����

   �������޸�����ʱֱ�ӵ���

   ������
   max_row   -- ����к�
   max_col   -- ����к�
   prefix    -- �ؼ�id��ǰ׺
   trid_str  -- tr��idǰ׺�ַ�����ϣ��ö��ŷָ�
   ctr_name  -- ���ú����ý���Ŀؼ�name����form����
   if_select -- ���ý�����Ƿ�ѡ�С� Y--ѡ�У�N--��ѡ��

   ʵ����_update_reset("5", "3", "move", "tr0,tr1,tr2", "rs10_form_d.item_code", "Y")
 */
function _update_reset(max_row, max_col, prefix, trid_str, ctr_name, if_select)
{
    if (!_dirty)
    {
	if (checkSpace(ctr_name))
	{
	    eval("document." + ctr_name + ".focus()")

		if (if_select == "Y")
		    eval("document." + ctr_name + ".select()")
	}

	return
    }

    if (!confirm("ȷ�����������ݵ��޸���?"))
    {
	if (checkSpace(ctr_name))
	{
	    eval("document." + ctr_name + ".focus()")

		if (if_select == "Y")
		    eval("document." + ctr_name + ".select()")
	}

	return
    }

    //�ָ�ԭֵ
    var k = 0;
    var m_value = _screen_value.split(";")

	for (var i=0; i<parseInt(max_row); i++)
	{
	    for (var j=0; j<parseInt(max_col); j++)
	    {
		eval("document.all." + prefix + i + "_" + j + ".value = '" + m_value[k] + "'")
		    k++
	    }
	}

    //�ָ����޸ı�ǡ���ǰ����ɫ���е�ɫ
    var m_cur_color = _old_cur_color.split(",")
	var m_trid = trid_str.split(",")

	for (var i=0; i<m_cur_color.length; i++)
	{
	    eval("document.rs10_form_d.modifyFlag" + i + ".value = 'N'")
		eval("document.rs10_form_d.cur_color" + i + ".value = '" + m_cur_color[i] + "'")

		for (var j=0; j<m_trid.length; j++)
		    eval(m_trid[j] + i + ".className = " + m_cur_color[i])
	}

    //�޸��޸ı��
    _dirty = false

	if (checkSpace(ctr_name))
	{
	    eval("document." + ctr_name + ".focus()")

		if (if_select == "Y")
		    eval("document." + ctr_name + ".select()")
	}
}

/*
   ��������_set_err_color(trid_str, rowno)

   ���ܣ�����tr����ɫ

   ������
   trid_str -- tr��id����ַ������ö��ŷָ�
   rowno    -- �к�
 */
function _set_err_color(trid_str, rowno)
{
    eval("document.rs10_form_d.cur_color" + rowno + ".value = 'updateLineClass'")
    eval("document.rs10_form_d.modifyFlag" + rowno + ".value = 'Y'")

	var m_tr = trid_str.split(",")

	for (var i=0; i<m_tr.length; i++)
	    eval(m_tr[i] + rowno + ".className = '" + updateLineClass + "'")

}
//ͯ�������
var moveFlag=true
    var rowToCol=true
function setMoveFlag()
{
    moveFlag=false
}
function setConvert()
{
    if( rowToCol==false)
    {
	rowToCol=true
    }
    else
    {
	rowToCol=false
    }
}
//type I input
//type V view
//row �к�,��col �к�, rowmax����к�,colmax ����к� ,prefix�ؼ�idǰ׺
//�ؼ������Ǳ������¸�ʽ prefix+row+"_"+col
function moveCursor(row,col,rowmax,colmax,prefix)
{

    rowmax=rowmax-1
    colmax=colmax-1
    if(!checkSpace(prefix))
    {
	prefix="move"
    }
    type=eval("document.all."+prefix+row+"_"+col+".type")
    if(type!="text")
    {
	moveFlag=true
    }
	if(moveFlag==true)//�ƶ�״̬
	{
	    if(event.keyCode == 13)//enter
	    {

		if(rowToCol==false)//����
		{
		if(type=="")
		{
		    event.keyCode =37
		}
		    row=row+1
		    if(row<=rowmax)
		    {
		        focAndSel(row,col,prefix)
		    }
		}
		else//����
		{
		if(type=="")
		{
		    event.keyCode = 37

		}
		    col=col+1
			if(col<=colmax)
			{
			    focAndSel(row,col,prefix)
			}
			else
			{
			    row=row+1
				if(row<=rowmax)
				{
				    focAndSel(row,0,prefix)
				}
			}
		}
		moveFlag=true
		    return
	    }
	    else if(event.keyCode == 32)//space
	    {
		event.keyCode = 13
	    }
	    else if(event.keyCode == 38)//up
	    {
		if(type=="select-one")
		{
		    event.keyCode = 37
		}
		row=row-1
		    if(row>=0)
		    {
			focAndSel(row,col,prefix)
		    }
	    }
	    else if(event.keyCode == 40)//down
	    {
		if(type=="select-one")
		{
		    event.keyCode = 37
		}

		row=row+1
		    if(row<=rowmax)
		    {
			focAndSel(row,col,prefix)
		    }
	    }
	    else if(event.keyCode == 37)//left
	    {
		col=col-1
		    if(col>=0)
		    {
			focAndSel(row,col,prefix)
		    }
		    else
		    {
			row=row-1
			    if(row>=0)
			    {
				focAndSel(row,colmax,prefix)
			    }
		    }
	    }
	    else if(event.keyCode == 39)//right
	    {
		col=col+1
		    if(col<=colmax)
		    {
			focAndSel(row,col,prefix)
		    }
		    else
		    {
			row=row+1
			    if(row<=rowmax)
			    {
				focAndSel(row,0,prefix)
			    }
		    }
	    }
	    else
	    {
		moveFlag=false
	    }

	}
	else
	{
	    if(event.keyCode == 13||event.keyCode == 9)//enter
	    {
		event.keyCode = 9
		    moveFlag=true
	    }
	    else if(event.keyCode == 32)//space
	    {
		event.keyCode = 13
		    moveFlag=true
	    }
	    else if(event.keyCode == 27)//esc
	    {
		moveFlag=true
	    }
	    else if(event.keyCode == 38)//up
	    {
		if(type=="select-one")
		{
		    event.keyCode = 37
		}
		row=row-1
		    if(row>=0)
		    {
			focAndSel(row,col,prefix)
		    }
		moveFlag=true
	    }
	    else if(event.keyCode == 40)//down
	    {
		if(type=="select-one")
		{
		    event.keyCode = 37
		}
		    if(row<=rowmax)
		    {
			focAndSel(row,col,prefix)
		    }
		moveFlag=true
	    }

	}
	if(type="select-one")
	{
	    if(event.keyCode == 33)
	    {
		    event.keyCode =38
	    }
	    else if(event.keyCode == 34)
	    {
		event.keyCode =40
	    }
	}

}
function focAndSel(row,col,prefix)
{
    val=eval("document.all."+prefix+row+"_"+col+".value")
    type=eval("document.all."+prefix+row+"_"+col+".type")
	    eval("document.all."+prefix+row+"_"+col+".focus()");
	if(type=="text"&&checkSpace(val))
	{
	    eval("document.all."+prefix+row+"_"+col+".select()")
	}
	else if(type==""&& event.keyCode == 13)
	{
	    event.keyCode=37
	}
}
//ͯ������ӽ���
