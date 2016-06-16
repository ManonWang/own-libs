<?php
namespace Home\Controller;

use Think\Controller;

class EvaluationController extends BaseController {
    public function index(){
        $select['name']     = I('name');
        $select['card']     = I('card');
        $select['position'] = I('position');

        $where = array();
        if(!empty($select['name'])){
            $where['name'] = array('like','%'.$select['name'].'%');
        }
        if(!empty($select['card'])){
            $where['card'] = $select['card'];
        }
        if(!empty($select['position'])){
            $where['position'] = $select['position'];
        }

        $count = M('Score')->where($where)->count();// 查询满足要求的总记录数
        $size  = C('PAGE_ZIAE');
        $item  = Page($count,$size);
        $list  = M('Score')->where($where)->order('times DESC,id DESC')->limit($item['limit'])->select();
        $this->assign('list',$list);
        $this->assign('page',$item['show']);
        $this->assign('select',$select);
        $this->display();
    }
}
