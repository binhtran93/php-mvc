<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 17:28
 */

class Utils
{
    /**
     * @param $array
     * @param SimpleXMLElement $simpleXMLElement
     * @return mixed
     */
    public static function toXml($array, &$simpleXMLElement) {
        foreach( $array as $key => $value ) {
            if (!is_array($value)) {
                $simpleXMLElement->addChild($key, htmlspecialchars($value));
                continue;
            }

            $key = is_numeric($key) ? 'item' : $key;
            $subNode = $simpleXMLElement->addChild($key);
            self::toXml($value, $subNode);
        }

        return $simpleXMLElement;
    }
}