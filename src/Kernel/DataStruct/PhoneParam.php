<?php

namespace Volcengine\Vms\Kernel\DataStruct;

use JsonSerializable;

class PhoneParam implements JsonSerializable
{
    /**
     * @var string
     */
    protected $phone;
    /**
     * @var array<string, string>|null
     */
    protected $phoneParam;
    /**
     * @var string|null
     */
    protected $ttsContent;
    /**
     * @var string|null
     */
    protected $ext;

    /**
     * PhoneParam constructor.
     * @param string      $phone
     * @param array|null  $phoneParam
     * @param string|null $ttsContent
     * @param string|null $ext
     */
    public function __construct(string $phone, ?array $phoneParam, ?string $ttsContent, ?string $ext)
    {
        $this->phone = $phone;
        $this->phoneParam = $phoneParam;
        $this->ttsContent = $ttsContent;
        $this->ext = $ext;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return array|null
     */
    public function getPhoneParam(): ?array
    {
        return $this->phoneParam;
    }

    /**
     * @param array|null $phoneParam
     */
    public function setPhoneParam(?array $phoneParam): void
    {
        $this->phoneParam = $phoneParam;
    }

    /**
     * @return string|null
     */
    public function getTtsContent(): ?string
    {
        return $this->ttsContent;
    }

    /**
     * @param string|null $ttsContent
     */
    public function setTtsContent(?string $ttsContent): void
    {
        $this->ttsContent = $ttsContent;
    }

    /**
     * @return string|null
     */
    public function getExt(): ?string
    {
        return $this->ext;
    }

    /**
     * @param string|null $ext
     */
    public function setExt(?string $ext): void
    {
        $this->ext = $ext;
    }

    public function jsonSerialize()
    {
        return array_filter([
            'Phone' => $this->phone,
            'PhoneParam' => $this->phoneParam,
            'TtsContent' => $this->ttsContent,
            'Ext' => $this->ext,
        ], function ($value) {
            return $value !== null;
        });
    }
}
