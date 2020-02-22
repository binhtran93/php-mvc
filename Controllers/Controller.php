<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 11:46
 */
namespace Controllers;

use Requests\BaseRequest;
use Responses\BaseResponse;

class Controller
{
    /** @var BaseResponse $response */
    protected $response;

    /**
     * Controller constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->response = new BaseResponse();
    }
}