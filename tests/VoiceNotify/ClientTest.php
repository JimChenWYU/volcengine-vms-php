<?php

namespace Volcengine\Vms\Tests\VoiceNotify;

use Volcengine\Kernel\DataStructs\BaseResponse;
use Volcengine\Vms\Application;
use Volcengine\Vms\VoiceNotify\Client;

class ClientTest extends \Volcengine\Vms\Tests\TestCase
{
    public function app()
    {
        return new Application([
            'auth_token' => '888888',
        ]);
    }

    public function testCreateTask()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['createTask'], $app)->makePartial();

        $client->expects()->httpPostJson('/', [
            'Name' => 'foo',
            'PhoneList' => [],
            'Resource' => 'foobar',
            'NumberPoolNo' => 'NP160084061100694433',
            'NumberList' => [],
            'StartTime' => '2020-01-01 00:00:00',
            'EndTime' => '2020-01-02 00:00:00',
            'RingAgainTimes' => 0,
            'RingAgainInterval' => 5,
            'Concurrency' => 1,
            'FinishWhenListEnd' => true,
            'Unique' => true,
            'ForbidTimeList' => [],
        ], [
            'Action' => 'CreateTask'
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->createTask(
            'foo',
            'foobar',
            'NP160084061100694433',
            [],
            (new \DateTime('2020-01-01 00:00:00')),
            (new \DateTime('2020-01-02 00:00:00')),
            1,
            [],
            0,
            5,
            true,
            true,
            []
        ));
    }

    public function testBatchAppend()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['batchAppend'], $app)->makePartial();

        $client->expects()->httpPostJson('/', [
            'TaskId' => 123456,
            'PhoneList' => [],
        ], [
            'Action' => 'BatchAppend'
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->batchAppend(
            123456,
            []
        ));
    }

    public function testPauseTask()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['pauseTask'], $app)->makePartial();

        $client->expects()->httpPostJson('/', [
            'TaskId' => 123456,
        ], [
            'Action' => 'PauseTask'
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->pauseTask(
            123456
        ));
    }

    public function testResumeTask()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['resumeTask'], $app)->makePartial();

        $client->expects()->httpPostJson('/', [
            'TaskId' => 123456,
        ], [
            'Action' => 'ResumeTask'
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->resumeTask(
            123456
        ));
    }

    public function testStopTask()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['stopTask'], $app)->makePartial();

        $client->expects()->httpPostJson('/', [
            'TaskId' => '123456',
        ], [
            'Action' => 'StopTask'
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->stopTask(
            '123456'
        ));
    }

    public function testUpdateTask()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['updateTask'], $app)->makePartial();

        $client->expects()->httpPostJson('/', [
            'TaskId' => 12345,
            'StartTime' => '2020-01-01 00:00:00',
            'EndTime' => '2020-01-02 00:00:00',
            'RingAgainTimes' => 0,
            'RingAgainInterval' => 5,
            'Concurrency' => 1,
            'ForbidTimeList' => [],
        ], [
            'Action' => 'UpdateTask'
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->updateTask(
            12345,
            1,
            new \DateTime('2020-01-01 00:00:00'),
            new \DateTime('2020-01-02 00:00:00'),
            0,
            5,
            []
        ));
    }

    public function testOpenUpdateResource()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['openUpdateResource'], $app)->makePartial();

        $client->expects()->httpPostJson('/', [
        ], [
            'Action' => 'OpenUpdateResource',
            'ResourceKey' => 'foobar'
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->openUpdateResource(
            'foobar'
        ));
    }

    public function testOpenDeleteResource()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['openDeleteResource'], $app)->makePartial();

        $client->expects()->httpPostJson('/', [
        ], [
            'Action' => 'OpenDeleteResource',
            'ResourceKey' => 'foobar'
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->openDeleteResource(
            'foobar'
        ));
    }

    public function testQueryUsableResource()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['queryUsableResource'], $app)->makePartial();

        $client->expects()->request('/', 'POST', [
            'query' => [
                'Action' => 'QueryUsableResource',
            ],
            'form_params' => [
                'Type' => 1,
            ],
            'headers' => [
                'Content-Type' => 'application/json'
            ],
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->queryUsableResource(
            1
        ));
    }

    public function testQueryOpenGetResource()
    {
        $app = $this->app();

        $client = $this->mockApiClient(Client::class, ['queryOpenGetResource'], $app)->makePartial();

        $client->expects()->httpPostJson('/', [
            'Offset' => 0,
            'Limit' => 10,
            'State' => 1,
            'Keyword' => 'foobar',
        ], [
            'Action' => 'QueryOpenGetResource',
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->queryOpenGetResource(
            0, 10, 1, 'foobar'
        ));

        $client->expects()->httpPostJson('/', [
            'Offset' => 0,
            'Limit' => 10,
            'State' => 1,
        ], [
            'Action' => 'QueryOpenGetResource',
        ])->andReturn(["success" => true]);
        $this->assertInstanceOf(BaseResponse::class, $client->queryOpenGetResource(
            0, 10, 1, ''
        ));
    }
}
