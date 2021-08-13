<?php

namespace Volcengine\Vms\VoiceNotify;

use DateTimeInterface;
use Volcengine\Kernel\Traits\ApiCastable;
use Volcengine\Vms\Kernel\BaseClient;
use Volcengine\Vms\Kernel\DataStruct\ForbidTimeItem;
use Volcengine\Vms\Kernel\DataStruct\PhoneParam;

class Client extends BaseClient
{
    use ApiCastable;

    protected function getServiceName()
    {
        return 'volc_voice_notify';
    }

    protected function getVersion()
    {
        return '2021-01-01';
    }

    /**
     * 创建任务
     * @see https://www.volcengine.com/docs/6358/68947
     * @param string            $name
     * @param string            $resource
     * @param string            $numberPoolNo
     * @param string[]          $numberList
     * @param DateTimeInterface $startTime
     * @param DateTimeInterface $endTime
     * @param int               $concurrency
     * @param PhoneParam[]      $phoneList
     * @param int               $ringAgainTimes
     * @param int               $ringAgainInterval
     * @param bool              $finishWhenListEnd
     * @param bool              $unique
     * @param ForbidTimeItem[]  $forbidTimeList
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function createTask(string $name, string $resource, string $numberPoolNo, array $numberList, DateTimeInterface $startTime, DateTimeInterface $endTime, int $concurrency, array $phoneList = [], int $ringAgainTimes = 0, int $ringAgainInterval = 5, bool $finishWhenListEnd = false, bool $unique = false, array $forbidTimeList = [])
    {
        $results = $this->httpPostJson('/', [
            'Name' => $name,
            'PhoneList' => $phoneList,
            'Resource' => $resource,
            'NumberPoolNo' => $numberPoolNo,
            'NumberList' => $numberList,
            'StartTime' => $startTime->format('Y-m-d H:i:s'),
            'EndTime' => $endTime->format('Y-m-d H:i:s'),
            'RingAgainTimes' => $ringAgainTimes,
            'RingAgainInterval' => $ringAgainInterval,
            'Concurrency' => $concurrency,
            'FinishWhenListEnd' => $finishWhenListEnd,
            'Unique' => $unique,
            'ForbidTimeList' => $forbidTimeList,
        ], [
            'Action' => 'CreateTask',
        ]);

        return $this->baseResponse($results);
    }

    /**
     * 添加号码
     * @see https://www.volcengine.com/docs/6358/68948
     * @param int $taskId
     * @param PhoneParam[]  $phoneList
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function batchAppend(int $taskId, array $phoneList)
    {
        $results = $this->httpPostJson('/', [
            'TaskId' => $taskId,
            'PhoneList' => $phoneList,
        ], [
            'Action' => 'BatchAppend',
        ]);

        return $this->baseResponse($results);
    }

    /**
     * 暂停任务
     * @see https://www.volcengine.com/docs/6358/68949
     * @param int $taskId
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function pauseTask(int $taskId)
    {
        $results = $this->httpPostJson('/', [
            'TaskId' => $taskId,
        ], [
            'Action' => 'PauseTask',
        ]);

        return $this->baseResponse($results);
    }

    /**
     * 恢复任务
     * @see https://www.volcengine.com/docs/6358/68950
     * @param int $taskId
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function resumeTask(int $taskId)
    {
        $results = $this->httpPostJson('/', [
            'TaskId' => $taskId,
        ], [
            'Action' => 'ResumeTask',
        ]);

        return $this->baseResponse($results);
    }

    /**
     * 终止任务
     * @see https://www.volcengine.com/docs/6358/68951
     * @param int $taskId
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function stopTask(int $taskId)
    {
        $results = $this->httpPostJson('/', [
            'TaskId' => $taskId,
        ], [
            'Action' => 'StopTask',
        ]);

        return $this->baseResponse($results);
    }

    /**
     * 更新任务
     * @see https://www.volcengine.com/docs/6358/68952
     * @param int               $taskId
     * @param int               $concurrency
     * @param DateTimeInterface $startTime
     * @param DateTimeInterface $endTime
     * @param int               $ringAgainTimes
     * @param int               $ringAgainInterval
     * @param array             $forbidTimeList
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function updateTask(int $taskId, int $concurrency, DateTimeInterface $startTime, DateTimeInterface $endTime, int $ringAgainTimes = 0, int $ringAgainInterval = 5, array $forbidTimeList = [])
    {
        $results = $this->httpPostJson('/', [
            'TaskId' => $taskId,
            'StartTime' => $startTime->format('Y-m-d H:i:s'),
            'EndTime'   => $endTime->format('Y-m-d H:i:s'),
            'RingAgainTimes' => $ringAgainTimes,
            'RingAgainInterval' => $ringAgainInterval,
            'Concurrency' => $concurrency,
            'ForbidTimeList' => $forbidTimeList,
        ], [
            'Action' => 'UpdateTask',
        ]);

        return $this->baseResponse($results);
    }

    public function openUploadResource()
    {
        // TODO: 没有 demo 搞不了
    }

    /**
     * 修改语音资源
     * @see https://www.volcengine.com/docs/6358/68956
     * @param string $resourceKey
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function openUpdateResource(string $resourceKey)
    {
        $results = $this->httpPostJson('/', [], [
            'Action' => 'OpenUpdateResource',
            'ResourceKey' => $resourceKey,
        ]);

        return $this->baseResponse($results);
    }

    /**
     * 删除语音资源
     * @see https://www.volcengine.com/docs/6358/68957
     * @param string $resourceKey
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function openDeleteResource(string $resourceKey)
    {
        $results = $this->httpPostJson('/', [], [
            'Action' => 'OpenDeleteResource',
            'ResourceKey' => $resourceKey,
        ]);

        return $this->baseResponse($results);
    }

    /**
     * 获取可用语音资源
     * @see https://www.volcengine.com/docs/6358/68958
     * @param int $type
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function queryUsableResource(int $type)
    {
        $results = $this->request('/', 'POST', [
            'query' => [
                'Action' => 'QueryUsableResource',
            ],
            'form_params' => [
                'Type' => $type,
            ],
            'headers' => [
                'Content-Type' => 'application/json'
            ],
        ]);

        return $this->baseResponse($results);
    }

    /**
     * 获取语音资源列表
     * @see https://www.volcengine.com/docs/6358/68959
     * @param int         $offset
     * @param int         $limit
     * @param int         $state
     * @param string|null $keyword
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function queryOpenGetResource(int $offset = 0, int $limit = 10, int $state = 0, ?string $keyword = null)
    {
        $results = $this->httpPostJson('/', array_merge([
            'Offset' => $offset,
            'Limit' => $limit,
            'State' => $state,
        ], array_filter([
            'Keyword' => $keyword,
        ])), [
            'Action' => 'QueryOpenGetResource',
        ]);

        return $this->baseResponse($results);
    }
}
