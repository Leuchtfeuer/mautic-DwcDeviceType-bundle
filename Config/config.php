<?php

return [
    'name'          => 'Device type filter for DWC',
    'description'   => 'Introduce menu item which gives access to the Audit Log',
    'version'       => '1.0',
    'author'        => 'Leuchtfeuer Digital Marketing GmbH',

    'routes'        => [],
    'menu'          => [],

    'services'      => [
        'integrations'  => [
            'mautic.integration.leuchtfeuerdwcdevicetype' => [
                'class'     => \MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\Integration\LeuchtfeuerDwcDeviceTypeIntegration::class,
                'arguments' => [
                    'event_dispatcher',
                    'mautic.helper.cache_storage',
                    'doctrine.orm.entity_manager',
                    'session',
                    'request_stack',
                    'router',
                    'translator',
                    'logger',
                    'mautic.helper.encryption',
                    'mautic.lead.model.lead',
                    'mautic.lead.model.company',
                    'mautic.helper.paths',
                    'mautic.core.model.notification',
                    'mautic.lead.model.field',
                    'mautic.plugin.model.integration_entity',
                    'mautic.lead.model.dnc',
                ],
            ],
        ],
    ],
];
