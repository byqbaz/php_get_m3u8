<?php

//设置脚本运行不超时

set_time_limit(0);

//即使浏览器关闭还继续运营

ignore_user_abort(true);

//睡眠5秒

sleep(5);

//要监控的网址

$cronurl = 'https://www.baidu.com/';
$cronurl = 'https://www.bilibili.com/video/BV1Sa411t7ye?p=1&share_medium=iphone&share_plat=ios&share_session_id=B71E66F2-AA3D-4681-A474-7B6F8DF81BB4&share_source=WEIXIN&share_tag=s_i&timestamp=1648109014&unique_k=UlTLdsJ';
// $cronurl = 'https://upos-sz-mirrorcos.bilivideo.com/upgcxcode/91/31/542233191/542233191_nb2-1-16.mp4?e=ig8euxZM2rNcNbRVhwdVhwdlhWdVhwdVhoNvNC8BqJIzNbfq9rVEuxTEnE8L5F6VnEsSTx0vkX8fqJeYTj_lta53NCM=&uipk=5&nbs=1&deadline=1648115361&gen=playurlv2&os=cosbv&oi=1972406074&trid=c8212b21a51e49eab694143132b36597h&platform=html5&upsig=dacff8301874d4917f84952f5740bc14&uparams=e,uipk,nbs,deadline,gen,os,oi,trid,platform&mid=0&bvc=vod&nettype=0&bw=40739&logo=80000000';
//开始get监控

httpGet($cronurl);

//这里还可以无限添加httpGet("网址");

//获取当前文件的访问url

// $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//开始get运行，达到无限循环的效果

// httpGet($url);

//发起GET模拟请求

function httpGet($url)
{
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_TIMEOUT, 30);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));

curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4");

curl_setopt($ch, CURLOPT_HEADER, 0);

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 3);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

$output = curl_exec($ch);

curl_close($ch);

return $output;

}

function test($url)
{
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_TIMEOUT, 30);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));

curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4");

curl_setopt($ch, CURLOPT_HEADER, 0);

curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 3);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

$output = curl_exec($ch);

curl_close($ch);

return $output;

}

function video_data($cronurl){
      $data=httpGet($cronurl);
    //   return $data;
      if(!is_string($data)) return 2;
      
        preg_match_all('/index\w*.ts/',$data,$res);
      if(is_array($res[0])){
        
        $dir=date('Y-m-dh');

        if(!is_dir($dir)){
            mkdir($dir);
        }

        foreach($res[0] as $vo){
        $url = 'https://vodtest1.cretech.cn/20w0471_00001C/'.$vo;

        if(file_put_contents($dir.'/'.basename($url),file_get_contents($url))) {
            echo "文件下载成功";
        }

        }

      }  
        // print_r($res);exit;
      
      
}


function combine_ts() {
	$dir = 'D:\www\a\1';//ts 文件所在目录
	$out_ts = 'test';//输出合并后的文件名
	$files = scandir($dir);
	$cmd = '';
	foreach ($files as $f) {
		if( is_file($dir . '\\' . $f) ) {
			if( pathinfo($f, PATHINFO_EXTENSION) == 'ts' ) {
				if( $cmd == '' ) {
					$cmd = 'copy ';
				} else {
					$cmd .= '+';
				}
				$cmd .= $f . '/b';
			}
		}
	}
	$cmd .= ' ' . $out_ts . '.ts ';
	//echo $cmd;
	$out_ts = $dir . '\\_' . $out_ts . '.bat';
	echo $out_ts;
	file_put_contents( $out_ts, $cmd);
}

// print_r(video_data($cronurl));
print_r(combine_ts($cronurl));

