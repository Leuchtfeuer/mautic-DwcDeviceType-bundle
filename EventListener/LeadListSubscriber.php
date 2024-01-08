<?php

namespace MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\EventListener;

use Mautic\LeadBundle\Event\LeadListFiltersChoicesEvent;
use Mautic\LeadBundle\LeadEvents;
use Mautic\LeadBundle\Model\ListModel;
use Mautic\LeadBundle\Provider\FieldChoicesProviderInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class LeadListSubscriber implements EventSubscriberInterface
{
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

    public function __construct(ListModel $listModel, TranslatorInterface $translator, FieldChoicesProviderInterface $fieldChoicesProvider)
    {
        $this->listModel = $listModel;
        $this->translator = $translator;
        $this->fieldChoicesProvider = $fieldChoicesProvider;
    }

    public static function getSubscribedEvents()
    {
        return [
            LeadEvents::LIST_FILTERS_CHOICES_ON_GENERATE    => ['onFilterChoiceFieldsGenerate', 0]
        ];
    }

    public function onFilterChoiceFieldsGenerate(LeadListFiltersChoicesEvent $event)
    {
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
