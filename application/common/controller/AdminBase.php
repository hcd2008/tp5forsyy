<?php
	namespace app\common\controller;
	use think\Controller;
	class AdminBase extends Controller{
		function __construct(){
			// $this->isLogin();
			parent::__construct();
		}
		public function isLogin(){
			$aduid=isset($_SESSION['aduid'])&&$_SESSION['aduid']!=''?intval($_SESSION['aduid']):0;
			if($aduid==0){
				$this->error("请登录","admin/login/index");
			}
		}
	}

?>