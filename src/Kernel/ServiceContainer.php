<?php

namespace Volcengine\Vms\Kernel;

class ServiceContainer extends \Volcengine\Kernel\ServiceContainer
{
    protected function getBaseUri(): string
    {
        return 'https://cloud-vms.volcengineapi.com/';
    }
}
