<?php

namespace MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\EventListener;

use Mautic\LeadBundle\Event\LeadListFiltersChoicesEvent;
use Mautic\LeadBundle\LeadEvents;
use Mautic\LeadBundle\Model\ListModel;
use Mautic\LeadBundle\Provider\FieldChoicesProviderInterface;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Translation\TranslatorInterface;

class LeadListSubscriber implements EventSubscriberInterface
{
    /**
     * @var IntegrationHelper
     */
    private $helper;

    /**
     * @var ListModel
     */
    private $listModel;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var FieldChoicesProviderInterface
     */
    private $fieldChoicesProvider;

    public function __construct(IntegrationHelper $helper, ListModel $listModel, TranslatorInterface $translator, FieldChoicesProviderInterface $fieldChoicesProvider)
    {
        $this->helper               = $helper;
        $this->listModel            = $listModel;
        $this->translator           = $translator;
        $this->fieldChoicesProvider = $fieldChoicesProvider;
    }

    public static function getSubscribedEvents()
    {
        return [
            LeadEvents::LIST_FILTERS_CHOICES_ON_GENERATE    => ['onFilterChoiceFieldsGenerate', 0],
        ];
    }

    public function onFilterChoiceFieldsGenerate(LeadListFiltersChoicesEvent $event)
    {
        $myIntegration = $this->helper->getIntegrationObject('LeuchtfeuerDwcDeviceType');

        if (false === $myIntegration || !$myIntegration->getIntegrationSettings()->getIsPublished()) {
            return;
        }

        $config = [
            'label'         => $this->translator->trans('mautic.plugin.device_type'),
            'properties'    => [
                'type'      => 'device_type',
                'list'      => $this->fieldChoicesProvider->getChoicesForField('select', 'device_type'),
            ],
            'operators'     => $this->listModel->getOperatorsForFieldType('multiselect'),
            'object'        => 'lead',
        ];

        $event->addChoice('lead', 'device_type', $config);
    }
}
