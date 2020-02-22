<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 14:30
 */

namespace Requests;


use Rules\Required;

class PaymentValidationRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => [
                Required::class,
            ]
        ];
    }
}