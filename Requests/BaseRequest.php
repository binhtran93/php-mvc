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
     */
    public function validate() {
        $errors = [];
        $data = $this->all();
        $validations = $this->rules() ?? [];

        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $validations)) {
                continue;
            }

            $rules = $validations[$key];
            foreach ($rules as $rule) {
                /** @var Rule $ruleInstance */
                $ruleInstance = new $rule($key, $value);
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
    public function all()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === self::POST) {
            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }
        }

        return $data;
    }
}