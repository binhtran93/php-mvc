<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 14:30
 */

namespace Requests;


use Models\Payment;

class PaymentValidationRequest extends BaseRequest {

    public function rules() {
        return [
            'type' => [
                "Rules\Required" => null,
                "Rules\Enum"     => Payment::getTypes()
            ],
            'credit_card_number' => [
                'Rules\RequiredIf' => ['type', Payment::TYPE_CREDIT_CARD],
                'Rules\CreditCardNumber' => null
            ],
            'name' => [
                'Rules\RequiredIf' => ['type', Payment::TYPE_CREDIT_CARD],
            ],
            'expiration_date' => [
                'Rules\RequiredIf' => ['type', Payment::TYPE_CREDIT_CARD],
                'Rules\ExpiredDate' => null
            ],
            'ccv2' => [
                'Rules\RequiredIf' => ['type', Payment::TYPE_CREDIT_CARD],
                "Rules\Regex" => ['/^\d{3,4}$/'] // regex check 3 or 4 digit
            ],
            'email' => [
                'Rules\RequiredIf' => ['type', Payment::TYPE_CREDIT_CARD],
                'Rules\Email' => null
            ],
            'phone_number' => [
                'Rules\RequiredIf' => ['type', Payment::TYPE_MOBILE],
                "Rules\Regex" => ['/^\+?\d{7,16}$/'] // simple regex with min is 7 and max is 16 number, may be start with +
            ]
        ];
    }
}