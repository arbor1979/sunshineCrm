/**
 * 发布日期：2002/05/22
 *
 * 归档整理：赵音
 *
 * 内容归纳：
 *     一、全局变量设置
 *     二、键盘函数：
 *        2.1  function f_keyenter(str1)
 *		    2.2  function chkInput(obj)
 *		    2.3  function chkInputDown()
 *	   三、鼠标当前行变色函数:
 *        3.1  function MoveOn(res)
 *        3.2  function MoveOut(res)
 3.3  click_tr(res)
 *     四、字符串处理函数
 *				4.1  function checkSpace(str)
 *				4.2  function parseString(str)
 *				4.3  function absLength(str)
 *			      4.4  function chkLen(strArg,note)
 *				4.5  function URLEncode(myStr)
 *        4.6  function _trim(str)
 *        4.7  function _ltrim(str)
 *        4.8  function _rtrim(str)
 *	   五、数字处理函数
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

 *		六、其它函数
 *				6.1  function winOpen(hrefStr,winName,width,height)
 *				6.2  function winOpenOnMain(hrefStr,winName,width,height)
 *				6.3  function winOpen_M(hrefStr,winName,width,height)
 *				6.4  function winOpenOnMain_M(hrefStr,winName,width,height)
 *              6.5  function openExcel(args)
 *              6.6  function form_submit(m_form)
 *              6.7  function winOpen_H(hrefStr)
 *
 *      七、日期函数：
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
 * 类型一、全局变量设置
 */

//保存背景色，用在类型三中的鼠标当前行变色函数MoveOn和MoveOut函数中
var bgColor;

//一条记录所跨最大 table 数,用于行变色
var nnn = 4;

//页面数据列表中前一行的行号
var _LastRowNo = "XXX";

//奇数行背景颜色
var oddBgColor = "#FFFFFF";

//奇数行class
var oddLineClass = "tr1";

//偶数行背景颜色
var evenBgColor = "#EEEEEE";

//偶数行class
var evenLineClass = "tr2";

//修改行背景颜色
var updateBgColor = "#FCF5CB";

//修改行class
var updateLineClass = "mod_err_Color";

//焦点行背景颜色
var activeBgColor = "#CBDDED";

//焦点行class
var activeLineClass = "cur_tr_Color";

//敲击Esc键次数,用在类型二键盘函数中的f_keyenter函数
var key_Count = 0;

//用在类型二键盘函数中的f_keyenter函数
var key_Esc = "false";

/**
 * 本函数是为了输出Excel文档使用
 * 参数：fileName 指明了要下载时显示给用户的文件名
 * arg 是字符串类型,其中包含了以下的参数：
 *       doc_no     指明一个已经定义了的报表编码
 *       con        提取报表内容所需的条件
 *       sp         在提取报表内容之前需要运行的 sp 名称
 *       sp_args    运行 sp 所需的参数值
 *       prt_name   强行指定报表的名称，其优先级高于报表定义中报表名称
 *       sheet_name 强行指定Excel中sheet的名称，如果没有指定，却省是 "sheet1"
 *
 *  例子：
 *       var doc_no="edm1100_e"
 *       var con="item_code like '125%' order by item_code"
 *       var sp="edm1100_sp"
 *       var sp_args= user_unique_id+","+document.item_code.value
 *       var prt_name=year+"/"+month+" 月报"
 *       var sheet_name="月报"
 *
 *       var arg="doc_no="+doc_no+
 *               "&con="+URLEncode(con)+
 *               "&sp="+sp+
 *               "&sp_args="+URLEncode(sp_args)+
 *               "&prt_name="+URLEncode(prt_name)+
 *               "&sheet_name="+URLEncode(sheet_name)
 *       openExcel(arg)
 *   注：其中只有 doc_no 参数是必需的，其余的都是可选参数。
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
 * 类型二、键盘函数
 */



/**
 * 2.1
 * 函数功能：   转换Tab为Enter，屏蔽Esc的重置功能
 * 参数说明：
 1、转换Enter键为Tab键
 2、使连击Esc键的重置功能失效
 3、转换Space键为Enter键
 4、对所有键都不起作用
 4个参数可配合使用，以实现不同的需求，以下是几个常见使用方法
 * 使用方法1
 * 对窗体中可维护的控件(包括条件选择控件和数据维护控件)，设置tabindex属性，该属性设定光标行走的顺序。
 * 使用举例：//按下Enter键时，光标按t1、t2、t3、t4的顺序行走,光标到t4时，再按Enter键不起作用。
 * <% int tab_no = 1;%>
 * <input type="text" name="t1" tabindex = "<%=tab_no++%>" onkeydown="javascript:return f_keyenter('Y','N','N','N')">
 * <input type="text" name="t2" tabindex = "<%=tab_no++%>" onkeydown="javascript:return f_keyenter('Y','N','N','N')">
 * <input type="text" name="t3" tabindex = "<%=tab_no++%>" onkeydown="javascript:return f_keyenter('Y','N','N','N')">
 * <input type="text" name="t4" tabindex = "<%=tab_no++%>" onkeydown="javascript:return f_keyenter('N','N','N','Y')">
 *
 * 使用方法2
 * 当光标在"删除"操作符上时，按Enter或Tab都不起作用，只能用鼠标去点击
 * <a href="javascript:f_add()" tabindex="-1" onkeydown="javascript:return f_keyenter('N','N','N','Y')">
 *    <img border="0" src="/com/rsc/rs/pub/images/add.gif" width="16" height="16" alt="删除" >
 * </a>
 *
 * 使用方法3
 * 按Space键弹出选择窗体,按下Enter键光标移动到下一个位置
 * <a href="javascript:selectWarehouse()" tabindex="-1" onkeydown="javascript:return f_keyenter('Y','N','Y','N')">
 *     <img border="0" src="/com/rsc/rs/pub/images/view.gif" width="16" height="16" alt="查找" >
 * </a>
 *
 * 使用方法4
 * 屏蔽连续两次esc键的重置功能，按下Enter键光标移动到下一个位置
 * <input type="text" name="t1" tabindex = "<%=tab_no++%>" onkeydown="javascript:return f_keyenter('Y','Y','N','N')">

 * 返 回 值：  true或false
 *			   true： 输入字符有效
 *             false：输入字符无效
 */
function f_keyenter(enter_key,esc_key,space_key,all_key,eve)
{

    //alert("ddd")
    var array_key_code = "18^33^34^35^36^37^38^39^40^45^46^114^121^122";

    //对所有键都不起作用，可用于屏蔽属性为readonly的控件，任何键对其都不起作用
    if (all_key == "Y")
	return false

	    //当enter_key为"Y"时，转换Enter键为Tab键
	    if (enter_key=="Y")
	    {
		if (event.keyCode == 13)
		    event.keyCode = 9
	    }

    //当enter_key为"Y"时，转换Space键为Enter键
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

    //当esc_key为"Y"时，使连击Esc键的重置功能失效，单击Esc键时重置本控件的内容
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
 * 函数功能：	判断输入的字符是否合法。
 * 参数说明：  判断输入是否合法的input组件的值
 * 使用举例：  <input type="text" name="test" maxlength="8" onkeypress="return chkInput(this.value)" >
 * 返 回 值：  true或false
 *				true： 输入字符有效
 *             false：输入字符无效
 */
function chkInput(obj)
{
    var charCode=event.keyCode
	if(obj.length==0&&charCode==32)
	    return false
		if(charCode==34)//如果输入的符号是分号(;)
		    return false
			if(charCode==59)//如果输入的符号是双引号(")
			    return false
				if(charCode==44)//如果输入的符号是逗号(,)
				    return false
					if(charCode==39)//如果输入的符号是单引号(')
					    return false
						if(charCode==92)//如果输入的符号是单引号(\)
						    return false
							return true

}
/**
 * 2.3
 * 函数功能：	判断输入的字符是否合法。
 * 使用举例：	<input type="text" name="test" maxlength="8" onkeydown="return chkInputDown()" >
 * 说    明： 这个函数和chkInput函数的区别是：
 * 			这个函数用在onkeydown事件里
 * 			chkInput函数用在onkeypress事件里
 * 返 回 值：  true或false
 *			 true： 输入字符有效
 *             false：输入字符无效
 */
function chkInputDown()
{
    var charCode=event.keyCode
	if(charCode==186)//如果输入的符号是分号(;)
	    return false
		if(charCode==16)//如果输入的符号是双引号(")
		    return false
			if(charCode==188)//如果输入的符号是逗号(,)
			    return false
				if(charCode==222)//如果输入的符号是单引号(')
				    return false
					return true

}



/**
 * 类型三：鼠标当前行变色函数
 */

/**
 * 3.1
 * 函数功能：	鼠标移到当前行，鼠标形状变为手形、当前行变色，提示用户当前行为点中行。
 * 参数说明：  鼠标移到的当前行
 * 使用举例：  <tr onMouseOver="MoveOn(this);" onMouseOut="MoveOut(this);">
 * 返 回 值：  无返值
 */
function MoveOn(res)//鼠标移到当前行;原函数名称：MouseOn
{
    res.style.cursor="hand";
    bgColor = res.style.backgroundColor;
    if(document.all.rows_table_1 == null)//旧版本
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
    else//新版本
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
 * 函数功能：	鼠标离开当前行时，鼠标形状和当前行颜色还原为初始状态。
 * 参数说明：  鼠标移出的当前行
 * 使用举例：  <tr onMouseOver="MoveOn(this);" onMouseOut="MoveOut(this);">
 * 返 回 值：  无返值
 */
function MoveOut(res)
{
    res.style.cursor="Default";
    if(document.all.rows_table_1 == null)//旧版本
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
    else//新版本
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
 * 函数功能：  鼠标点击当前行时，当前行颜色变为标记色。
 * 参数说明：  鼠标点击的当前行, 所有使用该方法的tr的table须设ID值, 类似 rows_table_i i值从1到n
 *            如果一个页面内有上下两个包括记录行的table时,禁用 rows_table_1 本函数功能无效
 *
 * 使用举例：  <tr onClick="click_tr(this);" onMouseOver="MoveOn(this);" onMouseOut="MoveOut(this);">
 * 返 回 值：  无返值
 */
function click_tr(res)//点击行变色
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
	    document.all("rows_table_"+i).rows(res.rowIndex).className="clickColor" ;//所有table的相同行都变色
	    document.all("rows_table_"+i).rows(res.rowIndex).style.backgroundColor="";//忽略onMouseOver的变色
	}
    }
}

/***************** fzg add END************************/

/**
 * 类型四：字符串处理函数
 */



/**
 * 4.1
 * 函数功能：	验证输入的字符串是否为空
 * 参数说明：  需要进行验证的字符串
 * 返 回 值：  true或false
 *			    true： 输入的字符串不为空
 *             false：输入的字符串为空
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
 * 函数功能：	将带有逗号分隔符的字符串格式转为不带逗号分隔符的字符串。
 * 参数说明：  需要进行转换的字符串
 * 返 回 值：  转换后不带逗号的字符串
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
 * 函数功能：	获得字符串的绝对长度。本函数将汉字作为两个字符，其返回的值可用于匹配数据库的字段长度
 * 参数说明： str 要判断的字符串
 * 返 回 值： 字符串的绝对长度
 */
function absLength(str)
{
    return str.length    //数据库中使用NVERCHAR类型后将不再对前端汉字进行长度计算
	/*
	   var len=0;
	   if(str!=null) {
	   var c;
	   var l = str.length;
	   for(var i=0;i<l;i++) {
	   c = str.charAt(i)
	   len+= (c>="　") ? 2 : 1;
	   }
	   }
	   return len
	 */
}

/**
 * 4.4
 * 函数功能：	判断输入的字符是否超长。
 * 参数说明：
 *            strArg:需要判断字符长度，类型为text的组件
 *            note:中英文标识
 * 使用举例:  <input type="text" name="test" maxlength="8" onblur="checkLength(this,'en')" >
 * 说    明:  input 组件的maxlength必须要设置，否则程序执行不正确
 */
function chkLen(strArg,note)
{
    try{
	var  lanFlag=note
	    var note1="输入的字符长度超过允许输入的最大长度!"
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
 * 函数功能：  将“特殊字符”转换成IE能够识别的符号
 * 参数说明：
 *             myStr: 字符串（含有或不含有特殊字符）
 * 返 回 值：  转换后的字符串
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
 *  4.6 去左右空格函数
 *  参数 str 是一字符串
 *  返回 去左右空格的字符串
 */
function _trim(str)
{
    var ss=""+str
	return (_ltrim(_rtrim(ss)));
}

/**
 *  4.7 去左空格函数
 *  参数 str 是一字符串
 *  返回 去左空格的字符串
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
 *  4.8 去右空格函数
 *  参数 str 是一字符串
 *  返回 去右空格的字符串
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
 * 类型五：数字处理函数
 */


/**
 * 5.1
 * 函数功能：	验证输入的字符类型是否为正整数
 * 参数说明：  需要进行判断的组件域
 * 返 回 值：  true或false
 *			    true： 输入的字符串是正整数
 *             false：输入的字符串不是正整数
 * 使用说明：  <input type="text"　name="plus" onblur="chkPlus(this)">
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
		alert("不能输入空格!")
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	    if (ch <'0' || ch>'9')
	    {
		alert("请输入正整数或零!")
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	}
    return true
}


/**
 * 5.2
 * 函数功能：	验证输入的字符类型是否为整数
 * 参数说明：  需要进行判断的组件域
 * 返 回 值：  true或false
 *			    true： 输入的字符串是整数
 *             false：输入的字符串不是整数
 * 使用说明：  <input type="text"　name="plus" onblur="chkNegative(this)">
 */
function chkNegative(strArg)
{
    var str=parseString(strArg.value)
	for (var i=0; i < str.length; i++)
	{
	    var ch=str.charAt(i);
	    if ((ch <'0' || ch>'9')&&ch!='-')
	    {
		alert("请输入整数!")
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	   if(ch=='-' && str.length==1)
      {
        alert("请输入整数!")
        strArg.focus()
        strArg.select()
        return false
      }
	}
    return true
}


/**
 * 5.3
 * 函数功能：	验证输入的字符类型是否为数字
 * 参数说明：  需要进行判断的组件域
 * 返 回 值：  true或false
 *			    true： 输入的字符串是数字
 *             false：输入的字符串不是数字
 * 使用举例：  <input type="text"　name="plus" onblur="chkDecNegative(this)">
 */
function chkDecNegative(strArg,len)
{
    var count=0
	var numberValue=parseString(strArg.value)   //去逗号，空格
	var pointLocat=numberValue.indexOf(".")     //判断小数点后的位数长度
	for (var i=0; i < numberValue.length; i++)
	{
	    var ch=numberValue.charAt(i);
	    if(i==0)
	    {
		if ((ch <'0' || ch>'9')&&ch!='-'&&ch!='.')
		{
		    alert("请输入数字!")
			strArg.focus()
			strArg.select()
			return false
		}
    if((ch=='-'||ch=='.') && numberValue.length==1)
    {
      alert("请输入数字!")
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
		    alert("请输入数字!")
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
 * 函数功能：	验证输入的字符类型是否为正数
 * 参数说明：  需要进行判断的组件域
 * 返 回 值：  true或false
 *			    true： 输入的字符串是正数
 *             false：输入的字符串不是正数
 * 使用举例：  <input type="text"　name="plus" onblur="chkDecPlus(this)">
 */
function chkDecPlus(strArg,len)
{
    var count=0
	var numberValue=parseString(strArg.value)
	var pointLocat=numberValue.indexOf(".")//判断小数点后的位数长度
	for (var i=0; i < numberValue.length; i++)
	{
	    var ch=numberValue.charAt(i);
	    if(i==0)
	    {
		if ((ch <'0' || ch>'9')&&ch!='.')
		{
		    alert("请输入正数!")
			strArg.focus()
			strArg.select()
			return false
		}
    if(ch=='.' && numberValue.length==1)
    {
      alert("请输入正数!")
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
			    alert("请输入正数!")
				strArg.focus()
				strArg.select()
				return false
			}
		if ((ch <'0' || ch>'9')&&ch!='.')
		{
		    alert("请输入正数!")
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
 * 函数功能：	加逗号分隔符，并补零、四舍五入
 * 使用背景：   对于数量、单价、金额类文本，要加逗号分隔符
 * 参数说明：
 *              myStr:  字符串
 *              len  :  需要保留的小数位数
 * 返 回 值：   加逗号后的字符串
 */
function addComma(myStr,len)
{
    var isNegative=false
	//如果myStr为空，则返回该字符串
	if (!checkSpace(myStr))
	{
	    return _trim(myStr)
	}

    //去掉逗号分隔符
    myStr = _trim(parseString(myStr))

	//如果是负数，先去掉负号
	if(myStr.charAt(0)=='-')
	{
	    myStr=myStr.substr(1,myStr.length-1)
		isNegative=true
	}
    //在myStr中查找小数点"."，记录下位置
    var position = myStr.indexOf(".")

	//如果第一位是小数点，则第一位补0
	if (position==0)
	{
	    myStr = "0" + myStr
	}

    //四舍五入
    myStr = round(myStr,len)

	//重新取小数点位置
	position = myStr.indexOf(".")

	//如果无小数点，则认为字符串长度为小数点位置
	if (position==-1)
	{
	    position = myStr.length
	}

    //如果小数点位置大于3则执行循环
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
 * 函数功能：	四舍五入，如果小数点后位数不够则以0补位
 * 参数说明：
 *              myStr:  字符串
 *              len  :  需要保留的小数位数
 * 返 回 值：   四舍五入后的字符串
 */
function round(myStr,len)
{
    //如果myStr为空，则返回该字符串
    if (!checkSpace(myStr))
    {
	return myStr
    }

    //四舍五入
    var tmp1 = myStr * Math.pow(10,len)
	var tmp2 = Math.round(tmp1)
	var tmp3 = tmp2 / Math.pow(10,len)

	//补位
	var tmp4 = tmp3.toString()
	if (parseInt(len)<=0)
	{
	    return tmp4
	}
	else
	{
	    //取小数点位置
	    var position = tmp4.indexOf(".")
		//如果无小数点
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
 * 函数功能：	验证输入的字符类型是否为正整数(不包括零)
 * 参数说明：  需要进行判断的组件域
 * 返 回 值：  true或false
 *			    true： 输入的字符串是正整数
 *             false：输入的字符串不是正整数
 * 使用说明：  <input type="text"　name="plus" onblur="chkPlusNoZero(this)">
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
		alert("请输入正整数!")
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
	    alert("请输入正整数!")
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
 * 函数功能：	验证输入的字符类型是否为数字，如果组件的值为负数，函数自动将组件中的值显示为红色。
 * 参数说明：  需要进行判断的组件域
 * 返 回 值：  true或false
 *			    true： 输入的字符串是数字
 *             false：输入的字符串不是数字
 * 使用举例：  <input type="text"　name="plus" onblur="chkDecNegative(this)">
 */
function glDecNegative(strArg,len)
{
    var count=0
	var numberValue=parseString(strArg.value)   //去逗号，空格
	var pointLocat=numberValue.indexOf(".")     //判断小数点后的位数长度
	for (var i=0; i < numberValue.length; i++)
	{
	    var ch=numberValue.charAt(i);
	    if(i==0)
	    {
		if ((ch <'0' || ch>'9')&&ch!='-'&&ch!='.')
		{
		    alert("请输入数字!")
			strArg.focus()
			strArg.select()
			return false
		}
		if((ch=='-'||ch=='.')&&numberValue.length==1)
    {
      alert("请输入数字!")
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
		    alert("请输入数字!")
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
 * 函数功能：	验证输入的字符类型是否为整数，如果组件的值为负数，函数自动将组件中的值显示为红色。
 * 参数说明：  需要进行判断的组件域
 * 返 回 值：  true或false
 *			    true： 输入的字符串是整数
 *             false：输入的字符串不是整数
 * 使用说明：  <input type="text"　name="plus" onblur="chkNegative(this)">
 */
function glNegative(strArg)
{
    var str=parseString(strArg.value)
	for (var i=0; i < str.length; i++)
	{
	    var ch=str.charAt(i);
	    if ((ch <'0' || ch>'9')&&ch!='-')
	    {
		alert("请输入整数!")
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	     if(ch=='-'&&numberValue.length==1)
      {
        alert("请输入整数!")
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
 * 函数功能：	验证输入的字符类型是否为正数
 * 参数说明：  需要进行判断的组件域
 * 返 回 值：  true或false
 *			    true： 输入的字符串是正数
 *             false：输入的字符串不是正数
 * 使用举例：  <input type="text"　name="plus" onblur="chkDecPlus(this)">
 */
function chkDecPlusNoZero(strArg,len)
{
    var count=0
	var numberValue=parseString(strArg.value)
	var pointLocat=numberValue.indexOf(".")//判断小数点后的位数长度
	for (var i=0; i < numberValue.length; i++)
	{
	    var ch=numberValue.charAt(i);
	    if(i==0)
	    {
		if ((ch <'0' || ch>'9')&&ch!='.')
		{
		    alert("请输入正数")
			strArg.focus()
			strArg.select()
			return false
		}
    if(ch=='.' && numberValue.length==1)
    {
      alert("请输入正数")
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
			    alert("请输入正数")
				strArg.focus()
				strArg.select()
				return false
			}
		if ((ch <'0' || ch>'9')&&ch!='.')
		{
		    alert("请输入正数")
			strArg.focus()
			strArg.select()
			return false
		}
	    }
	}
    if(addComma(strArg.value,len)==0&&numberValue.length>0)
    {
	alert("请输入正数")
	    strArg.focus()
	    strArg.select()
	    return false
    }
    strArg.value=addComma(strArg.value,len)

	return true
}

/**
 * 5.10
 * 函数功能：	验证输入的字符类型是否为小数
 * 参数说明：  需要进行判断的组件域
 * 返 回 值：  true或false
 *			    true： 输入的字符串是小数
 *             false：输入的字符串不是小数
 * 使用举例：  <input type="text"　name="plus" onblur="chkDecimal(this)">
 */
function chkDecimal(strArg,len)
{
    var count=0
	var numberValue=parseString(strArg.value)   //去逗号，空格
	var pointLocat=numberValue.indexOf(".")     //判断小数点后的位数长度
	var point_9 = "0."
	for (var i=0; i < numberValue.length; i++)
	{
	    var ch=numberValue.charAt(i);
	    if(i==0)
	    {
		if ((ch <'0' || ch>'9')&&ch!='-'&&ch!='.')
		{
		    alert("请输入不大于1的正数!")
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
		    alert("请输入不大于1的正数!")
			strArg.focus()
			strArg.select()
			return false
		}
	    }
	    if ((strArg.value>1)||(strArg.value<0))
	    {
		alert("请输入不大于1的正数!")
		    strArg.focus()
		    strArg.select()
		    return false
	    }
	}
    strArg.value=addComma(strArg.value,len)
	return true
}

/**
 * 类型六：其它函数
 */




/**
 * 6.1
 * 函数功能：	以无状态方式打开新窗口
 * 参数说明：
 *             hrefStr： 窗口的请求地址
 *             winName： 窗口名称
 *             width  ： 窗口的宽度
 *             height ： 窗口高度
 * 返 回 值：  无返值
 */
function winOpen(hrefStr,winName,width,height)
{
    var screenWidth=screen.availWidth
	var screenHeight=screen.availHeight
	var left=(screenWidth-width-6)/2 - 2
	var top=(screenHeight-height-24)/2 - 2
	//经过细微的调整，可使窗口打开绝对居中；
	//但打开页面最大宽度不可超过1014，最大高度不可超过740；
	//否则left及top置零。
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
 * 函数功能：	以无状态方式打开新窗口
 * 参数说明：
 *             hrefStr： 窗口的请求地址
 *             winName： 窗口名称
 *             width  ： 窗口的宽度
 *             height ： 窗口高度
 * 返 回 值：  无返值
 */
function winOpenScro(hrefStr,winName,width,height)
{
    var screenWidth=screen.availWidth
	var screenHeight=screen.availHeight
	var left=(screenWidth-width-6)/2 - 2
	var top=(screenHeight-height-24)/2 - 2
	//经过细微的调整，可使窗口打开绝对居中；
	//但打开页面最大宽度不可超过1014，最大高度不可超过740；
	//否则left及top置零。
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
 *  6.2  判断是否是日期字符串
 *
 *  参数 dateStr 有以下格式：yyyy/mm/dd;yyyymmdd; 空值认为不是日期
 *  参数 ymdFlag  是日期格式字符串 "ymd" 表示 "yyyy/mm/dd"格式；"ym" 表示 "yyyy/mm"格式
 *  返回 true 代表是日期，false 代表非日期
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
 *  检查控件中的值是否是日期字符串，如果是日期，则根据参数ymdFlag指定的格式日期进行返回，如果不是日期，给出提示信息并产生聚焦，空字符串不进行检查。
 *  参数 ob 是控件名称
 *  参数 ymdFlag 是日期格式字符串 "ymd" 表示 "yyyy/mm/dd"格式；"ym" 表示 "yyyy/mm"格式
 */
function _chkDate(ob,ymdFlag)
{
    var dd=_getDate(ob.value,ymdFlag)
	if(dd=="")
	{
	    alert("日期错误！")
		ob.select()
		ob.focus()
	}
	else if(dd=="blank")
	    ob.value=""
	else
	    ob.value=dd

}
/**
 * 6.4 获取格式化的日期字符串，并具有日期合法性检验功能
 * 此函数是内部处理函数，也可以直接使用
 * 非日期返回 ""
 * 空日期返回 "blank"
 * 日期型返回 yyyy/mm/dd 格式字符串
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
 *  6.5 比较两个日期
 *
 *  参数：date1,date2是日期型字符串
 *  参数 ymdFlag  是日期格式字符串 "ymd" 表示 "yyyy/mm/dd"格式；"ym" 表示 "yyyy/mm"格式
 *  返回值：
 *          0：日期相等；
 *          1：date1>date2;
 *         -1: date1<date2;
 *         11: date1不是正确日期
 *        -11：date2不是正确日期
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

/** 6.6  取得两个日期相差的天数
 *  参数：dateStr1,dateStr2 是两个需要经过判断正确的日期字符串，方可调用此函数。
 *  参数：ymdFlag 目前没有用到，其格式应该是：'ymd' 或 'ym' 用于以后的扩展。
 *  返回：两个日期相差的天数，数据类型是整形。
 */

function _dateDiff(dateStr1,dateStr2,ymdFlag)
{

    var dd1=new Date(dateStr1)
	var dd2=new Date(dateStr2)
	return (Math.abs(dd2-dd1)/(24*60*60*1000))
}
/**
 *  6.7 日期相加 对一个给定的日期加上天数返回一个新的日期字符串
 *  参数：dateStr 给定的日期字符串，需要经过判断是正确的日期。
 *  参数：add 是整形字符串类型，表示要增加的天数。
 *  参数：ymdFlag 目前没有用到，其格式应该是：'ymd' 或 'ym' 用于以后的扩展。
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
 * 弹出式窗口以RS10第三框架为基础进行居中弹出。
 *
 */
function winOpenOnMain(hrefStr,winName,width,height)
{
    var screenWidth=screen.availWidth
	var screenHeight=screen.availHeight
	//205是菜单栏的宽度，其后的17是垂直滚动条的宽度
	//74是标题栏的高度，其后的20是窗体标题栏（顶端的蓝条）高度，最后的21是状态栏的高度
	//height后面的20是所需打开的窗口的标题栏（顶端的蓝条）高度，其后的8是窗体的上、下边框的高度和
	var left=(screenWidth-205-17-width)/2+205+17  //加上205+17是因为前面算出来的只是第三帧的起始点
	var top=(screenHeight-74-20-21-height-20-8)/2+74+20  //加上74+20是因为前面算出来的只是第三帧的起始点

	//当所需打开的窗体的宽度或高度高出第三帧（内容页面）的宽度或高度的话，起始点以整个屏幕居中
	if(width>(screenWidth-205-17-8))
	    left=(screenWidth-width)/2
		if(height>(screenHeight-74-20-21-20-8))
		    top=(screenHeight-height)/2-10

			//当所需打开的窗体的宽度或高度高出显示的分辩率的宽度或高度的话，就置起始点为零
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
 *  6.3 在屏幕中进行居中弹出模态窗口
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
 *  6.4 在main框架中进行居中弹出模态窗口
 *
 *
 */
function winOpenOnMain_M(hrefStr,winName,width,height)
{
    var screenWidth=screen.availWidth
	var screenHeight=screen.availHeight
	//205是菜单栏的宽度，其后的17是垂直滚动条的宽度
	//74是标题栏的高度，其后的20是窗体标题栏（顶端的蓝条）高度，最后的21是状态栏的高度
	//height后面的20是所需打开的窗口的标题栏（顶端的蓝条）高度，其后的8是窗体的上、下边框的高度和
	var left=(screenWidth-205-17-width)/2+205+17  //加上205+17是因为前面算出来的只是第三帧的起始点
	var top=(screenHeight-74-20-21-height-20-8)/2+74+20  //加上74+20是因为前面算出来的只是第三帧的起始点

	//当所需打开的窗体的宽度或高度高出第三帧（内容页面）的宽度或高度的话，起始点以整个屏幕居中
	if(width>(screenWidth-205-17-8))
	    left=(screenWidth-width)/2
		if(height>(screenHeight-74-20-21-20-8))
		    top=(screenHeight-height)/2-10

			//当所需打开的窗体的宽度或高度高出显示的分辩率的宽度或高度的话，就置起始点为零
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
//时间函数
function chkTime(ob)
{
    var dd=_getTime(ob.value)
	if(dd=="")
	{
	    alert("时间错误!")
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
//取时间
function _getTime(dateStr)
{
    var len=dateStr.length
	var hh//小时
	var mm//分钟
	var ss//秒
	if(dateStr.length==0)
	{
	    return "blank"
	}
	else  if(len==8 )//有冒号
	{
	    hh=dateStr.substring(0,2)
		mm=dateStr.substring(3,5)
		ss=dateStr.substring(6)
	}
	else if(len==6)//无冒号
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
//检查是否是正整数&&是否小于max
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
 *  功能：对FORM进行提交操作
 *  作用：避免由于用户操作引起的连续提交问题
 *  参数：m_form -- 提交的FORM名
 *  返回值：无
 *  作者：施毅
 *  时间：2003/07/21
 */
var _is_submit = 0  //信号灯变量（本页面内公用），页面刷新后自动恢复

function form_submit(m_form)
{
    //如果页面正在提交，则返回
    if (_is_submit==1)
	return

	    //改变信号灯变量
	    _is_submit = 1

	    //执行提交页面操作
	    eval("document." + m_form + ".submit()")
}

/**
 *  6.7 在屏幕右下角模态弹出隐藏望远镜窗口
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
   函数名：_DataCtrlOnFocus(tr_str, rowno)

   功能：恢复前一数据行的底色；设置当前数据行的底色

   背景：在数据行各控件的onfocus()，onkeypress()事件中调用

   参数：
   tr_str -- 页面列表中，各tr的id的前缀组合字符串，各前缀间以逗号分隔
   rowno  -- 当前行号

   实例：
   假定页面数据行中由三个table组成，行前缀分别为：tr0，tr1，tr2
   当前行为5

   调用如下：_DataCtrlOnFocus("tr0,tr1,tr2","5")
 */
function _DataCtrlOnFocus(tr_str, rowno)
{
    //如果当前行号等于前一行号，则退出本函数
    if (rowno == _LastRowNo)
	return

	    //记录下各tr的id前缀
	    var m_tr = tr_str.split(",")

	    //恢复前一行的底色
	    if (_LastRowNo != "XXX")
	    {
		for (var i=0; i<m_tr.length; i++)
		    eval(_trim(m_tr[i]) + _LastRowNo + ".className = " + eval("document.rs10_form_d.cur_color" + _LastRowNo + ".value"))
	    }

    //设置当前行底色
    for (var i=0; i<m_tr.length; i++)
	eval(_trim(m_tr[i]) + rowno + ".className = '" + activeLineClass + "'")

	    //设置前一行号
	    _LastRowNo = rowno
}

/*
   函数名：_DataCtrlOnChange(rowno)

   功能：修改数据列表中修改标记、当前颜色隐藏控件的值

   背景：数据列表中，各控件onchange事件、望远镜取值与原值不同时调用

   参数：rowno -- 当前行号

   实例：假定修改的控件所在行为5
   调用如下：_DataCtrlOnChange("5")
 */

//页面数据列表中有控件值被修改
var _dirty = false

function _DataCtrlOnChange(rowno)
{
    eval("document.rs10_form_d.modifyFlag" + rowno + ".value = 'Y'")
	eval("document.rs10_form_d.cur_color" + rowno + ".value = 'updateLineClass'")
	_dirty = true
}

/*
   函数名：_form_submit(cmd_name, is_confirm, judge_dirty, divid_str)

   功能：判断数据列表是否被更改，获取各div滚动条位置，提交页面

   背景：数据列表的页面，提交页面时调用

   参数：
   cmd_name    -- 命令的中文名
   is_confirm  -- 是否需要用户确认后才提交 Y:需要 N:不需要
   judge_dirty -- 是否需要判断数据列表有无改变 Y:需要 N:不需要
   divid_str   -- 各div的id的组合字符串，由逗号分隔

   实例：
   假定该页面是数据列表页面，有两个div，id分别为div0、div1
   查询调用：_form_submit("查询", "N", "Y", "div0,div1")
   新增调用：_form_submit("新增", "N", "Y", "div0,div1")
   删除调用：_form_submit("删除", "Y", "Y", "div0,div1")
   更新调用：_form_submit("更新", "Y", "N", "div0,div1")
   翻页调用：_form_submit("翻页", "N", "Y", "div0,div1")
   排序调用：_form_submit("排序", "N", "Y", "div0,div1")

   注：对于没有div的页面，参数divid_str赋空串""
 */
function _form_submit(cmd_name, is_confirm, judge_dirty, divid_str)
{
    if (judge_dirty == "Y")
    {
	if (_dirty)
	{
	    if (confirm("是否保存对数据的修改?\n\n确定:放弃" + cmd_name + "操作," +
			"等待用户保存修改；\n取消:放弃对数据的修改,继续" + cmd_name + "操作。"))
		return
	}
    }

    if (is_confirm == "Y")
    {
	if (!confirm("确定" + cmd_name + "吗?"))
	    return
    }

    //获取各div的id，读取各div滚动条当前位置
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

    //提交页面
    form_submit("rs10_form_d")
}

/*
   程序名：_resume_div_scrollbar()

   功能：恢复各div滚动条位置的函数

   背景：对于有数据列表div的页面，直接调用

   参数：无

   实例：假定该页面是数据列表型页面
   调用如下：_resume_div_scrollbar()
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
			alert("div与位置值个数不一致，请程序员修改!")
			    return
		    }

    for (var i=0; i<m_div.length; i++)
	eval(m_div[i] + ".scrollLeft=" + m_left[i])
}

/*
   程序名：_save_screen_value(max_row, max_col, prefix)

   功能：保存数据列表中各控件的初值，为更新重置做准备。

   背景：维护型数据列表页面刷新后，直接调用；
   如果页面存在自动赋值的情况，应在赋值后调用本函数，保证记录下来的是所想要的初值。

   参数：
   max_row -- 最大行号
   max_col -- 最大列号
   prefix  -- 控件id的前缀
 */

var _screen_value = ""
var _old_cur_color = ""

function _save_screen_value(max_row, max_col, prefix)
{
    //保存数据控件的原值
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

    //保存当前颜色原值
    for (var i=0; i<parseInt(max_row); i++)
    {
	if (i == 0)
	    _old_cur_color = eval("document.rs10_form_d.cur_color" + i + ".value")
	else
	    _old_cur_color+= "," + eval("document.rs10_form_d.cur_color" + i + ".value")
    }
}

/*
   程序名：_update_reset(max_row, max_col, prefix, trid_str, ctr_name, if_select)

   功能：修改重置

   背景：修改重置时直接调用

   参数：
   max_row   -- 最大行号
   max_col   -- 最大列号
   prefix    -- 控件id的前缀
   trid_str  -- tr的id前缀字符串组合，用逗号分隔
   ctr_name  -- 重置后，设置焦点的控件name，带form名的
   if_select -- 设置焦点后，是否选中。 Y--选中；N--不选中

   实例：_update_reset("5", "3", "move", "tr0,tr1,tr2", "rs10_form_d.item_code", "Y")
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

    if (!confirm("确定放弃对数据的修改吗?"))
    {
	if (checkSpace(ctr_name))
	{
	    eval("document." + ctr_name + ".focus()")

		if (if_select == "Y")
		    eval("document." + ctr_name + ".select()")
	}

	return
    }

    //恢复原值
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

    //恢复行修改标记、当前行颜色、行底色
    var m_cur_color = _old_cur_color.split(",")
	var m_trid = trid_str.split(",")

	for (var i=0; i<m_cur_color.length; i++)
	{
	    eval("document.rs10_form_d.modifyFlag" + i + ".value = 'N'")
		eval("document.rs10_form_d.cur_color" + i + ".value = '" + m_cur_color[i] + "'")

		for (var j=0; j<m_trid.length; j++)
		    eval(m_trid[j] + i + ".className = " + m_cur_color[i])
	}

    //修改修改标记
    _dirty = false

	if (checkSpace(ctr_name))
	{
	    eval("document." + ctr_name + ".focus()")

		if (if_select == "Y")
		    eval("document." + ctr_name + ".select()")
	}
}

/*
   程序名：_set_err_color(trid_str, rowno)

   功能：设置tr的颜色

   参数：
   trid_str -- tr的id组合字符串，用逗号分隔
   rowno    -- 行号
 */
function _set_err_color(trid_str, rowno)
{
    eval("document.rs10_form_d.cur_color" + rowno + ".value = 'updateLineClass'")
    eval("document.rs10_form_d.modifyFlag" + rowno + ".value = 'Y'")

	var m_tr = trid_str.split(",")

	for (var i=0; i<m_tr.length; i++)
	    eval(m_tr[i] + rowno + ".className = '" + updateLineClass + "'")

}
//童冬雷添加
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
//row 行号,　col 列号, rowmax最大行号,colmax 最大列号 ,prefix控件id前缀
//控件命名是必须如下格式 prefix+row+"_"+col
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
	if(moveFlag==true)//移动状态
	{
	    if(event.keyCode == 13)//enter
	    {

		if(rowToCol==false)//换行
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
		else//换列
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
//童冬雷添加结束
