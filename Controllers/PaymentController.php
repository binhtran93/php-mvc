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
    public function index() {

    }

    public function validate(BaseRequest $request) {
        $data = $this->request->all();

        return $this->response->toJson($data);
    }
}