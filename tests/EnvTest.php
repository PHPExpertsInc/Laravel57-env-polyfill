<?php declare(strict_types=1);

/**
 * This file is part of Laravel 5.7 env() polyfill, a PHP Experts, Inc., project.
 *
 * Copyright © 2019-2022 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *  GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *  https://www.phpexperts.pro/
 *  https://github.com/PHPExpertsInc/Laravel57-env-polyfill
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

    private function getEnvFileLocation(): string
    {
        return realpath(__DIR__ . '/../') . '/.env';
    }

    /** @testdox Will load vlucas/phpdot if a .env is present. */
    public function testWillLoadPhpDotEnvIfDotEnvIsPresent()
    {
        if (is_readable($this->getEnvFileLocation())) {
            unlink($this->getEnvFileLocation());
        }

        $this->assertNull(env('HELLO'));
        file_put_contents($this->getEnvFileLocation(), 'HELLO=123456');

        $this->assertEquals('123456', env('HELLO'));

    }

    /** @testdox Will not load vlucas/phpdotenv if a .env is not present. */
    public function testWillNotLoadPhpDotEnvIfDotEnvIsNotPresent()
    {
        if (is_readable($this->getEnvFileLocation())) {
            unlink($this->getEnvFileLocation());
        }

        $this->assertNull(env('HELLO2'));
        putenv('HELLO2=12345');
        $this->assertEquals('12345', env('HELLO2'));
        putenv('HELLO2');
    }
}
