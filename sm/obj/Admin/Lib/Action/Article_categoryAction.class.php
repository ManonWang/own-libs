<?php
// 文章分类模块
class Article_categoryAction extends CommonAction {
	public function index() {
		//列表过滤器，生成查询Map对象
		$model = D ('Article_category');
		//取得满足条件的记录数
		$count = $model->count ();
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
			$voList = $model->order('sort desc,id desc')->limit($p->firstRow . ',' . $p->listRows)->select ( );
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
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'numPerPage', $p->listRows );
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		Cookie::set ( '_currentUrl_', __SELF__ );
		$this->display ();
	}

    
	// 插入数据
	public function insert() {
		$name = trim($_REQUEST['name']);
		$sort = intval($_REQUEST['sort']);
		$Article_category = M('Article_category');
		if(empty($name)){
			echo $this->returnajax(300, "分类名称不能为空！");
			die();
		}
		$map['name'] = $name;
		$c_name = $Article_category->where($map)->find();
		if(!empty($c_name)){
			echo $this->returnajax(300, "分类名称已存在！");
			die();
		}
		$data['name'] = $name;
		$data['sort'] = $sort;
		$result = $Article_category->add($data);
		if(!empty($result)){
			$this->success('分类添加成功');
		}else{
			echo $this->returnajax(300, "分类添加失败！");
			die();
		}
	}
	
	
	
	public function update() {
		$id = $_POST['id'];
		$name = trim($_REQUEST['name']);
		$sort = trim($_REQUEST['sort']);
		$Article_category = M('Article_category');
		//查询新名称是否存在
		$c_map['name'] = $name;
		$c_map['id'] = array('neq',$id);
		$c_result = $Article_category->where($c_map)->find();
		if(!empty($c_result)){
			echo $this->returnajax(300, "分类名称已存在！");
			die();
		}
		$data['name'] = $name;
		$data['sort'] = $sort;
		$map['id'] = $id;
		$result = $Article_category->where($map)->save($data);
		if(!empty($result)){
			$this->success('分类信息修改成功');
		}else{
			echo $this->returnajax(300, "分类信息修改失败！");
			die();
		}
	}
	

    public function foreverdelete(){
		$id = $_REQUEST['id'];
		$Article = M('Article');
		$Article_category = M('Article_category');
		$map['id'] = $id;
		//查询该分类下是否存在文章
		$list = $Article->where(array('category'=>$id))->find();
		if(!empty($list)){
			 echo $this->returnajax(300, "该分类下存在文章，请勿直接删除！");
			die();
		} 
		$result = $Article_category->where($map)->delete();
		if(!empty($result)){
			$this->success('分类删除成功');
		}else{
			echo $this->returnajax(300, "分类删除失败！");
			die();
		}
    }
}
?>