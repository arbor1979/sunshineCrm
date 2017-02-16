<?php

//HTTP�ϴ��ļ�ʹ��

// ------example------ 

// $pf = new IBPostFile( "test.php");

// $pf->setFile( "uploadFile", "d:/images/ice.gif" );

// $pf->sendRequest();

// echo $pf->getResponse();

//====================================================


class IBPostFile
{
    var $url; //Ҫ�����ļ���URL

    var $formData; //���͵ı�����

    var $fileData; //�ļ�����

    var $boundary; //���ݷָ���ʶ

    var $response; //������������ص���Ϣ

    var $username; //��Ҫ�����֤ʱ���û���

    var $pwd; //��Ҫ�����֤ʱ������

    var $port; //�˿ں�


    var $debug = true; //�Ƿ����


    /* ����: IBPostFile
    ** ����: Constructor
    ** ����: $url String Ҫ�����ļ���URL
    */
    function IBPostFile( $url="", $port="80")
    {
        $this->url = $url;
        $this->port = $port;
        $this->boundary = $this->createBoundary();
    }
    
    /* ����: sendRequest
    ** ����: �������󲢱�����
    */
    function sendRequest()
    {
        $urlArray = parse_url( $this->url );
        $fp = fsockopen( $urlArray['host'], $this->port );

        $requestData = $this->buildRequest();

        //*

        fwrite( $fp, $requestData );
        
        $content = "";
        while( !feof( $fp ) )
        {
            $content .= fread( $fp, 4096 );
        }
        fclose( $fp );
        //*/

        $this->response = $content;

        if( $this->debug )
        {
            //echo "---------HTTP-REQUEST-------";
            //echo "$requestData";
            //echo "---------HTTP-RESPONSE------";
            return $content;
        }
        //*/

    }

    /* ����: getResponse()
    ** ����: ���ط������˵���Ϣ
    */
    function getResponse()
    {
        return $this->response;
    }

    /* ����: setForm( $formData )
    ** ����: ���ñ����ֶ�ֵ
    ** ����: $formData Array �ֶ�����ֵ������
    */
    function setForm( $formData )
    {
        $this->formData = $this->buildFormData( $formData );
    }

    /* ����: setFile( $name, $filePath )
    ** ����: ����Ҫ���͵��ļ�
    ** ����: $name �ļ�������file���name
    ** ����: $filePath Ҫ���͵��ļ�·��
    */
    function setFile( $name, $filePath )
    {

        $this->fileData = $this->buildFileData( $name, $filePath );
    }
    
    /* ����: setAuthor( $user, $pwd )
    ** ����: ���������֤ʱ��Ҫ���û���������
    ** ����: $user �û���
    ** ����: $pwd ����
    */
    function setAuthor( $user, $pwd )
    {
        $this->username = $user;
        $this->pwd = $pwd;
    }

    /* ����: buildRequest()
    ** ����: ��������
    */
    function buildRequest()
    {
        $urlArray = parse_url( $this->url );
        $request = array();

        $request[] = "POST {$urlArray['path']} HTTP/1.0";
        $request[] = "Host: {$urlArray['host']}";
        $request[] = "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)";
        $request[] = "Accept: */*";
        $request[] = "Accept-Language: zh-cn";
        $request[] = "Connection: Keep-Alive";
        $request[] = "Cache-Control: no-cache";
        
        //��Ҫ�����֤

        if ( !empty( $this->username ) && !empty( $this->pwd ) ) 
        {
            $request[] = 'Authorization: BASIC ' . base64_encode( $this->username.':'.$this->pwd );
        }

        $request[] = "Content-Type: multipart/form-data; boundary={$this->boundary}";
        $request[] = "Content-Length: " . $this->getDataLength() . "\r\n";

        $requestString = join( "\r\n", $request ) . "\r\n" . $this->formData . "\r\n" . $this->fileData;

                
        if( $this->debug )
        {
            //echo "----------- REQUEST_INFOMATION -----------";
            //echo "" . $requestString . "";
        }
        return $requestString;
    }

    /* ����: getDataLength()
    ** ����: ����Ҫ�������ݵĳ���
    */
    function getDataLength()
    {
        return strlen( $this->formData ) + strlen("\r\n") + strlen( $this->fileData );
    }
    
    /* ����: buildFormData()
    ** ����: �������͵����ݸ�ʽ
    */
    function buildFormData( $formData )
    {
        $postData = array();
        foreach( $formData as $k => $v )
        {
            $row = array();
            $row[] = "--{$this->boundary}";
            $row[] = "Content-Disposition: form-data; name=\"$k\"\r\n";
            $row[] = "$v";

            $postData[] = join( "\r\n", $row );
        }

        return join( "\r\n", $postData );
    }
    
    /* ����: buildFileData( $name, $filePath )
    ** ����: �������͵��ļ���ʽ
    */
    function buildFileData( $name, $filePath )
    {
        //��ȡ�ļ���Ϣ

        $fname = basename( $filePath );
        $fp = fopen ( $filePath, "r" );
        $data = fread ( $fp, filesize( $filePath ) );
        fclose ($fp); 
        
        $postData = array();
        $postData[] = "--{$this->boundary}";
        $postData[] = "Content-Disposition: form-data; name=\"$name\"; filename=\"$fname\"\r\n";
        //$postData[] = "Content-Type: text/plain\r\n";

        $postData[] = $data;
        $postData[] = "--{$this->boundary}--";

        return join( "\r\n", $postData );
    }

    /* ����: createBoundary()
    ** ����: �������ݷָ���ʶ
    */
    function createBoundary()
    {
        return "---------------------------" . substr(md5(time()), -12 );
    }

}

?><?php
/*
	��Ȩ����:֣�ݵ���Ƽ�������޹�˾;
	��ϵ��ʽ:0371-69663266;
	��˾��ַ:����֣�ݾ��ü��������������־�����·ͨ�Ų�ҵ԰��¥����;
	��˾���:֣�ݵ���Ƽ�������޹�˾λ���й��в�����-֣��,������2007��1��,�����ڰѻ����Ƚ���Ϣ����������ͨ�ż���������ѹ�����ҵ��ʵ���ռ���������ҵ�ͻ��Ĺ�����ҵ���»�У�ȫ���ṩ��������֪ʶ��Ȩ�Ľ�����������������������������в�������ĸ�У���������������СѧУ��������ṩ�̡�Ŀǰ�Ѿ��ж�Ҹ�ְ����ְ��ԺУʹ��ͨ���в��з����Ŀ���������ͷ���;

	�������:����Ƽ�������������Լܹ�ƽ̨,�Լ��������֮����չ���κ��������Ʒ;
	����Э��:���ֻ�У԰��ƷΪ��ҵ���,�������ΪLICENSE��ʽ;����CRMϵͳ��SunshineCRMϵͳΪGPLV3Э�����,GPLV3Э����������뵽�ٶ�����;
	��������:�����ʹ�õ�ADODB��,PHPEXCEL��,SMTARY���ԭ��������,���´���������������;
	*/
?>