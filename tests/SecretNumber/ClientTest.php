<?php

namespace Volcengine\Vms\Tests\SecretNumber;

use Volcengine\Kernel\DataStructs\BaseResponse;
use Volcengine\Vms\Application;
use Volcengine\Vms\SecretNumber\Client;

class ClientTest extends \Volcengine\Vms\Tests\TestCase
{
    public function app()
    {
        return new Application([
            'auth_token' => '888888',
        ]);
    }

    public function testBindAXB()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['bindAXB'], $app)->makePartial();

        $client->expects()->httpPost('/', [
            'Action' => 'BindAXB',
            'PhoneNoA' => '13700000000',
            'PhoneNoX' => '13700000002',
            'NumberPoolNo' => 'NP160084061100694433',
            'ExpireTime' => '1577808000',
            'AudioRecordFlag' => 1,
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->bindAXB(
            '13700000000',
            '13700000002',
            'NP160084061100694433',
            (new \DateTime('2020-01-01 00:00:00')),
            null,
            true
        ));
    }

    public function testSelectNumberAndBindAXB()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['selectNumberAndBindAXB'], $app)->makePartial();

        $client->expects()->httpPost('/', [
            'Action' => 'SelectNumberAndBindAXB',
            'PhoneNoA' => '13700000000',
            'PhoneNoX' => '13700000002',
            'NumberPoolNo' => 'NP160084061100694433',
            'ExpireTime' => '1577808000',
            'AudioRecordFlag' => 1,
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->selectNumberAndBindAXB(
            '13700000000',
            '13700000002',
            'NP160084061100694433',
            (new \DateTime('2020-01-01 00:00:00')),
            null,
            true
        ));
    }

    public function testUpgradeAXToAXB()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['upgradeAXToAXB'], $app)->makePartial();

        $client->expects()->httpPost('/', [
            'Action' => 'UpgradeAXToAXB',
            'NumberPoolNo' => 'NP160084061100694433',
            'SubId' => '1',
            'PhoneNoB' => '13700000002',
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->upgradeAXToAXB(
            'NP160084061100694433',
            '1',
            '13700000002'
        ));
    }

    public function testUnbindAXB()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['unbindAXB'], $app)->makePartial();

        $client->expects()->httpPost('/', [
            'Action' => 'UnbindAXB',
            'NumberPoolNo' => 'NP160084061100694433',
            'SubId' => '1',
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->unbindAXB(
            'NP160084061100694433',
            '1'
        ));
    }

    public function testQuerySubscription()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['querySubscription'], $app)->makePartial();

        $client->expects()->httpPost('/', [
            'Action' => 'QuerySubscription',
            'NumberPoolNo' => 'NP160084061100694433',
            'SubId' => '1',
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->querySubscription(
            'NP160084061100694433',
            '1'
        ));
    }
}
