<?php
/**
 * Snippet from https://stackoverflow.com/a/254543/2969706
 */

namespace HiHaHo\Saml\Enums;

use ReflectionClass;

abstract class BaseEnum
{
    /**
     * @var array
     */
    private static $constCache = [];

    private static function getConstants(): array
    {
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCache)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCache[$calledClass] = $reflect->getConstants();
        }
        return self::$constCache[$calledClass];
    }

    public static function isValidName($name, $strict = false): bool
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true): bool
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }
}