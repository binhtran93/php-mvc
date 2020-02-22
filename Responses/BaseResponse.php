<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 12:42
 */
namespace Responses;

use SimpleXMLElement;

class BaseResponse implements IResponse
{
    const XML  = 'application/xml';
    const JSON = 'application/json';

    /**
     * @param $data
     * @param int $code
     * @return false|string
     */
    public function toJson($data, $code=200) {
        http_response_code($code);
        header('Content-Type: application/json');

        return json_encode($data);
    }

    /**
     * @param $data
     * @param int $code
     * @return mixed
     */
    public function toXml($data, $code=200) {
        http_response_code($code);

        header('Content-Type: application/xml');
        $simpleXMLElement = new SimpleXMLElement('<?xml version="1.0"?><data></data>');

        return \Utils::toXml($data, $simpleXMLElement)->asXML();
    }

    /**
     * @param $data
     * @param $type
     * @return false|string
     */
    public function to($data, $type) {
        return $type === self::JSON
            ? $this->toJson($data)
            : $this->toXml($data);
    }

    /**
     * @param $data
     * @return false|string
     */
    public function from($data) {
        $acceptTypes = $_SERVER['HTTP_ACCEPT'];
        $acceptTypeArr = explode(',', $acceptTypes);
        $acceptTypeArr = array_map(function($acceptType) {
            return trim($acceptType);
        }, $acceptTypeArr);

        $constantTypes = [self::JSON, self::XML];

        foreach ($constantTypes as $constantType) {
            foreach ($acceptTypeArr as $acceptType) {
                if ($acceptType === $constantType) {
                    return $this->to($data, $acceptType);
                }
            }
        }
        return $this->to($data, self::JSON);
    }
}