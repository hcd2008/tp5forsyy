<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
    	// echo __ASSETS__;exit;
        return $this->fetch();
    }
}
