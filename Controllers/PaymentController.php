<?php
namespace Controllers;

use Requests\BaseRequest;

/**
 * Created by PhpStorm.
 * User: binh
 * Date: 21/02/2020
 * Time: 23:30
 */

class PaymentController extends Controller
{
    /** @var BaseRequest $request */
    private $request;

    /**
     * PaymentController constructor.
     * @param BaseRequest $request
     * @throws \Exception
     */
    public function __construct(BaseRequest $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    public function validate() {
        $data = $this->request->all();

        echo $this->response->toJson($data);
        die();
    }
}