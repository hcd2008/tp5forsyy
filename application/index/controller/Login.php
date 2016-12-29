<?php
	namespace app\index\controller;
	use think\Controller;
	use think\Db;
	use think\Session;

	class Login extends Controller{
		public function index(){
			$uid=Session::get('uid')>0?intval(Session::get('uid')):0;
			if($uid){
				$this->redirect("index/index");
			}
			if($this->request->isPost()){
				$post=$this->request->param();
				$username=$post['username'];
				$passwd=$post['passwd'];
				$res=Db::name('member')->where("username",$username)->find();
				if($res){
					$npassword=dpassword($passwd,$res['passsalt']);
					if($npassword==$res['password']){
						Session::set('uid',$res['id']);
						Session::set('uname',$username);
						Db::name('member')->where("id",$res['id'])->update(['logintime'=>time()]);
						Db::name('member')->where("id",$res['id'])->setInc('logintimes');
						$this->success("登录成功","index/index");
					}else{
						$this->error("用户名或密码错误");
					}
				}else{
					$this->error("用户名或密码错误");
				}
			}else{
				return $this->fetch("index");
			}
			
		}
		//退出登录
		public function logout(){
			Session::delete("uid");
			Session::delete("uname");
			$this->redirect("login/index");
		}
	}

?>