<?php

namespace Home\Model;

class UserModel extends BaseModel {

    public function getUserByEnName($data) {
        $conds = 'en_name = :en_name';
        $binds = array('en_name' => $data['en_name']);

        if (!empty($data['id'])) {
            $conds .= ' AND id != :id';
            $binds[':id'] = $data['id'];
        }

        return $this->getRow(array('conds' => $conds, 'bind' => $binds));
    }

    public function getPagedConds($data) {
        $conds = '1 = 1';
        $binds = array();

        if (!empty($data['zh_name'])) {
            $conds .= ' AND zh_name = :zh_name';
            $binds[':zh_name'] = $data['zh_name'];
        }

        return array('conds' => $conds, 'bind' => $binds);
    }

}
