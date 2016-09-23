<?php

namespace MyPhalcon\App\Models;

use MyPhalcon\App\Library\LoggerUtil;

class BaseModel extends \Phalcon\Mvc\Model {

    const DB_READ_KEY  = 'db_myPhalcon_r'; //读服务
    const DB_WRITE_KEY = 'db_myPhalcon_w'; //写服务

    public function initialize() {
        $this->setReadConnectionService(self::DB_READ_KEY);
        $this->setWriteConnectionService(self::DB_WRITE_KEY);
    }

    /**
     * 转义函数
     * @param  string $str 要转义的字符串
     * @return string 转义后的字符串
     */
    public function escape($str) {
        return @mysql_escape_string($str);
    }

    /**
     * 获取第一条出错信息
     * @return string 错误信息
     */
    public function getFirstError() {
        $message = (array) $this->getMessages();
        return (string) current($message);
    }

    /**
     * 保存一条数据
     * @param array $data 保存的数据, 例如: array('name' => 'zhangsan')
     * @return false or array 保存失败时返回false, 保存成功时候返回array, 例如: array('id'=>1, 'name'=>'zhangsan')
     */
    public function saveRow(array $data) {
        try {
            $result = $this->save($data);
            if (false !== $result) {
                return $this->toArray();
            }

            $message = $this->getFirstError();
            if ($message) {
                LoggerUtil::error($message);
            }

            return false;
        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return false;
        }
    }

    /**
     * 获取列字符串
     * @param mixed $columns 获取的列, 例如:'id, name' 或者 array('id', 'name')
     * @return string 列字符串 'id, name'
     */
    public function getColumns($columns) {
        return is_array($columns) ? implode(', ', $columns) : $columns;
    }

    /**
     * 获取排序字符串
     * @param  mixed $order 排序规则,如: 'id DESC, create_time ASC' 或者 array('id' => 'DESC', 'create_time' => 'ASC')
     * @return string 排序字符串 'id DESC, create_time ASC'
     */
    public function getOrder($order) {
        if (!is_array($order)) {
            return $order;
        }

        $tmp = array();
        foreach ($order as $field => $sort) {
            $tmp[] = sprintf('%s %s', $field, $sort);
        }

        return implode(', ', $tmp);
    }

    /**
     * 按条件查询一条数据
     * @param array  $conds   查询条件,例如: array('conditions' => 'name = :name:', 'bind' => array('name' => 'zhangsan'))
     * @param mixed  $order   排序规则,例如: 'id DESC, create_time ASC' 或者 array('id' => 'DESC', 'create_time' => 'ASC')
     * @param mixed  $columns 查询的列,例如: 'id, name' 或者  array('id', 'name')
     * @return false or array 查询失败时返回false, 查询失败成功时候返回array, 例如: array('id' => 1, 'name' => 'zhangsan')
     */
    public function getRow(array $conds, $order = '', $columns = '') {
        try {
            $criteria = $conds;

            if ($columns) {
                $criteria['columns'] = $this->getColumns($columns);
            }

            if ($order) {
                $criteria['order'] = $this->getOrder($order);
            }

            $result = static::findFirst($criteria);
            if (false !== $result) {
                return $result->toArray();
            }

            $message = $this->getFirstError();
            if ($message) {
                LoggerUtil::error($message);
                return false;
            }

            return array();
        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return false;
        }
    }


    /**
     * 获取偏移量
     * @param mixed $limit 例如: '0, 10' 或者 10 或者 array(0, 10)
     * @return string 偏移量字符串 '0, 10'
     */
    public function getLimit($limit) {
        return is_array($limit) ? implode(', ', $limit) : $limit;
    }

    /**
     * 按条件查询数据
     * @param array  $conds   查询条件,例如: array('conditions' => 'name = :name:', 'bind' => array('name' => 'zhangsan'))
     * @param mixed  $order   排序规则,例如: 'id DESC, create_time ASC' 或者 array('id' => 'DESC', 'create_time' => 'ASC')
     * @param mixed  $columns 查询的列,例如: 'id, name' 或者  array('id', 'name')
     * @param mixed  $limit   获取的数据行数,例如: '0, 10' 或者 10 或者 array(0, 10)
     * @return false or array 查询失败时返回false, 查询失败成功时候返回array, 例如: array('id' => 1, 'name' => 'zhangsan')
     */
    public function getRows(array $conds, $order = '', $columns = '', $limit = '') {
        try {
            $criteria = $conds;

            if ($columns) {
                $criteria['columns'] = $this->getColumns($columns);
            }

            if ($order) {
                $criteria['order'] = $this->getOrder($order);
            }

            if ($limit) {
                $criteria['limit'] = $this->getLimit($limit);
            }

            $result = static::find($criteria);
            if (false !== $result) {
                return $result->toArray();
            }

            $message = $this->getFirstError();
            if ($message) {
                LoggerUtil::error($message);
                return false;
            }

            return array();
        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return false;
        }
    }

    /**
     * 获取记录行数
     * @param array $conds 查询条件,例如: array('conditions' => 'name = :name:', 'bind' => array('name' => 'zhangsan'))
     * @return false or int 查询失败时返回false, 查询失败成功时候返回个数
     */
    public function getRowsCount(array $conds) {
        try {
            $criteria = $conds;

            $result = static::count($criteria);
            if (false !== $result) {
                return $result;
            }

            $message = $this->getFirstError();
            if ($message) {
                LoggerUtil::error($message);
                return false;
            }
        } catch (\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return false;
        }
    }

    /**
     * 获取分页信息
     * @param int $count 总记录数
     * @param int $pageNo 当前是第几页
     * @param int $pageSize 每页显示多少数据
     * @return array 分页信息
     */
    public function getPageInfo($count, $pageNo = 1, $pageSize = 15) {
        $totalPage = ceil($count / $pageSize);
        $pageNo > $totalPage && $pageNo = $totalPage;
        $pageNo < 1 && $pageNo = 1;

        return array(
            'limit' => sprintf('%d , %d', ($pageNo - 1) * $pageSize, $pageSize),
            'pager' => array(
                'totalRow'  => $count, //总记录数
                'totalPage' => $totalPage, //总页数
                'pageNo'    => $pageNo, //当前页数
                'pageSize'  => $pageSize, //每页数量
                'first'     => $totalPage > 0 ? 1 : false, //第一页
                'prev'      => $pageNo - 1 >= 1 ? $pageNo - 1 : false, //上一页
                'num'       => $totalPage > 0 ? $this->getShowNum($totalPage, $pageNo) : array(), //显示的页码
                'next'      => $pageNo + 1 <= $totalPage ? $pageNo + 1 : false, //下一页
                'last'      => $totalPage > 0 ? $totalPage : false, //最后一页
             ),
        );
    }

    /**
     * 获取显示的页码
     * @param int $totalPage 总页数
     * @param int $pageNo 当前是第几页
     * @param int $showNum 显示多少页的页码
     * @return array 要显示的页码 array(2,3,4,5,6,7)
     */
    public function getShowNum($totalPage, $pageNo = 1, $showNum = 10) {
        if ($pageNo <= $showNum / 2 + 1) {
            $pageStart = 1;
            $pageEnd   = $showNum;
            if ($pageEnd > $totalPage) {
                $pageEnd = $totalPage;
            }
        } else {
            $pageStart = $pageNo - $showNum / 2;
            $pageEnd   = $pageNo + $showNum / 2 - 1;
            if ($pageEnd > $totalPage) {
                $pageEnd = $totalPage;
                $pageStart = $totalPage - $showNum + 1;
            }
        }

        if ($pageEnd <= $showNum) {
            $pageStart = 1;
        }

        return range($pageStart, $pageEnd);
    }

    /**
     * 获取分页数据
     * @param array  $conds   查询条件,例如: array('conditions' => 'name = :name:', 'bind' => array('name' => 'zhangsan'))
     * @param mixed  $order   排序规则,例如: 'id DESC, create_time ASC' 或者 array('id' => 'DESC', 'create_time' => 'ASC')
     * @param int $pageNo 当前是第几页
     * @param int $pageSize 每页显示多少数据
     * @param mixed  $columns 查询的列,例如: 'id, name' 或者  array('id', 'name')
     * @return false or array 失败返回false
     */
    public function getPageRows(array $conds, $order = '', $pageNo = 1, $pageSize = 15, $columns = '') {
        $criteria = $conds;

        $count = $this->getRowsCount($criteria);
        if (false === $count) {
            return false;
        }

        $rowCount = intval($count);
        if ($rowCount <= 0) {
            return array();
        }

        $pager  = $this->getPageInfo($rowCount, $pageNo, $pageSize);
        $result = $this->getRows($criteria, $order, $columns, $pager['limit']);
        if (false === $result) {
            return $result;
        }

        return array(
            'pager' => $pager['pager'],
            'rows'  => $result,
        );
    }

    /**
     * 根据id或者多个id查询数据
     * @param mixed  $id      查询条件,例如: 5 或者 array(1, 3)
     * @return false or array 查询失败时返回false, 查询失败成功时候返回array, 例如: array('id' => 1, 'name' => 'zhangsan')
     */
    public function getByIds($id) {
        if (empty($id)) {
            return array();
        }

        if (is_array($id)) {
            return $this->getRows(array('conditions' => 'id IN (' . implode(',', $id) . ')'));
        }

        return $this->getRow(array('conditions' => 'id = :id:', 'bind' => array('id' => $id)));
    }

    /**
     * 获取默认的分页数据的方法
     * @param array $data 外部传入的数据
     * @return false or array 错误时候返回false
     */
    public function getPagedList($data) {
        $conds = $this->getPagedConds($data);
        $order = $this->getPagedOrder($data);
        $pageNo   = $this->getPageNo($data);
        $pageSize = $this->getPageSize($data);
        return $this->getPageRows($conds, $order, $pageNo, $pageSize);
    }

    /**
     * 获取默认的分页查询条件,需要在父类重写
     * @param array $data 外部传入的数据
     * @return array 查询条件 array('conditions' => 'name = :name:', 'bind' => array('name' => 'zhangsan'))
     */
    public function getPagedConds($data) {
        $conds['conditions'] = '1 = 1';
        $conds['bind'] = array();
        return $conds;
    }

    /**
     * 获取默认的排序规则
     * @param array $data 外部传入的数据
     * @param string $orderBy 排序的字段 默认字段field   默认按id排序
     * @param string $orderRule  排序规则字段 默认字段order 默认是降序
     */
    public function getPagedOrder($data, $orderBy = 'order_by', $orderRule = 'order_rule') {
        $field = $data[$orderBy] ? $data[$orderBy] : 'id';
        $order = $data[$orderRule] == 1 ? 'ASC' : 'DESC';
        return sprintf('%s %s', $field, $order);
    }

    /**
     * 获取当前页码
     * @param array $data 外部传入的数据
     * @param string $pageNoField 排序的字段 默认字段page_no
     * @return int 当前页码
     */
    public function getPageNo($data, $pageNoField = 'page_no') {
        return $data[$pageNoField] > 0 ? intval($data[$pageNoField]) : 1;
    }

    /**
     * 获取每页数量
     * @param array $data 外部传入的数据
     * @param string $pageSizeField 排序的字段 默认字段page_size
     * @param int $defaultPageSize 默认每页显示数量
     * @param int $maxPageSize 最大每页显示数量,用于防止内存打爆
     * @return int  每页数量
     */
    public function getPageSize($data, $pageSizeField = 'page_size', $defaultPageSize = 15, $maxPageSize = 1000) {
        $pageSize = $data[$pageSizeField] > 0 ? intval($data[$pageSizeField]) : $defaultPageSize;
        return min($pageSize, $maxPageSize);
    }

    /**
     * 根据等值条件获取数据
     * @param array $data 外部传入的数据, 例如 array('age' => 18, 'status' => array(1, 2))
     * @param mixed  $limit   获取的数据行数,例如: '0, 10' 或者 10 或者 array(0, 10)
     * @param mixed  $order   排序规则,例如: 'id DESC, create_time ASC' 或者 array('id' => 'DESC', 'create_time' => 'ASC')
     * @param mixed  $columns 查询的列,例如: 'id, name' 或者  array('id', 'name')
     * @return false or array 查询失败时返回false, 查询失败成功时候返回array, 例如: array('id' => 1, 'name' => 'zhangsan')
     */
    public function getByEqualsConds($data, $limit = '', $order = '', $columns = '') {
        $binds = array();
        $conds = array('1 = 1');

        foreach ($data as $field => $value) {
            if (is_array($value)) {
                $value = array_map(array($this, 'escape'), $value);
                $conds[] = sprintf("%s IN ('%s')", $field, implode("', '", $value));
            } else {
                $conds[] = sprintf("%s = :%s:", $field, $field);
                $binds[$field] = $value;
            }
        }

        $conds = implode(' AND ', $conds);
        return $this->getRows(array('conditions' => $conds, 'bind' => $binds), $order, $columns, $limit);
    }

    /**
     * 执行原生的查询sql
     * @params string $sql    查询的sql
     * @params array $params  查询的参数
     * @params bool  $read  是否是读实例
     * @return false or array 执行失败返回false， 成功返回数组
     */
    public function execSelect($sql, $params = null, $read = true) {
        try {
            $connect = $read ? $this->getReadConnection() : $this->getWriteConnection();
            $result  = $connect->query($sql, $params);
            if (false === $result) {
                LoggerUtil::error($connect->getErrorInfo());
                return false;
            }

            $result = new \Phalcon\Mvc\Model\Resultset\Simple(null, $this, $result);
            return $result->toArray();
        } catch(\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return false;
        }
    }

    /**
     * 执行原生的插入sql
     * @params string $sql    查询的sql
     * @params array $params  查询的参数
     * @return false or int 执行失败返回false, 成功返回插入的id
     */
    public function execInsert($sql, $params = null) {
        try {
            $connect = $this->getWriteConnection();
            $result = $connect->execute($sql, $params);
            if (false === $result) {
                LoggerUtil::error($connect->getErrorInfo());
                return false;
            }

            return $connect->lastInsertId();
        } catch(\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return false;
        }
    }

    /**
     * 执行原生的更新sql
     * @params string $sql    查询的sql
     * @params array $params  查询的参数
     * @return false or int 执行失败返回false，成功返回影响行数
     */
    public function execUpdate($sql, $params = null) {
        try {
            $connect = $this->getWriteConnection();
            $result = $connect->execute($sql, $params);
            if (false === $result) {
                LoggerUtil::error($connect->getErrorInfo());
                return false;
            }

            return $connect->affectedRows();
        } catch(\Exception $e) {
            LoggerUtil::error($e->getMessage());
            return false;
        }
    }

}
