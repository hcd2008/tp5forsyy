<?php
	namespace app\admin\controller;
	use app\common\controller\AdminBase;
	use think\Db;
	use think\Validate;
	class Member extends AdminBase{
		public function index(){
			$res=Db::name('member')->field("id,username,quanxian,state,logintime,logintimes,addtime")->where('state','>=',0)->order("id")->paginate(10);
			$data=[
				"list"=>$res,
			];
			return $this->fetch("index",$data);
		}

		//添加用户
		public function addUser(){
			if($this->request->isPost()){
				//验证规则
				$rule=[
					'username'=>'require|min:3',
					'password'=>'require|min:6',
					'quanxian'=>'require'
				];
				$msg=[
					'username.require'=>'必须输入用户名',
					'username.min'=>'用户名必须超过2个字符',
					'password.require'=>'密码必填',
					'password.min'=>'密码最少6位',
					'quanxian.require'=>'请勾选权限'
				];
				$param=$this->request->param();
				$validate=new Validate($rule,$msg);
				$result=$validate->check($param);
				if(!$result){
					$this->error($validate->getError());
				}
				//判断用户名是否重复
				$useryz=Db::name('member')->where('username',$param['username'])->count();
				if($useryz){
					$this->error("用户名已经被注册");
				}
				if(isset($param['quanxian'])){
					$param['quanxian']=implode($param['quanxian'], ",");
				}
				$param['addtime']=time();
				$param['passsalt']=random(5);
				$param['password']=dpassword($param['password'],$param['passsalt']);
				unset($param['submit']);
				$res=Db::name('member')->insert($param);

				if($res){
					$this->success("添加会员成功","admin/member/addUser");
				}else{
					$this->error("添加失败");
				}
			}else{
				return $this->fetch();
			}
		}
		//编辑用户
		public function editUser(){
			if($this->request->isPost()){
				$param=$this->request->param();
				$userid=$param['userid'];
				if($userid==''){
					$this->error("非法访问");
				}
				if($param['password']!=''){
					if(strlen($param['password'])<6){
						$this->error("密码长度最少6位");
					}
					//更新密码
					$pswarr=Db::name('member')->field('passsalt')->where('id',$param['userid'])->find();
					$npwd=dpassword($param['password'],$pswarr['passsalt']);
					$res=Db::name('member')->where('id',$userid)->update(['password'=>$npwd]);
				}
				unset($param['submit']);
				unset($param['password']);
				unset($param['userid']);
				if(isset($param['quanxian'])){
					$param['quanxian']=implode($param['quanxian'], ",");
				}
				$result=Db::name('member')->where('id',$userid)->update($param);
				if($result){
					$this->success("编辑成功","member/index");
				}else{
					$this->error("编辑失败");
				}	
				
			}else{
				$param=$this->request->param();
				$userid=$param['userid'];
				$info=Db::name('member')->where("id",$userid)->find();
				$info['qx']=explode(",", $info['quanxian']);
				$this->assign("info",$info);
				return $this->fetch();
			}
			
		}
		//删除用户
		public function delUser(){
			if($this->request->isGet()){
				$param=$this->request->param();
				$userid=$param['userid'];
				if($userid<1){
					$this->error("非法访问");
				}
				$res=Db::name('member')->where('id',$userid)->update(['state'=>'-1']);
				if($res){
					$this->success("删除成功",'member/index');
				}else{
					$this->error("删除失败");
				}
			}
			

		}
	}


?>