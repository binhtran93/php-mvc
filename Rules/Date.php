<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 12:18
 */

namespace Rules;

class Date extends Rule
{
    const SLASH = '/';
    const HYPHEN = '-';
    const CONVERTED_FORMAT = 'm/Y';

    /** @var string $delimiter */
    private $delimiter;

    /**
     * Date constructor.
     * @param $key
     * @param $value
     * @param $data
     * @param array $args
     */
    public function __construct($key, $value, $data, ...$args)
    {
        parent::__construct($key, $value, $data, $args);

        if (strpos($this->value, self::HYPHEN) !== false) {
            $this->delimiter = self::HYPHEN;
        } else if (strpos($this->value, self::SLASH) !== false) {
            $this->delimiter = self::SLASH;
        } else {
            $this->delimiter = null;
        }
    }

    /**
     * @return array
     */
    protected function getMonthYear() {
        return $this->delimiter === self::SLASH
            ? explode(self::SLASH, $this->value)
            : explode(self::HYPHEN, $this->value);
    }

    /**
     * Only accept m/Y, m-Y
     *
     * @return boolean
     */
    public function isValid()
    {
        if (is_null($this->delimiter)) {
            return false;
        }

        [$month, $year] = $this->getMonthYear();

        return checkdate($month, 1, $year);
    }
}