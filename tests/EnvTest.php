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

namespace PHPExperts\Laravel57EnvPolyfill\Tests;

use function AAutoloadFirst\PHPExperts\value;
use PHPUnit\Framework\TestCase;

/**
 * Source is taken from
 *    https://github.com/laravel/framework/blob/5.7/tests/Support/SupportHelpersTest.php
 * Copyright (c) 2018 Taylor Otwell
 */
class EnvTest extends TestCase
{
    public function testEnv()
    {
        putenv('foo=bar');
        self::assertEquals('bar', env('foo'));
    }

    public function testEnvWithQuotes()
    {
        putenv('foo="bar"');
        self::assertEquals('bar', env('foo'));
    }

    public function testEnvTrue()
    {
        putenv('foo=true');
        self::assertTrue(env('foo'));

        putenv('foo=(true)');
        self::assertTrue(env('foo'));
    }

    public function testEnvFalse()
    {
        putenv('foo=false');
        self::assertFalse(env('foo'));

        putenv('foo=(false)');
        self::assertFalse(env('foo'));
    }

    public function testEnvEmpty()
    {
        putenv('foo=');
        self::assertEquals('', env('foo'));

        putenv('foo=empty');
        self::assertEquals('', env('foo'));

        putenv('foo=(empty)');
        self::assertEquals('', env('foo'));
    }

    public function testEnvNull()
    {
        putenv('foo=null');
        self::assertEquals('', env('foo'));

        putenv('foo=(null)');
        self::assertEquals('', env('foo'));
    }

    public function testValue()
    {
        $this->assertEquals('foo', value('foo'));
        $this->assertEquals('foo', value(function () {
            return 'foo';
        }));
    }

    public function testEnvWillUseDefaultValueIfNeeded()
    {
        self::assertEquals('default', env('nonexistant', 'default'));

        putenv('false=false');
        self::assertEquals(false, env('false', 'default'));

        putenv('null=null');
        self::assertEquals(null, env('null', 'default'));

        putenv('empty=');
        self::assertEquals('', env('empty', 'default'));

    }
}
