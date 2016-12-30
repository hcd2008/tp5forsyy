<?php
	namespace app\admin\controller;
	use app\common\controller\AdminBase;
	use think\Db;
	use think\Validate;

	class Dept extends AdminBase{
		public function _initalize(){
			echo 111;
		}
		public function  index(){
			return $this->fetch();
		}
		public function addDept(){
			if($this->request->isPost()){
				$param=$this->request->param();
				$param['name']=trim($param['name']);
				$rule=["name"=>"require|min:2"];
				$msg=[
					"name.require"=>'请填写部门名称',
					'name.min'=>'部门名称最少为2个字符'
				];
				
				unset($param['submit']);
				$validate=new Validate($rule,$msg);
				$result=$validate->check($param);
				if(!$result){
					$this->error($validate->getError());
				}
				//验证部门名称
				$darr=Db::name('dept')->where('name',$param['name'])->count();
				if($darr){
					$this->error("该部门已经添加，请勿重复添加");
				}
				$res=Db::name('dept')->insert($param);
				if($res){
					$this->success("添加部门成功","dept/addDept");
				}else{
					$this->error("添加部门失败");
				}

			}else{
				return $this->fetch(); 
			}
			
		}
	}

?>