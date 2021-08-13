<?php

namespace Volcengine\Vms\Kernel\DataStruct;

use JsonSerializable;

class ForbidTimeItem implements JsonSerializable
{
    /**
     * @var int[]|null
     */
    protected $weekdays;
    /**
     * @var string[]
     */
    protected $times;

    /**
     * ForbidTimeItem constructor.
     * @param int[]|null $weekdays
     * @param string[]   $times
     */
    public function __construct(?array $weekdays, array $times)
    {
        $this->weekdays = $weekdays;
        $this->times = $times;
    }

    /**
     * @return int[]|null
     */
    public function getWeekdays(): ?array
    {
        return $this->weekdays;
    }

    /**
     * @param int[]|null $weekdays
     */
    public function setWeekdays(?array $weekdays): void
    {
        $this->weekdays = $weekdays;
    }

    /**
     * @return string[]
     */
    public function getTimes(): array
    {
        return $this->times;
    }

    /**
     * @param string[] $times
     */
    public function setTimes(array $times): void
    {
        $this->times = $times;
    }

    public function jsonSerialize()
    {
        return array_filter([
            'Weekdays' => $this->weekdays,
            'Times' => $this->times,
        ], function ($value) {
            return $value !== null;
        });
    }
}
