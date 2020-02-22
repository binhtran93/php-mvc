<?php
namespace Controllers;

use Requests\PaymentValidateRequest;

/**
 * Created by PhpStorm.
 * User: binh
 * Date: 21/02/2020
 * Time: 23:30
 */

class PaymentController extends Controller
{
    /**
     * PaymentController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function validate(PaymentValidateRequest $request) {
        $data = $request->all();

        $errors = $request->validate();
        if (count($errors) > 0) {
            echo $this->response->toJson($errors, 400);
            die();
        }

        echo $this->response->toJson($data);
    }
}