<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;

class Index extends AdminBase{
    public function index(){
    	// echo __ASSETS__;exit;
        return $this->fetch();
    }
}
