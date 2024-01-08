<?php

namespace MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

class LeuchtfeuerDwcDeviceTypeIntegration extends AbstractIntegration
{
    public const PLUGIN_NAME         = 'LeuchtfeuerDwcDeviceType';
    public const DISPLAY_NAME        = 'Device type filter for DWC';
    public const AUTHENTICATION_TYPE = 'none';

    public function getName()
    {
        return self::PLUGIN_NAME;
    }

    public function getDisplayName()
    {
        return self::DISPLAY_NAME;
    }

    public function getAuthenticationType()
    {
        return self::AUTHENTICATION_TYPE;
    }
}
