<?php

namespace MyPhalcon\App\Library;

use MyPhalcon\App\Library\StringUtil;
use MyPhalcon\App\Library\LoggerUtil;


class ValidateUtil {

    private static $valiLangs = array(
        'RULE_NOT_FIND'    => '找不到验证规则 [%s] ',
        'METHOD_NOT_FIND'  => '找不到验证的方法 [%s]',
        'ERROR_INPUT'      => '请输入正确的内容',
        'ERROR_NOT_EMPTY'  => '请输入内容',
        'ERROR_MIN_LEN'    => '长度不能小于%s个字符',
        'ERROR_MAX_LEN'    => '长度不能大于%s个字符',
        'ERROR_MIN_VAL'    => '不能小于%s',
        'ERROR_MAX_VAL'    => '不能大于%s',
        'ERROR_WORD'       => '只能输入中文',
        'ERROR_INT'        => '只能输入正整数',
        'ERROR_NUM'        => '只能输入整数',
        'ERROR_FLOAT'      => '只能输入小数',
        'ERROR_MOBILE'     => '请输入正确的手机号',
        'ERROR_EMAIL'      => '请输入正确的邮箱',
        'ERROR_MONEY'      => '请输入正确的金额',
        'ERROR_URL'        => '请输入正确的链接',
        'ERROR_IP'         => '请输入正确的IP地址',
        'ERROR_REGEX'      => '输入数据格式不正确',
        'ERROR_PWD_NUM'    => '密码只能是数字',
        'ERROR_PWD_CHAR'   => '密码只能是字母',
        'ERROR_PWD_CPLEX'  => '密码必须由字母、数字、符号组成',
        'ERROR_CONFIRM'    => '两次输入的密码不一致',
        'ERROR_IN_LIST'    => '输入数据不在指定列表中',
        'ERROR_FILE'       => '必须上传文件',
        'ERROR_EXT_IN'     => '只允许上传%s格式的文件',
        'ERROR_COUNT'      => '必须选择%s项',
        'ERROR_MIN_COUNT'  => '至少选择%s项',
        'ERROR_MAX_COUNT'  => '最多选择%s项',
        'ERROR_DOMAIN'     => '请输入正确的域名',
        'ERROR_ID'         => '请输入正确的身份证号',
    );

    private static $checker = array(
        'not-empty'  => 'checkNotEmpty',
        'min-len'    => 'checkMinLen',
        'max-len'    => 'checkMaxLen',
        'word'       => 'checkWord',
        'mobile'     => 'checkMobile',
        'min-val'    => 'checkMinVal',
        'max-val'    => 'checkMaxVal',
        'int'        => 'checkInt',
        'num'        => 'checkNum',
        'email'      => 'checkEmail',
        'float'      => 'checkFloat',
        'money'      => 'checkMoney',
        'url'        => 'checkUrl',
        'ip'         => 'checkIp',
        'regex'      => 'checkRegex',
        'pwd-num'    => 'checkPwdNum',
        'pwd-char'   => 'checkPwdChar',
        'pwd-cplex'  => 'checkPwdCplex',
        'confirm'    => 'checkConfirm',
        'in-list'    => 'checkInList',
        'file'       => 'checkFile',
        'ext-in'     => 'checkExtIn',
        'count'      => 'checkCount',
        'min-count'  => 'checkMinCount',
        'max-count'  => 'checkMaxCount',
        'domain'     => 'checkDomain',
        'id'         => 'checkId',
    );


    private static $data = array();

    private static $error = array();

    private static $userParams = array();

    private static $saveDataFlag = true;

    private static function initValidate($userParams) {
        self::$data  = array();
        self::$error = array();
        self::$userParams = $userParams;
    }

    private static function getParamValue($field) {
        return self::$userParams[$field];
    }

    private static function getRuleItemInfo($fieldRule) {
        $ruleArgs = explode(':', $fieldRule, 2);
        $ruleName = array_shift($ruleArgs);
        return array('ruleName' => trim($ruleName), 'ruleArgs' => $ruleArgs);
    }

    private static function getCheckMethod($ruleName) {
        if (empty(self::$checker[$ruleName])) {
            throw new \Exception(sprintf(self::$valiLangs['RULE_NOT_FIND'], $ruleName));
        }

        $checkMethod = self::$checker[$ruleName];
        if (!is_callable("self::$checkMethod")) {
            throw new \Exception(sprintf(self::$valiLangs['METHOD_NOT_FIND'], $checkMethod));
        }

        return self::$checker[$ruleName];
    }

    private static function runFieldRules($fieldName, $fieldRules) {
        self::$saveDataFlag = true;

        foreach ($fieldRules as $fieldRule => $userError) {
            if (is_int($fieldRule)) {
                $fieldRule = $userError;
                $userError = '';
            }

            $ruleItemInfo = self::getRuleItemInfo($fieldRule);
            $checkMethod  = self::getCheckMethod($ruleItemInfo['ruleName']);
            if (!self::$checkMethod($fieldName, $ruleItemInfo['ruleArgs'], $userError)) {
                return false;
            }
        }

        if (self::$saveDataFlag) {
            self::$data[$fieldName] = self::getParamValue($fieldName);
        }
    }

    private static function runUserRules($userRules) {
        foreach ($userRules as $fieldName => $fieldRules) {
            if (is_int($fieldName)) {
                $fieldName = $fieldRules;
                $fieldRules = array();
            }

            if (empty($fieldRules)) {
                self::$data[$fieldName] = self::getParamValue($fieldName);
                continue ;
            }

            self::runFieldRules($fieldName, $fieldRules);
        }
    }

    private static function getCheckResult() {
        $result = empty(self::$error);
        if (!$result) {
            $lang = get_lang('VALIDATE_PARAM_FAIL', json_encode(self::$userParams, JSON_UNESCAPED_UNICODE));
            LoggerUtil::warn($lang);
        }
        return array('result' => $result, 'error' => self::$error, 'data' => self::$data);
    }

    public static function validate($userParams, $userRules) {
        self::initValidate($userParams);
        self::runUserRules($userRules);
        return self::getCheckResult();
    }

    private static function checkIp($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^((?:(?:25[0-5]|2[0-4]\d|[01]?\d?\d)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d?\d))$~', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_IP', $userError));
        }

        return $checkRes;
    }

    private static function checkDomain($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^(?=^.{3,255}$)[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+$~', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_DOMAIN', $userError));
        }

        return $checkRes;
    }

    private static function checkMoney($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^(([1-9][0-9]*)|(([0]\.\d{1,2}|[1-9][0-9]*\.\d{1,2})))$~', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_MONEY', $userError));
        }

        return $checkRes;
    }

    private static function checkUrl($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^[a-zA-z]+://([\w-]+\.)+[\w-]+(/[\w-./?%&=]*)?$~', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_URL', $userError));
        }

        return $checkRes;
    }

    private static function checkId($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^(\d{15})|(\d{17}\d|x|X)$~', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_ID', $userError));
        }

        return $checkRes;
    }

    private static function checkEmail($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$~', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_EMAIL', $userError));
        }

        return $checkRes;
    }

    private static function checkMobile($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$~', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_MOBILE', $userError));
        }

        return $checkRes;
    }

    private static function checkWord($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^[\x{4e00}-\x{9fa5}]{1,}$~u', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_WORD', $userError));
        }

        return $checkRes;
    }

    private static function checkMinLen($fieldName, $ruleArgs, $userError) {
        $minLen = $ruleArgs[0];
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || StringUtil::strLenth($fieldValue) >= $minLen;
        if (!$checkRes) {
            $errorMsg = sprintf(self::getErrorMsg('ERROR_MIN_LEN', $userError), $minLen);
            self::addError($fieldName, $errorMsg);
        }

        return $checkRes;
    }

    private static function checkMaxLen($fieldName, $ruleArgs, $userError) {
        $maxLen = $ruleArgs[0];
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || StringUtil::strLenth($fieldValue) <= $maxLen;
        if (!$checkRes) {
            $errorMsg = sprintf(self::getErrorMsg('ERROR_MAX_LEN', $userError), $maxLen);
            self::addError($fieldName, $errorMsg);
        }

        return $checkRes;
    }

    private static function checkMinVal($fieldName, $ruleArgs, $userError) {
        $minVal = $ruleArgs[0];
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || $fieldValue >= $minVal;
        if (!$checkRes) {
            $errorMsg = sprintf(self::getErrorMsg('ERROR_MIN_VAL', $userError), $minVal);
            self::addError($fieldName, $errorMsg);
        }

        return $checkRes;
    }

    private static function checkMaxVal($fieldName, $ruleArgs, $userError) {
        $maxVal = $ruleArgs[0];
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || $fieldValue <= $maxVal;
        if (!$checkRes) {
            $errorMsg = sprintf(self::getErrorMsg('ERROR_MAX_VAL', $userError), $maxVal);
            self::addError($fieldName, $errorMsg);
        }

        return $checkRes;
    }

    private static function checkInt($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^\d+$~', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_INT', $userError));
        }

        return $checkRes;
    }

    private static function checkNum($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^[+-]?\d+$~', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_NUM', $userError));
        }

        return $checkRes;
    }

    private static function checkFloat($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || is_float($fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_FLOAT', $userError));
        }

        return $checkRes;
    }

    private static function checkRegex($fieldName, $ruleArgs, $userError) {
        $regex = $ruleArgs[0];
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match($regex, $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_REGEX', $userError));
        }

        return $checkRes;
    }

    private static function checkPwdNum($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^\d+$~', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_PWD_NUM', $userError));
        }

        return $checkRes;
    }

    private static function checkPwdChar($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || preg_match('~^[a-zA-Z]+$~', $fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_PWD_CHAR', $userError));
        }

        return $checkRes;
    }

    private static function checkPwdCplex($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        if (StringUtil::strLenth($fieldValue) == 0) {
            return true;
        }

        if (!preg_match('~[0-9]~', $fieldValue) || !preg_match('~[a-zA-Z]~', $fieldValue)) {
            self::addError($fieldName, self::getErrorMsg('ERROR_PWD_CPLEX', $userError));
            return false;
        }

        $other = preg_replace('~[0-9a-zA-Z]~', '', $fieldValue);
        if (StringUtil::strLenth($other)) {
            return true;
        }

        self::addError($fieldName, self::getErrorMsg('ERROR_PWD_CPLEX', $userError));
        return false;
    }

    private static function checkConfirm($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $compValue  = self::getParamValue($ruleArgs[0]);
        $checkRes = $fieldValue == $compValue;
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_CONFIRM', $userError));
        }

        return $checkRes;
    }

    private static function checkInList($fieldName, $ruleArgs, $userError) {
        $inList = explode(',', $ruleArgs[0]);
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || in_array($fieldValue, $inList);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_IN_LIST', $userError));
        }

        return $checkRes;
    }

    private static function checkFile($fieldName, $ruleArgs, $userError) {
        if (empty($_FILES[$fieldName]['name'])) {
            self::addError($fieldName, self::getErrorMsg('ERROR_FILE', $userError));
            return false;
        }

        self::$saveDataFlag = false;
        return true;
    }

    private static function checkExtIn($fieldName, $ruleArgs, $userError) {
        $extIn = explode(',', $ruleArgs[0]);
        $fieldValue = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
        $checkRes = StringUtil::strLenth($fieldValue) == 0 || in_array($fieldValue, $extIn);
        if (!$checkRes) {
            $errorMsg = sprintf(self::getErrorMsg('ERROR_EXT_IN', $userError), $ruleArgs[0]);
            self::addError($fieldName, $errorMsg);
        }

        self::$saveDataFlag = false;
        return $checkRes;
    }

    private static function checkCount($fieldName, $ruleArgs, $userError) {
        $count = $ruleArgs[0];
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = is_string($fieldValue) && StringUtil::strLenth($fieldValue) == 0 || count($fieldValue) == $count;
        if (!$checkRes) {
            $errorMsg = sprintf(self::getErrorMsg('ERROR_COUNT', $userError), $count);
            self::addError($fieldName, $errorMsg);
        }

        return $checkRes;
    }

    private static function checkMinCount($fieldName, $ruleArgs, $userError) {
        $minCount = $ruleArgs[0];
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = is_string($fieldValue) && StringUtil::strLenth($fieldValue) == 0 || count($fieldValue) >= $minCount;
        if (!$checkRes) {
            $errorMsg = sprintf(self::getErrorMsg('ERROR_MIN_COUNT', $userError), $minCount);
            self::addError($fieldName, $errorMsg);
        }

        return $checkRes;
    }

    private static function checkMaxCount($fieldName, $ruleArgs, $userError) {
        $maxCount = $ruleArgs[0];
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = is_string($fieldValue) && StringUtil::strLenth($fieldValue) == 0 || count($fieldValue) <= $maxCount;
        if (!$checkRes) {
            $errorMsg = sprintf(self::getErrorMsg('ERROR_MAX_COUNT', $userError), $maxCount);
            self::addError($fieldName, $errorMsg);
        }

        return $checkRes;
    }

    private static function checkNotEmpty($fieldName, $ruleArgs, $userError) {
        $fieldValue = self::getParamValue($fieldName);
        $checkRes = is_string($fieldValue) ? strlen($fieldValue) > 0 : false == empty($fieldValue);
        if (!$checkRes) {
            self::addError($fieldName, self::getErrorMsg('ERROR_NOT_EMPTY', $userError));
        }

        return $checkRes;
    }

    private static function addError($fieldName, $errorMsg) {
        self::$error[$fieldName] = $errorMsg;
    }

    private static function getErrorMsg($errorLabel, $userError) {
        if (!empty($userError)) {
            return $userError;
        }

        if (!empty(self::$valiLangs[$errorLabel])) {
            return self::$valiLangs[$errorLabel];
        }

        return self::$valiLangs['ERROR_INPUT'];
    }

}
