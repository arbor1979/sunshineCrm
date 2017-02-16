var lunarInfo = new Array(
        0x4bd8, 0x4ae0, 0xa570, 0x54d5, 0xd260, 0xd950, 0x5554, 0x56af, 0x9ad0, 0x55d2,
        0x4ae0, 0xa5b6, 0xa4d0, 0xd250, 0xd255, 0xb54f, 0xd6a0, 0xada2, 0x95b0, 0x4977,
        0x497f, 0xa4b0, 0xb4b5, 0x6a50, 0x6d40, 0xab54, 0x2b6f, 0x9570, 0x52f2, 0x4970,
        0x6566, 0xd4a0, 0xea50, 0x6a95, 0x5adf, 0x2b60, 0x86e3, 0x92ef, 0xc8d7, 0xc95f,
        0xd4a0, 0xd8a6, 0xb55f, 0x56a0, 0xa5b4, 0x25df, 0x92d0, 0xd2b2, 0xa950, 0xb557,
        0x6ca0, 0xb550, 0x5355, 0x4daf, 0xa5b0, 0x4573, 0x52bf, 0xa9a8, 0xe950, 0x6aa0,
        0xaea6, 0xab50, 0x4b60, 0xaae4, 0xa570, 0x5260, 0xf263, 0xd950, 0x5b57, 0x56a0,
        0x96d0, 0x4dd5, 0x4ad0, 0xa4d0, 0xd4d4, 0xd250, 0xd558, 0xb540, 0xb6a0, 0x95a6,
        0x95bf, 0x49b0, 0xa974, 0xa4b0, 0xb27a, 0x6a50, 0x6d40, 0xaf46, 0xab60, 0x9570,
        0x4af5, 0x4970, 0x64b0, 0x74a3, 0xea50, 0x6b58, 0x5ac0, 0xab60, 0x96d5, 0x92e0,
        0xc960, 0xd954, 0xd4a0, 0xda50, 0x7552, 0x56a0, 0xabb7, 0x25d0, 0x92d0, 0xcab5,
        0xa950, 0xb4a0, 0xbaa4, 0xad50, 0x55d9, 0x4ba0, 0xa5b0, 0x5176, 0x52bf, 0xa930,
        0x7954, 0x6aa0, 0xad50, 0x5b52, 0x4b60, 0xa6e6, 0xa4e0, 0xd260, 0xea65, 0xd530,
        0x5aa0, 0x76a3, 0x96d0, 0x4afb, 0x4ad0, 0xa4d0, 0xd0b6, 0xd25f, 0xd520, 0xdd45,
        0xb5a0, 0x56d0, 0x55b2, 0x49b0, 0xa577, 0xa4b0, 0xaa50, 0xb255, 0x6d2f, 0xada0,
        0x4b63, 0x937f, 0x49f8, 0x4970, 0x64b0, 0x68a6, 0xea5f, 0x6b20, 0xa6c4, 0xaaef,
        0x92e0, 0xd2e3, 0xc960, 0xd557, 0xd4a0, 0xda50, 0x5d55, 0x56a0, 0xa6d0, 0x55d4,
        0x52d0, 0xa9b8, 0xa950, 0xb4a0, 0xb6a6, 0xad50, 0x55a0, 0xaba4, 0xa5b0, 0x52b0,
        0xb273, 0x6930, 0x7337, 0x6aa0, 0xad50, 0x4b55, 0x4b6f, 0xa570, 0x54e4, 0xd260,
        0xe968, 0xd520, 0xdaa0, 0x6aa6, 0x56df, 0x4ae0, 0xa9d4, 0xa4d0, 0xd150, 0xf252,
        0xd520);

var solarMonth = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
var Gan = new Array("��", "��", "��", "��", "��", "��", "��", "��", "��", "��");
var Zhi = new Array("��", "��", "��", "î", "��", "��", "��", "δ", "��", "��", "��", "��");
var Animals = new Array("��", "ţ", "��", "��", "��", "��", "��", "��", "��", "��", "��", "��");
var solarTerm = new Array("С��", "��", "����", "��ˮ", "����", "����", "����", "����", "����", "С��", "â��", "����", "С��", "����", "����", "����", "��¶", "���", "��¶", "˪��", "����", "Сѩ", "��ѩ", "����")
var sTermInfo = new Array(0, 21208, 42467, 63836, 85337, 107014, 128867, 150921, 173149, 195551, 218072, 240693, 263343, 285989, 308563, 331033, 353350, 375494, 397447, 419210, 440795, 462224, 483532, 504758)
var nStr1 = new Array('��', 'һ', '��', '��', '��', '��', '��', '��', '��', '��', 'ʮ')
var nStr2 = new Array('��', 'ʮ', 'إ', 'ئ', ' ')

var jcName0 = new Array('��', '��', '��', 'ƽ', '��', 'ִ', '��', 'Σ', '��', '��', '��', '��');
var jcName1 = new Array('��', '��', '��', '��', 'ƽ', '��', 'ִ', '��', 'Σ', '��', '��', '��');
var jcName2 = new Array('��', '��', '��', '��', '��', 'ƽ', '��', 'ִ', '��', 'Σ', '��', '��');
var jcName3 = new Array('��', '��', '��', '��', '��', '��', 'ƽ', '��', 'ִ', '��', 'Σ', '��');
var jcName4 = new Array('��', '��', '��', '��', '��', '��', '��', 'ƽ', '��', 'ִ', '��', 'Σ');
var jcName5 = new Array('Σ', '��', '��', '��', '��', '��', '��', '��', 'ƽ', '��', 'ִ', '��');
var jcName6 = new Array('��', 'Σ', '��', '��', '��', '��', '��', '��', '��', 'ƽ', '��', 'ִ');
var jcName7 = new Array('ִ', '��', 'Σ', '��', '��', '��', '��', '��', '��', '��', 'ƽ', '��');
var jcName8 = new Array('��', 'ִ', '��', 'Σ', '��', '��', '��', '��', '��', '��', '��', 'ƽ');
var jcName9 = new Array('ƽ', '��', 'ִ', '��', 'Σ', '��', '��', '��', '��', '��', '��', '��');
var jcName10 = new Array('��', 'ƽ', '��', 'ִ', '��', 'Σ', '��', '��', '��', '��', '��', '��');
var jcName11 = new Array('��', '��', 'ƽ', '��', 'ִ', '��', 'Σ', '��', '��', '��', '��', '��');

function jcr(d) {
    var jcrjx;
    if (d == '��') jcrjx = '<span style="vertical-align:middle; margin:1px; font-size:12px"><img src="images/yi.gif"/></span>&nbsp;����.����.����.����.����<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;����.����.��Ȣ.�ɲ�';
    if (d == '��') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;����.�Ʋ�.����.��ж.��լ<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;���.����.����.���.̽��';
    if (d == '��') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;��.����.����.����.����<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;��ҩ.��ҽ.����.����.Ǩ��';
    if (d == 'ƽ') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;����.����.Ϳ��.������ȡ<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;����.��լ.��Ȣ.����.����';
    if (d == '��') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;��.��ȯ.����.ǩԼ.����<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;��ֲ.��ҵ.����.��.�촬';
    if (d == 'ִ') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;��.����.����.���.��Լ<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;����.����.���.Զ��';
    if (d == '��') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;��ҽ.����.����.������ȡ<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;����.����.����.����.����';
    if (d == 'Σ') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;��Ӫ.����.���.����.����<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;�Ǹ�.�д�.����.��լ.����';
    if (d == '��') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;��.��ѧ.����.��ҽ.�ɷ�<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;����.����.����';
    if (d == '��') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;����.���.ǩԼ.��Ȣ.����<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;����.����.����.��լ.����';
    if (d == '��') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;�Ʋ�.���.����.���.��ְ<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;����.����.���';
    if (d == '��') jcrjx = '<span style="vertical-align:middle; margin:1px;"><img src="images/yi.gif"/></span>&nbsp;����.����.�ղ�.����<br><br><span style="vertical-align:middle; margin:1px;"><img src="images/ji.gif"/></span>&nbsp;���.����.����.��Ȣ.����';
    return(jcrjx);
}

//��������  *��ʾ�ż���
var sFtv = new Array(
        "0101*Ԫ��",
        "0106  �й�13���˿���",
        "0110  �й�110������",

        "0202  ����ʪ����",
        "0204  ���翹��֢��",
        "0210  ����������",
        "0214  ���˽�",
        "0221  ����ĸ����",
        "0207  ������Ԯ�Ϸ���",

        "0303  ȫ��������",
        "0308  ��Ů��",
        "0312  ֲ���� ����ɽ����������",
        "0315  ������Ȩ�汣����",
        "0321  ����ɭ����",
        "0322  ����ˮ��",
        "0323  ����������",
        "0324  ������ν�˲���",

        "0401  ���˽�",
        "0407  ����������",
        "0422  ���������",

        "0501*�����Ͷ���",
        "0504  �й������",
        "0505  ȫ����ȱ������",
        "0508  �����ʮ����",
        "0512  ���ʻ�ʿ��",
        "0515  ���ʼ�ͥ��",
        "0517  ���������",
        "0518  ���ʲ������",
        "0519  �й��봨���𰧵��� ȫ��������",
        "0520  ȫ��ѧ��Ӫ����",
        "0522  ���������������",
        "0523  ����ţ����",
        "0531  ����������",

        "0601  ���ʶ�ͯ��",
        "0605  ���绷����",
        "0606  ȫ��������",
        "0617  ���λ�Į���͸ɺ���",
        "0623  ���ʰ���ƥ����",
        "0625  ȫ��������",
        "0626  ���ʷ���Ʒ��",

        "0701  ������ ��ۻع������",
        "0707  ����ս��������",
        "0711  �����˿���",

        "0801  ��һ������",
        "0815  �ձ���ʽ����������Ͷ����",

        "0908  ����ɨä��",
        "0909  ë������������",
        "0910  ��ʦ��",
        "0916  ���ʳ����㱣����",
        "0917  ���ʺ�ƽ��",
        "0918  �š�һ���±������",
        "0920  ���ʰ�����",
        "0927  ����������",
        "0928  ���ӵ���",

        "1001*����� �������ֽ� �������˽�",
        "1002  ���ʼ�����Ȼ�ֺ���",
        "1004  ���綯����",
        "1007  ����ס����",
        "1008  �����Ӿ��� ȫ����Ѫѹ��",
        "1009  ����������",
        "1010  �������������� ���羫��������",
        "1015  ����ä�˽�",
        "1016  ������ʳ��",
        "1017  ��������ƶ����",
        "1022  ���紫ͳҽҩ��",
        "1024  ���Ϲ���",
        "1025  �����컨������",
        "1026  ��������",
        "1031  ��ʥ��",

        "1107  ʮ������������������",
        "1108  �й�������",
        "1109  ����������",
        "1110  ���������",
        "1112  ����ɽ����",
        "1114  ����������",
        "1117  ���ʴ�ѧ����",

        "1201  ���簬�̲���",
        "1203  ����м�����",
        "1209  ����������",
        "1210  ������Ȩ��",
        "1212  �����±������",
        "1213  �Ͼ�����ɱ",
        "1220  ���Żع������",
        "1221  ����������",
        "1224  ƽ��ҹ",
        "1225  ʥ���� ����ǿ��������",
        "1226  ë�󶫵���")
//ũ������  *��ʾ�ż���
var lFtv = new Array(
        "0101*����",
        "0102*�������",
        "0103*�������",
        "0105  ·������",
        "0115  Ԫ����",
        "0202  ��̧ͷ",
        "0219  ������ʥ��",
        "0404  ��ʳ��",
        "0408  �𵮽� ",
        "0505*�����",
        "0606  ���ܽ� �ùý�",
        "0624  �����ѽ�",
        "0707  ��Ϧ���˽�",
        "0714  ���(�Ϸ�)",
        "0715  ������",
        "0730  �زؽ�",
        "0815*�����",
        "0909  ������",
        "1001  �����",
        "1117  �����ӷ�ʥ��",
        "1208  ���˽� ���������ɵ���",
        "1223  ��С��",
        "0100*��Ϧ");
//ĳ�µĵڼ������ڼ�; 5,6,7,8 ��ʾ������ 1,2,3,4 �����ڼ�
var wFtv = new Array(
        "0110  ���˽�",
        "0150  ���������",
        "0121  �ձ����˽�",
        "0520  ĸ�׽�",
        "0530  ȫ��������",
        "0630  ���׽�",
        "0716  ������",
        "0730  ��ū�۹�����",
        "0932  ���ʺ�ƽ��",
        "0940  �������˽� �����ͯ��",
        "1011  ����ס����",
        "1144  �ж���")

/*****************************************************************************
 ���ڼ���
 *****************************************************************************/

//====================================== ����ũ�� y���������
function lYearDays(y) {
    var i, sum = 348;
    for (i = 0x8000; i > 0x8; i >>= 1) sum += (lunarInfo[y - 1900] & i) ? 1 : 0;
    return(sum + leapDays(y));
}

//====================================== ����ũ�� y�����µ�����
function leapDays(y) {
    if (leapMonth(y)) return( (lunarInfo[y - 1899] & 0xf) == 0xf ? 30 : 29);
    else return(0);
}

//====================================== ����ũ�� y�����ĸ��� 1-12 , û�򷵻� 0
function leapMonth(y) {
    var lm = lunarInfo[y - 1900] & 0xf;
    return(lm == 0xf ? 0 : lm);
}

//====================================== ����ũ�� y��m�µ�������
function monthDays(y, m) {
    return( (lunarInfo[y - 1900] & (0x10000 >> m)) ? 30 : 29 );
}

//====================================== ���ũ��, �������ڿؼ�, ����ũ�����ڿؼ�
//                                       �ÿؼ������� .year .month .day .isLeap
function Lunar(objDate) {

    var i, leap = 0, temp = 0;
    var offset = (Date.UTC(objDate.getFullYear(), objDate.getMonth(), objDate.getDate()) - Date.UTC(1900, 0, 31)) / 86400000;

    for (i = 1900; i < 2100 && offset > 0; i++) {
        temp = lYearDays(i);
        offset -= temp;
    }

    if (offset < 0) {
        offset += temp;
        i--;
    }

    this.year = i;

    leap = leapMonth(i); //���ĸ���
    this.isLeap = false;

    for (i = 1; i < 13 && offset > 0; i++) {
        //����
        if (leap > 0 && i == (leap + 1) && this.isLeap == false) {
            --i;
            this.isLeap = true;
            temp = leapDays(this.year);
        }
        else {
            temp = monthDays(this.year, i);
        }

        //�������
        if (this.isLeap == true && i == (leap + 1)) this.isLeap = false;

        offset -= temp;
    }

    if (offset == 0 && leap > 0 && i == leap + 1)
        if (this.isLeap) {
            this.isLeap = false;
        }
        else {
            this.isLeap = true;
            --i;
        }

    if (offset < 0) {
        offset += temp;
        --i;
    }

    this.month = i;
    this.day = offset + 1;
}

//==============================���ع��� y��ĳm+1�µ�����
function solarDays(y, m) {
    if (m == 1)
        return(((y % 4 == 0) && (y % 100 != 0) || (y % 400 == 0)) ? 29 : 28);
    else
        return(solarMonth[m]);
}
//============================== ���� offset ���ظ�֧, 0=����
function cyclical(num) {
    return(Gan[num % 10] + Zhi[num % 12]);
}

//============================== ��������
function calElement(sYear, sMonth, sDay, week, lYear, lMonth, lDay, isLeap, cYear, cMonth, cDay) {

    this.isToday = false;
    //���
    this.sYear = sYear;   //��Ԫ��4λ����
    this.sMonth = sMonth;  //��Ԫ������
    this.sDay = sDay;    //��Ԫ������
    this.week = week;    //����, 1������
    //ũ��
    this.lYear = lYear;   //��Ԫ��4λ����
    this.lMonth = lMonth;  //ũ��������
    this.lDay = lDay;    //ũ��������
    this.isLeap = isLeap;  //�Ƿ�Ϊũ������?
    //����
    this.cYear = cYear;   //����, 2������
    this.cMonth = cMonth;  //����, 2������
    this.cDay = cDay;    //����, 2������

    this.color = '';

    this.lunarFestival = ''; //ũ������
    this.solarFestival = ''; //��������
    this.solarTerms = ''; //����
}

//===== ĳ��ĵ�n������Ϊ����(��0С������)
function sTerm(y, n) {
    var offDate = new Date(( 31556925974.7 * (y - 1900) + sTermInfo[n] * 60000  ) + Date.UTC(1900, 0, 6, 2, 5));
    return(offDate.getUTCDate());
}

//============================== �������� (y��,m+1��)
function cyclical6(num, num2) {
    if (num == 0) return(jcName0[num2]);
    if (num == 1) return(jcName1[num2]);
    if (num == 2) return(jcName2[num2]);
    if (num == 3) return(jcName3[num2]);
    if (num == 4) return(jcName4[num2]);
    if (num == 5) return(jcName5[num2]);
    if (num == 6) return(jcName6[num2]);
    if (num == 7) return(jcName7[num2]);
    if (num == 8) return(jcName8[num2]);
    if (num == 9) return(jcName9[num2]);
    if (num == 10) return(jcName10[num2]);
    if (num == 11) return(jcName11[num2]);
}
function CalConv2(yy, mm, dd, y, d, m, dt, nm, nd) {
    var dy = d + '' + dd
    if ((yy == 0 && dd == 6) || (yy == 6 && dd == 0) || (yy == 1 && dd == 7) || (yy == 7 && dd == 1) || (yy == 2 && dd == 8) || (yy == 8 && dd == 2) || (yy == 3 && dd == 9) || (yy == 9 && dd == 3) || (yy == 4 && dd == 10) || (yy == 10 && dd == 4) || (yy == 5 && dd == 11) || (yy == 11 && dd == 5)) {
        return '<FONT color=#0000A0>��ֵ���� ���²���</font>';
    }
    else if ((mm == 0 && dd == 6) || (mm == 6 && dd == 0) || (mm == 1 && dd == 7) || (mm == 7 && dd == 1) || (mm == 2 && dd == 8) || (mm == 8 && dd == 2) || (mm == 3 && dd == 9) || (mm == 9 && dd == 3) || (mm == 4 && dd == 10) || (mm == 10 && dd == 4) || (mm == 5 && dd == 11) || (mm == 11 && dd == 5)) {
        return '<FONT color=#0000A0>��ֵ���� ���²���</font>';
    }
    else if ((y == 0 && dy == '911') || (y == 1 && dy == '55') || (y == 2 && dy == '111') || (y == 3 && dy == '75') || (y == 4 && dy == '311') || (y == 5 && dy == '95') || (y == 6 && dy == '511') || (y == 7 && dy == '15') || (y == 8 && dy == '711') || (y == 9 && dy == '35')) {
        return '<FONT color=#0000A0>��ֵ��˷ ���²���</font>';
    }
    else if ((m == 1 && dt == 13) || (m == 2 && dt == 11) || (m == 3 && dt == 9) || (m == 4 && dt == 7) || (m == 5 && dt == 5) || (m == 6 && dt == 3) || (m == 7 && dt == 1) || (m == 7 && dt == 29) || (m == 8 && dt == 27) || (m == 9 && dt == 25) || (m == 10 && dt == 23) || (m == 11 && dt == 21) || (m == 12 && dt == 19)) {
        return '<FONT color=#0000A0>��ֵ�ʮ���� ���²���</font>';
    }
    else {
        return 0;
    }
}


function calendar(y, m) {

    var sDObj, lDObj, lY, lM, lD = 1, lL, lX = 0, tmp1, tmp2, lM2,lY2,lD2,tmp3,dayglus,bsg,xs,xs1,fs,fs1,cs,cs1
    var cY, cM, cD; //����,����,����
    var lDPOS = new Array(3);
    var n = 0;
    var firstLM = 0;

    sDObj = new Date(y, m, 1, 0, 0, 0, 0);    //����һ������

    this.length = solarDays(y, m);    //������������
    this.firstWeek = sDObj.getDay();    //��������1�����ڼ�

    ////////���� 1900��������Ϊ������(60����36)
    if (m < 2) cY = cyclical(y - 1900 + 36 - 1);
    else cY = cyclical(y - 1900 + 36);
    var term2 = sTerm(y, 2); //��������

    ////////���� 1900��1��С����ǰΪ ������(60����12)
    var firstNode = sTerm(y, m * 2) //���ص��¡��ڡ�Ϊ���տ�ʼ
    cM = cyclical((y - 1900) * 12 + m + 12);

    lM2 = (y - 1900) * 12 + m + 12;
    //����һ���� 1900/1/1 �������
    //1900/1/1�� 1970/1/1 ���25567��, 1900/1/1 ����Ϊ������(60����10)
    var dayCyclical = Date.UTC(y, m, 1, 0, 0, 0, 0) / 86400000 + 25567 + 10;

    for (var i = 0; i < this.length; i++) {

        if (lD > lX) {
            sDObj = new Date(y, m, i + 1);    //����һ������
            lDObj = new Lunar(sDObj);     //ũ��
            lY = lDObj.year;           //ũ����
            lM = lDObj.month;          //ũ����
            lD = lDObj.day;            //ũ����
            lL = lDObj.isLeap;         //ũ���Ƿ�����
            lX = lL ? leapDays(lY) : monthDays(lY, lM); //ũ���������һ��

            if (n == 0) firstLM = lM;
            lDPOS[n++] = i - lD + 1;
        }

        //�������������·ֵ�����, ������Ϊ��
        if (m == 1 && (i + 1) == term2) {
            cY = cyclical(y - 1900 + 36);
            lY2 = (y - 1900 + 36);
        }
        //����������, �ԡ��ڡ�Ϊ��
        if ((i + 1) == firstNode) {
            cM = cyclical((y - 1900) * 12 + m + 13);
            lM2 = (y - 1900) * 12 + m + 13;
        }
        //����
        cD = cyclical(dayCyclical + i);
        lD2 = (dayCyclical + i);

        this[i] = new calElement(y, m + 1, i + 1, nStr1[(i + this.firstWeek) % 7],
                lY, lM, lD++, lL,
                cY, cM, cD);


        this[i].sgz5 = CalConv2(lY2 % 12, lM2 % 12, (lD2) % 12, lY2 % 10, (lD2) % 10, lM, lD - 1, m + 1, cs1);
        this[i].sgz3 = cyclical6(lM2 % 12, (lD2) % 12);


    }

    //����
    tmp1 = sTerm(y, m * 2) - 1;
    tmp2 = sTerm(y, m * 2 + 1) - 1;
    this[tmp1].solarTerms = solarTerm[m * 2];
    this[tmp2].solarTerms = solarTerm[m * 2 + 1];
    if (m == 3) this[tmp1].color = 'red'; //������ɫ

    //��������
    for (i  in  sFtv)
        if (sFtv[i].match(/^(\d{2})(\d{2})([\s\*])(.+)$/))
            if (Number(RegExp.$1) == (m + 1)) {
                this[Number(RegExp.$2) - 1].solarFestival += RegExp.$4 + '  '
                if (RegExp.$3 == '*')  this[Number(RegExp.$2) - 1].color = 'red'
            }


    //ũ������
    for (i  in  lFtv)
        if (lFtv[i].match(/^(\d{2})(.{2})([\s\*])(.+)$/)) {
            tmp1 = Number(RegExp.$1) - firstLM
            if (tmp1 == -11)  tmp1 = 1
            if (tmp1 >= 0 && tmp1 < n) {
                tmp2 = lDPOS[tmp1] + Number(RegExp.$2) - 1
                if (tmp2 >= 0 && tmp2 < this.length) {
                    this[tmp2].lunarFestival += RegExp.$4 + '  '
                    if (RegExp.$3 == '*')  this[tmp2].color = 'red'
                }
            }
        }

    //�����ֻ������3��4��
    if (m == 2 || m == 3) {
        var estDay = new easter(y);
        if (m == estDay.m)
            this[estDay.d - 1].solarFestival = this[estDay.d - 1].solarFestival + ' �����(Easter Sunday)';
    }


    //��ɫ������
    if ((this.firstWeek + 12) % 7 == 5)
        this[12].solarFestival += '��ɫ������';

    //����
    if (y == tY && m == tM) this[tD - 1].isToday = true;
}

//======================================= ���ظ���ĸ����(���ֺ��һ�������ܺ�ĵ�һ����)
function easter(y) {

    var term2 = sTerm(y, 5); //ȡ�ô�������
    var dayTerm2 = new Date(Date.UTC(y, 2, term2, 0, 0, 0, 0)); //ȡ�ô��ֵĹ������ڿؼ�(����һ��������3��)
    var lDayTerm2 = new Lunar(dayTerm2); //ȡ��ȡ�ô���ũ��

    if (lDayTerm2.day < 15) //ȡ���¸���Բ���������
        var lMlen = 15 - lDayTerm2.day;
    else
        var lMlen = (lDayTerm2.isLeap ? leapDays(y) : monthDays(y, lDayTerm2.month)) - lDayTerm2.day + 15;

    //һ����� 1000*60*60*24 = 86400000 ����
    var l15 = new Date(dayTerm2.getTime() + 86400000 * lMlen); //�����һ����ԲΪ��������
    var dayEaster = new Date(l15.getTime() + 86400000 * ( 7 - l15.getUTCDay() )); //����¸�����

    this.m = dayEaster.getUTCMonth();
    this.d = dayEaster.getUTCDate();

}
//======================  ��������
function cDay(d) {
    var s;

    switch (d) {
        case  10:
            s = '��ʮ';  break;
        case  20:
            s = '��ʮ';  break;
            break;
        case  30:
            s = '��ʮ';  break;
            break;
        default  :
            s = nStr2[Math.floor(d / 10)];
            s += nStr1[d % 10];
    }
    return(s);
}
var cld;

function drawCld(SY, SM) {

    var i,sD,s,size;
    cld = new calendar(SY, SM);


    $("#GZ")[0].innerHTML = '  ũ��' + cyclical(SY - 1900 + 36) + '��&nbsp;��' + Animals[(SY - 4) % 12] + '�꡿';

    for (i = 0; i < 42; i++) {
        sObj = $("#SD" + i)[0];

        lObj = $("#LD" + i)[0];

        sObj.className = '';

        sD = i - cld.firstWeek;

        if (sD > -1 && sD < cld.length) {  //������
            sObj.innerHTML = sD + 1;

            if (cld[sD].isToday)  $("#GD" + i).addClass("jinri");  //������ɫ

            sObj.style.color = cld[sD].color;  //����������ɫ

            if (cld[sD].lDay == 1)  //��ʾũ����
                lObj.innerHTML = '<b>' + (cld[sD].isLeap ? '��' : '') + cld[sD].lMonth + '��' + (monthDays(cld[sD].lYear, cld[sD].lMonth) == 29 ? 'С' : '��') + '</b>';
            else  //��ʾũ����
                lObj.innerHTML = cDay(cld[sD].lDay);

            s = cld[sD].lunarFestival;
            if (s.length > 0) {  //ũ������
                if (s.length > 8)  s = s.substr(0, 5) + '...';
                s = s.fontcolor('red');
            }
            else {  //��������
                s = cld[sD].solarFestival;
                if (s.length > 0) {
                    if (s.length > 8)  s = s.substr(0, 5) + '...';
                    s = (s == '��ɫ������') ? s.fontcolor('black') : s.fontcolor('#0066FF');
                }
                else {  //إ�Ľ���
                    s = cld[sD].solarTerms;
                    if (s.length > 0)  s = s.fontcolor('limegreen');
                }
            }
            if (cld[sD].solarTerms == '����') s = '������'.fontcolor('red');
            if (cld[sD].solarTerms == 'â��') s = 'â��'.fontcolor('red');
            if (cld[sD].solarTerms == '����') s = '����'.fontcolor('red');
            if (cld[sD].solarTerms == '����') s = '����'.fontcolor('red');

            if (s.length > 0)  lObj.innerHTML = s;

        }
        else {  //������
            $("#GD" + i).addClass("unover");

        }
    }
}


/*�������*/
function clear() {
    for (i = 0; i < 42; i++) {
        sObj = $("#SD" + i)[0];
        sObj.innerHTML = '';
        lObj = $("#LD" + i)[0];
        lObj.innerHTML = '';
        $("#GD" + i).removeClass("unover");
        $("#GD" + i).removeClass("jinri");

    }

}


var Today = new Date();
var tY = Today.getFullYear();
var tM = Today.getMonth();

var tD = Today.getDate();
//////////////////////////////////////////////////////////////////////////////

var width = "130";
var offsetX = 2;
var offsetY = 18;

var x = 0;
var y = 0;
var snow = 0;
var sw = 0;
var cnt = 0;
var dStyle;


// ��ũ��iLunarMonth�¸�ʽ����ũ����ʾ���ַ���
function FormatLunarMonth(iLunarMonth) {
    var szText = new String("�������������߰˾�ʮ");
    var strMonth;
    if (iLunarMonth <= 10) {
        strMonth = szText.substr(iLunarMonth - 1, 1);
    }
    else if (iLunarMonth == 11) strMonth = "ʮһ";
    else strMonth = "ʮ��";
    return strMonth + "��";
}
// ��ũ��iLunarDay�ո�ʽ����ũ����ʾ���ַ���
function FormatLunarDay(iLunarDay) {
    var szText1 = new String("��ʮإ��");
    var szText2 = new String("һ�����������߰˾�ʮ");
    var strDay;
    if ((iLunarDay != 20) && (iLunarDay != 30)) {
        strDay = szText1.substr((iLunarDay - 1) / 10, 1) + szText2.substr((iLunarDay - 1) % 10, 1);
    }
    else if (iLunarDay != 20) {
        strDay = szText1.substr(iLunarDay / 10, 1) + "ʮ";
    }
    else {
        strDay = "��ʮ";
    }
    return strDay;
}
//��ʾ��ϸ��������
function mOvr(thisObj, v) {
    var s,festival,jy;

    sObj = $("#SD" + v);
    var d = sObj.html() - 1;

    if (sObj.html() != '') {
        if (cld[d].sgz5 != 0) {

            jy = cld[d].sgz5;
        } else {
            jy = jcr(cld[d].sgz3);

        }

        var arr = [];
        if (cld[d].solarTerms == '' && cld[d].solarFestival == '' && cld[d].lunarFestival == '')

            arr.push('<div id="teshu"></div>');
        else
        arr.push('<div id="teshu"><FONT  COLOR="#ff0000"  STYLE="font-size:12px;">' + cld[d].solarTerms + ' ' + cld[d].solarFestival + ' ' + cld[d].lunarFestival + '</FONT></div>');

        arr.push('<div style="width:60px; height:30px; color:#666666; float:left; font-size:60px; text-align:center;">' + cld[d].sDay + '</div>');
        arr.push('<font color="black" style="font-weight:bold;font-size:13px;">    ' + cld[d].sYear + '��' + cld[d].sMonth + '��' + cld[d].sDay + '��</font>');
        arr.push('<font style="font-size:12px;line-height:28px"><b>' + '����' + cld[d].week + '</b></font><br>');
        arr.push('<font style="font-size:12px;color:#000000;" >ũ��' + (cld[d].isLeap ? '��' : ' ') + FormatLunarMonth(cld[d].lMonth) + FormatLunarDay(cld[d].lDay) + '</font>');
        arr.push('<font style="font-size:12px">&nbsp;&nbsp;' + cld[d].cYear + '�� ' + cld[d].cMonth + '�� ' + cld[d].cDay + '��</font><br><br>');
        arr.push('<div style="width:95%; height:70px; margin-top:30px; padding-top:8px; border-top:1px solid #CCCCCC; margin-left:auto; margin-right:auto;">' + jy + '</div>');

        thisObj.style.backgroundColor = '#fbfbad';
        var d = $(thisObj);
        var pos = d.offset();
        var t = pos.top + d.height() + 5; // ��������ϱ�λ��
        var l = pos.left + d.width() - 150;  // ����������λ��


        <!--

        var winWidth = 0;

        var winHeight = 0;

        function findDimensions() {

            // ��ȡ���ڿ��

            if (window.innerWidth)

                winWidth = window.innerWidth;

            else if ((document.body) && (document.body.clientWidth))

                winWidth = document.body.clientWidth;

            // ��ȡ���ڸ߶�

            if (window.innerHeight)

                winHeight = window.innerHeight;

            else if ((document.body) && (document.body.clientHeight))

                winHeight = document.body.clientHeight;

            // ͨ������ Document �ڲ��� body ���м�⣬��ȡ���ڴ�С

            if (document.documentElement && document.documentElement.clientHeight && document.documentElement.clientWidth) {

                winHeight = document.documentElement.clientHeight;

                winWidth = document.documentElement.clientWidth;

            }

            // �������������ı���


        }

        findDimensions();

        // ���ú�������ȡ��ֵ

        window.onresize = findDimensions;

        //-->
        /* alert("h:"+winHeight+"w:"+winWidth)*/

        if (winHeight - pos.top < 230) {
            t = pos.top + d.height() - 180;
            l = pos.left + d.width() + 5;

        }

        if (winWidth - pos.left < 350) {

            t = pos.top + d.height() - 180;
            l = pos.left + d.width() - 360;

            if (pos.top < 216) {
                t = pos.top + d.height() - 100;
                l = pos.left + d.width() - 360;
            }
        }


        $("#details").addClass("pop");
        $("#details").css({ "top": t, "left": l }).show();
        $("#details").html(arr.join(""));


        if (snow == 0) {

            snow = 1;

        }


    }
}

//�����ϸ��������
function mOut(thisObj) {

    thisObj.style.backgroundColor = '';
    if (cnt >= 1) {
        sw = 0
    }
    if (sw == 0) {
        snow = 0;
        document.getElementById("details").style.display = 'none';
    }
    else  cnt++;
}


/*��ʼ������*/

$(function() {
    initRiliIndex();
    clear();
    $("#nian").html(tY);
    $("#yue").html(tM + 1);
    drawCld(tY, tM);

    /*��ݵݼ�*/
    $("#nianjian").click(function() {
        dateSelection.goPrevYear();

    });
    /*��ݵݼ�*/
    $("#nianjia").click(function() {
        dateSelection.goNextYear();

    });

    /*�·ݵݼ�*/
    $("#yuejian").click(function() {

        dateSelection.goPrevMonth();
    });

    /*�·ݵݼ�*/
    $("#yuejia").click(function() {
        dateSelection.goNextMonth();

    });


});


var global = {
    currYear : -1, // ��ǰ��
    currMonth : -1, // ��ǰ�£�0-11
    currDate : null, // ��ǰ��ѡ������
    uid : null,
    username : null,
    email : null,
    single : false
    // �Ƿ�Ϊ����ҳ���ã������ֵΪ����id��ʹ��ʱ��ע���0���жϣ�ʹ�� single !== false ���� single === false
};

var dateSelection = {
    currYear : -1,
    currMonth : -1,

    minYear : 1901,
    maxYear : 2100,

    beginYear : 0,
    endYear : 0,

    tmpYear : -1,
    tmpMonth : -1,

    init : function(year, month) {
        if (typeof year == 'undefined' || typeof month == 'undefined') {
            year = global.currYear;
            month = global.currMonth;
        }
        this.setYear(year);
        this.setMonth(month);
        this.showYearContent();
        this.showMonthContent();
    },
    show : function() {
        document.getElementById('dateSelectionDiv').style.display = 'block';
    },
    hide : function() {
        this.rollback();
        document.getElementById('dateSelectionDiv').style.display = 'none';
    },
    today : function() {
        var today = new Date();
        var year = today.getFullYear();
        var month = today.getMonth();

        if (this.currYear != year || this.currMonth != month) {
            if (this.tmpYear == year && this.tmpMonth == month) {
                this.rollback();
            } else {
                this.init(year, month);
                this.commit();
            }
        }
    },
    go : function() {
        if (this.currYear == this.tmpYear && this.currMonth == this.tmpMonth) {
            this.rollback();
        } else {
            this.commit();
        }
        this.hide();
    },
    goToday : function() {
        this.today();
        this.hide();
    },
    goPrevMonth : function() {
        this.prevMonth();
        this.commit();
    },
    goNextMonth : function() {
        this.nextMonth();
        this.commit();
    },
    goPrevYear : function() {
        this.prevYear();
        this.commit();
    },
    goNextYear : function() {
        this.nextYear();
        this.commit();
    },
    changeView : function() {
        global.currYear = this.currYear;
        global.currMonth = this.currMonth;
        clear();
        $("#nian").html(global.currYear);
        $("#yue").html(parseInt(global.currMonth) + 1);
        drawCld(global.currYear, global.currMonth);


    },
    commit : function() {
        if (this.tmpYear != -1 || this.tmpMonth != -1) {
            // ��������˱仯
            if (this.currYear != this.tmpYear
                    || this.currMonth != this.tmpMonth) {
                // ִ��ĳ����
                this.showYearContent();
                this.showMonthContent();
                this.changeView();


            }

            this.tmpYear = -1;
            this.tmpMonth = -1;
        }
    },
    rollback : function() {
        if (this.tmpYear != -1) {
            this.setYear(this.tmpYear);
        }
        if (this.tmpMonth != -1) {
            this.setMonth(this.tmpMonth);
        }
        this.tmpYear = -1;
        this.tmpMonth = -1;
        this.showYearContent();
        this.showMonthContent();
    },
    prevMonth : function() {
        var month = this.currMonth - 1;
        if (month == -1) {
            var year = this.currYear - 1;
            if (year >= this.minYear) {
                month = 11;
                this.setYear(year);
            } else {
                month = 0;
            }
        }
        this.setMonth(month);
    },
    nextMonth : function() {
        var month = this.currMonth + 1;
        if (month == 12) {
            var year = this.currYear + 1;
            if (year <= this.maxYear) {
                month = 0;
                this.setYear(year);
            } else {
                month = 11;
            }
        }
        this.setMonth(month);
    },
    prevYear : function() {
        var year = this.currYear - 1;
        if (year >= this.minYear) {
            this.setYear(year);
        }
    },
    nextYear : function() {
        var year = this.currYear + 1;
        if (year <= this.maxYear) {
            this.setYear(year);
        }
    },
    prevYearPage : function() {
        this.endYear = this.beginYear - 1;
        this.showYearContent(null, this.endYear);
    },
    nextYearPage : function() {
        this.beginYear = this.endYear + 1;
        this.showYearContent(this.beginYear, null);
    },
    selectYear : function() {//�select
        var selectY = $('select[@name="SY"] option[@selected]').text();
        this.setYear(selectY);
        this.commit();
    },
    selectMonth : function() {
        var selectM = $('select[@name="SM"] option[@selected]').text();
        this.setMonth(selectM - 1);
        this.commit();
    },
    setYear : function(value) {
        if (this.tmpYear == -1 && this.currYear != -1) {
            this.tmpYear = this.currYear;
        }
        $('#SY' + this.currYear).removeClass('curr');
        this.currYear = value;
        $('#SY' + this.currYear).addClass('curr');
    },
    setMonth : function(value) {
        if (this.tmpMonth == -1 && this.currMonth != -1) {
            this.tmpMonth = this.currMonth;
        }
        $('#SM' + this.currMonth).removeClass('curr');
        this.currMonth = value;
        $('#SM' + this.currMonth).addClass('curr');
    },
    showYearContent : function(beginYear, endYear) {
        if (!beginYear) {
            if (!endYear) {
                endYear = this.currYear + 1;
            }
            this.endYear = endYear;
            if (this.endYear > this.maxYear) {
                this.endYear = this.maxYear;
            }
            this.beginYear = this.endYear - 3;
            if (this.beginYear < this.minYear) {
                this.beginYear = this.minYear;
                this.endYear = this.beginYear + 3;
            }
        }
        if (!endYear) {
            if (!beginYear) {
                beginYear = this.currYear - 2;
            }
            this.beginYear = beginYear;
            if (this.beginYear < this.minYear) {
                this.beginYear = this.minYear;
            }
            this.endYear = this.beginYear + 3;
            if (this.endYear > this.maxYear) {
                this.endYear = this.maxYear;
                this.beginYear = this.endYear - 3;
            }
        }

        var s = '';
        for (var i = this.beginYear; i <= this.endYear; i++) {
            s += '<span id="SY' + i
                    + '" class="year" onclick="dateSelection.setYear(' + i
                    + ')">' + i + '</span>';
        }
        document.getElementById('yearListContent').innerHTML = s;
        $('#SY' + this.currYear).addClass('curr');
    },
    showMonthContent : function() {
        var s = '';
        for (var i = 0; i < 12; i++) {
            s += '<span id="SM' + i
                    + '" class="month" onclick="dateSelection.setMonth(' + i
                    + ')">' + (i + 1).toString() + '</span>';
        }
        document.getElementById('monthListContent').innerHTML = s;
        $('#SM' + this.currMonth).addClass('curr');
    }
};
function initRiliIndex() {
    var dateObj = new Date();
    global.currYear = dateObj.getFullYear();
    global.currMonth = dateObj.getMonth();

    dateSelection.init();

}