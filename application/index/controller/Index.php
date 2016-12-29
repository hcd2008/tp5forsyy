<?php
namespace app\index\controller;
use app\common\controller\Base;

class Index extends Base{
	//标法首页
    public function index($param=array()){
        $bzNearConf=array("days"=>"500");
        $fgNearConf=array("days"=>"500");
    	$fgnLst=$this->fgNoticeLst($param);
        $bznLst=$this->bzNoticeLst($param);
        $bzNearLst=$this->bzNearLst($bzNearConf);
        $fgNearLst=$this->fgNearLst($fgNearConf);
        // print_r($bzNearLst);
        $data=array(
            'bznLst'=>$bznLst[0],
            'bznSum'=>$bznLst[1],
            'fgnLst'=>$fgnLst[0],
            'fgnSum'=>$fgnLst[1],
            'bzNearLst'=>$bzNearLst[0],
            'bzNearSum'=>$bzNearLst[1],
            'fgNearLst'=>$fgNearLst[0],
            'fgNearSum'=>$fgNearLst[1]
            );
        return $this->fetch('index',$data);
    }
    //标准最新公告
    public function bzNoticeLst($param=array()){
        $bznoticeUrl=$this->remote_url."?r=front/biaozhun/index/notice_lst";
        $send=array_merge($this->send,(array)$param);
        $bznoticeLst=$this->getData($bznoticeUrl,$send);
        return $bznoticeLst;
    }
    //法规最新公告
    public function fgNoticeLst($param=array()){
        $fgnoticeUrl=$this->remote_url."?r=front/fagui/index/notice_lst";
        $send=array_merge($this->send,(array)$param);
        $fgnoticeLst=$this->getData($fgnoticeUrl,$send);
        return $fgnoticeLst;
    }
    //标准最近添加
    public function bzNearLst($param=array("days"=>100)){
        $bzNearUrl=$this->remote_url."?r=front/biaozhun/index/lately_release_lst";
        $send=array_merge($this->send,(array)$param);
        $bzNearLst=$this->getData($bzNearUrl,$send);
        return $bzNearLst;
    }
    //法规最近添加
    public function fgNearLst($param=array("days"=>100)){
        $fgNearUrl=$this->remote_url."?r=front/fagui/index/lately_release_lst";
        $send=array_merge($this->send,(array)$param);
        $fgNearLst=$this->getData($fgNearUrl,$send);
        return $fgNearLst;
    }
    //标准详情
    public function bzDetail(){
    	$detailUrl=$this->remote_url."?r=front/biaozhun/index/subject_detail";
    	$request=$this->request->param();
    	$send=array_merge($this->send,["itemid"=>$request['itemid']]);
    	$detail=$this->getData($detailUrl,$send);
        // print_r($detail);exit;
        $data=array("detail"=>$detail);
    	return $this->fetch('bzdetail',$data);
    }
    //法规详情
    public function fgDetail(){
    	$detailUrl=$this->remote_url."?r=front/fagui/index/subject_detail";
    	print_r($this->request);
    }
}
