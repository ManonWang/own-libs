<?php

namespace Home\Model;

use Think\Model;

class BaseModel extends Model {

    public function saveOne($data) {
        $data['update_time'] = time();
        if (empty($data['create_time'])) {
            $data['create_time'] = time();
        }

        if (!$this->create($data)) {
            return $this->getError();
        }

        if (!empty($data['id'])) {
            return $this->save();
        }

        return $this->add();
    }

    public function getOne($conds, $order = null) {
        $obj = $this->where($conds);

        if (!empty($order)) {
            $obj = $obj->order($order);
        }

        return $obj->find();
    }

    public function getList($conds, $order = null, $limit = null) {
        $obj = $this->where($conds);

        if (!empty($order)) {
            $obj = $obj->order($order);
        }

        if (!empty($limit)) {
            $obj = $obj->limit($limit);
        }

        return $obj->select();
    }
    
    public function getPagedList($conds, $order, $pageNum = 1, $pageSize = 20, $showNum = 9) {
        $count = $this->where($conds)->count();
        if (!$count) {
            return $count;
        }

        $totalPage = ceil($count / $pageSize);
        $pageNum < 1 && $pageNum = 1;
        $pageNum > $totalPage && $pageNum = $totalPage;
        $limit  = ($pageNum - 1) * $pageSize . ', ' . $pageSize;

        $list = $this->getList($conds, $order, $limit);
        if (false === $list) {
            return $list;
        }
        
        $numbers = array();
        $left  = ceil($showNum / 2); 
        $right = $showNum - $left;

        if ($pageNum - $left <= 0) {
            for ($index = 1; $index <= min($totalPage, $showNum); $index ++) {
                array_push($numbers, $index);
            }   
        } elseif ($pageNum + $right >= $totalPage) {
            for ($index = $totalPage; $index > max($totalPage - $showNum, 1); $index --) {
                array_unshift($numbers, $index);
            }
        } else {
            for ($index = $pageNum - $left + 1; $index <= $pageNum + $right; $index ++) {
                array_push($numbers, $index);
            }       
        }

        return array(
           'current_page' => $pageNum, 
           'total_page'   => $totalPage, 
           'total_count'  => $count, 
           'show_num'  => $numbers, 
           'paged_url' => get_curr_url(true), 
           'data_list' => $list
        );
    }

    public function hashByFeild($data, $feild) {
        $return = array();
        foreach ($data as $item) {
            $return[$item[$feild]] = $item;
        }
        return $return;
    }

}
