<?php

declare(strict_types=1);

namespace MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\EventListener;

use Composer\EventDispatcher\EventSubscriberInterface;
use Mautic\DynamicContentBundle\DynamicContentEvents;
use Mautic\DynamicContentBundle\Event\ContactFiltersEvaluateEvent;

class DeviceTypeFilterSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            DynamicContentEvents::ON_CONTACTS_FILTER_EVALUATE => 'onContactsFilterEvaluate',
        ];
    }

    public function onContactsFilterEvaluate(ContactFiltersEvaluateEvent $event)
    {
        $filters = $event->getFilters();
        $lead = $event->getLead();

        // Handle device_type filter
        if (isset($filters['device_type'])) {
            // Query lead_devices table to get device_type for lead
            $deviceType = $this->getDeviceTypeForLead($lead['id']);

            // Compare lead's device_type to filter's device_type
            if ($deviceType !== $filters['device_type']) {
                $event->setIsMatch(false);
            }
        }
    }

    private function getDeviceTypeForLead($leadId)
    {
        // Query lead_devices table to get device_type for lead
        // This is just a placeholder - replace with your actual query
        $query = "SELECT device_type FROM lead_devices WHERE id = ?";
        $deviceType = $this->db->fetchColumn($query, [$leadId]);

        return $deviceType;
    }
}
