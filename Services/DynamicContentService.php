<?php

namespace MauticPlugin\LeuchtfeuerDwcDeviceTypeBundle\Services;

use Mautic\DynamicContentBundle\DynamicContentEvents;
use Mautic\DynamicContentBundle\Helper\DynamicContentHelper;
use Mautic\LeadBundle\Entity\LeadDevice;
use Mautic\LeadBundle\Model\DeviceModel;

class DynamicContentService
{
    public function __construct(private DynamicContentEvents $dynamicContentEvents, private DeviceModel $deviceModel, private DynamicContentHelper $dynamicContentHelper)
    {
    }

    private function filterDeviceTypeMatchContact(array $filters, array $contactArray): bool
    {
        if (empty($contactArray['id'])) {
            return false;
        }

        /** @var LeadDevice $leadDevice */
        $leadDevice = $this->deviceModel->getEntity($contactArray['id']);
        if (empty($leadDevice)) {
            return false;
        }
        $contact = $this->convertDeviceToArray($leadDevice);

        $deviceType = $contact['device'] ?? null;
        if (empty($deviceType)) {
            return false;
        }

        foreach ($filters as $filter) {
            if (isset($filter['device_type']) && in_array($deviceType, $filter['device_type'])) {
                return true;
            }
        }

        return false;

    }

    /**
     * @param LeadDevice $device
     *
     * @return array
     */
    public function convertDeviceToArray(LeadDevice $device): array
    {
        return [
            'id' => $device->getId(),
            'device' => $device->getDevice(),
        ];
    }
}
