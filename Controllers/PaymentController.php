<?php
namespace Controllers;

use Models\Payment;
use Requests\PaymentValidationRequest;

/**
 * Created by PhpStorm.
 * User: binh
 * Date: 21/02/2020
 * Time: 23:30
 */

class PaymentController extends Controller {
    /** @var Payment $payment */
    private $payment;
    /**
     * PaymentController constructor.
     * @param Payment $payment
     * @throws \Exception
     */
    public function __construct(Payment $payment)
    {
        parent::__construct();
        $this->payment = $payment;
    }

    /**
     * @param PaymentValidationRequest $request
     * @throws \Exception
     */
    public function validate(PaymentValidationRequest $request) {
        $errors = $request->validate();

        echo $this->response->from([
            'valid'  => !count($errors),
            'errors' => $errors
        ]);
    }
}