<?php

namespace App\Library;

use App\Library\HttpUtil;

class ElementsPlugin extends \Phalcon\Mvc\User\Component  {

    public function outputCss($key) {
        $config = $this->config;
        $version = $config->assetVersion;
        $assetCss = $config->asset->css;
        if (isset($assetCss->$key)) {
            $cssUrl = HttpUtil::urlAppendParams($assetCss->$key, array($config->versionParam => $config->assetVersion));
            return sprintf('<link href="%s" rel="stylesheet">' . PHP_EOL, $cssUrl);
        }
    }

    public function outputJs($key) {
        $config = $this->config;
        $version = $config->assetVersion;
        $assetJs = $config->asset->js;
        if (isset($assetJs->$key)) {
            $jsUrl = HttpUtil::urlAppendParams($assetJs->$key, array($config->versionParam => $config->assetVersion));
            return sprintf('<script src="%s"></script>' . PHP_EOL, $jsUrl);
        }
    }

}
