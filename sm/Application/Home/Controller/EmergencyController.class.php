<?php
namespace Home\Controller;

use Think\Controller;

class EmergencyController extends BaseController {
    /**
     *******************************
     * Auth:dingwei
     * Time:2016-5-14 14:27:12
     * Desc:应急管理
     ********************************
     */
    public function index(){
        $pid = 12;
        $data = $this->getDataByType($pid);
        $list = $data['list'];
        $page = $data['page'];
        $this->assign('list',$list);
        $this->assign('page',$page);// 赋值分页输出
        $this->display();
    }

    /**
     *******************************
     * Auth:dingwei
     * Time:2016-5-14 14:27:12
     * Desc:非正常情况应急处置
     ********************************
     */
    public function dispose(){
        $pid = 11;
        $data = $this->getDataByType($pid);
        $list = $data['list'];
        $page = $data['page'];
        $this->assign('list',$list);
        $this->assign('page',$page);// 赋值分页输出
        $this->display();
    }

    /**
     *******************************
     * Auth:dingwei
     * Time:2016-5-14 14:27:12
     * Desc:应急预案
     ********************************
     */
    public function plans(){
        $pid = 13;
        $data = $this->getDataByType($pid);
        $list = $data['list'];
        $page = $data['page'];
        $this->assign('list',$list);
        $this->assign('page',$page);// 赋值分页输出
        $this->display();
    }

    public function detail($id){
        $vo = M('Article')->where("id=".$id)->find();
        $vo['p_name'] = M('ArticleCategory')->where("id=".$vo['category'])->getField('name');
        $this->assign('vo',$vo);
        $this->display();
    }

        /**
     *******************************
     * Auth:dingwei
     * Time:2016-5-14 14:55:37
     * Desc:获取下载列表
     ********************************
     */
    private function getDataByType($pid=1){
        $count = M('Article')->where("category=".$pid)->count();// 查询满足要求的总记录数
        $size  = C('PAGE_ZIAE');
        $item  = Page($count,$size);
        $list = M('Article')->where("category=".$pid)->order('ctime DESC,id DESC')->limit($item['limit'])->select();
        $data = array(
            'list' => $list,
            'page' => $item['show']
        );
        return $data;
    }
}
