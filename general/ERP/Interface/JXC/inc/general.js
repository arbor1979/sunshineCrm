function emptyCheck(fldName, fldLabel, fldType) {
	var fldObj = document.getElementById(fldName);
	if (fldType == "text") {
		if (fldObj.value.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0) {
			alert( '"' + fldLabel + '"����Ϊ�ա�');
			fldObj.focus();
			return false;
		}
	}else {
		if (fldObj.value == ""){
			alert('"' + fldLabel+ '"����Ϊ�ա�');
			return false;
		}
	}
	return true;
}

function patternValidate(fldName, fldLabel, type) {
	var fldObj = document.getElementById(fldName);
	
	if (type.toUpperCase() == 'NUMBER') {
		var re = new RegExp(/^[1-9]\d*$/);
	}

	if (type.toUpperCase() == 'EMAIL')  {
	}

	if (type.toUpperCase() == 'DATE')   {
	}

	var value = fldObj.value.replace(/^\s+/g, '').replace(/\s+$/g, '');
	if (value == "")
	{
		fldObj.value = "";
		return true;
	}

	if (!re.test(value))	{
		alert('������"' + fldLabel + '"����Чֵ��');
		return false;
	}
	else {
		return true;
	}
}