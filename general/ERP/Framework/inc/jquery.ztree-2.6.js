/*
 * JQuery zTree 2.6
 * http://code.google.com/p/jquerytree/
 *
 * Copyright (c) 2010 Hunter.z (baby666.cn)
 *
 * Licensed same as jquery - under the terms of either the MIT License or the GPL Version 2 License
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * email: hunter.z@263.net
 * Date: 2011-06-01
 */

(function($) {

	var ZTREE_NODECREATED = "ZTREE_NODECREATED";
	var ZTREE_CLICK = "ZTREE_CLICK";
	var ZTREE_CHANGE = "ZTREE_CHANGE";
	var ZTREE_RENAME = "ZTREE_RENAME";
	var ZTREE_REMOVE = "ZTREE_REMOVE";
	var ZTREE_DRAG = "ZTREE_DRAG";
	var ZTREE_DROP = "ZTREE_DROP";
	var ZTREE_EXPAND = "ZTREE_EXPAND";
	var ZTREE_COLLAPSE = "ZTREE_COLLAPSE";
	var ZTREE_ASYNC_SUCCESS = "ZTREE_ASYNC_SUCCESS";
	var ZTREE_ASYNC_ERROR = "ZTREE_ASYNC_ERROR";

	var IDMark_Switch = "_switch";
	var IDMark_Icon = "_ico";
	var IDMark_Span = "_span";
	var IDMark_Input = "_input";
	var IDMark_Check = "_check";
	var IDMark_Edit = "_edit";
	var IDMark_Remove = "_remove";
	var IDMark_Ul = "_ul";
	var IDMark_A = "_a";

	var LineMark_Root = "root";
	var LineMark_Roots = "roots";
	var LineMark_Center = "center";
	var LineMark_Bottom = "bottom";
	var LineMark_NoLine = "noLine";
	var LineMark_Line = "line";

	var FolderMark_Open = "open";
	var FolderMark_Close = "close";
	var FolderMark_Docu = "docu";

	var Class_CurSelectedNode = "curSelectedNode";
	var Class_CurSelectedNode_Edit = "curSelectedNode_Edit";
	var Class_TmpTargetTree = "tmpTargetTree";
	var Class_TmpTargetNode = "tmpTargetNode";
	
	var Check_Style_Box = "checkbox";
	var Check_Style_Radio = "radio";
	var CheckBox_Default = "chk";
	var CheckBox_False = "false";
	var CheckBox_True = "true";
	var CheckBox_Full = "full";
	var CheckBox_Part = "part";
	var CheckBox_Focus = "focus";
	var Radio_Type_All = "all";
	var Radio_Type_Level = "level";
	
	var MoveType_Inner = "inner";
	var MoveType_Before = "before";
	var MoveType_After = "after";
	var MinMoveSize = "5";

	var settings = new Array();
	var zTreeId = 0;
	var zTreeNodeCache = [];

	//zTree���캯��
	$.fn.zTree = function(zTreeSetting, zTreeNodes) {

		var setting = {
			//Tree Ψһ��ʶ����UL��ID
			treeObjId: "",
			treeObj: null,
			//�Ƿ���ʾCheckBox
			checkable: false,
			//�Ƿ��ڱ༭״̬
			editable: false,
			//�༭״̬�Ƿ���ʾ�޸İ�ť
			edit_renameBtn:true,
			//�༭״̬�Ƿ���ʾɾ���ڵ㰴ť
			edit_removeBtn:true,
			//�Ƿ���ʾ������
			showLine: true,
			//�Ƿ���ʾͼ��
			showIcon: true,
			//�Ƿ��������ڵ�״̬
			keepParent: false,
			//�Ƿ�����Ҷ�ӽڵ�״̬
			keepLeaf: false,
			//��ǰ��ѡ���TreeNode
			curTreeNode: null,
			//��ǰ�����༭��TreeNode
			curEditTreeNode: null,
			//�Ƿ�����ק�ڼ� 0: not Drag; 1: doing Drag
			dragStatus: 0,
			dragNodeShowBefore: false,
			//��ק�������� move or copy
			dragCopy: false,
			dragMove: true,
			//ѡ��CheckBox �� Radio
			checkStyle: Check_Style_Box,
			//checkBox�����Ӱ�츸�ӽڵ����ã�checkStyle=Check_Style_Radioʱ��Ч�� 			
			checkType: {
				"Y": "ps",
				"N": "ps"
			},
			//radio �������������ͣ�ÿһ���ڵ����� �� ����Tree��ȫ���ڵ����ƣ�checkStyle=Check_Style_Boxʱ��Ч��
			checkRadioType:Radio_Type_Level,
			//checkRadioType = Radio_Type_All ʱ�����汻ѡ��ڵ�Ķ�ջ
			checkRadioCheckedList:[],
			//�Ƿ��첽��ȡ�ڵ�����
			async: false,
			//��ȡ�ڵ����ݵ�URL��ַ
			asyncUrl: "",
			//��ȡ�ڵ�����ʱ��������������ƣ����磺id��name
			asyncParam: [],
			//��������
			asyncParamOther: [],
			//�첽���ػ�ȡ���ݣ�������ݽ���Ԥ����ĺ���
			asyncDataFilter: null,
			//��Array����ת��ΪJSONǶ�����ݲ���
			isSimpleData: false,
			treeNodeKey: "",
			treeNodeParentKey: "",
			rootPID: null,
			//�û��Զ���������
			nameCol: "name",
			//�û��Զ����ӽڵ���
			nodesCol: "nodes", 
			//�û��Զ���checked��
			checkedCol: "checked", 
			//�۵���չ����Ч�ٶ�
			expandSpeed: "fast",
			//�۵���չ��Trigger����
			expandTriggerFlag:false,
			//hover ���Ӱ�ť�ӿ�
			addHoverDom:null,
			//hover ɾ����ť�ӿ�
			removeHoverDom:null,
			//�����Զ�����ʾ�ؼ�����
			addDiyDom:null,
			//������Ի���ʽ�ӿ�
			fontCss:{},
			
			root: {
				isRoot: true,
				nodes: []
			},
			//event Function
			callback: {
				beforeAsync:null,
				beforeClick:null,
				beforeRightClick:null,
				beforeMouseDown:null,
				beforeMouseUp:null,
				beforeChange:null,
				beforeDrag:null,
				beforeDrop:null,
				beforeRename:null,
				beforeRemove:null,
				beforeExpand:null,
				beforeCollapse:null,
				confirmDragOpen:null,
				confirmRename:null,
				
				nodeCreated:null,
				click:null,
				rightClick:null,
				mouseDown:null,
				mouseUp:null,
				change:null,
				drag:null,
				drop:null,
				rename:null,
				remove:null,
				expand:null,
				collapse:null,
				asyncConfirmData:null,
				asyncSuccess:null,
				asyncError:null
			}			
		};

		if (zTreeSetting) {
			var tmp_checkType = zTreeSetting.checkType;
			zTreeSetting.checkType = undefined;
			var tmp_callback = zTreeSetting.callback;
			zTreeSetting.callback = undefined;
			var tmp_root = zTreeSetting.root;
			zTreeSetting.root = undefined;
			
			$.extend(setting, zTreeSetting);
			
			zTreeSetting.checkType = tmp_checkType;				
			$.extend(true, setting.checkType, tmp_checkType);
			zTreeSetting.callback = tmp_callback;				
			$.extend(setting.callback, tmp_callback);
			zTreeSetting.root = tmp_root;				
			$.extend(setting.root, tmp_root);
		}

		setting.treeObjId = this.attr("id");
		setting.treeObj = this;
		setting.root.tId = -1;
		setting.root.name = "ZTREE ROOT";
		setting.root.isRoot = true;
		setting.checkRadioCheckedList = [];
		setting.curTreeNode = null;
		setting.curEditTreeNode = null;
		setting.dragNodeShowBefore = false;
		setting.dragStatus = 0;
		setting.expandTriggerFlag = false;
		if (!setting.root[setting.nodesCol]) setting.root[setting.nodesCol]= [];

		if (zTreeNodes) {
			setting.root[setting.nodesCol] = zTreeNodes;
		}
		if (setting.isSimpleData) {
			setting.root[setting.nodesCol] = transformTozTreeFormat(setting, setting.root[setting.nodesCol]);
		}
		settings[setting.treeObjId] = setting;

		setting.treeObj.empty();
		zTreeNodeCache[setting.treeObjId] = [];
		bindTreeNodes(setting, this);
		if (setting.root[setting.nodesCol] && setting.root[setting.nodesCol].length > 0) {
			initTreeNodes(setting, 0, setting.root[setting.nodesCol]);
		} else if (setting.async && setting.asyncUrl && setting.asyncUrl.length > 0) {
			asyncGetNode(setting);
		}
		
		return new zTreePlugin().init(this);
	};

	//���¼�
	function bindTreeNodes(setting, treeObj) {
		var eventParam = {treeObjId: setting.treeObjId};
		setting.treeObj.unbind('click', eventProxy);
		setting.treeObj.bind('click', eventParam, eventProxy);
		setting.treeObj.unbind('dblclick', eventProxy);
		setting.treeObj.bind('dblclick', eventParam, eventProxy);
		setting.treeObj.unbind('mouseover', eventProxy);
		setting.treeObj.bind('mouseover', eventParam, eventProxy);
		setting.treeObj.unbind('mouseout', eventProxy);
		setting.treeObj.bind('mouseout', eventParam, eventProxy);
		setting.treeObj.unbind('mousedown', eventProxy);
		setting.treeObj.bind('mousedown', eventParam, eventProxy);
		setting.treeObj.unbind('mouseup', eventProxy);
		setting.treeObj.bind('mouseup', eventParam, eventProxy);
		setting.treeObj.unbind('contextmenu', eventProxy);
		setting.treeObj.bind('contextmenu', eventParam, eventProxy);

		treeObj.unbind(ZTREE_NODECREATED);		
		treeObj.bind(ZTREE_NODECREATED, function (event, treeId, treeNode) {
			tools.apply(setting.callback.nodeCreated, [event, treeId, treeNode]);
		});

		treeObj.unbind(ZTREE_CLICK);		
		treeObj.bind(ZTREE_CLICK, function (event, treeId, treeNode) {
			tools.apply(setting.callback.click, [event, treeId, treeNode]);
		});

		treeObj.unbind(ZTREE_CHANGE);
		treeObj.bind(ZTREE_CHANGE, function (event, treeId, treeNode) {
			tools.apply(setting.callback.change, [event, treeId, treeNode]);
		});

		treeObj.unbind(ZTREE_RENAME);
		treeObj.bind(ZTREE_RENAME, function (event, treeId, treeNode) {
			tools.apply(setting.callback.rename, [event, treeId, treeNode]);
		});
		
		treeObj.unbind(ZTREE_REMOVE);
		treeObj.bind(ZTREE_REMOVE, function (event, treeId, treeNode) {
			tools.apply(setting.callback.remove, [event, treeId, treeNode]);
		});

		treeObj.unbind(ZTREE_DRAG);
		treeObj.bind(ZTREE_DRAG, function (event, treeId, treeNode) {
			tools.apply(setting.callback.drag, [event, treeId, treeNode]);
		});

		treeObj.unbind(ZTREE_DROP);
		treeObj.bind(ZTREE_DROP, function (event, treeId, treeNode, targetNode, moveType) {
			tools.apply(setting.callback.drop, [event, treeId, treeNode, targetNode, moveType]);
		});

		treeObj.unbind(ZTREE_EXPAND);
		treeObj.bind(ZTREE_EXPAND, function (event, treeId, treeNode) {
			tools.apply(setting.callback.expand, [event, treeId, treeNode]);
		});

		treeObj.unbind(ZTREE_COLLAPSE);
		treeObj.bind(ZTREE_COLLAPSE, function (event, treeId, treeNode) {
			tools.apply(setting.callback.collapse, [event, treeId, treeNode]);
		});

		treeObj.unbind(ZTREE_ASYNC_SUCCESS);
		treeObj.bind(ZTREE_ASYNC_SUCCESS, function (event, treeId, treeNode, msg) {
			tools.apply(setting.callback.asyncSuccess, [event, treeId, treeNode, msg]);
		});

		treeObj.unbind(ZTREE_ASYNC_ERROR);
		treeObj.bind(ZTREE_ASYNC_ERROR, function (event, treeId, treeNode, XMLHttpRequest, textStatus, errorThrown) {
			tools.apply(setting.callback.asyncError, [event, treeId, treeNode, XMLHttpRequest, textStatus, errorThrown]);
		});
	}
	
	//��ʼ������ʾ�ڵ�Json����
	function initTreeNodes(setting, level, treeNodes, parentNode) {
		if (!treeNodes) return;

		var zTreeHtml = appendTreeNodes(setting, level, treeNodes, parentNode);
		if (!parentNode) {
			setting.treeObj.append(zTreeHtml.join(''));
		} else {
			$("#" + parentNode.tId + IDMark_Ul).append(zTreeHtml.join(''));
		}
		repairParentChkClassWithSelf(setting, parentNode);
		createCallback(setting, treeNodes);
	}

	function createCallback(setting, treeNodes) {
		for (var i = 0, l = treeNodes.length; i < l; i++) {
			var node = treeNodes[i];
			tools.apply(setting.addDiyDom, [setting.treeObjId, node]);
			//����nodeCreated�¼�
			setting.treeObj.trigger(ZTREE_NODECREATED, [setting.treeObjId, node]);
			if (node[setting.nodesCol] && node[setting.nodesCol].length > 0) {
				createCallback(setting, node[setting.nodesCol], node);
			}
		}
	}

	function appendTreeNodes(setting, level, treeNodes, parentNode) {
		if (!treeNodes) return [];
		var html = [];
		for (var i = 0, l = treeNodes.length; i < l; i++) {
			var node = treeNodes[i];
			node.level = level;
			node.tId = setting.treeObjId + "_" + (++zTreeId);
			node.parentNode = parentNode;
			node[setting.checkedCol] = !!node[setting.checkedCol];
			node.checkedOld = node[setting.checkedCol];
			node.check_Focus = false;
			node.check_True_Full = true;
			node.check_False_Full = true;
			node.editNameStatus = false;
			node.isAjaxing = null;
			addCache(setting, node);
			fixParentKeyValue(setting, node);

			var tmpParentNode = (parentNode) ? parentNode: setting.root;
			//�����ڷǿսڵ������ӽڵ�
			node.isFirstNode = (tmpParentNode[setting.nodesCol].length == treeNodes.length) && (i == 0);
			node.isLastNode = (i == (treeNodes.length - 1));

			if (node[setting.nodesCol] && node[setting.nodesCol].length > 0) {
				node.open = (node.open) ? true: false;
				node.isParent = true;
			} else {
				node.isParent = (node.isParent) ? true: false;
			}
            
			var url = makeNodeUrl(setting, node);
			var fontcss = makeNodeFontCss(setting, node);
			var fontStyle = [];
			for (var f in fontcss) {
				fontStyle.push(f, ":", fontcss[f], ";");
			}
			
			var childHtml = [];
			if (node[setting.nodesCol] && node[setting.nodesCol].length > 0) {
				childHtml = appendTreeNodes(setting, level + 1, node[setting.nodesCol], node);
			}
			html.push("<li id='", node.tId, "' treenode>",
				"<button type='button' id='", node.tId, IDMark_Switch,
				"' title='' class='", makeNodeLineClass(setting, node), "' treeNode", IDMark_Switch," onfocus='this.blur();'></button>");
			if (setting.checkable) {
				makeChkFlag(setting, node);
				if (setting.checkStyle == Check_Style_Radio && setting.checkRadioType == Radio_Type_All && node[setting.checkedCol] ) {
					setting.checkRadioCheckedList = setting.checkRadioCheckedList.concat([node]);
				}
				html.push("<button type='button' ID='", node.tId, IDMark_Check, "' class='", makeChkClass(setting, node), "' treeNode", IDMark_Check," onfocus='this.blur();' ",(node.nocheck === true?"style='display:none;'":""),"></button>");
			}
			html.push("<a id='", node.tId, IDMark_A, "' treeNode", IDMark_A," onclick=\"", (node.click || ''),
				"\" ", ((url != null && url.length > 0) ? "href='" + url + "'" : ""), " target='",makeNodeTarget(node),"' style='", fontStyle.join(''), 
				"'><button type='button' id='", node.tId, IDMark_Icon,
				"' title='' treeNode", IDMark_Icon," onfocus='this.blur();' class='", makeNodeIcoClass(setting, node), "' style='", makeNodeIcoStyle(setting, node), "'></button><span id='", node.tId, IDMark_Span,
				"'>",node[setting.nameCol].replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'),"</span></a><ul id='", node.tId, IDMark_Ul, "' class='", makeUlLineClass(setting, node), "' style='display:", (node.open ? "block": "none"),"'>");
			html.push(childHtml.join(''));
			html.push("</ul></li>");
		}
		return html;
	}

	function eventProxy(event) {
		var target = event.target;
		var relatedTarget = event.relatedTarget;
		var setting = settings[event.data.treeObjId];
		var tId = "";
		var childEventType = "", mainEventType = "";
		var tmp = null;

		if (tools.eqs(event.type, "mouseover")) {
			if (setting.checkable && tools.eqs(target.tagName, "button") && target.getAttribute("treeNode"+IDMark_Check) !== null) {
				tId = target.parentNode.id;
				childEventType = "mouseoverCheck";
			} else {
				tmp = tools.getMDom(setting, target, [{tagName:"a", attrName:"treeNode"+IDMark_A}]);
				if (tmp) {
					tId = tmp.parentNode.id;
					childEventType = "hoverOverNode";
				}
			}
		} else if (tools.eqs(event.type, "mouseout")) {
			if (setting.checkable && tools.eqs(target.tagName, "button") && target.getAttribute("treeNode"+IDMark_Check) !== null) {
				tId = target.parentNode.id;
				childEventType = "mouseoutCheck";
			} else {
				tmp = tools.getMDom(setting, relatedTarget, [{tagName:"a", attrName:"treeNode"+IDMark_A}]);
				if (!tmp) {
					tId = "remove";
					childEventType = "hoverOutNode";
				}
			}
		} else if (tools.eqs(event.type, "mousedown")) {
			mainEventType = "mousedown";
			tmp = tools.getMDom(setting, target, [{tagName:"a", attrName:"treeNode"+IDMark_A}]);
			if (tmp) {
				tId = tmp.parentNode.id;
				childEventType = "mousedownNode";
			}
		} else if (tools.eqs(event.type, "mouseup")) {
			mainEventType = "mouseup";
			tmp = tools.getMDom(setting, target, [{tagName:"a", attrName:"treeNode"+IDMark_A}]);
			if (tmp) {tId = tmp.parentNode.id;}
		} else if (tools.eqs(event.type, "contextmenu")) {
			mainEventType = "contextmenu";
			tmp = tools.getMDom(setting, target, [{tagName:"a", attrName:"treeNode"+IDMark_A}]);
			if (tmp) {tId = tmp.parentNode.id;}
		} else if (tools.eqs(event.type, "click")) {
			if (tools.eqs(target.tagName, "button") && target.getAttribute("treeNode"+IDMark_Switch) !== null) {
				tId = target.parentNode.id;
				childEventType = "switchNode";
			} else if (setting.checkable && tools.eqs(target.tagName, "button") && target.getAttribute("treeNode"+IDMark_Check) !== null) {
				tId = target.parentNode.id;
				childEventType = "checkNode";
			} else {
				tmp = tools.getMDom(setting, target, [{tagName:"a", attrName:"treeNode"+IDMark_A}]);
				if (tmp) {
					tId = tmp.parentNode.id;
					childEventType = "clickNode";
				}
			}
		} else if (tools.eqs(event.type, "dblclick")) {
			mainEventType = "dblclick";
			tmp = tools.getMDom(setting, target, [{tagName:"a", attrName:"treeNode"+IDMark_A}]);
			if (tmp) {
				tId = tmp.parentNode.id;
				childEventType = "switchNode";
			}
		}

		if (tId.length>0 || mainEventType.length>0) {
			if (childEventType!="hoverOverNode" && childEventType != "hoverOutNode"
				&& childEventType!="mouseoverCheck" && childEventType != "mouseoutCheck"
				&& target.getAttribute("treeNode"+IDMark_Input) === null
				&& !st.checkEvent(setting)) return false;
		}
		if (tId.length>0) {
			//	�༭��Text״̬�� ����ѡ���ı�
			if (!(setting.curTreeNode && setting.curTreeNode.editNameStatus)) {
				tools.noSel();
			}
			event.data.treeNode = getTreeNodeByTId(setting, tId);
			switch (childEventType) {
				case "switchNode" :
					handler.onSwitchNode(event);
					break;
				case "clickNode" :
					handler.onClickNode(event);
					break;
				case "checkNode" :
					handler.onCheckNode(event);
					break;
				case "mouseoverCheck" :
					handler.onMouseoverCheck(event);
					break;
				case "mouseoutCheck" :
					handler.onMouseoutCheck(event);
					break;
				case "mousedownNode" :
					handler.onMousedownNode(event);
					break;
				case "hoverOverNode" :
					handler.onHoverOverNode(event);
					break;
				case "hoverOutNode" :
					handler.onHoverOutNode(event);
					break;
			}
		} else {
			event.data.treeNode = null;
		}
		switch (mainEventType) {
			case "mousedown" :
				return handler.onZTreeMousedown(event);
				break;
			case "mouseup" :
				return handler.onZTreeMouseup(event);
				break;
			case "dblclick" :
				return handler.onZTreeDblclick(event);
				break;
			case "contextmenu" :
				return handler.onZTreeContextmenu(event);
				break;
		}
	}

	var tools = {
		eqs: function(str1, str2) {
			return str1.toLowerCase() === str2.toLowerCase();
		},
		isArray: function(arr) {
			return Object.prototype.toString.apply(arr) === "[object Array]";
		},
		noSel: function() {
			//����Ĭ���¼�����ֹ�ı���ѡ��
			window.getSelection ? window.getSelection().removeAllRanges() : setTimeout(function(){document.selection.empty();}, 10);
		},
		inputFocus: function(inputObj) {
			if (inputObj.get(0)) {
				inputObj.focus();
				setCursorPosition(inputObj.get(0), inputObj.val().length);
			}
		},
		apply: function(fun, param, defaultValue) {
			if ((typeof fun) == "function") {
				return fun.apply(tools, param);
			}
			return defaultValue;
		},
		getAbs: function (obj) {
			//��ȡ����ľ�������
			oRect = obj.getBoundingClientRect();
			return [oRect.left,oRect.top]
		},
		getMDom: function (setting, curDom, targetExpr) {
			if (!curDom) return null;
			while (curDom && curDom.id !== setting.treeObjId) {
				for (var i=0, l=targetExpr.length; curDom.tagName && i<l; i++) {
					if (tools.eqs(curDom.tagName, targetExpr[i].tagName) && curDom.getAttribute(targetExpr[i].attrName) !== null) {
						return curDom;
					}
				}
				curDom = curDom.parentNode;
			}
			return null;
		},
		clone: function (jsonObj) {
			var buf;
			if (jsonObj instanceof Array) {
				buf = [];
				var i = jsonObj.length;
				while (i--) {
					buf[i] = arguments.callee(jsonObj[i]);
				}
				return buf;
			}else if (typeof jsonObj == "function"){
				return jsonObj;
			}else if (jsonObj instanceof Object){
				buf = {};
				for (var k in jsonObj) {
					if (k!="parentNode") {
						buf[k] = arguments.callee(jsonObj[k]);
					}
				}
				return buf;
			}else{
				return jsonObj;
			}
		}
	};

	var st = {
		checkEvent: function(setting) {
			return st.checkCancelPreEditNode(setting);
		},
		//ȡ��֮ǰѡ�нڵ�״̬
		cancelPreSelectedNode: function (setting) {
			if (setting.curTreeNode) {
				$("#" + setting.curTreeNode.tId + IDMark_A).removeClass(Class_CurSelectedNode);
				setNodeName(setting, setting.curTreeNode);
				removeTreeDom(setting, setting.curTreeNode);
				setting.curTreeNode = null;
			}
		},
		//У��ȡ��֮ǰ�༭�ڵ�״̬
		checkCancelPreEditNode: function (setting) {
			if (setting.curEditTreeNode) {
				var inputObj = setting.curEditInput;
				if ( tools.apply(setting.callback.confirmRename, [setting.treeObjId, setting.curEditTreeNode, inputObj.val()], true) === false) {
					setting.curEditTreeNode.editNameStatus = true;
					tools.inputFocus(inputObj);
					return false;
				}
			}
			return true;
		},
		//ȡ��֮ǰ�༭�ڵ�״̬
		cancelPreEditNode: function (setting, newName) {
			if (setting.curEditTreeNode) {
				var inputObj = $("#" + setting.curEditTreeNode.tId + IDMark_Input);
				setting.curEditTreeNode[setting.nameCol] = newName ? newName:inputObj.val();
				//����rename�¼�
				setting.treeObj.trigger(ZTREE_RENAME, [setting.treeObjId, setting.curEditTreeNode]);

				$("#" + setting.curEditTreeNode.tId + IDMark_A).removeClass(Class_CurSelectedNode_Edit);
				inputObj.unbind();
				setNodeName(setting, setting.curEditTreeNode);
				setting.curEditTreeNode.editNameStatus = false;
				setting.curEditTreeNode = null;
				setting.curEditInput = null;
			}
			return true;
		}
	}

	var handler = {
		//���չ�����۵��ڵ�
		onSwitchNode: function (event) {
			var setting = settings[event.data.treeObjId];
			var treeNode = event.data.treeNode;

			if (treeNode.open) {
				if (tools.apply(setting.callback.beforeCollapse, [setting.treeObjId, treeNode], true) == false) return;
				setting.expandTriggerFlag = true;
				switchNode(setting, treeNode);
			} else {
				if (tools.apply(setting.callback.beforeExpand, [setting.treeObjId, treeNode], true) == false) return;
				setting.expandTriggerFlag = true;
				switchNode(setting, treeNode);
			}
		},
		onClickNode: function (event) {
			var setting = settings[event.data.treeObjId];
			var treeNode = event.data.treeNode;
			if (tools.apply(setting.callback.beforeClick, [setting.treeObjId, treeNode], true) == false) return;
			//���ýڵ�Ϊѡ��״̬
			selectNode(setting, treeNode);
			//����click�¼�
			setting.treeObj.trigger(ZTREE_CLICK, [setting.treeObjId, treeNode]);
		},
		onCheckNode: function (event) {
			var setting = settings[event.data.treeObjId];
			var treeNode = event.data.treeNode;
			if (tools.apply(setting.callback.beforeChange, [setting.treeObjId, treeNode], true) == false) return;

			treeNode[setting.checkedCol] = !treeNode[setting.checkedCol];
			checkNodeRelation(setting, treeNode);

			var checkObj = $("#" + treeNode.tId + IDMark_Check);
			setChkClass(setting, checkObj, treeNode);
			repairParentChkClassWithSelf(setting, treeNode);

			//���� CheckBox ����¼�
			setting.treeObj.trigger(ZTREE_CHANGE, [setting.treeObjId, treeNode]);
		},
		onMouseoverCheck: function(event) {
			var setting = settings[event.data.treeObjId];
			var treeNode = event.data.treeNode;
			var checkObj = $("#" + treeNode.tId + IDMark_Check);
			treeNode.checkboxFocus = true;
			setChkClass(setting, checkObj, treeNode);			
		},
		onMouseoutCheck: function(event) {
			var setting = settings[event.data.treeObjId];
			var treeNode = event.data.treeNode;
			var checkObj = $("#" + treeNode.tId + IDMark_Check);
			treeNode.checkboxFocus = false;
			setChkClass(setting, checkObj, treeNode);
		},
		onMousedownNode: function(eventMouseDown) {
			var setting = settings[eventMouseDown.data.treeObjId];
			var treeNode = eventMouseDown.data.treeNode;
			//�Ҽ���������ק���� ������ק
			if (eventMouseDown.button == 2 || !setting.editable || (!setting.dragCopy && !setting.dragMove)) return;
			//�༭������ڲ�����ק�ڵ�
			var target = eventMouseDown.target;
			if (treeNode.editNameStatus && tools.eqs(target.tagName, "input") && target.getAttribute("treeNode"+IDMark_Input) !== null) {
				return;
			}

			var doc = document;
			var curNode;
			var tmpArrow;
			var tmpTarget;
			var isOtherTree = false;
			var targetSetting = setting;
			var preTmpTargetNodeId = null;
			var preTmpMoveType = null;
			var tmpTargetNodeId = null;
			var moveType = MoveType_Inner;
			var mouseDownX = eventMouseDown.clientX;
			var mouseDownY = eventMouseDown.clientY;
			var startTime = (new Date()).getTime();

			$(doc).mousemove(function(event) {
				tools.noSel();

				//�����������������ڵ�һ���ƶ�С��MinMoveSizeʱ����������ק����
				if (setting.dragStatus == 0 && Math.abs(mouseDownX - event.clientX) < MinMoveSize
					&& Math.abs(mouseDownY - event.clientY) < MinMoveSize) {
					return true;
				}

				$("body").css("cursor", "pointer");

				if (setting.dragStatus == 0 && treeNode.isParent && treeNode.open) {
					expandAndCollapseNode(setting, treeNode, !treeNode.open);
					setting.dragNodeShowBefore = true;
				}

				if (setting.dragStatus == 0) {
					//����beforeDrag alertʱ���õ�����ֵ֮ǰ������ק��Bug
					setting.dragStatus = -1;
					if (tools.apply(setting.callback.beforeDrag, [setting.treeObjId, treeNode], true) == false) return true;

					setting.dragStatus = 1;
					showIfameMask(true);

					//���ýڵ�Ϊѡ��״̬
					treeNode.editNameStatus = false;
					selectNode(setting, treeNode);
					removeTreeDom(setting, treeNode);

					var tmpNode = $("#" + treeNode.tId).clone();
					tmpNode.attr("id", treeNode.tId + "_tmp");
					tmpNode.css("padding", "0");
					tmpNode.children("#" + treeNode.tId + IDMark_A).removeClass(Class_CurSelectedNode);
					tmpNode.children("#" + treeNode.tId + IDMark_Ul).css("display", "none");

					curNode = $("<ul class='zTreeDragUL'></ul>").append(tmpNode);
					curNode.attr("id", treeNode.tId + IDMark_Ul + "_tmp");
					curNode.addClass(setting.treeObj.attr("class"));
					curNode.appendTo("body");

					tmpArrow = $("<button class='tmpzTreeMove_arrow'></button>");
					tmpArrow.attr("id", "zTreeMove_arrow_tmp");
					tmpArrow.appendTo("body");

					//���� DRAG ��ק�¼�������������ק��Դ���ݶ���
					setting.treeObj.trigger(ZTREE_DRAG, [setting.treeObjId, treeNode]);
				}

				if (setting.dragStatus == 1 && tmpArrow.attr("id") != event.target.id) {
					if (tmpTarget) {
						tmpTarget.removeClass(Class_TmpTargetTree);
						if (tmpTargetNodeId) $("#" + tmpTargetNodeId + IDMark_A, tmpTarget).removeClass(Class_TmpTargetNode);
					}
					tmpTarget = null;
					tmpTargetNodeId = null;

					//�ж��Ƿ�ͬ����
					isOtherTree = false;
					targetSetting = setting;
					for (var s in settings) {
						if (settings[s].editable && settings[s].treeObjId != setting.treeObjId
							&& (event.target.id == settings[s].treeObjId || $(event.target).parents("#" + settings[s].treeObjId).length>0)) {
							isOtherTree = true;
							targetSetting = settings[s];
						}
					}

					var docScrollTop = $(doc).scrollTop();
					var docScrollLeft = $(doc).scrollLeft();
					var treeOffset = targetSetting.treeObj.offset();
					var scrollHeight = targetSetting.treeObj.get(0).scrollHeight;
					var scrollWidth = targetSetting.treeObj.get(0).scrollWidth;
					var dTop = (event.clientY + docScrollTop - treeOffset.top);
					var dBottom = (targetSetting.treeObj.height() + treeOffset.top - event.clientY - docScrollTop);
					var dLeft = (event.clientX + docScrollLeft - treeOffset.left);
					var dRight = (targetSetting.treeObj.width() + treeOffset.left - event.clientX - docScrollLeft);
					var isTop = (dTop < 10 && dTop > -5);
					var isBottom = (dBottom < 10 && dBottom > -5);
					var isLeft = (dLeft < 10 && dLeft > -5);
					var isRight = (dRight < 10 && dRight > -5);
					var isTreeTop = (isTop && targetSetting.treeObj.scrollTop() <= 0);
					var isTreeBottom = (isBottom && (targetSetting.treeObj.scrollTop() + targetSetting.treeObj.height()+10) >= scrollHeight);
					var isTreeLeft = (isLeft && targetSetting.treeObj.scrollLeft() <= 0);
					var isTreeRight = (isRight && (targetSetting.treeObj.scrollLeft() + targetSetting.treeObj.width()+10) >= scrollWidth);

					if (event.target.id && targetSetting.treeObj.find("#" + event.target.id).length > 0) {
						//����ڵ� �Ƶ� �����ڵ�
						var targetObj = event.target;
						while (targetObj && targetObj.tagName && !tools.eqs(targetObj.tagName, "li") && targetObj.id != targetSetting.treeObjId) {
							targetObj = targetObj.parentNode;
						}

						var canMove = false;
						//����Ƶ��Լ� �����Լ����Ӽ������ܵ�����ʱĿ��
						if (treeNode.parentNode && targetObj.id != treeNode.tId && $("#" + treeNode.tId).find("#" + targetObj.id).length == 0) {
							//�Ǹ��ڵ��ƶ�
							canMove = true;
						} else if (treeNode.parentNode == null && targetObj.id != treeNode.tId && $("#" + treeNode.tId).find("#" + targetObj.id).length == 0) {
							//���ڵ��ƶ�
							canMove = true;
						}
						if (canMove) {
							if (event.target.id &&
								(event.target.id == (targetObj.id + IDMark_A) || $(event.target).parents("#" + targetObj.id + IDMark_A).length > 0)) {
								tmpTarget = $(targetObj);
								tmpTargetNodeId = targetObj.id;
							}
						}
					}

					//ȷ�������zTree�ڲ�
					if (event.target.id == targetSetting.treeObjId || $(event.target).parents("#" + targetSetting.treeObjId).length>0) {
						//ֻ���ƶ���zTree�����ı�Ե�����Ƶ� �����ų����ڵ��ڱ������ڵ��ƶ���
						if (!tmpTarget && (isTreeTop || isTreeBottom || isTreeLeft || isTreeRight) && (isOtherTree || (!isOtherTree && treeNode.parentNode != null))) {
							tmpTarget = targetSetting.treeObj;
							tmpTarget.addClass(Class_TmpTargetTree);
						}
						//�������Զ�����
						if (isTop) {
							targetSetting.treeObj.scrollTop(targetSetting.treeObj.scrollTop()-10);
						} else if (isBottom)  {
							targetSetting.treeObj.scrollTop(targetSetting.treeObj.scrollTop()+10);
						}
						if (isLeft) {
							targetSetting.treeObj.scrollLeft(targetSetting.treeObj.scrollLeft()-10);
						} else if (isRight) {
							targetSetting.treeObj.scrollLeft(targetSetting.treeObj.scrollLeft()+10);
						}
						//Ŀ��ڵ��ڿ���������࣬�Զ��ƶ����������
						if (tmpTarget && tmpTarget != targetSetting.treeObj && tmpTarget.offset().left < targetSetting.treeObj.offset().left) {
							targetSetting.treeObj.scrollLeft(targetSetting.treeObj.scrollLeft()+ tmpTarget.offset().left - targetSetting.treeObj.offset().left);
						}
					}

					curNode.css({
						"top": (event.clientY + docScrollTop + 3) + "px",
						"left": (event.clientX + docScrollLeft + 3) + "px"
					});

					var dX = 0;
					var dY = 0;
					if (tmpTarget && tmpTarget.attr("id")!=targetSetting.treeObjId) {
						var tmpTargetNode = tmpTargetNodeId == null ? null: getTreeNodeByTId(targetSetting, tmpTargetNodeId);
						var tmpNodeObj = $("#" + treeNode.tId);
						var isPrev = (tmpNodeObj.prev().attr("id") == tmpTargetNodeId) ;
						var isNext = (tmpNodeObj.next().attr("id") == tmpTargetNodeId) ;
						var isInner = (treeNode.parentNode && treeNode.parentNode.tId == tmpTargetNodeId) ;

						var canPrev = !isNext;
						var canNext = !isPrev;
						var canInner = !isInner && !(targetSetting.keepLeaf && !tmpTargetNode.isParent);
						if (!canPrev && !canNext && !canInner) {
							tmpTarget = null;
							tmpTargetNodeId = "";
							moveType = MoveType_Inner;
							tmpArrow.css({
								"display":"none"
							});
							if (window.zTreeMoveTimer) {
								clearTimeout(window.zTreeMoveTimer);
							}
						} else {
							var tmpTargetA = $("#" + tmpTargetNodeId + IDMark_A, tmpTarget);
							tmpTargetA.addClass(Class_TmpTargetNode);

							var prevPercent = canPrev ? (canInner ? 0.25 : (canNext ? 0.5 : 1) ) : -1;
							var nextPercent = canNext ? (canInner ? 0.75 : (canPrev ? 0.5 : 0) ) : -1;
							var dY_percent = (event.clientY + docScrollTop - tmpTargetA.offset().top)/tmpTargetA.height();
							if ((prevPercent==1 ||dY_percent<=prevPercent && dY_percent>=-.2) && canPrev) {
								dX = 1 - tmpArrow.width();
								dY = 0 - tmpArrow.height()/2;
								moveType = MoveType_Before;
							} else if ((nextPercent==0 || dY_percent>=nextPercent && dY_percent<=1.2) && canNext) {
								dX = 1 - tmpArrow.width();
								dY = tmpTargetA.height() - tmpArrow.height()/2;
								moveType = MoveType_After;
							}else {
								dX = 5 - tmpArrow.width();
								dY = 0;
								moveType = MoveType_Inner;
							}
							tmpArrow.css({
								"display":"block",
								"top": (tmpTargetA.offset().top + dY) + "px",
								"left": (tmpTargetA.offset().left + dX) + "px"
							});							

							if (preTmpTargetNodeId != tmpTargetNodeId || preTmpMoveType != moveType) {
								startTime = (new Date()).getTime();
							}
							if (moveType == MoveType_Inner) {
								window.zTreeMoveTimer = setTimeout(function() {
									if (moveType != MoveType_Inner) return;
									var targetNode = getTreeNodeByTId(targetSetting, tmpTargetNodeId);
									if (targetNode && targetNode.isParent && !targetNode.open && (new Date()).getTime() - startTime > 500
										&& tools.apply(targetSetting.callback.confirmDragOpen, [targetSetting.treeObjId, targetNode], true)) {
										switchNode(targetSetting, targetNode);
									}
								}, 600);
							}
						}
					} else {
						moveType = MoveType_Inner;
						tmpArrow.css({
							"display":"none"
						});
						if (window.zTreeMoveTimer) {
							clearTimeout(window.zTreeMoveTimer);
						}
					}
					preTmpTargetNodeId = tmpTargetNodeId;
					preTmpMoveType = moveType;
				}
				return false;
			});

			$(doc).mouseup(function(event) {
				if (window.zTreeMoveTimer) {
					clearTimeout(window.zTreeMoveTimer);
				}
				preTmpTargetNodeId = null;
				preTmpMoveType = null;
				$(doc).unbind("mousemove");
				$(doc).unbind("mouseup");
				$("body").css("cursor", "auto");
				if (tmpTarget) {
					tmpTarget.removeClass(Class_TmpTargetTree);
					if (tmpTargetNodeId) $("#" + tmpTargetNodeId + IDMark_A, tmpTarget).removeClass(Class_TmpTargetNode);
				}
				showIfameMask(false);

				if (setting.dragStatus == 0) return;
				setting.dragStatus = 0;

				if (treeNode.isParent && setting.dragNodeShowBefore && !treeNode.open) {
					expandAndCollapseNode(setting, treeNode, !treeNode.open);
					setting.dragNodeShowBefore = false;
				}

				if (curNode) curNode.remove();
				if (tmpArrow) tmpArrow.remove();

				//��ʾ���� �ƶ���Ľڵ�
				if (tmpTarget && tmpTargetNodeId && treeNode.parentNode && tmpTargetNodeId==treeNode.parentNode.tId && moveType == MoveType_Inner) {
					tmpTarget = null;
				}
				if (tmpTarget) {
					var dragTargetNode = tmpTargetNodeId == null ? null: getTreeNodeByTId(targetSetting, tmpTargetNodeId);
					if (tools.apply(setting.callback.beforeDrop, [targetSetting.treeObjId, treeNode, dragTargetNode, moveType], true) == false) return;
					var isCopy = (event.ctrlKey && setting.dragMove && setting.dragCopy) || (!setting.dragMove && setting.dragCopy);

					var newNode = isCopy ? tools.clone(treeNode) : treeNode;
					if (isOtherTree) {
						if (!isCopy) {removeTreeNode(setting, treeNode);}
						if (moveType == MoveType_Inner) {
							addTreeNodes(targetSetting, dragTargetNode, [newNode]);
						} else {
							addTreeNodes(targetSetting, dragTargetNode.parentNode, [newNode]);
							moveTreeNode(targetSetting, dragTargetNode, newNode, moveType, false);
						}
					}else {
						if (isCopy) {
							if (moveType == MoveType_Inner) {
								addTreeNodes(targetSetting, dragTargetNode, [newNode]);
							} else {
								addTreeNodes(targetSetting, dragTargetNode.parentNode, [newNode]);
								moveTreeNode(targetSetting, dragTargetNode, newNode, moveType, false);
							}
						} else {
							moveTreeNode(targetSetting, dragTargetNode, newNode, moveType);
						}						
					}
					selectNode(targetSetting, newNode);
					$("#" + newNode.tId + IDMark_Icon).focus().blur();

					//���� DROP ��ק�¼���������ק��Ŀ�����ݶ���
					setting.treeObj.trigger(ZTREE_DROP, [targetSetting.treeObjId, newNode, dragTargetNode, moveType]);

				} else {
					//���� DROP ��ק�¼�������null
					setting.treeObj.trigger(ZTREE_DROP, [setting.treeObjId, null, null, null]);
				}
			});

			//��ֹĬ���¼�ר�����ڴ��� FireFox ��Bug��
			//�� Bug ������� zTree Div CSS �д��� overflow ���ã�����ק�ڵ��Ƴ� zTree ʱ���޷��õ���ȷ��event.target
			if(eventMouseDown.preventDefault) {
				eventMouseDown.preventDefault();
			}
		},
		onHoverOverNode: function(event) {
			var setting = settings[event.data.treeObjId];
			var treeNode = event.data.treeNode;
			if (setting.curHoverTreeNode != treeNode) {
				event.data.treeNode = setting.curHoverTreeNode;
				handler.onHoverOutNode(event);
			}
			setting.curHoverTreeNode = treeNode;
			addTreeDom(setting, treeNode);
		},
		onHoverOutNode: function(event) {
			var setting = settings[event.data.treeObjId];
			if (setting.curHoverTreeNode && setting.curTreeNode != setting.curHoverTreeNode) {
				removeTreeDom(setting, setting.curHoverTreeNode);
				setting.curHoverTreeNode = null;
			}
		},
		onZTreeMousedown: function(event) {
			var setting = settings[event.data.treeObjId];
			var treeNode = event.data.treeNode;
			//����mouseDown�¼�
			if (tools.apply(setting.callback.beforeMouseDown, [setting.treeObjId, treeNode], true)) {
				tools.apply(setting.callback.mouseDown, [event, setting.treeObjId, treeNode]);
			}
			return true;
		},
		onZTreeMouseup: function(event) {
			var setting = settings[event.data.treeObjId];
			var treeNode = event.data.treeNode;
			//����mouseUp�¼�
			if (tools.apply(setting.callback.beforeMouseUp, [setting.treeObjId, treeNode], true)) {
				tools.apply(setting.callback.mouseUp, [event, setting.treeObjId, treeNode]);
			}
			return true;
		},
		onZTreeDblclick: function(event) {
			var setting = settings[event.data.treeObjId];
			var treeNode = event.data.treeNode;
			//����mouseUp�¼�
			if (tools.apply(setting.callback.beforeDblclick, [setting.treeObjId, treeNode], true)) {
				tools.apply(setting.callback.dblclick, [event, setting.treeObjId, treeNode]);
			}
			return true;
		},
		onZTreeContextmenu: function(event) {
			var setting = settings[event.data.treeObjId];
			var treeNode = event.data.treeNode;
			//����rightClick�¼�
			if (tools.apply(setting.callback.beforeRightClick, [setting.treeObjId, treeNode], true)) {
				tools.apply(setting.callback.rightClick, [event, setting.treeObjId, treeNode]);
			}
			return (typeof setting.callback.rightClick) != "function";
		}		
	};

	//���ù��λ�ú���
	function setCursorPosition(obj, pos){
		if(obj.setSelectionRange) {
			obj.focus();
			obj.setSelectionRange(pos,pos);
		} else if (obj.createTextRange) {
			var range = obj.createTextRange();
			range.collapse(true);
			range.moveEnd('character', pos);
			range.moveStart('character', pos);
			range.select();
		}
	}

	var dragMaskList = new Array();
	//��ʾ������ Iframe�����ֲ㣨��Ҫ���ڱ�����ק��������
	function showIfameMask(showSign) {
		//�����������
		while (dragMaskList.length > 0) {
			dragMaskList[0].remove();
			dragMaskList.shift();
		}
		if (showSign) {
			//��ʾ����
			var iframeList = $("iframe");
			for (var i = 0, l = iframeList.length; i < l; i++) {
				var obj = iframeList.get(i);
				var r = tools.getAbs(obj);
				var dragMask = $("<div id='zTreeMask_" + i + "' class='zTreeMask' style='top:" + r[1] + "px; left:" + r[0] + "px; width:" + obj.offsetWidth + "px; height:" + obj.offsetHeight + "px;'></div>");
				dragMask.appendTo("body");
				dragMaskList.push(dragMask);
			}
		}
	}
	
	//����Name
	function setNodeName(setting, treeNode) {
		var nObj = $("#" + treeNode.tId + IDMark_Span);
		nObj.text(treeNode[setting.nameCol]);
	}
	//����Target
	function setNodeTarget(treeNode) {
		var aObj = $("#" + treeNode.tId + IDMark_A);
		aObj.attr("target", makeNodeTarget(treeNode));
	}
	function makeNodeTarget(treeNode) {
		return (treeNode.target || "_blank");
	}
	//����URL
	function setNodeUrl(setting, treeNode) {
		var aObj = $("#" + treeNode.tId + IDMark_A);
		var url = makeNodeUrl(setting, treeNode);
		if (url == null || url.length == 0) {
			aObj.removeAttr("href");
		} else {
			aObj.attr("href", url);
		}
	}
	function makeNodeUrl(setting, treeNode) {
		return (treeNode.url && !setting.editable) ? treeNode.url : null;        
	}
	//����Line��Ico��css����
	function setNodeLineIcos(setting, treeNode) {
		if (!treeNode) return;
		var switchObj = $("#" + treeNode.tId + IDMark_Switch);
		var ulObj = $("#" + treeNode.tId + IDMark_Ul);
		var icoObj = $("#" + treeNode.tId + IDMark_Icon);
		
		var ulLine = makeUlLineClass(setting, treeNode);
		if (ulLine.length==0) {
			ulObj.removeClass(LineMark_Line);
		} else {
			ulObj.addClass(ulLine);
		}
		
		switchObj.attr("class", makeNodeLineClass(setting, treeNode));		
		icoObj.attr("style", makeNodeIcoStyle(setting, treeNode));
		icoObj.attr("class", makeNodeIcoClass(setting, treeNode));
	}
	function makeNodeLineClass(setting, treeNode) {
		var lineClass = ["switch"];
		if (setting.showLine) {
			if (treeNode.level == 0 && treeNode.isFirstNode && treeNode.isLastNode) {
				lineClass.push(LineMark_Root);
			} else if (treeNode.level == 0 && treeNode.isFirstNode) {
				lineClass.push(LineMark_Roots);
			} else if (treeNode.isLastNode) {
				lineClass.push(LineMark_Bottom);
			} else {
				lineClass.push(LineMark_Center);
			}
			
		} else {
			lineClass.push(LineMark_NoLine);
		}
		if (treeNode.isParent) {
			lineClass.push(treeNode.open ? FolderMark_Open : FolderMark_Close);
		} else {
			lineClass.push(FolderMark_Docu);
		}
		return lineClass.join('_');
	}
	function makeUlLineClass(setting, treeNode) {
		return (setting.showLine && !treeNode.isLastNode) ? LineMark_Line : "";
	}
	function makeNodeIcoClass(setting, treeNode) {
		var icoCss = ["ico"];
		if (!treeNode.isAjaxing) {
			icoCss[0] = (treeNode.iconSkin ? treeNode.iconSkin : "") + " " + icoCss[0];
			if (treeNode.isParent) {
				icoCss.push(treeNode.open ? FolderMark_Open : FolderMark_Close);
			} else {
				icoCss.push(FolderMark_Docu);
			}
		}
		return icoCss.join('_');
	}
	function makeNodeIcoStyle(setting, treeNode) {
		var icoStyle = [];
		if (!treeNode.isAjaxing) {
			var icon = (treeNode.isParent && treeNode.iconOpen && treeNode.iconClose) ? (treeNode.open ? treeNode.iconOpen : treeNode.iconClose) : treeNode.icon;
			if (icon) icoStyle.push("background:url(", icon, ") 0 0 no-repeat;");
			if (setting.showIcon == false || !tools.apply(setting.showIcon, [setting.treeObjId, treeNode], true)) {
				icoStyle.push("width:0px;height:0px;");
			}			
		}
		return icoStyle.join('');
	}
	
	//�����Զ���������ʽ
	function setNodeFontCss(setting, treeNode) {
		var aObj = $("#" + treeNode.tId + IDMark_A);
		var fontCss = makeNodeFontCss(setting, treeNode);
		if (fontCss) {
			aObj.css(fontCss);
		}
	}
	function makeNodeFontCss(setting, treeNode) {
		var fontCss = tools.apply(setting.fontCss, [setting.treeObjId, treeNode]);
		if (fontCss == null) {
			fontCss = setting.fontCss;
		}
		if (fontCss) {
			return fontCss;
		} else {
			return {};
		}		
	}

	//����button�滻class ƴ���ַ���
	function replaceSwitchClass(obj, newName) {
		if (!obj) return;

		var tmpName = obj.attr("class");
		if (tmpName == undefined) return;
		var tmpList = tmpName.split("_");
		switch (newName) {
			case LineMark_Root:
			case LineMark_Roots:
			case LineMark_Center:
			case LineMark_Bottom:
			case LineMark_NoLine:
				tmpList[1] = newName;
				break;
			case FolderMark_Open:
			case FolderMark_Close:
			case FolderMark_Docu:
				tmpList[2] = newName;
				break;
		}

		obj.attr("class", tmpList.join("_"));
	}
	function replaceIcoClass(treeNode, obj, newName) {
		if (!obj || treeNode.isAjaxing) return;

		var tmpName = obj.attr("class");
		if (tmpName == undefined) return;
		var tmpList = tmpName.split("_");
		switch (newName) {
			case FolderMark_Open:
			case FolderMark_Close:
			case FolderMark_Docu:
				tmpList[1] = newName;
				break;
		}

		obj.attr("class", tmpList.join("_"));
	}
	
	//���zTree�İ�ť�ؼ�
	function addTreeDom(setting, treeNode) {
		if (setting.dragStatus == 0) {
			treeNode.isHover = true;
			if (setting.editable) {
				addEditBtn(setting, treeNode);
				addRemoveBtn(setting, treeNode);
			}
			tools.apply(setting.addHoverDom, [setting.treeObjId, treeNode]);
		}
	}
	//ɾ��zTree�İ�ť�ؼ�
	function removeTreeDom(setting, treeNode) {
		treeNode.isHover = false;
		removeEditBtn(treeNode); 
		removeRemoveBtn(treeNode);
		tools.apply(setting.removeHoverDom, [setting.treeObjId, treeNode]);
	}
	//ɾ�� �༭��ɾ����ť
	function removeEditBtn(treeNode) {		
		$("#" + treeNode.tId + IDMark_Edit).unbind().remove();
	}
	function removeRemoveBtn(treeNode) {		
		$("#" + treeNode.tId + IDMark_Remove).unbind().remove();
	}
	function addEditBtn(setting, treeNode) {
		if (treeNode.editNameStatus || $("#" + treeNode.tId + IDMark_Edit).length > 0) {
			return;
		}
		if (!tools.apply(setting.edit_renameBtn, [treeNode], setting.edit_renameBtn)) {
			return;
		}
		var nObj = $("#" + treeNode.tId + IDMark_Span);
		var editStr = "<button type='button' class='edit' id='" + treeNode.tId + IDMark_Edit + "' title='' treeNode"+IDMark_Edit+" onfocus='this.blur();' style='display:none;'></button>";
		nObj.after(editStr);
		
		$("#" + treeNode.tId + IDMark_Edit).bind('click', 
			function() {
				if (tools.apply(setting.callback.beforeRename, [setting.treeObjId, treeNode], true) == false) return true;
				editTreeNode(setting, treeNode);
				return false;
			}
			).show();
	}
	function addRemoveBtn(setting, treeNode) {		
		if (!setting.edit_removeBtn || $("#" + treeNode.tId + IDMark_Remove).length > 0) {
			return;
		}
		if (!tools.apply(setting.edit_removeBtn, [treeNode], setting.edit_removeBtn)) {
			return;
		}		
		var aObj = $("#" + treeNode.tId + IDMark_A);
		var removeStr = "<button type='button' class='remove' id='" + treeNode.tId + IDMark_Remove + "' title='' treeNode"+IDMark_Remove+" onfocus='this.blur();' style='display:none;'></button>";
		aObj.append(removeStr);
		
		$("#" + treeNode.tId + IDMark_Remove).bind('click', 
			function() {
				if (tools.apply(setting.callback.beforeRemove, [setting.treeObjId, treeNode], true) == false) return true;
				removeTreeNode(setting, treeNode);
				//����remove�¼�
				setting.treeObj.trigger(ZTREE_REMOVE, [setting.treeObjId, treeNode]);
				return false;
			}
			).bind('mousedown',
			function(eventMouseDown) {
				return true;
			}
			).show();
	}
	
	//����check�󣬸��ӽڵ�������ϵ
	function checkNodeRelation(setting, treeNode) {
		var pNode, i, l;
		if (setting.checkStyle == Check_Style_Radio) {
			if (treeNode[setting.checkedCol]) {
				if (setting.checkRadioType == Radio_Type_All) {
					for (i = setting.checkRadioCheckedList.length-1; i >= 0; i--) {
						pNode = setting.checkRadioCheckedList[i];
						pNode[setting.checkedCol] = false;
						setting.checkRadioCheckedList.splice(i, 1);
						
						setChkClass(setting, $("#" + pNode.tId + IDMark_Check), pNode);
						if (pNode.parentNode != treeNode.parentNode) {
							repairParentChkClassWithSelf(setting, pNode);
						}
					}
					setting.checkRadioCheckedList = setting.checkRadioCheckedList.concat([treeNode]);
				} else {
					var parentNode = (treeNode.parentNode) ? treeNode.parentNode : setting.root;
					for (i = 0, l = parentNode[setting.nodesCol].length; i < l; i++) {
						pNode = parentNode[setting.nodesCol][i];
						if (pNode[setting.checkedCol] && pNode != treeNode) {
							pNode[setting.checkedCol] = false;
							setChkClass(setting, $("#" + pNode.tId + IDMark_Check), pNode);
						}
					}
				}
			} else if (setting.checkRadioType == Radio_Type_All) {
				for (i = 0, l = setting.checkRadioCheckedList.length; i < l; i++) {
					if (treeNode == setting.checkRadioCheckedList[i]) {
						setting.checkRadioCheckedList.splice(i, 1);
						break;
					}
				}
			}
			
		} else {
			if (treeNode[setting.checkedCol] && setting.checkType.Y.indexOf("s") > -1) {
				setSonNodeCheckBox(setting, treeNode, true);
			}
			if (treeNode[setting.checkedCol] && setting.checkType.Y.indexOf("p") > -1) {
				setParentNodeCheckBox(setting, treeNode, true);
			}
			if (!treeNode[setting.checkedCol] && setting.checkType.N.indexOf("s") > -1) {
				setSonNodeCheckBox(setting, treeNode, false);
			}
			if (!treeNode[setting.checkedCol] && setting.checkType.N.indexOf("p") > -1) {
				setParentNodeCheckBox(setting, treeNode, false);
			}
		}
	}
	
	//�������ڵ�����checkbox
	function setParentNodeCheckBox(setting, treeNode, value) {
		var checkObj = $("#" + treeNode.tId + IDMark_Check);
		treeNode[setting.checkedCol] = value;
		setChkClass(setting, checkObj, treeNode);
		if (treeNode.parentNode) {
			var pSign = true;
			if (!value) {
				for (var i = 0, l = treeNode.parentNode[setting.nodesCol].length; i < l; i++) {
					if (treeNode.parentNode[setting.nodesCol][i][setting.checkedCol]) {
						pSign = false;
						break;
					}
				}
			}
			if (pSign) {
				setParentNodeCheckBox(setting, treeNode.parentNode, value);
			}
		}
	}

	//�����ӽڵ�����checkbox
	function setSonNodeCheckBox(setting, treeNode, value) {
		if (!treeNode) return;
		var checkObj = $("#" + treeNode.tId + IDMark_Check);

		if (treeNode != setting.root) {
			treeNode[setting.checkedCol] = value;
			treeNode.check_True_Full = true;
			treeNode.check_False_Full = true;
			setChkClass(setting, checkObj, treeNode);
		}

		if (!treeNode[setting.nodesCol]) return;
		for (var i = 0, l = treeNode[setting.nodesCol].length; i < l; i++) {
			if (treeNode[setting.nodesCol][i]) setSonNodeCheckBox(setting, treeNode[setting.nodesCol][i], value);
		}
	}
	
	//����CheckBox��Class���ͣ���Ҫ������ʾ�ӽڵ��Ƿ�ȫ����ѡ�����ʽ
	function setChkClass(setting, obj, treeNode) {
		if (!obj) return;
		if (treeNode.nocheck === true) {
			obj.hide();
		} else {
			obj.show();
		}
		obj.removeClass();
		obj.addClass(makeChkClass(setting, treeNode));
	}
	function makeChkClass(setting, treeNode) {
		var chkName = setting.checkStyle + "_" + (treeNode[setting.checkedCol] ? CheckBox_True : CheckBox_False)
		+ "_" + ((treeNode[setting.checkedCol] || setting.checkStyle == Check_Style_Radio) ? (treeNode.check_True_Full? CheckBox_Full:CheckBox_Part) : (treeNode.check_False_Full? CheckBox_Full:CheckBox_Part) );
		chkName = treeNode.checkboxFocus ? chkName + "_" + CheckBox_Focus : chkName;
		return CheckBox_Default + " " + chkName;
	}
	
	function repairAllChk(setting, checked) {
		if (setting.checkable) {
			for (var son = 0; son < setting.root[setting.nodesCol].length; son++) {
				var treeNode = setting.root[setting.nodesCol][son];
				treeNode[setting.checkedCol] = checked;
				setSonNodeCheckBox(setting, treeNode, checked);
			}
		}
	}
	//�������ڵ�ѡ�����ʽ
	function repairParentChkClass(setting, treeNode) {
		if (!treeNode || !treeNode.parentNode) return;
		repairChkClass(setting, treeNode.parentNode);
		repairParentChkClass(setting, treeNode.parentNode);
	}	
	function repairParentChkClassWithSelf(setting, treeNode) {
		if (!treeNode) return;
		if (treeNode[setting.nodesCol] && treeNode[setting.nodesCol].length > 0) {
			repairParentChkClass(setting, treeNode[setting.nodesCol][0]);
		} else {
			repairParentChkClass(setting, treeNode);
		}
	}

	function repairChkClass(setting, treeNode) {
		if (!treeNode) return;
		makeChkFlag(setting, treeNode);
		var checkObj = $("#" + treeNode.tId + IDMark_Check);
		setChkClass(setting, checkObj, treeNode);
	}
	function makeChkFlag(setting, treeNode) {
		if (!treeNode) return;
		var chkFlag = {"trueFlag": true, "falseFlag": true};
		if (treeNode[setting.nodesCol]) {
			for (var i = 0, l = treeNode[setting.nodesCol].length; i < l; i++) {
				if (setting.checkStyle == Check_Style_Radio && (treeNode[setting.nodesCol][i][setting.checkedCol] || !treeNode[setting.nodesCol][i].check_True_Full)) {
					chkFlag.trueFlag = false;
				} else if (setting.checkStyle != Check_Style_Radio && treeNode[setting.checkedCol] && (!treeNode[setting.nodesCol][i][setting.checkedCol] || !treeNode[setting.nodesCol][i].check_True_Full)) {
					chkFlag.trueFlag = false;
				} else if (setting.checkStyle != Check_Style_Radio && !treeNode[setting.checkedCol] && (treeNode[setting.nodesCol][i][setting.checkedCol] || !treeNode[setting.nodesCol][i].check_False_Full)) {
					chkFlag.falseFlag = false;
				}
				if (!chkFlag.trueFlag || !chkFlag.falseFlag) break;
			}
		}
		treeNode.check_True_Full = chkFlag.trueFlag;
		treeNode.check_False_Full = chkFlag.falseFlag;
	}

	function switchNode(setting, treeNode) {
		if (treeNode.open || (treeNode && treeNode[setting.nodesCol] && treeNode[setting.nodesCol].length > 0)) {
			expandAndCollapseNode(setting, treeNode, !treeNode.open);
		} else if (setting.async) {
			if (tools.apply(setting.callback.beforeAsync, [setting.treeObjId, treeNode], true) == false) {
				expandAndCollapseNode(setting, treeNode, !treeNode.open);
				return;
			}			
			asyncGetNode(setting, treeNode);
		} else if (treeNode) {
			expandAndCollapseNode(setting, treeNode, !treeNode.open);
		}
	}

	function asyncGetNode(setting, treeNode) {
		var i, l;
		if (treeNode && (treeNode.isAjaxing || !treeNode.isParent)) {
			return;
		}
		if (treeNode) {
			treeNode.isAjaxing = true;
			var icoObj = $("#" + treeNode.tId + IDMark_Icon);
			icoObj.attr("class", "ico_loading");
		}

		var tmpParam = "";
		for (i = 0, l = setting.asyncParam.length; treeNode && i < l; i++) {
			tmpParam += (tmpParam.length > 0 ? "&": "") + setting.asyncParam[i] + "=" + treeNode[setting.asyncParam[i]];
		}
		if (tools.isArray(setting.asyncParamOther)) {
			for (i = 0, l = setting.asyncParamOther.length; i < l; i += 2) {
				tmpParam += (tmpParam.length > 0 ? "&": "") + setting.asyncParamOther[i] + "=" + setting.asyncParamOther[i + 1];
			}
		} else {
			for (var p in setting.asyncParamOther) {
				tmpParam += (tmpParam.length > 0 ? "&" : "") + p + "=" + setting.asyncParamOther[p];
			}
		}
		
		$.ajax({
			type: "POST",
			url: tools.apply(setting.asyncUrl, [treeNode], setting.asyncUrl),
			data: tmpParam,
			dataType: "text",
			success: function(msg) {
				
				var newNodes = [];
				try {
					if (!msg || msg.length == 0) {
						newNodes = [];
					} else if (typeof msg == "string") {
						newNodes = eval("(" + msg + ")");
					} else {
						newNodes = msg;
					}
				} catch(err) {}
				
				if (treeNode) treeNode.isAjaxing = null;
				setNodeLineIcos(setting, treeNode);
				if (newNodes && newNodes != "") {
					newNodes = tools.apply(setting.asyncDataFilter, [setting.treeObjId, treeNode, newNodes], newNodes);
					addTreeNodes(setting, treeNode, newNodes, false);
				} else {
					addTreeNodes(setting, treeNode, [], false);
				}
				setting.treeObj.trigger(ZTREE_ASYNC_SUCCESS, [setting.treeObjId, treeNode, msg]);

			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				setting.expandTriggerFlag = false;
				setNodeLineIcos(setting, treeNode);
				if (treeNode) treeNode.isAjaxing = null;
				setting.treeObj.trigger(ZTREE_ASYNC_ERROR, [setting.treeObjId, treeNode, XMLHttpRequest, textStatus, errorThrown]);
			}
		});
	}

	// չ�� ���� �۵� �ڵ��¼�
	function expandAndCollapseNode(setting, treeNode, expandSign, animateSign, callback) {
		if (!treeNode || treeNode.open == expandSign) {
			tools.apply(callback, []);
			return;
		}		
		if (setting.expandTriggerFlag) {
			callback = function(){
				if (treeNode.open) {
					//����expand�¼�
					setting.treeObj.trigger(ZTREE_EXPAND, [setting.treeObjId, treeNode]);
				} else {
					//����collapse�¼�
					setting.treeObj.trigger(ZTREE_COLLAPSE, [setting.treeObjId, treeNode]);
				}
			};
			setting.expandTriggerFlag = false;
		}
		
		var switchObj = $("#" + treeNode.tId + IDMark_Switch);
		var icoObj = $("#" + treeNode.tId + IDMark_Icon);
		var ulObj = $("#" + treeNode.tId + IDMark_Ul);

		if (treeNode.isParent) {
			treeNode.open = !treeNode.open;
			if (treeNode.iconOpen && treeNode.iconClose) {
				icoObj.attr("style", makeNodeIcoStyle(setting, treeNode));
			}

			if (treeNode.open) {
				replaceSwitchClass(switchObj, FolderMark_Open);
				replaceIcoClass(treeNode, icoObj, FolderMark_Open);
				if (animateSign == false || setting.expandSpeed == "") {
					ulObj.show();
					tools.apply(callback, []);
				} else {
					if (treeNode[setting.nodesCol] && treeNode[setting.nodesCol].length > 0) {
						ulObj.show(setting.expandSpeed, callback);
					} else {
						ulObj.show();
						tools.apply(callback, []);
					}
				}
			} else {
				replaceSwitchClass(switchObj, FolderMark_Close);
				replaceIcoClass(treeNode, icoObj, FolderMark_Close);
				if (animateSign == false || setting.expandSpeed == "") {
					ulObj.hide();
					tools.apply(callback, []);
				} else {
					ulObj.hide(setting.expandSpeed, callback);
				}
			}
		} else {
			tools.apply(callback, []);
		}
	}

	//�����ӽڵ�չ�� �� �۵�
	function expandCollapseSonNode(setting, treeNode, expandSign, animateSign, callback) {
		var treeNodes = (treeNode) ? treeNode[setting.nodesCol]: setting.root[setting.nodesCol];
		
		//��Զ��������Ż�,һ����˵ֻ���ڵ�һ���ʱ�򣬲Ž��ж���Ч��
		var selfAnimateSign = (treeNode) ? false : animateSign;
		if (treeNodes) {
			for (var i = 0, l = treeNodes.length; i < l; i++) {
				if (treeNodes[i]) expandCollapseSonNode(setting, treeNodes[i], expandSign, selfAnimateSign);
			}
		}
		//��֤callbackִֻ��һ��
		expandAndCollapseNode(setting, treeNode, expandSign, animateSign, callback );

	}

	//�������ڵ�չ�� �� �۵�
	function expandCollapseParentNode(setting, treeNode, expandSign, animateSign, callback) {
		//��Զ��������Ż�,һ����˵ֻ���ڵ�һ���ʱ�򣬲Ž��ж���Ч��
		if (!treeNode) return;
		if (!treeNode.parentNode) {
			//��֤callbackִֻ��һ��
			expandAndCollapseNode(setting, treeNode, expandSign, animateSign, callback);
			return ;
		} else {
			expandAndCollapseNode(setting, treeNode, expandSign, animateSign);
		}
		
		if (treeNode.parentNode) {
			expandCollapseParentNode(setting, treeNode.parentNode, expandSign, animateSign, callback);
		}
	}

	//�����ӽڵ�����level,��Ҫ�����ƶ��ڵ��Ĵ���
	function setSonNodeLevel(setting, parentNode, treeNode) {
		if (!treeNode) return;
		treeNode.level = (parentNode)? parentNode.level + 1 : 0;
		if (!treeNode[setting.nodesCol]) return;
		for (var i = 0, l = treeNode[setting.nodesCol].length; i < l; i++) {
			if (treeNode[setting.nodesCol][i]) setSonNodeLevel(setting, treeNode, treeNode[setting.nodesCol][i]);
		}
	}

	//�����ӽڵ�
	function addTreeNodes(setting, parentNode, newNodes, isSilent) {
		if (setting.keepLeaf && parentNode && !parentNode.isParent) {
			return;
		}
		if (setting.isSimpleData) {
			newNodes = transformTozTreeFormat(setting, newNodes);
		}
		if (parentNode) {
			//Ŀ��ڵ�����ڵ�ǰ����
			if (setting.treeObj.find("#" + parentNode.tId).length == 0) return;

			var target_switchObj = $("#" + parentNode.tId + IDMark_Switch);
			var target_icoObj = $("#" + parentNode.tId + IDMark_Icon);
			var target_ulObj = $("#" + parentNode.tId + IDMark_Ul);

			//����ڵ���Ŀ��ڵ��ͼƬ����
			if (!parentNode.open) {
				replaceSwitchClass(target_switchObj, FolderMark_Close);
				replaceIcoClass(parentNode, target_icoObj, FolderMark_Close);			
				parentNode.open = false;
				target_ulObj.css({"display": "none"});
			}

			addTreeNodesData(setting, parentNode, newNodes);
			initTreeNodes(setting, parentNode.level + 1, newNodes, parentNode);
			//���ѡ��ĳ�ڵ㣬�����չ����ȫ�����ڵ�
			if (!isSilent) {
				expandCollapseParentNode(setting, parentNode, true);
			}
		} else {
			addTreeNodesData(setting, setting.root, newNodes);
			initTreeNodes(setting, 0, newNodes, null);
		}
	}

	//���ӽڵ�����
	function addTreeNodesData(setting, parentNode, treenodes) {
		if (!parentNode[setting.nodesCol]) parentNode[setting.nodesCol] = [];
		if (parentNode[setting.nodesCol].length > 0) {
			parentNode[setting.nodesCol][parentNode[setting.nodesCol].length - 1].isLastNode = false;
			setNodeLineIcos(setting, parentNode[setting.nodesCol][parentNode[setting.nodesCol].length - 1]);
		}
		parentNode.isParent = true;
		parentNode[setting.nodesCol] = parentNode[setting.nodesCol].concat(treenodes);
	}

	//�ƶ��ӽڵ�
	function moveTreeNode(setting, targetNode, treeNode, moveType, animateSign) {
		if (targetNode == treeNode) return;
		if (setting.keepLeaf && targetNode && !targetNode.isParent && moveType == MoveType_Inner) return;
		var oldParentNode = treeNode.parentNode == null ? setting.root: treeNode.parentNode;
		
		var targetNodeIsRoot = (targetNode === null || targetNode == setting.root);
		if (targetNodeIsRoot && targetNode === null) targetNode = setting.root;
		if (targetNodeIsRoot) moveType = MoveType_Inner;
		var targetParentNode = (targetNode.parentNode ? targetNode.parentNode : setting.root);

		if (moveType != MoveType_Before && moveType != MoveType_After) {
			moveType = MoveType_Inner;
		}
		
		//�������ݽṹ����
		var i,l;
		var tmpSrcIndex = -1;
		var tmpTargetIndex = 0;
		var oldNeighbor = null;
		var newNeighbor = null;
		if (treeNode.isFirstNode) {
			tmpSrcIndex = 0;
			if (oldParentNode[setting.nodesCol].length > 1 ) {
				oldNeighbor = oldParentNode[setting.nodesCol][1];
				oldNeighbor.isFirstNode = true;
			}
		} else if (treeNode.isLastNode) {
			tmpSrcIndex = oldParentNode[setting.nodesCol].length -1;
			oldNeighbor = oldParentNode[setting.nodesCol][tmpSrcIndex - 1];
			oldNeighbor.isLastNode = true;
		} else {
			for (i = 0, l = oldParentNode[setting.nodesCol].length; i < l; i++) {
				if (oldParentNode[setting.nodesCol][i].tId == treeNode.tId) tmpSrcIndex = i;
			}
		}
		if (tmpSrcIndex >= 0) {
			oldParentNode[setting.nodesCol].splice(tmpSrcIndex, 1);
		}
		if (moveType != MoveType_Inner) {
			for (i = 0, l = targetParentNode[setting.nodesCol].length; i < l; i++) {
				if (targetParentNode[setting.nodesCol][i].tId == targetNode.tId) tmpTargetIndex = i;
			}
		}
		if (moveType == MoveType_Inner) {
			if (targetNodeIsRoot) {
				//��Ϊ���ڵ㣬�򲻲���Ŀ��ڵ�����
				treeNode.parentNode = null;
			} else {
				targetNode.isParent = true;
				treeNode.parentNode = targetNode;
			}
			
			if (!targetNode[setting.nodesCol]) targetNode[setting.nodesCol] = new Array();
			if (targetNode[setting.nodesCol].length > 0) {
				newNeighbor = targetNode[setting.nodesCol][targetNode[setting.nodesCol].length - 1];
				newNeighbor.isLastNode = false;
			}
			targetNode[setting.nodesCol].splice(targetNode[setting.nodesCol].length, 0, treeNode);
			treeNode.isLastNode = true;
			treeNode.isFirstNode = (targetNode[setting.nodesCol].length == 1);
		} else if (targetNode.isFirstNode && moveType == MoveType_Before) {
			targetParentNode[setting.nodesCol].splice(tmpTargetIndex, 0, treeNode);
			newNeighbor = targetNode;
			newNeighbor.isFirstNode = false;
			treeNode.parentNode = targetNode.parentNode;
			treeNode.isFirstNode = true;
			treeNode.isLastNode = false;
			
		} else if (targetNode.isLastNode && moveType == MoveType_After) {
			targetParentNode[setting.nodesCol].splice(tmpTargetIndex + 1, 0, treeNode);
			newNeighbor = targetNode;
			newNeighbor.isLastNode = false;
			treeNode.parentNode = targetNode.parentNode;
			treeNode.isFirstNode = false;
			treeNode.isLastNode = true;
			
		} else {
			if (moveType == MoveType_Before) {
				targetParentNode[setting.nodesCol].splice(tmpTargetIndex, 0, treeNode);
			} else {
				targetParentNode[setting.nodesCol].splice(tmpTargetIndex + 1, 0, treeNode);
			}
			treeNode.parentNode = targetNode.parentNode;
			treeNode.isFirstNode = false;
			treeNode.isLastNode = false;
		}
		fixParentKeyValue(setting, treeNode);
		
		setSonNodeLevel(setting, treeNode.parentNode, treeNode);
		
		//����HTML�ṹ����
		var targetObj;
		var target_switchObj;
		var target_icoObj;
		var target_ulObj;

		if (targetNodeIsRoot) {
			//ת�Ƶ����ڵ�
			targetObj = setting.treeObj;
			target_ulObj = targetObj;
		} else {
			//ת�Ƶ��ӽڵ�
			targetObj = $("#" + targetNode.tId);
			target_switchObj = $("#" + targetNode.tId + IDMark_Switch);
			target_icoObj = $("#" + targetNode.tId + IDMark_Icon);
			target_ulObj = $("#" + targetNode.tId + IDMark_Ul);
		}
		
		//����Ŀ��ڵ�
		if (moveType == MoveType_Inner) {
			replaceSwitchClass(target_switchObj, FolderMark_Open);
			replaceIcoClass(targetNode, target_icoObj, FolderMark_Open);
			targetNode.open = true;
			target_ulObj.css({
				"display":"block"
			});
			target_ulObj.append($("#" + treeNode.tId).remove(null, true));
		} else if (moveType == MoveType_Before) {
			targetObj.before($("#" + treeNode.tId).remove(null, true));
			
		} else if (moveType == MoveType_After) {
			targetObj.after($("#" + treeNode.tId).remove(null, true));
		}

		//�����ƶ��Ľڵ�
		setNodeLineIcos(setting, treeNode);
		
		//����ԭ�ڵ�ĸ��ڵ�
		if (!setting.keepParent && oldParentNode[setting.nodesCol].length < 1) {
			//ԭ���ڸ��ڵ����ӽڵ�
			oldParentNode.isParent = false;
			var tmp_ulObj = $("#" + oldParentNode.tId + IDMark_Ul);
			var tmp_switchObj = $("#" + oldParentNode.tId + IDMark_Switch);
			var tmp_icoObj = $("#" + oldParentNode.tId + IDMark_Icon);
			replaceSwitchClass(tmp_switchObj, FolderMark_Docu);
			replaceIcoClass(oldParentNode, tmp_icoObj, FolderMark_Docu);
			tmp_ulObj.css("display", "none");

		} else if (oldNeighbor) {
			//ԭ����λ����Ҫ��������ڽڵ�
			setNodeLineIcos(setting, oldNeighbor);
		}
		
		//����Ŀ��ڵ�����ڽڵ�
		if (newNeighbor) {
			setNodeLineIcos(setting, newNeighbor);
		}
		
		//�������ڵ�Check״̬
		if (setting.checkable) {
			repairChkClass(setting, oldParentNode);
			repairParentChkClassWithSelf(setting, oldParentNode);
			if (oldParentNode != treeNode.parent) 
				repairParentChkClassWithSelf(setting, treeNode);
		}
		
		//�ƶ��������չ����λ�õ�ȫ�����ڵ�
		expandCollapseParentNode(setting, treeNode.parentNode, true, animateSign);
	}
	
	//����pId
	function fixParentKeyValue(setting, treeNode) {
		if (setting.isSimpleData) {
			treeNode[setting.treeNodeParentKey] = treeNode.parentNode ? treeNode.parentNode[setting.treeNodeKey] : setting.rootPID;
		}
	}
	
	//�༭�ӽڵ�����
	function editTreeNode(setting, treeNode) {
		treeNode.editNameStatus = true;
		removeTreeDom(setting, treeNode);
		selectNode(setting, treeNode);
	}

	//ɾ���ӽڵ�
	function removeTreeNode(setting, treeNode) {
		var parentNode = treeNode.parentNode == null ? setting.root: treeNode.parentNode;
		if (setting.curTreeNode === treeNode) setting.curTreeNode = null;
		if (setting.curEditTreeNode === treeNode) setting.curEditTreeNode = null;

		$("#" + treeNode.tId).remove();
		removeCache(setting, treeNode);

		//�������ݽṹ����
		var tmpSrcIndex = -1;
		for (var i = 0, l = parentNode[setting.nodesCol].length; i < l; i++) {
			if (parentNode[setting.nodesCol][i].tId == treeNode.tId) tmpSrcIndex = i;
		}
		if (tmpSrcIndex >= 0) {
			parentNode[setting.nodesCol].splice(tmpSrcIndex, 1);
		}
		var tmp_ulObj,tmp_switchObj,tmp_icoObj;

		//����ԭ�ڵ�ĸ��ڵ��ͼ�ꡢ��
		if (!setting.keepParent && parentNode[setting.nodesCol].length < 1) {
			//ԭ���ڸ��ڵ����ӽڵ�
			parentNode.isParent = false;
			parentNode.open = false;
			tmp_ulObj = $("#" + parentNode.tId + IDMark_Ul);
			tmp_switchObj = $("#" + parentNode.tId + IDMark_Switch);
			tmp_icoObj = $("#" + parentNode.tId + IDMark_Icon);
			replaceSwitchClass(tmp_switchObj, FolderMark_Docu);
			replaceIcoClass(parentNode, tmp_icoObj, FolderMark_Docu);
			tmp_ulObj.css("display", "none");

		} else if (setting.showLine && parentNode[setting.nodesCol].length > 0) {
			//ԭ���ڸ��ڵ����ӽڵ�
			parentNode[setting.nodesCol][parentNode[setting.nodesCol].length - 1].isLastNode = true;
			parentNode[setting.nodesCol][parentNode[setting.nodesCol].length - 1].isFirstNode = (parentNode[setting.nodesCol].length == 1);
			tmp_ulObj = $("#" + parentNode[setting.nodesCol][parentNode[setting.nodesCol].length - 1].tId + IDMark_Ul);
			tmp_switchObj = $("#" + parentNode[setting.nodesCol][parentNode[setting.nodesCol].length - 1].tId + IDMark_Switch);
			tmp_icoObj = $("#" + parentNode[setting.nodesCol][parentNode[setting.nodesCol].length - 1].tId + IDMark_Icon);
			if (parentNode == setting.root) {
				if (parentNode[setting.nodesCol].length == 1) {
					//ԭΪ���ڵ� �����ƶ���ֻ��һ�����ڵ�
					replaceSwitchClass(tmp_switchObj, LineMark_Root);
				} else {
					var tmp_first_switchObj = $("#" + parentNode[setting.nodesCol][0].tId + IDMark_Switch);
					replaceSwitchClass(tmp_first_switchObj, LineMark_Roots);
					replaceSwitchClass(tmp_switchObj, LineMark_Bottom);
				}
			} else {
				replaceSwitchClass(tmp_switchObj, LineMark_Bottom);
			}

			tmp_ulObj.removeClass(LineMark_Line);
		}
	}

	//���� tId ��ȡ �ڵ�����ݶ���
	function getTreeNodeByTId(setting, treeId) {
		return zTreeNodeCache[setting.treeObjId][treeId];
	}
	function addCache(setting, treeNode) {
		zTreeNodeCache[setting.treeObjId][treeNode.tId] = treeNode;
	}
	function removeCache(setting, treeNode) {
		delete zTreeNodeCache[setting.treeObjId][treeNode.tId];
	}
	//����Ψһ���� ��ȡ �ڵ�����ݶ���
	function getTreeNodeByParam(setting, treeNodes, key, value) {
		if (!treeNodes || !key) return null;
		for (var i = 0, l = treeNodes.length; i < l; i++) {
			if (treeNodes[i][key] == value) {
				return treeNodes[i];
			}
			var tmp = getTreeNodeByParam(setting, treeNodes[i][setting.nodesCol], key, value);
			if (tmp) return tmp;
		}
		return null;
	}
	//�������� ��ȡ �ڵ�����ݶ��󼯺�
	function getTreeNodesByParam(setting, treeNodes, key, value) {
		if (!treeNodes || !key) return [];
		var result = [];
		for (var i = 0, l = treeNodes.length; i < l; i++) {
			if (treeNodes[i][key] == value) {
				result.push(treeNodes[i]);
			}
			result = result.concat(getTreeNodesByParam(setting, treeNodes[i][setting.nodesCol], key, value));
		}
		return result;
	}
	//�������� ģ��������ȡ �ڵ�����ݶ��󼯺ϣ�����String��
	function getTreeNodesByParamFuzzy(setting, treeNodes, key, value) {
		if (!treeNodes || !key) return [];
		var result = [];
		for (var i = 0, l = treeNodes.length; i < l; i++) {
			if (typeof treeNodes[i][key] == "string" && treeNodes[i][key].indexOf(value)>-1) {
				result.push(treeNodes[i]);
			}
			result = result.concat(getTreeNodesByParamFuzzy(setting, treeNodes[i][setting.nodesCol], key, value));
		}
		return result;
	}
	
	//���ýڵ�Ϊ��ǰѡ�нڵ�
	function selectNode(setting, treeNode) {
		if (setting.curTreeNode == treeNode && ((setting.curEditTreeNode == treeNode && treeNode.editNameStatus))) {return;}
		st.cancelPreEditNode(setting);
		st.cancelPreSelectedNode(setting);
			
		if (setting.editable && treeNode.editNameStatus) {
			$("#" + treeNode.tId + IDMark_Span).html("<input type=text class='rename' id='" + treeNode.tId + IDMark_Input + "' treeNode" + IDMark_Input + " >");
			
			var inputObj = $("#" + treeNode.tId + IDMark_Input);
			setting.curEditInput = inputObj;
			inputObj.attr("value", treeNode[setting.nameCol]);
			tools.inputFocus(inputObj);
			
			//����A��click dblclick����
			inputObj.bind('blur', function(event) {
				if (st.checkEvent(setting)) {
					treeNode.editNameStatus = false;
					selectNode(setting, treeNode);
				}
			}).bind('keyup', function(event) {
				if (event.keyCode=="13") {
					if (st.checkEvent(setting)) {
						treeNode.editNameStatus = false;
						selectNode(setting, treeNode);
					}
				} else if (event.keyCode=="27") {
					inputObj.attr("value", treeNode[setting.nameCol]);
					treeNode.editNameStatus = false;
					selectNode(setting, treeNode);
				}
			}).bind('click', function(event) {
				return false;
			}).bind('dblclick', function(event) {
				return false;
			});
			
			$("#" + treeNode.tId + IDMark_A).addClass(Class_CurSelectedNode_Edit);
			setting.curEditTreeNode = treeNode;
		} else {
			$("#" + treeNode.tId + IDMark_A).addClass(Class_CurSelectedNode);
		}
		addTreeDom(setting, treeNode);
		setting.curTreeNode = treeNode;
	}
	
	//��ȡȫ�� checked = true or false �Ľڵ㼯��
	function getTreeCheckedNodes(setting, treeNodes, checked) {
		if (!treeNodes) return [];
		var results = [];
		for (var i = 0, l = treeNodes.length; i < l; i++) {
			if (treeNodes[i].nocheck !== true && treeNodes[i][setting.checkedCol] == checked) {
				results = results.concat([treeNodes[i]]);
			}
			var tmp = getTreeCheckedNodes(setting, treeNodes[i][setting.nodesCol], checked);
			if (tmp.length > 0) results = results.concat(tmp);
		}
		return results;
	}
	
	//��ȡȫ�� ���޸�Check״̬ �Ľڵ㼯��
	function getTreeChangeCheckedNodes(setting, treeNodes) {
		if (!treeNodes) return [];
		var results = [];
		for (var i = 0, l = treeNodes.length; i < l; i++) {
			if (treeNodes[i].nocheck !== true && treeNodes[i][setting.checkedCol] != treeNodes[i].checkedOld) {
				results = results.concat([treeNodes[i]]);
			}
			var tmp = getTreeChangeCheckedNodes(setting, treeNodes[i][setting.nodesCol]);
			if (tmp.length > 0) results = results.concat(tmp);
		}
		return results;
	}
	
	//��Ҫ����ת��Ϊ��׼JSON����
	function transformTozTreeFormat(setting, simpleTreeNodes) {
		var i,l;
		var key = setting.treeNodeKey;
		var parentKey = setting.treeNodeParentKey;
		if (!key || key=="" || !simpleTreeNodes) return [];
		
		if (tools.isArray(simpleTreeNodes)) {
			var r = [];
			var tmpMap = [];
			for (i=0, l=simpleTreeNodes.length; i<l; i++) {
				tmpMap[simpleTreeNodes[i][key]] = simpleTreeNodes[i];
			}
			for (i=0, l=simpleTreeNodes.length; i<l; i++) {
				if (tmpMap[simpleTreeNodes[i][parentKey]]) {
					if (!tmpMap[simpleTreeNodes[i][parentKey]][setting.nodesCol])
						tmpMap[simpleTreeNodes[i][parentKey]][setting.nodesCol] = [];
					tmpMap[simpleTreeNodes[i][parentKey]][setting.nodesCol].push(simpleTreeNodes[i]);
				} else {
					r.push(simpleTreeNodes[i]);
				}
			}
			return r;
		}else {
			return [simpleTreeNodes];
		}
	}
	
	//��׼JSON zTreeNode ����ת��Ϊ��ͨArray��Ҫ����
	function transformToArrayFormat(setting, treeNodes) {
		if (!treeNodes) return [];
		var r = [];
		if (tools.isArray(treeNodes)) {
			for (var i=0, l=treeNodes.length; i<l; i++) {
				r.push(treeNodes[i]);
				if (treeNodes[i][setting.nodesCol])
					r = r.concat(transformToArrayFormat(setting, treeNodes[i][setting.nodesCol]));
			}
		} else {
			r.push(treeNodes);
			if (treeNodes[setting.nodesCol])
				r = r.concat(transformToArrayFormat(setting, treeNodes[setting.nodesCol]));
		}
		return r;
	}

	function zTreePlugin(){
		return {
			container:null,
			setting:null,

			init: function(obj) {
				this.container = obj;
				this.setting = settings[obj.attr("id")];
				return this;
			},

			refresh : function() {
				this.setting.treeObj.empty();
				zTreeNodeCache[this.setting.treeObjId] = [];
				this.setting.curTreeNode = null;
				this.setting.curEditTreeNode = null;
				this.setting.dragStatus = 0;
				this.setting.dragNodeShowBefore = false;
				this.setting.checkRadioCheckedList = [];
				initTreeNodes(this.setting, 0, this.setting.root[this.setting.nodesCol]);
			},

			setEditable : function(editable) {
				this.setting.editable = editable;
				return this.refresh();
			},
			
			transformTozTreeNodes : function(simpleTreeNodes) {
				return transformTozTreeFormat(this.setting, simpleTreeNodes);
			},
			
			transformToArray : function(treeNodes) {
				return transformToArrayFormat(this.setting, treeNodes);
			},

			getNodes : function() {
				return this.setting.root[this.setting.nodesCol];
			},

			getSelectedNode : function() {
				return this.setting.curTreeNode;
			},

			getCheckedNodes : function(checked) {
				checked = (checked != false);
				return getTreeCheckedNodes(this.setting, this.setting.root[this.setting.nodesCol], checked);
			},
			
			getChangeCheckedNodes : function() {
				return getTreeChangeCheckedNodes(this.setting, this.setting.root[this.setting.nodesCol]);
			},

			getNodeByTId : function(treeId) {
				if (!treeId) return null;
				return getTreeNodeByTId(this.setting, treeId);
			},
			getNodeByParam : function(key, value) {
				if (!key) return null;
				return getTreeNodeByParam(this.setting, this.setting.root[this.setting.nodesCol], key, value);
			},
			getNodesByParam : function(key, value) {
				if (!key) return null;
				return getTreeNodesByParam(this.setting, this.setting.root[this.setting.nodesCol], key, value);
			},
			getNodesByParamFuzzy : function(key, value, parentNode) {
				if (!key) return null;
				return getTreeNodesByParamFuzzy(this.setting, parentNode?parentNode[this.setting.nodesCol]:this.setting.root[this.setting.nodesCol], key, value);
			},
			
			getNodeIndex : function(treeNode) {
				if (!treeNode) return null;
				var parentNode = (treeNode.parentNode == null) ? this.setting.root : treeNode.parentNode;
				for (var i=0, l = parentNode[this.setting.nodesCol].length; i < l; i++) {
					if (parentNode[this.setting.nodesCol][i] == treeNode) return i;
				}
				return -1;
			},
			
			getSetting : function() {
				var zTreeSetting = this.setting;
				var setting = {
					checkType:{}, 
					callback:{}
				};
				
				var tmp_checkType = zTreeSetting.checkType;
				zTreeSetting.checkType = undefined;
				var tmp_callback = zTreeSetting.callback;
				zTreeSetting.callback = undefined;
				var tmp_root = zTreeSetting.root;
				zTreeSetting.root = undefined;
				
				$.extend(setting, zTreeSetting);
				
				zTreeSetting.checkType = tmp_checkType;				
				zTreeSetting.callback = tmp_callback;				
				zTreeSetting.root = tmp_root;				

				//���ܻ�ȡroot��Ϣ
				$.extend(true, setting.checkType, tmp_checkType);
				$.extend(setting.callback, tmp_callback);
				
				return setting;
			},
			
			updateSetting : function(zTreeSetting) {
				if (!zTreeSetting) return;
				var setting = this.setting;
				var treeObjId = setting.treeObjId;
				
				var tmp_checkType = zTreeSetting.checkType;
				zTreeSetting.checkType = undefined;
				var tmp_callback = zTreeSetting.callback;
				zTreeSetting.callback = undefined;
				var tmp_root = zTreeSetting.root;
				zTreeSetting.root = undefined;
				
				$.extend(setting, zTreeSetting);
				
				zTreeSetting.checkType = tmp_checkType;
				zTreeSetting.callback = tmp_callback;
				zTreeSetting.root = tmp_root;
				
				//���ṩroot��Ϣupdate
				$.extend(true, setting.checkType, tmp_checkType);
				$.extend(setting.callback, tmp_callback);
				setting.treeObjId = treeObjId;
				setting.treeObj = this.container;
				
			},

			expandAll : function(expandSign) {
				expandCollapseSonNode(this.setting, null, expandSign, true);
			},

			expandNode : function(treeNode, expandSign, sonSign, focus) {
				if (!treeNode) return;

				if (expandSign) {
					//���չ��ĳ�ڵ㣬�����չ����ȫ�����ڵ�
					//Ϊ�˱�֤Ч��,չ�����ڵ�ʱ��ʹ�ö���
					if (treeNode.parentNode) expandCollapseParentNode(this.setting, treeNode.parentNode, expandSign, false);
				}
				if (sonSign) {
					//���ͼ��ͬʱ���ж��������²������ӳٺ����ô���׼ȷ���񶯻����ս���ʱ��
					//���Ϊ�˱�֤׼ȷ���ڵ�focus���ж�λ�������js�����ڵ�ʱ�������ж���
					expandCollapseSonNode(this.setting, treeNode, expandSign, false, function() {
						if (focus !== false) {$("#" + treeNode.tId + IDMark_Icon).focus().blur();}
					});
				} else if (treeNode.open != expandSign) {
					switchNode(this.setting, treeNode);
					if (focus !== false) {$("#" + treeNode.tId + IDMark_Icon).focus().blur();}
				}
			},

			selectNode : function(treeNode) {
				if (!treeNode) return;

				if (st.checkEvent(this.setting)) {
					selectNode(this.setting, treeNode);
					//���ѡ��ĳ�ڵ㣬�����չ����ȫ�����ڵ�
					//���ͼ��ͬʱ���ж��������²������ӳٺ����ô���׼ȷ���񶯻����ս���ʱ��
					//���Ϊ�˱�֤׼ȷ���ڵ�focus���ж�λ�������js�����ڵ�ʱ�������ж���
					if (treeNode.parentNode) {
						expandCollapseParentNode(this.setting, treeNode.parentNode, true, false, function() {
							$("#" + treeNode.tId + IDMark_Icon).focus().blur();
						});
					} else {
						$("#" + treeNode.tId + IDMark_Icon).focus().blur();
					}
				}
			},
			
			cancleSelectedNode : function() {
				this.cancelSelectedNode();
			},
			cancelSelectedNode : function() {
				st.cancelPreSelectedNode(this.setting);
			},
			
			checkAllNodes : function(checked) {
				repairAllChk(this.setting, checked);
			},
			
			reAsyncChildNodes : function(parentNode, reloadType) {
				if (!this.setting.async) return;
				var isRoot = !parentNode;
				if (isRoot) {
					parentNode = this.setting.root;
				}
				if (reloadType=="refresh") {
					parentNode[this.setting.nodesCol] = [];
					if (isRoot) {
						this.setting.treeObj.empty();
					} else {
						var ulObj = $("#" + parentNode.tId + IDMark_Ul);
						ulObj.empty();
					}
				}
				asyncGetNode(this.setting, isRoot? null:parentNode);
			},

			addNodes : function(parentNode, newNodes, isSilent) {
				if (!newNodes) return;
				if (!parentNode) parentNode = null;
				var xNewNodes = tools.isArray(newNodes)? newNodes: [newNodes];
				addTreeNodes(this.setting, parentNode, xNewNodes, (isSilent==true));
			},
			inputNodeName: function(treeNode) {
				if (!treeNode) return;
				if (st.checkEvent(this.setting)) {
					editTreeNode(this.setting, treeNode)
				}
			},
			cancelInput: function(newName) {
				if (!this.setting.curEditTreeNode) return;
				var treeNode = this.setting.curEditTreeNode;
				st.cancelPreEditNode(this.setting, newName?newName:treeNode[this.setting.nameCol]);
				this.selectNode(treeNode);
			},
			updateNode : function(treeNode, checkTypeFlag) {
				if (!treeNode) return;
				if (st.checkEvent(this.setting)) {
					var checkObj = $("#" + treeNode.tId + IDMark_Check);
					if (this.setting.checkable) {
						if (checkTypeFlag == true) checkNodeRelation(this.setting, treeNode);
						setChkClass(this.setting, checkObj, treeNode);
						repairParentChkClassWithSelf(this.setting, treeNode);
					}
					setNodeName(this.setting, treeNode);
					setNodeTarget(treeNode);
					setNodeUrl(this.setting, treeNode);
					setNodeLineIcos(this.setting, treeNode);
					setNodeFontCss(this.setting, treeNode);
				}
			},

			moveNode : function(targetNode, treeNode, moveType) {
				if (!treeNode) return;
				
				if (targetNode && ((treeNode.parentNode == targetNode && moveType == MoveType_Inner) || $("#" + treeNode.tId).find("#" + targetNode.tId).length > 0)) {
					return;
				} else if (!targetNode) {
					targetNode = null;
				}
				moveTreeNode(this.setting, targetNode, treeNode, moveType, false);
			},

			copyNode : function(targetNode, treeNode, moveType) {
				if (!treeNode) return null;
				var newNode = tools.clone(treeNode);
				if (!targetNode) {
					targetNode = null;
					moveType = MoveType_Inner;
				}
				if (moveType == MoveType_Inner) {
					addTreeNodes(this.setting, targetNode, [newNode]);
				} else {
					addTreeNodes(this.setting, targetNode.parentNode, [newNode]);
					moveTreeNode(this.setting, targetNode, newNode, moveType, false);
				}
				return newNode;
			},

			removeNode : function(treeNode) {
				if (!treeNode) return;
				removeTreeNode(this.setting, treeNode);
			}
		};
	}
})(jQuery);