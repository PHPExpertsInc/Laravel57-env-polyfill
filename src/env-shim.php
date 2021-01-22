<?php declare(strict_types=1);

/**
 * This file is part of RESTSpeaker, a PHP Experts, Inc., Project.
 *
 * Copyright © 2019-2021 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *  https://www.phpexperts.pro/
 *  https://github.com/phpexpertsinc/RESTSpeaker
 *
 * This file is licensed under the MIT License.
 */

namespace AAutoloadFirst\PHPExperts
{
    /**
     * This is a shim to make Laravel 5.8's env() as
     * backward compatible as possible with pre-5.8.
     *
     * Namely, it searches for `getenv()` if `env()
     * returns FALSE.
     *
     * See https://github.com/laravel/framework/issues/27949
     *
     * Gets the value of an environment variable.
     * Source is taken from
     *    https://github.com/laravel/framework/blob/5.7/src/Illuminate/Support/helpers.php
     * Copyright (c) 2018 Taylor Otwell
     *
     * @param string $key
     * @param mixed $default
     * @return array|bool|false|string|int|float
     */
    function env($key, $default = null)
    {
        if (array_key_exists($key, $_ENV)) {
            $value = $_ENV[$key];
        } else {
            $value = getenv($key);
        }

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (($valueLength = strlen($value)) > 1 && $value[0] === '"' && $value[$valueLength - 1] === '"') {
            return substr($value, 1, -1);
        }

        return $value;
    }

    /**
     * Return the default value of the given value.
     *
     * Source is taken from
     *    https://github.com/laravel/framework/blob/5.7/src/Illuminate/Support/helpers.php
     * Copyright (c) 2018 Taylor Otwell
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof \Closure ? $value() : $value;
    }
}

namespace {
    // Shim for non-Laravel projects where env() is not present.
    if (!function_exists('env')) {
        function env($key, $default = null)
        {
            return \AAutoloadFirst\PHPExperts\env($key, $default);
        }
    }

    if (! function_exists('class_uses_recursive')) {
        /**
         * Returns all traits used by a class, its parent classes and trait of their traits.
         * Copyright (c) 2018 Taylor Otwell
         *
         * @param  object|string  $class
         * @return array
         */
        function class_uses_recursive($class)
        {
            if (is_object($class)) {
                $class = get_class($class);
            }

            $results = [];

            foreach (array_reverse(class_parents($class)) + [$class => $class] as $class) {
                $results += trait_uses_recursive($class);
            }

            return array_unique($results);
        }
    }

    if (! function_exists('trait_uses_recursive')) {
        /**
         * Returns all traits used by a trait and its traits.
         * Copyright (c) 2018 Taylor Otwell
         *
         * @param  string  $trait
         * @return array
         */
        function trait_uses_recursive($trait)
        {
            $traits = class_uses($trait);

            foreach ($traits as $trait) {
                $traits += trait_uses_recursive($trait);
            }

            return $traits;
        }
    }
}

