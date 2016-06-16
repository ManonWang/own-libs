<?php
class ArticleAction extends CommonAction {

	// 文章列表
	public function index() {
	//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$model = D ('Article');
	//取得满足条件的记录数
		$count = $model->where ( $map )->count ();
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
			//获取文章分类名称
			foreach($voList as $key=>$val){
				$voList[$key]['category'] = $this->get_category_name($val['category']);
			}
			//echo $model->getlastsql();
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
	//添加页面
	public function add(){
		$Article_category = M('Article_category');
		$category_list = $Article_category->field('id,name')->order('sort desc')->select();
		$this->assign('category_list',$category_list);
		$this->display();
	}
	
	//添加文章
	public function doadd(){	
		$title = trim($_REQUEST['title']);
		$category = intval($_REQUEST['category']);
		$sort = intval($_REQUEST['sort']);
		$content = trim($_REQUEST['content']);
		$is_comment = trim($_REQUEST['is_comment']);
		$com_num = intval($_REQUEST['com_num']);
		$Article = M('Article');
		$data['ctime'] = time();
		$data['title'] = $title;
		$data['category'] = $category;
		$data['content'] = $content;
		$result = $Article->add($data);
		if(!empty($result)){
			$this->success('文章添加成功！');
		}else{
			echo $this->returnajax(300,'文章添加失败！');
			die();
		}
	}
	
	//上传图片
	public function editorimg(){
			import('Admin.Util.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath =  '../Public/Uploads/article/';// 设置附件上传目录	
			$upload->thumb = false;	//是否需要对图片文件进行缩略图处理，默认为false
			$upload->thumbPrefix = '';	//缩略图的文件前缀，默认为thumb_
			$upload->uploadReplace = true;	//是否覆盖
			$upload->thumbRemoveOrigin = false;	//生成缩略图后是否删除原图 
			$upload->autoSub = true;	//是否使用子目录保存上传文件
			$upload->subType = 'date';	//子目录创建方式，默认为hash，可以设置为hash或者date
			$upload->dateFormat = 'Ymd';	//子目录方式为date的时候指定日期格式
			if(!$upload->upload()) {// 上传错误提示错误信息
				echo $this->returnajax(300, $upload->getErrorMsg());
				die();
			}else{// 上传成功 获取上传文件信息
					$info =  $upload->getUploadFileInfo();	
					$imgpath = C("PATH_IMG").'Public/Uploads/article/'.$info[0]['savename'];
					$path = array(
						'err'=>0,
						'msg'=>$imgpath
					);
					echo json_encode($path);
			}
	}
	//修改页面
	public function edit(){
		$id = $_REQUEST['id'];
		$Article = M('Article');
		$Article_category = M('Article_category');
		$category_list = $Article_category->field('id,name')->order('sort desc')->select();
		$map['id'] = $id;
		$info = $Article->where($map)->find();
		$info['content'] = stripslashes($info['content']);
		$this->assign('info',$info);
		$this->assign('category_list',$category_list);
		$this->display();
	}
	//执行修改
	public function update(){
		$Article = M('Article');
		$id = $_REQUEST['id'];
		$map['id'] = $id;
		if(!empty($_FILES['cover']['name'])){
			import('Admin.Util.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
			$upload->savePath =  '../Public/Uploads/article/';// 设置附件上传目录	
			$upload->thumb = false;	//是否需要对图片文件进行缩略图处理，默认为false
			$upload->thumbPrefix = '';	//缩略图的文件前缀，默认为thumb_
			$upload->uploadReplace = true;	//是否覆盖
			$upload->thumbRemoveOrigin = false;	//生成缩略图后是否删除原图 
			$upload->autoSub = true;	//是否使用子目录保存上传文件
			$upload->subType = 'date';	//子目录创建方式，默认为hash，可以设置为hash或者date
			$upload->dateFormat = 'Ymd';	//子目录方式为date的时候指定日期格式
			if(!$upload->upload()) {// 上传错误提示错误信息
				echo $this->returnajax(300, $upload->getErrorMsg());
				die();
			}else{// 上传成功 获取上传文件信息
					$info =  $upload->getUploadFileInfo();	
					$data['cover'] = $info[0]['savename'];
					$img = $Article->where($map)->field('cover')->find();
			}
		}
		$title = trim($_REQUEST['title']);
		$content = trim($_REQUEST['content']);
		$category = intval($_REQUEST['category']);
		$data['title'] = $title;
		$data['content'] = $content;
		$data['category'] = $category;
		$result = $Article->where($map)->save($data);
		if(!empty($result)){
			$img = '../Public/Uploads/article/'.$img['cover'];
			$a = unlink($img);
			$this->success('文章修改成功！');
		}else{
			echo $this->returnajax(300,'文章修改失败！');
			die();
		}
	}
	//删除文章
	public function foreverdelete(){
		$id = $_REQUEST['id'];
		$Article = M('Article');
		$map['id'] = $id;
		$result = $Article->where($map)->delete();
		if(!empty($result)){
			$this->success('文章删除成功');
		}else{
			echo $this->returnajax(300,'文章删除失败！');
			die();
		}
		
	}
	//获取文章分类名称
	public function get_category_name($id){
		/*
		*id 文章分类id
		*/
		$info = M('Article_category')->field('name')->where(array('id'=>$id))->find();
		return $info['name'];
	}

}
?>