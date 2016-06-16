<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

class PublicAction extends Action {
	// 检查用户是否登录

	protected function checkUser() {
		if(!isset($_SESSION['shop_id'])) {
			$this->assign('jumpUrl','Public/login');
			$this->error('没有登录');
		}
	}

	// 顶部页面
	public function top() {
		C('SHOW_RUN_TIME',false);			// 运行时间显示
		C('SHOW_PAGE_TRACE',false);
		$model	=	M("Group");
		$list	=	$model->where('status=1')->getField('id,title');
		$this->assign('nodeGroupList',$list);
		$this->display();
	}
	// 尾部页面
	public function footer() {
		C('SHOW_RUN_TIME',false);			// 运行时间显示
		C('SHOW_PAGE_TRACE',false);
		$this->display();
	}
	// 菜单页面
	public function menu() {
		$this->display();
	}
	
    // 后台首页 查看系统信息
    public function main() {
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式'=>php_sapi_name(),
            'ThinkPHP版本'=>THINK_VERSION,
            '上传附件限制'=>ini_get('upload_max_filesize'),
            '执行时间限制'=>ini_get('max_execution_time').'秒',
            '服务器时间'=>date("Y年n月j日 H:i:s"),
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            '剩余空间'=>round((@disk_free_space(".")/(1024*1024)),2).'M',
            'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
            'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
            'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO',
            );
        $this->assign('info',$info);
        $this->display();
    }

	// 用户登录页面
	public function login() {
		 if(!isset($_SESSION['shop_id'])) {
			$this->display();
		}else{
			$this->redirect('Index/index');
		}
	}

	public function index()
	{
		//如果通过认证跳转到首页
		redirect(__APP__);
	}

	// 用户登出
    public function logout()
    {
        if(isset($_SESSION['shop_id'])) {
			unset($_SESSION['shop_id']);
			unset($_SESSION);
			session_destroy();
            $this->assign("jumpUrl",__URL__.'/login/');
            $this->success('登出成功！');
        }else {
            $this->error('已经登出！');
        }
    }

	// 登录检测
	public function checkLogin() {
		if(empty($_POST['user'])) {
			$this->error('帐号错误！');
		}elseif (empty($_POST['pass'])){
			$this->error('密码不能为空！');
		}elseif (empty($_POST['verify'])){
			$this->error('验证码不能为空！');
		}
        //生成认证条件
        $map     =   array();
		// 支持使用绑定帐号登录
		$map['user']	= $_POST['user'];
		if($_SESSION['verify'] != md5($_POST['verify'])) {
			$this->error('验证码错误！');
		}
        $authInfo = M('shop_user')->where($map)->find();
        //使用用户名、密码和状态的方式进行认证
        if(null === $authInfo) {
            $this->error('帐号不存在或已禁用！');
        }else {
            if($authInfo['pass'] != md5($_POST['pass'])) {
            	$this->error('密码错误！');
            }
            $_SESSION['shop_id']	=	$authInfo['id'];
            $_SESSION['state']	=	$authInfo['state'];
            $_SESSION['user']	=	$authInfo['user'];
			// 缓存访问权限
           // RBAC::saveAccessList();
			$this->success('登录成功！');

		}
	}
	
	public function ajax_Return($status,$message,$type="closeCurrent",$nav="",$for=""){
        $arr=array(
                "statusCode"=>$status,
                "message"=>$message,
                "navTabId"=>$nav,//刷新那个页面
                "forwardUrl"=>$for,
                "callbackType"=>$type//关闭页面closeCurrent代表关闭,为空就不关闭页面
        );
        return json_encode($arr);
    }
	
    // 更换密码
    public function changePwd()
    {
		$this->checkUser();
        //对表单提交处理进行处理或者增加非表单数据
		if(md5($_POST['verify'])	!= $_SESSION['verify']) {
			echo $this->returnajax(300, "验证码错误！");
			die();
		}
		$map	=	array();
        $map['pass']= pwdHash($_POST['oldpass']);
        if(isset($_POST['user'])) {
            $map['user']	 =	 $_POST['user'];
        }elseif(isset($_SESSION['shop_id'])) {
            $map['id']		=	$_SESSION['shop_id'];
        }
        //检查用户
        $User    =   M("shop_user");
        if(!$User->where($map)->field('id')->find()) {
			echo $this->returnajax(300, "旧密码不符或者用户名错误！");
			die();
        }else {
			$User->pass	=	pwdHash($_POST['pass']);
			$User->save();
			$this->success('密码修改成功！');
         }
    }
	
	public function verify()
    {
		$type	 =	 isset($_GET['type'])?$_GET['type']:'gif';
        import("@.ORG.Util.Image");
        Image::buildImageVerify(4,1,$type);
    }

// 检查帐号
	public function checkShop_name($id) {
		$shop_user = M("shop_user");
        // 检测用户名是否冲突
        $shop_name  =  $_REQUEST['shop_name'];
		if(!empty($id)){
			$map['id'] = array('neq',$id);
		}
		$map['shop_name'] = $shop_name;
        $result  =  $shop_user->where($map)->find();
        if($result) {
			echo $this->returnajax(300, "该店铺名已经存在！");
			die();
        }
    }
	// 检查帐号
	public function checkAccount($id) {
        if(!preg_match('/^[1][3578][0-9]{9}$/',$_POST['user'])) {
			echo $this->returnajax(300, "用户名必须是手机号！");
			die();
        }
		$shop_user = M("shop_user");
        // 检测用户名是否冲突
        $name  =  $_REQUEST['user'];
		if(!empty($id)){
			$map['id'] = array('neq',$id);
		}
		$map['user'] = $name;
        $result  =  $shop_user->where($map)->find();
        if($result) {
			echo $this->returnajax(300, "该用户名已经存在！");
			die();
        }
    }
	//上传logo
	public function upload_logo(){
		$sid = $_SESSION['shop_id'];
		import('Shop.Util.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->savePath =  '../Public/Uploads/shop/'.$sid.'/';// 设置附件上传目录	
		$upload->thumb = false;	//是否需要对图片文件进行缩略图处理，默认为false
		$upload->thumbPrefix = '';	//缩略图的文件前缀，默认为thumb_
		$upload->uploadReplace = true;	//是否覆盖
		$upload->thumbRemoveOrigin = false;	//生成缩略图后是否删除原图 
		$upload->autoSub = false;	//是否使用子目录保存上传文件
		$upload->subType = 'date';	//子目录创建方式，默认为hash，可以设置为hash或者date
		$upload->dateFormat = 'Ymd';	//子目录方式为date的时候指定日期格式
		if(!$upload->upload()) {// 上传错误提示错误信息
			echo $this->returnajax(300, $upload->getErrorMsg());
			die();
		}else{// 上传成功 获取上传文件信息
				$info =  $upload->getUploadFileInfo();	
				$logo = $info[0]['savename'];
				return $logo;
		}
	}
}
	
?>