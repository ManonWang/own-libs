<?php

namespace Home\Service;

class UserService extends DefaultService {

    public function checkEnNameUnique($data) {
        $userModel = $this->getModel();
        $result = $userModel->getUserByEnName($data);

        if (false === $result) {
            return data_pack(get_code('FIND_DATA_FAIL'), get_lang('OPERATION_FAIL'));
        }

        if ($result) {
            return data_pack(get_code('DATA_REPEATE'), get_lang('DATA_REPEATE', $data['en_name']));
        }

        return data_pack(get_code('SUCC'));
    }

    public function beforeSave() {
        return $this->checkEnNameUnique($this->data['input']);
    }

    public function test() {
        return data_pack(get_code('SUCC'), null, func_get_args());
    }
}
