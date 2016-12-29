<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function random($length, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz') {
	$hash = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++)	{
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}

//密码加密
function dpassword($password, $salt) {
	return md5(md5($password).$salt);
}
//传入权限id字符串获得权限字符
function get_quanxian($str){
	if(trim($str)==''){
		return '';
	}
	$qx=['未定义','标准','法规','竞品','日报'];
	$arr=explode(",", $str);
	$res='';
	foreach ($arr as $k => $v) {
		$res.=$qx[$v]."|";
	}
	$res=substr($res, 0,-1);
	return $res;
}
