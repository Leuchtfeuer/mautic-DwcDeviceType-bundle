<?php

namespace MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\EventListener;

use Mautic\DynamicContentBundle\DynamicContentEvents;
use Mautic\DynamicContentBundle\Event\ContactFiltersEvaluateEvent;
use Mautic\LeadBundle\Entity\LeadDevice;
use Mautic\LeadBundle\Model\DeviceModel;
use MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\Services\DynamicContentService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DynamicContentSubscriber implements EventSubscriberInterface
{
    public function __construct(protected DeviceModel $deviceModel, protected DynamicContentService $dynamicContentService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            DynamicContentEvents::ON_CONTACTS_FILTER_EVALUATE => ['onContactFiltersEvaluate', 0],
        ];
    }

    public function onContactFiltersEvaluate(ContactFiltersEvaluateEvent $event): void
    {
        $filters = $event->getFilters();
        $contact = $event->getContact();
        $leadDeviceRepository = $this->deviceModel->getRepository();
        $leadDevice = $leadDeviceRepository->getLeadDevices($contact);
        if (empty($leadDevice)) {
            return;
        }

        $deviceType = $leadDevice[0]['device'];
        foreach ($filters as $filter) {
            if ('device_type' === $filter['type']) {
                switch ($filter['operator']) {
                    case 'in':
                        if (in_array($deviceType, $filter['filter'])) {
                            $event->setIsEvaluated(true);
                            $event->setIsMatched(in_array($deviceType, $filter['filter']));
                        }
                        break;
                    case '!in':
                        if (!in_array($deviceType, $filter['filter'])) {
                            $event->setIsEvaluated(true);
                            $event->setIsMatched(!in_array($deviceType, $filter['filter']));
                        }
                        break;
                    case 'empty':
                        if (empty($deviceType)) {
                            $event->setIsEvaluated(true);
                            $event->setIsMatched(empty($deviceType));
                        }
                        break;
                    case '!empty':
                        if (!empty($deviceType)) {
                            $event->setIsEvaluated(true);
                            $event->setIsMatched(!empty($deviceType));
                        }
                        break;
                    default:
                        $event->setIsEvaluated(true);
                        $event->setIsMatched(false);
                        break;
                }
            }
        }
    }
}
