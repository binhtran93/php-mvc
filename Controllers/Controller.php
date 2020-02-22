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
    /** @var BaseRequest $request */
    protected $request;

    /** @var BaseResponse $response */
    protected $response;

    /**
     * Controller constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->request = new BaseRequest();
        $this->response = new BaseResponse();
    }
}