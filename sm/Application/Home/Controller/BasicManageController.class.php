<?php
namespace Home\Controller;

use Think\Controller;

class BasicManageController extends BaseController {

    public function index(){
        $this->display();
    }

    /**
     *******************************
     * Auth:dingwei
     * Time:2016-5-14 13:23:14
     * Desc:技术规章
     ********************************
     */
    public function rule(){
        $type = 1;
        $data = $this->getDataByType($type);
        $list = $data['list'];
        $page = $data['page'];
        $this->assign('list',$list);
        $this->assign('page',$page);// 赋值分页输出
        $this->display();
    }

    /**
     *******************************
     * Auth:dingwei
     * Time:2016-5-14 13:23:33
     * Desc:企业标准
     ********************************
     */
    public function standard(){
        $type = 2;
        $data = $this->getDataByType($type);
        $list = $data['list'];
        $page = $data['page'];
        $this->assign('list',$list);
        $this->assign('page',$page);// 赋值分页输出
        $this->display();
    }

    /**
     *******************************
     * Auth:dingwei
     * Time:2016-5-14 13:23:48
     * Desc:制度措施
     ********************************
     */
    public function measures(){
        $type = 3;
        $data = $this->getDataByType($type);
        $list = $data['list'];
        $page = $data['page'];
        $this->assign('list',$list);
        $this->assign('page',$page);// 赋值分页输出
        $this->display();
    }

    /**
     *******************************
     * Auth:dingwei
     * Time:2016-5-14 13:24:05
     * Desc:典型事故
     ********************************
     */
    public function accident(){
        $select['start_time'] = I('start_time');
        $select['end_time']   = I('end_time');
        $select['address']    = I('address');
        $select['company']    = I('company');
        $select['blance']     = I('blance');
        $select['type']       = I('type');
        $select['cartype']    = I('cartype');
        $select['weather']    = I('weather');
        $select['reason']     = I('reason');
        $where = array();
        if(!empty($select['start_time']) && !empty($select['end_time'])){
            $where['starttime'] = array('BETWEEN',array(strtotime($select['start_time']),strtotime($select['end_time'])));
        }
        if(!empty($select['start_time']) && empty($select['end_time'])){
            $time=strtotime($select['start_time']);
            $where['starttime'] = array('gt',$time);
        }
        if(!empty($select['end_time']) && empty($select['start_time']) ){
            $where['starttime'] = array('lt',strtotime($select['end_time']));
        }
        if(!empty($select['address'])){
            $where['address'] = $select['address'];
        }
        if(!empty($select['company'])){
            $where['company'] = $select['company'];
        }
        if(!empty($select['blance'])){
            $where['blance'] = $select['blance'];
        }
        if(!empty($select['type'])){
            $where['type'] = $select['type'];
        }
        if(!empty($select['cartype'])){
            $where['cartype'] = $select['cartype'];
        }
        if(!empty($select['weather'])){
            $where['weather'] = $select['weather'];
        }
        if(!empty($select['reason'])){
            $where['reason'] = array('like','%'.$select['reason'].'%');
        }
        $count = M('Basic')->where($where)->count();// 查询满足要求的总记录数
        $size  = C('PAGE_ZIAE');
        $Page  = new \Think\Page($count,$size);// 实例化分页类 传入总记录数和每页显示的记录数
        //分页跳转的时候保证查询条件
        $list = M('Basic')->where($where)->order('starttime DESC,id DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
        $show=$Page->show();
        $this->assign('list',$list);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('select',$select);
        $this->display();
    }

    /**
     *******************************
     * Auth:dingwei
     * Time:2016-5-14 14:55:37
     * Desc:获取下载列表
     ********************************
     */
    private function getDataByType($type=1){
        $count = M('BasicDownload')->where("type=".$type)->count();// 查询满足要求的总记录数
        $size  = C('PAGE_ZIAE');
        $item  = Page($count,$size);
        $list = M('BasicDownload')->where("type=".$type)->order('addtime DESC,id DESC')->limit($item['limit'])->select();
        $data = array(
            'list' => $list,
            'page' => $item['show']
        );
        return $data;
    }
}
