<?php

//设置脚本运行不超时

set_time_limit(0);

//即使浏览器关闭还继续运营

ignore_user_abort(true);

//睡眠5秒

//sleep(5);

// $url = 'https://cdn2.jiuse.cloud/hls/615350index/'.$i.'';
//    $url = 'https://cdn2.jiuse.cloud/hls/615350/index0.ts';
$url = 'https://hls-hw.xvideos-cdn.com/videos/hls/f6/e5/29/f6e52992d52f0bb90804b922681bae93/hls-250p4.ts';
//$url='https://cdn2.jiuse.cloud/hls/615350/index2.ts';
$url='https://cdn2.jiuse.cloud/hls/594323/index.m3u8?t=1648138801&m=pPaTSgilgH6GpnUnXC3sGQ';
function vide($url){
    echo "<pre>";
    $data=httpGet($url);
    //   return $data;
    if(!is_string($data)) return 2;

    preg_match_all('/index\w*.ts/',$data,$res);
    if(is_array($res[0])){

        $dir=2;

        if(!is_dir($dir)){
            mkdir($dir);
        }

        foreach($res[0] as $vo){
//            $url = 'https://vodtest1.cretech.cn/20w0471_00001C/'.$vo;
            $url='https://cdn2.jiuse.cloud/hls/603953/'.$vo;
//            echo $url;
//            echo "\n";
            if(file_put_contents($dir.'/'.basename($url),file_get_contents($url))) {
                echo "第".$vo."文件下载成功";
                echo "\n";
            }else{
                echo "第".$vo."下载失败";
                echo "\n";
            }

        }

    }

}
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

function combine_ts() {
    $dir = 'D:\www\php_get_m3u8\2';//ts 文件所在目录
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
//print_r(vide($url));
print_r(combine_ts($url));