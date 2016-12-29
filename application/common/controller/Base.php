<?php
	namespace app\common\controller;
	use think\Controller;
	use think\Session;

	class Base extends Controller{
		protected $remote_url='http://kefu.foodvip.net/front.php';
		protected $customer_id=1;
		protected $app_secret='528bcc1e26a735af6d49fbf45901bb33';
		protected $send;
		function __construct(){
			$this->send=["customer_id"=>$this->customer_id,"app_secret"=>$this->app_secret];
			$this->isLogin();
			parent::__construct();
		}
		//判断是否登录
		function isLogin(){
			$uid=Session::get('uid')>0?intval(Session::get('uid')):0;
			if($uid==0){
				$this->redirect("login/index");
			}
		}
		// curl发送post请求
		protected function _post($url,$mydata){
			$post_fields='';
			foreach($mydata as $k=>$v){
				$post_fields.="{$k}={$v}&";
			}
			$post_fields=rtrim($post_fields,'&');
			$ch=curl_init($url);
			curl_setopt($ch,CURLOPT_HEADER,0);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_POST,1);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$post_fields);
			curl_setopt($ch,CURLOPT_TIMEOUT,10);
			$contents=curl_exec($ch);
			curl_close($ch);
			return $contents;
		}
		//处理数据
		protected function handleData($contents){
			if($contents){
				$arr=(array) json_decode($contents,true);
				isset($arr['code']) or exit($contents);
				if($arr['code']==0){
					return $arr['data'];
				}else{
					exit($arr['msg']);
				}
			}
		}
		//发送post请求并获取数据
		function getData($url,$mydata){
			return $this->handleData($this->_post($url,$mydata));
		}

	}

?>