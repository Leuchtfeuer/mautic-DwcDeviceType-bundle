<?php

namespace MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\EventListener;

use Mautic\LeadBundle\Event\LeadListFiltersChoicesEvent;
use Mautic\LeadBundle\LeadEvents;
use Mautic\LeadBundle\Model\ListModel;
use Mautic\LeadBundle\Provider\FieldChoicesProviderInterface;
use MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\Integration\Config;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class LeadListSubscriber implements EventSubscriberInterface
{
    public function __construct(private Config $config, private ListModel $listModel, private TranslatorInterface $translator, private FieldChoicesProviderInterface $fieldChoicesProvider)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LeadEvents::LIST_FILTERS_CHOICES_ON_GENERATE => ['onFilterChoiceFieldsGenerate', 0],
        ];
    }

    public function onFilterChoiceFieldsGenerate(LeadListFiltersChoicesEvent $event): void
    {
        if (!$this->config->isPublished()) {
            return;
        }

        $config = [
            'label'      => $this->translator->trans('mautic.plugin.device_type'),
            'properties' => [
                'type' => 'device_type',
                'list' => $this->fieldChoicesProvider->getChoicesForField('select', 'device_type'),
            ],
            'operators' => $this->listModel->getOperatorsForFieldType('multiselect'),
            'object'    => 'lead',
        ];

        $event->addChoice('lead', 'device_type', $config);
    }
}
