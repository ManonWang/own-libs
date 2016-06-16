<?php 
class PayModel extends CommonModel{
		
		//$check = D('Pay')->log($id,$price,2);
		public function log($sid,$money,$type){
			/*
			*sid 商店ID
			*money 变动金额
			*type 1订单收入 2提现
			*/
			$Shop_paylog = M('Shop_paylog');
			$map['sid'] = $sid;
			$result = $Shop_paylog->field('id,total,balance,withdrawal')->where($map)->find();
			if(empty($result)){
				switch($type){
					case 1:
						//为空，新增一条数据
						$data['sid'] = $sid;
						$data['total'] = $money;
						$data['balance'] = $money;
						$data['withdrawal'] = '0.00';
						$data['ctime'] =time();
						$results = $Shop_paylog->add($data);
					break;
					case 2:
						return false;
					break;
				}
			}else{
				//不为空,修改数据
				switch($type){
					case 1:
					$data['total'] = $result['total']+$money;
					$data['balance'] = $result['balance']+$money;
					$data['withdrawal'] = $result['withdrawal'];
					$data['ctime'] = time();
					break;
					
					case 2:
					$data['total'] = $result['total'];
					$data['balance'] = $result['balance']-$money;
					$data['withdrawal'] = $result['withdrawal']+$money;
					$data['ctime'] = time();
					break;
				}
				$results = $Shop_paylog->where($map)->save($data);
			}
				if(!empty($results)){
						return true;
					}else{
						return false;
					}
		}
    }
?>