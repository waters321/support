<?php

class Base_OpacityController extends \Yaf\Controller_Abstract
{
    public function init()
    {
        // $topMenus = AdmUserModel::getInstance()->getModule('top', AdmUserModel::getInstance()->purview);
        // $leftMenus = AdmUserModel::getInstance()->getModule('left', AdmUserModel::getInstance()->purview);

        $this->getView()->assign("APP_VERSION", APP_VERSION);
        $this->getView()->assign("APP_WEB_HOST", APP_WEB_HOST);
        $this->getView()->assign("APP_STATIC_HOST", APP_STATIC_HOST);   
        
        $this->getView()->assign("APP_STATIC_VERSION", time());

    }

    /**
     * 输出 json
     */
    public function showMessage($message, $scriptCode = null, $autoScript = null,  $code = 0, $error = '')
    {
        \Tool::show_message($message, $autoScript, $scriptCode, $code, $error);
    }
}