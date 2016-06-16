<?php
class ScoreAction extends CommonAction {
	public function index() {
		if(!empty($_POST['name'])){
			$map['name'] = array('like',"%".$_POST['name']."%");
		}
		if(!empty($_POST['card'])){
			$map['card'] = array('like',"%".$_POST['card']."%");
		}
		if(!empty($_POST['position'])){
			$map['position'] = array('like',"%".$_POST['position']."%");
		}
		$model = D ('Score');
		$count = $model->where($map )->count();
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
		$this->assign ( 'name', $_REQUEST['name'] );
		$this->assign ( 'card', $_REQUEST['card'] );
		$this->assign ( 'position', $_REQUEST['position']);
		$this->assign ( 'totalCount', $count );
		$this->assign ( 'numPerPage', $p->listRows );
		$this->assign ( 'currentPage', !empty($_REQUEST[C('VAR_PAGE')])?$_REQUEST[C('VAR_PAGE')]:1);
		Cookie::set ( '_currentUrl_', __SELF__ );
		$this->display ();
	}
	function doadd(){
		import('Admin.Util.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->maxSize  = 3145728 ;// 设置附件上传大小
		$upload->allowExts  = array('xls','xlsx');// 设置附件上传类型
		$upload->savePath =  '../Public/Uploads/files/';// 设置附件上传目录	
		$upload->autoSub = true;	//是否使用子目录保存上传文件
		$upload->subType = 'date';	//子目录创建方式，默认为hash，可以设置为hash或者date
		$upload->dateFormat = 'Ymd';	//子目录方式为date的时候指定日期格式
		if(!$upload->upload()) {// 上传错误提示错误信息
			echo $this->returnajax(300, $upload->getErrorMsg());
			die();
		}else{// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();	
			$url = '../Public/Uploads/files/'.$info[0]['savename'];
			Vendor('PHPExcel.PHPExcel');
			Vendor('PHPExcel.PHPExcel.IOFactory');
			Vendor('PHPExcel.PHPExcel.Reader.Excel5');
			$filePath = "$url";//需要导入的Excel文件完整路径
			$objReader = PHPExcel_IOFactory::createReader('Excel5');//use excel2007 for 2007 format
			$objPHPExcel = $objReader->load($filePath);//$file_url即Excel文件的路径
			$sheet = $objPHPExcel->getSheet(0);//获取第一个工作表
			$highestRow = $sheet->getHighestRow();//取得总行数
			$highestColumn = $sheet->getHighestColumn(); //取得总列数
			$num = 0;
			for($j=2;$j<=$highestRow;$j++){
				/* $str='';
				for($k='A';$k<=$highestColumn;$k++){       
					var_dump($objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue());die;
					$str.=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'\\';//读取单元格
				}
				$strs=explode("\\",$str);
				$query = "insert into score(`name`,`card`,`position`,`workshop`,`theme`,`subject`,`score`,`times`) 
								values('$strs[1]','$strs[2]','$strs[3]','$strs[4]','$strs[5]','$strs[6]','$strs[7]','$strs[8]');";
				$model=M();
				$model->query($query);
				$num ++; */
				$tempArray=array();
				for($k='A';$k<=$highestColumn;$k++){ 
					if($k=='I') //I列是时间
						$tempArray[] = $this->excelTime($objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue());
					else
						$tempArray[] = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
					}
					$strs=$tempArray;
					$query = "insert into score(`name`,`card`,`position`,`workshop`,`theme`,`subject`,`score`,`times`) 
							values('$strs[1]','$strs[2]','$strs[3]','$strs[4]','$strs[5]','$strs[6]','$strs[7]','$strs[8]');";
					$model=M();
					$model->query($query);
			}
			$this->success("添加成功");
		}
	}
	function excelTime($date, $time = false) {
		if(function_exists('GregorianToJD')){
			if (is_numeric( $date )) {
			$jd = GregorianToJD( 1, 1, 1970 );
			$gregorian = JDToGregorian( $jd + intval ( $date ) - 25569 );
			$date = explode( '/', $gregorian );
			$date_str = str_pad( $date [2], 4, '0', STR_PAD_LEFT )
			."-". str_pad( $date [0], 2, '0', STR_PAD_LEFT )
			."-". str_pad( $date [1], 2, '0', STR_PAD_LEFT )
			. ($time ? " 00:00:00" : '');
			return $date_str;
			}
		}else{
			$date=$date>25568?$date+1:25569;
			/*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/
			$ofs=(70 * 365 + 17+2) * 86400;
			$date = date("Y-m-d",($date * 86400) - $ofs).($time ? " 00:00:00" : '');
		}
	  return $date;
	}
	public function foreverdelete(){
		$id = $_REQUEST['id'];
		$Score = M('Score');
		$map['id'] = $id;
		$result = $Score->where($map)->delete();
		if(!empty($result)){
			$this->success('删除成功');
		}else{
			echo $this->returnajax(300,'删除失败！');
			die();
		}
		
	}
}
?>