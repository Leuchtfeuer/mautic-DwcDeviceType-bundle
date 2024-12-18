<?php

namespace MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\Integration;

use Mautic\IntegrationsBundle\Integration\BasicIntegration;
use Mautic\IntegrationsBundle\Integration\DefaultConfigFormTrait;
use Mautic\IntegrationsBundle\Integration\Interfaces\BasicInterface;
use Mautic\IntegrationsBundle\Integration\Interfaces\ConfigFormInterface;

class LeuchtfeuerDwcDeviceTypeIntegration extends BasicIntegration implements BasicInterface, ConfigFormInterface
{
    use DefaultConfigFormTrait;

    public const PLUGIN_NAME  = 'LeuchtfeuerDwcDeviceType';
    public const DISPLAY_NAME = 'Device type filter for DWC';

    public function getName(): string
    {
        return self::PLUGIN_NAME;
    }

    public function getDisplayName(): string
    {
        return self::DISPLAY_NAME;
    }

    public function getIcon(): string
    {
        return 'plugins/LeuchtfeuerDwcDeviceTypeBundle/Assets/img/leuchtfeuerdwcdevicetype.png';
    }
}
