<?php
class BasicAction extends CommonAction {
	public function index() {
		//列表过滤器，生成查询Map对象
		$model = D ('Basic');
	    //取得满足条件的记录数
		if(!empty($_POST['address'])){
			$map['address'] = array('like',"%".$_POST['address']."%");
		}
		if(!empty($_POST['company'])){
			$map['company'] = array('like',"%".$_POST['company']."%");
		}
		if(!empty($_POST['type'])){
			$map['type'] = array('like',"%".$_POST['type']."%");
		}
		$count = $model->where($map)->count ();
		if ($count > 0) {
			import ( "@.ORG.Util.Page" );
			//创建分页对象
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $count, $listRows );
			//分页查询数据
			$voList = $model->where($map)->order('id desc')->limit($p->firstRow . ',' . $p->listRows)->select ( );
			//分页跳转的时候保证查询条件
			foreach ( $map as $key => $val ) {
				if (! is_array ( $val )) {
					$p->parameter .= "$key=" . urlencode ( $val ) . "&";
				}
			}
			//分页显示
			$page = $p->show ();
			//模板赋值显示
			$this->assign ( 'list', $voList );
			$this->assign ( "page", $page );
		}
		$this->assign ( 'address', $_REQUEST['address'] );
		$this->assign ( 'company', $_REQUEST['company'] );
		$this->assign ( 'type', $_REQUEST['type']);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'numPerPage', $p->listRows );
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		Cookie::set ( '_currentUrl_', __SELF__ );
		$this->display ();
	}
	
	//添加页面
	public function add(){
		/*//获取综合分类
		$category = M('shop_category')->where(array('parent_id'=>0))->order('sort desc,category_id desc')->select();
		//获取商家分类
		$sid = $_SESSION['shop_id'];
		$m_category = M('shop_mcategory')->where(array('sid'=>$sid))->field('category_name,id')->order('sort desc,id desc')->select();
		$this->assign('category',$category);
		$this->assign('m_category',$m_category);*/
		$this->display();
	}

	//ajax查询二级分类
	
	public function select_category(){
		$id = $_REQUEST['id'];
		$map['parent_id'] = $id;
		$list = D('shop_category')->field('category_id,category_name')->order('sort desc,category_id desc')->where($map)->select();
		foreach($list as $key){
			$m_list[]=array($key['category_id'],$key['category_name']);
		}
		echo json_encode($m_list);
	}
	
	public function insert(){
		$Basic = M('Basic');
        $data=$this->_post("data");
        $data['starttime']=strtotime($data['starttime']);
		$result = $Basic->add($data);
		if(!empty($result)){
			$this->success('添加成功！');
		}else{
			echo $this->returnajax(300,'添加失败！');
			die();
		}
	}
	public function foreverdelete(){
		$id = $_REQUEST['id'];
		$result = M('Basic')->where(array('id'=>$id))->delete();
		if(!empty($result)){
			$this->success('删除成功！');
		}else{
			echo $this->returnajax(300,'删除失败！');
			die();
		}
	}
    function info(){
        $id = $_REQUEST['id'];
        $result = M('Basic')->where(array('id'=>$id))->find();
        $this->assign('res',$result);
        $this->display();
    }
}
?>