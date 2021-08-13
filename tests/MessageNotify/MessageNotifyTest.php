<?php

namespace Volcengine\Vms\Tests\MessageNotify;

use phpmock\MockBuilder;
use Symfony\Component\HttpFoundation\Request;
use Volcengine\Kernel\Exceptions\InvalidSignException;
use Volcengine\Vms\Application;
use Volcengine\Vms\Kernel\Exceptions\RequestExpiredException;
use Volcengine\Vms\MessageNotify\MessageNotify;

class MessageNotifyTest extends \Volcengine\Vms\Tests\TestCase
{
    public function app()
    {
        return new Application([
            'auth_token' => '8D202AC288',
        ]);
    }

    public function testNotify()
    {
        $builder = new MockBuilder();
        $builder->setNamespace('Volcengine\Vms\MessageNotify')
            ->setName("time")
            ->setFunction(
                function () {
                    return 1622539884;
                }
            );
        $mock = $builder->build();
        /** 模拟 `time()` 时间函数 **/

        $mock->enable();
        $app = $this->app();
        $app['request'] = Request::create('', 'POST', [
            'timestamp' => '1622539884',
            'authCode' => '8090de7b7bab3d9e626280f635a60a8453d2ba75403f13aac3f4d5dccf6c2264',
        ], [], [], [], '{"callId":"abcdefg","accountId":"123456789"}');
        $notify = new MessageNotify($app);
        $response = $notify->handle(function ($message) {
            $this->assertSame([
                'callId' => 'abcdefg',
                'accountId' => '123456789',
            ], $message);

            return true;
        });

        $this->assertTrue($response);
        $mock->disable();
    }

    public function testInvalidSign()
    {
        $builder = new MockBuilder();
        $builder->setNamespace('Volcengine\Vms\MessageNotify')
            ->setName("time")
            ->setFunction(
                function () {
                    return 1622539884;
                }
            );
        $mock = $builder->build();
        /** 模拟 `time()` 时间函数 **/

        // 1. 时间导致校验失败
        $app = $this->app();
        $app['request'] = Request::create('', 'POST', [
            'timestamp' => '1622539884',
            'authCode' => '8090de7b7bab3d9e626280f635a60a8453d2ba75403f13aac3f4d5dccf6c2264',
        ], [], [], [], '{"callId":"abcdefg","accountId":"123456789"}');
        $notify = new MessageNotify($app);
        $this->expectException(RequestExpiredException::class);
        $notify->handle(function ($message) {
            //
        });

        // 2. 签名不一致
        $mock->enable();
        $app = $this->app();
        $app['request'] = Request::create('', 'POST', [
            'timestamp' => '1622539884',
            'authCode' => '8090de7b7bab3d9e626280f635a60a8453d2ba75403f13aac3f4d5dccf6c2264',
        ], [], [], [], '{"callId":"foobar","accountId":"123456789"}');
        $notify = new MessageNotify($app);
        $this->expectException(InvalidSignException::class);
        $notify->handle(function ($message) {
            //
        });
        $mock->disable();
    }
}
