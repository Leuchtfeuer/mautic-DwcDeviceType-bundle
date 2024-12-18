<?php

namespace MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\EventListener;

use Mautic\DynamicContentBundle\DynamicContentEvents;
use Mautic\DynamicContentBundle\Event\ContactFiltersEvaluateEvent;
use Mautic\DynamicContentBundle\Helper\DynamicContentHelper;
use Mautic\EmailBundle\EventListener\MatchFilterForLeadTrait;
use Mautic\LeadBundle\Model\DeviceModel;
use MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\Integration\Config;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DynamicContentSubscriber implements EventSubscriberInterface
{
    use MatchFilterForLeadTrait;

    public function __construct(private Config $config, private DeviceModel $deviceModel, private DynamicContentHelper $dynamicContentHelper)
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
        if (!$this->config->isPublished()) {
            return;
        }

        $filters              = $event->getFilters();
        $contact              = $event->getContact();
        $leadDeviceRepository = $this->deviceModel->getRepository();
        $leadDevice           = $leadDeviceRepository->getLeadDevices($contact);
        if ([] === $leadDevice) {
            return;
        }

        $deviceType = $leadDevice[0]['device'];
        $evaluated  = false;
        $matched    = false;
        foreach ($filters as $filter) {
            if ('device_type' !== $filter['type']) {
                continue;
            }

            $evaluated = true;

            switch ($filter['operator']) {
                case 'in':
                    $matched = in_array($deviceType, $filter['filter'], true);
                    break;
                case '!in':
                    $matched = !in_array($deviceType, $filter['filter'], true);
                    break;
                case 'empty':
                    $matched = null === $deviceType || '' === $deviceType;
                    break;
                case '!empty':
                    $matched = null !== $deviceType && '' !== $deviceType;
                    break;
                default:
                    throw new \InvalidArgumentException('Invalid filter operator: '.$filter['operator']);
            }
        }

        if (!$evaluated) {
            return;
        }

        $event->setIsEvaluated(true);
        $event->setIsMatched($matched);
    }
}
