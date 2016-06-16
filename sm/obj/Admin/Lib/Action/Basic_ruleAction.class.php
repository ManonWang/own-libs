<?php
class Basic_ruleAction extends CommonAction {
	public function index() {
		$map = $this->_search ();
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$map['type']=1;
		$model = D ('Basic_download');
		$count = $model->where ( $map )->count ();
		if ($count > 0) {
			import ( "@.ORG.Util.Page" );
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $count, $listRows );
			$voList = $model->where($map)->order('id desc')->limit($p->firstRow . ',' . $p->listRows)->select ( );
			foreach ( $map as $key => $val ) {
				if (! is_array ( $val )) {
					$p->parameter .= "$key=" . urlencode ( $val ) . "&";
				}
			}
			$page = $p->show ();
			$this->assign ( 'list', $voList );
			$this->assign ( "page", $page );
		}
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'numPerPage', $p->listRows );
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		Cookie::set ( '_currentUrl_', __SELF__ );
		$this->display ();
	}
	public function doadd(){	
		$data=$_POST['data'];
		$Basic_download = M('Basic_download');
		$data['addtime'] = time();
		$data['type'] = 1;
		import('Admin.Util.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('pdf', 'doc', 'docx', 'xls','xlsx','ppt','pptx','txt');// 设置附件上传类型
		$upload->savePath =  '../Public/Uploads/files/';// 设置附件上传目录	
		$upload->autoSub = true;	//是否使用子目录保存上传文件
		$upload->subType = 'date';	//子目录创建方式，默认为hash，可以设置为hash或者date
		$upload->dateFormat = 'Ymd';	//子目录方式为date的时候指定日期格式
		if(!$upload->upload()) {// 上传错误提示错误信息
			echo $this->returnajax(300, $upload->getErrorMsg());
			die();
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();	
			$data[url] = C("PATH_IMG").'Public/Uploads/files/'.$info[0]['savename'];
		}
		$result = $Basic_download->add($data);
		if(!empty($result)){
			$this->success('添加成功！');
		}else{
			echo $this->returnajax(300,'添加失败！');
			die();
		}
	}
	
	//修改页面
	public function edit(){
		$id = $_REQUEST['id'];
		$Basic_download = M('Basic_download');
		$map['id'] = $id;
		$info = $Basic_download->where($map)->find();
		$this->assign('info',$info);
		$this->display();
	}
	//执行修改
	public function update(){
		$Basic_download = M('Basic_download');
		$id = $_REQUEST['id'];
		$data=$_POST['data'];
		$map['id'] = $id;
		if(!empty($_FILES['url']['name'])){
			import('Admin.Util.UploadFile');
			$upload = new UploadFile();// 实例化上传类
			$upload->maxSize  = 3145728 ;// 设置附件上传大小
			$upload->allowExts  = array('pdf', 'doc', 'docx', 'xls','xlsx','ppt','pptx','txt');// 设置附件上传类型
			$upload->savePath =  '../Public/Uploads/files/';// 设置附件上传目录	
			$upload->autoSub = true;	//是否使用子目录保存上传文件
			$upload->subType = 'date';	//子目录创建方式，默认为hash，可以设置为hash或者date
			$upload->dateFormat = 'Ymd';	//子目录方式为date的时候指定日期格式
			if(!$upload->upload()) {// 上传错误提示错误信息
				echo $this->returnajax(300, $upload->getErrorMsg());
				die();
			}else{// 上传成功 获取上传文件信息
					$info =  $upload->getUploadFileInfo();	
					$data['url'] =  C("PATH_IMG").'Public/Uploads/files/'.$info[0]['savename'];
				
			}
		}
		$result = $Basic_download->where($map)->save($data);
		if(!empty($result)){
			$this->success('修改成功！');
		}else{
			echo $this->returnajax(300,'修改失败！');
			die();
		}
	}
	public function foreverdelete(){
		$id = $_REQUEST['id'];
		$Basic_download = M('Basic_download');
		$map['id'] = $id;
		$result = $Basic_download->where($map)->delete();
		if(!empty($result)){
			$this->success('删除成功');
		}else{
			echo $this->returnajax(300,'删除失败！');
			die();
		}
		
	}
}
?>