<?php
// 后台用户模块
class UserAction extends CommonAction {	
	public function index() {
		$map['id'] = array('neq',1);
		$model = D ('Shop_user');
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
	

	// 检查帐号
	public function checkAccount() {
        if(!preg_match('/^[a-z]\w{4,}$/i',$_POST['user'])) {
			echo $this->returnajax(300, "用户名必须是字母，且5位以上！");
			die();
        }
		$User = M("Shop_user");
        // 检测用户名是否冲突
        $name  =  $_REQUEST['user'];
		$map['user']=$name;
        $result  =  $User->where($map)->find();
        if($result) {
			echo $this->returnajax(300, "该用户名已经存在！");
			die();
        }
    }
    
	// 插入数据
	public function insert() {
		$this->checkAccount();
		$data['user'] = $_POST['user'];
		$data['pass'] = md5($_POST['pwd']);
		$data['ctime'] = time();
		$User = M('Shop_user');
		$result = $User->add($data);
		if(!empty($result)){
			$this->success('添加成功');
		}else{
			echo $this->returnajax(300, "添加失败！");
			die();
		}
	}
    //重置密码
    public function resetPwd()
    {
    	$id  =  $_POST['id'];
        $password = $_POST['password'];
        if(''== trim($password)) {
			echo $this->returnajax(300, "密码不能为空！");
			die();
        }
		if($_SESSION['verify'] != md5($_POST['verify'])) {
		   echo $this->returnajax(300, "验证码错误！");
			die();
		}
        $User = M('Shop_user');
		$User->pass	=	md5($password);
		$User->id			=	$id;
		$result	=	$User->save();
        if(false !== $result) {
            $this->success("密码修改为$password");
        }else {
        	echo $this->returnajax(300, "密码重置失败！");
			die();
        }
    }
    
    function foreverdelete(){
       $id  =  $_GET['id'];
	   $map['id']=$id;
	   $User = M('Shop_user');
	   $result = $User->where($map)->delete();
	   if($result) {
            $this->success("删除成功");
        }else {
        	echo $this->returnajax(300, "删除失败");
			die();
        }
    }
}
?>