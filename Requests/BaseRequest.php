<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 12:33
 */

namespace Requests;

use Exception;
use Exceptions\MethodNotAllowed;
use Rules\Rule;

abstract class BaseRequest implements IRequest
{
    /**
     * Only support
     * 1. GET and POST for simple MVC
     * 2. urlencoded for POST request
     */
    const POST = 'POST';
    const GET = 'GET';
    const SUPPORT_METHODS = [self::POST, self::GET];

    /**
     * Request constructor.
     * @throws Exception
     */
    public function __construct()
    {
        if (!$this->isSupportMethod()) {
            throw new MethodNotAllowed('Method is not support');
        }
    }

    /**
     * @return bool
     */
    private function isSupportMethod() {
        return in_array($_SERVER['REQUEST_METHOD'], self::SUPPORT_METHODS);
    }

    public abstract function rules();

    /**
     * @return array
     * @throws Exception
     */
    public function validate() {
        $errors = [];
        $data = $this->all();
        $keyWithRules = $this->rules() ?? [];

        foreach ($keyWithRules as $key => $rules) {
            $value = $data[$key] ?? null;

            foreach ($rules as $rule => $params) {
                $params = $params ?? [];
                /** @var Rule $ruleInstance */
                $ruleInstance = new $rule($key, $value, $data, ...$params);
                $isValid = $ruleInstance->isValid();
                if (!$isValid) {
                    $errors[$key][] = $ruleInstance->message();
                }
            }

        }

        return $errors;
    }

    /**
     * Retrieve all of input data
     *
     * @return mixed
     */
    public function all() {
        $params = [];
        if ($_SERVER['REQUEST_METHOD'] === self::POST) {
            if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
                $data = $this->parseJson();
            } else if ($_SERVER['CONTENT_TYPE'] === 'application/xml') {
                $data = $this->parseXml();
            } else {
                $data = $_POST;
            }

            foreach ($data as $key => $value) {
                $params[$key] = $value;
            }
        }

        return $params;
    }

    /**
     * @return array|mixed
     */
    private function parseJson() {
        try {
            $data = json_decode(file_get_contents('php://input'));
        } catch (\Throwable $t) {
            $data = [];
        }
        return $data;
    }

    /**
     * @return array|mixed
     */
    private function parseXml() {
        try {
            $xml = simplexml_load_string(
                file_get_contents('php://input'),
                "SimpleXMLElement",
                LIBXML_NOCDATA
            );
            $json = json_encode($xml);
            $data = json_decode($json,true);
        } catch (\Throwable $t) {
            $data = [];
        }
        return $data;
    }
}