<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 10:42
 */
namespace Models;

class Payment {
    const TYPE_CREDIT_CARD = 'credit_card';
    const TYPE_MOBILE = 'mobile';

    /**
     * @return array
     */
    public static function getTypes() {
        return [
            self::TYPE_CREDIT_CARD,
            self::TYPE_MOBILE
        ];
    }
}