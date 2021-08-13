<?php

namespace Volcengine\Vms\SecretNumber;

use DateTimeInterface;
use Volcengine\Kernel\Traits\ApiCastable;
use Volcengine\Vms\Kernel\BaseClient;

class Client extends BaseClient
{
    use ApiCastable;

    /**
     * @return string
     */
    protected function getServiceName()
    {
        return 'volc_secret_number';
    }

    /**
     * AX&AXB绑定（指定X号码）
     * @see https://www.volcengine.com/docs/6358/67254
     * @param string            $phoneNoA
     * @param string            $phoneNoX
     * @param string            $numberPoolNo
     * @param DateTimeInterface $expireTime
     * @param string|null       $phoneNoB
     * @param bool              $audioRecordFlag
     * @param string|null       $userData
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function bindAXB(string $phoneNoA, string $phoneNoX, string $numberPoolNo, DateTimeInterface $expireTime, ?string $phoneNoB = null, bool $audioRecordFlag = true, ?string $userData = null)
    {
        $results = $this->httpPost('/', array_merge([
            'Action' => 'BindAXB',
            'PhoneNoA' => $phoneNoA,
            'PhoneNoX' => $phoneNoX,
            'NumberPoolNo' => $numberPoolNo,
            'ExpireTime' => (string)$expireTime->getTimestamp(),
            'AudioRecordFlag' => $audioRecordFlag ? 1 : 0,
        ], array_filter([
            'PhoneNoB' => $phoneNoB,
            'UserData' => $userData,
        ])));

        return $this->baseResponse($results);
    }

    /**
     * AX&AXB绑定（平台选号）
     * @see https://www.volcengine.com/docs/6358/67667
     * @param string            $phoneNoA
     * @param string            $phoneNoX
     * @param string            $numberPoolNo
     * @param DateTimeInterface $expireTime
     * @param string|null       $phoneNoB
     * @param bool              $audioRecordFlag
     * @param string|null       $cityCode
     * @param string|null       $cityCodeByPhoneNo
     * @param array|null        $degradeCityList
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function selectNumberAndBindAXB(string $phoneNoA, string $phoneNoX, string $numberPoolNo, DateTimeInterface $expireTime, ?string $phoneNoB = null, bool $audioRecordFlag = true, ?string $cityCode = null, ?string $cityCodeByPhoneNo = null, ?array $degradeCityList = null)
    {
        $results = $this->httpPost('/', array_merge([
            'Action' => 'SelectNumberAndBindAXB',
            'PhoneNoA' => $phoneNoA,
            'PhoneNoX' => $phoneNoX,
            'NumberPoolNo' => $numberPoolNo,
            'ExpireTime' => (string)$expireTime->getTimestamp(),
            'AudioRecordFlag' => $audioRecordFlag ? 1 : 0,
        ], array_filter([
            'PhoneNoB' => $phoneNoB,
            'CityCode' => $cityCode,
            'CityCodeByPhoneNo' => $cityCodeByPhoneNo,
            'DegradeCityList' => $degradeCityList ? implode(',', $degradeCityList) : '',
        ])));

        return $this->baseResponse($results);
    }

    /**
     * AX升级AXB关系
     * @see https://www.volcengine.com/docs/6358/67256
     * @param string $numberPoolNo
     * @param string $subId
     * @param string $phoneNoB
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function upgradeAXToAXB(string $numberPoolNo, string $subId, string $phoneNoB)
    {
        $results = $this->httpPost('/', [
            'Action' => 'UpgradeAXToAXB',
            'NumberPoolNo' => $numberPoolNo,
            'SubId' => $subId,
            'PhoneNoB' => $phoneNoB,
        ]);

        return $this->baseResponse($results);
    }

    /**
     * 解绑AX&AXB关系
     * @see https://www.volcengine.com/docs/6358/67255
     * @param string $numberPoolNo
     * @param string $subId
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function unbindAXB(string $numberPoolNo, string $subId)
    {
        $results = $this->httpPost('/', [
            'Action' => 'UnbindAXB',
            'NumberPoolNo' => $numberPoolNo,
            'SubId' => $subId,
        ]);

        return $this->baseResponse($results);
    }

    /**
     * 查询绑定关系
     * @see https://www.volcengine.com/docs/6358/67257
     * @param string $numberPoolNo
     * @param string $subId
     * @return \Volcengine\Kernel\DataStructs\BaseResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Volcengine\Kernel\Exceptions\InvalidConfigException
     */
    public function querySubscription(string $numberPoolNo, string $subId)
    {
        $results = $this->httpPost('/', [
            'Action' => 'QuerySubscription',
            'NumberPoolNo' => $numberPoolNo,
            'SubId' => $subId,
        ]);

        return $this->baseResponse($results);
    }
}
