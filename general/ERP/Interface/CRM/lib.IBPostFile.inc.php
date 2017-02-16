<?php

//HTTP上传文件使用

// ------example------ 

// $pf = new IBPostFile( "test.php");

// $pf->setFile( "uploadFile", "d:/images/ice.gif" );

// $pf->sendRequest();

// echo $pf->getResponse();

//====================================================


class IBPostFile
{
    var $url; //要发送文件的URL

    var $formData; //发送的表单数据

    var $fileData; //文件数据

    var $boundary; //数据分隔标识

    var $response; //保存服务器返回的信息

    var $username; //需要身份验证时的用户名

    var $pwd; //需要身份验证时的密码

    var $port; //端口号


    var $debug = true; //是否调试


    /* 函数: IBPostFile
    ** 功能: Constructor
    ** 参数: $url String 要发送文件的URL
    */
    function IBPostFile( $url="", $port="80")
    {
        $this->url = $url;
        $this->port = $port;
        $this->boundary = $this->createBoundary();
    }
    
    /* 函数: sendRequest
    ** 功能: 发送请求并保存结果
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

    /* 函数: getResponse()
    ** 功能: 返回服务器端的信息
    */
    function getResponse()
    {
        return $this->response;
    }

    /* 函数: setForm( $formData )
    ** 功能: 设置表单的字段值
    ** 参数: $formData Array 字段名和值的数组
    */
    function setForm( $formData )
    {
        $this->formData = $this->buildFormData( $formData );
    }

    /* 函数: setFile( $name, $filePath )
    ** 功能: 设置要发送的文件
    ** 参数: $name 文件名，即file域的name
    ** 参数: $filePath 要发送的文件路径
    */
    function setFile( $name, $filePath )
    {

        $this->fileData = $this->buildFileData( $name, $filePath );
    }
    
    /* 函数: setAuthor( $user, $pwd )
    ** 功能: 设置身份验证时需要的用户名和密码
    ** 参数: $user 用户名
    ** 参数: $pwd 密码
    */
    function setAuthor( $user, $pwd )
    {
        $this->username = $user;
        $this->pwd = $pwd;
    }

    /* 函数: buildRequest()
    ** 功能: 建立请求
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
        
        //需要身份验证

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

    /* 函数: getDataLength()
    ** 功能: 返回要发送数据的长度
    */
    function getDataLength()
    {
        return strlen( $this->formData ) + strlen("\r\n") + strlen( $this->fileData );
    }
    
    /* 函数: buildFormData()
    ** 功能: 创建发送的数据格式
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
    
    /* 函数: buildFileData( $name, $filePath )
    ** 功能: 创建发送的文件格式
    */
    function buildFileData( $name, $filePath )
    {
        //读取文件信息

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

    /* 函数: createBoundary()
    ** 功能: 创建数据分隔标识
    */
    function createBoundary()
    {
        return "---------------------------" . substr(md5(time()), -12 );
    }

}

?><?php
/*
	版权归属:郑州单点科技软件有限公司;
	联系方式:0371-69663266;
	公司地址:河南郑州经济技术开发区第五大街经北三路通信产业园四楼西南;
	公司简介:郑州单点科技软件有限公司位于中国中部城市-郑州,成立于2007年1月,致力于把基于先进信息技术（包括通信技术）的最佳管理与业务实践普及到教育行业客户的管理与业务创新活动中，全面提供具有自主知识产权的教育管理软件、服务与解决方案，是中部最优秀的高校教育管理软件及中小学校管理软件提供商。目前已经有多家高职和中职类院校使用通达中部研发中心开发的软件和服务;

	软件名称:单点科技软件开发基础性架构平台,以及在其基础之上扩展的任何性软件作品;
	发行协议:数字化校园产品为商业软件,发行许可为LICENSE方式;单点CRM系统即SunshineCRM系统为GPLV3协议许可,GPLV3协议许可内容请到百度搜索;
	特殊声明:软件所使用的ADODB库,PHPEXCEL库,SMTARY库归原作者所有,余下代码沿用上述声明;
	*/
?>