<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once APPPATH . 'core/v1/Controller.php';

require_once APPPATH . 'controllers/v1/autoloader.php';

use Misc\Controller;
use Misc\Models\TabModels;
use Misc\Authorize;
use Misc\Models\AppHashKeyModels;
use Misc\Object\Values\ResultObject;
use Misc\Http\Util;
use Misc\Models\GSVInfoModels;

class ApiController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->setDbConfig(array('db' => 'system_info', 'type' => 'slave'));
    }

    public function init() {
        try {
            $paramBodys = $this->getReceiver()->getBodys();
            $paramHeaders = $this->getReceiver()->getHeaders();

            $author = new Authorize();
            $author->setDbConfig($this->getDbConfig());

            $resultAuthor = $author->AuthorizeRequest($paramBodys, $paramHeaders);

            if ($resultAuthor->getCode() === ResultObject::AUTHORIZE_SUCCESS) {
                //to chức cache data tại chổ này
                //nếu cache == true return kết quả ngược lại đọc db
            } else {
                $resultAuthor->OutOfEncryptResponse();
            }
        } catch (Exception $ex) {
            $resultAuthor = new ResultObject();
            $resultAuthor->setCode(ResultObject::EXCEPTION);
            $resultAuthor->setMessage($ex->getMessage());
            $resultAuthor->OutOfEncryptResponse();
        }
    }

    public function StateApproved() {
        //chưa hỗ trợ post
        try {
            $paramBodys = $this->getReceiver()->getBodys();
            $resultAuthor = new ResultObject();
            if (isset($paramBodys["channel"])) {

                $gsvInfo = new GSVInfoModels($this->getDbConfig(), $this);
                $channel = $paramBodys["channel"];
                $pos = mb_strpos($channel, "gsv_");
                $posId = mb_strpos(mb_substr($channel, $pos + 4), "_");                
                $gsv = mb_substr($channel, $pos, $posId + 4);                
                $info = $gsvInfo->getConfig(array("gsv_id" => $gsv, "platform" => $paramBodys["platform"], "service_id" => $paramBodys["app"]), array("status"));                
                $resultAuthor->setCode(ResultObject::REQUEST_SUCCESS);
                $resultAuthor->setData($info);
                $resultAuthor->OutOfJsonResponse();
            } else {
                $resultAuthor->setCode(ResultObject::REQUEST_FAILED);
                $resultAuthor->OutOfJsonResponse();
            }
        } catch (Exception $ex) {
            $resultAuthor = new ResultObject();
            $resultAuthor->setCode(ResultObject::EXCEPTION);
            $resultAuthor->setMessage($ex->getMessage());
            $resultAuthor->OutOfJsonResponse();
        }
    }

}
