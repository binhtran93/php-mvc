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

class BaseRequest implements IRequest
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

    /**
     * Retrieve all of input data
     *
     * @return mixed
     */
    function all()
    {
        $data = [];
        if ($_SERVER['REQUEST_METHOD'] === self::POST) {
            foreach ($_POST as $key => $value) {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * get body data by name
     *
     * @param $name
     * @param null $default
     * @return mixed
     */
    function input($name, $default = null)
    {
        // TODO: Implement input() method.
    }

    /**
     * get query data by name
     *
     * @param $name
     * @param null $default
     * @return mixed
     */
    function query($name, $default = null)
    {
        // TODO: Implement query() method.
    }
}