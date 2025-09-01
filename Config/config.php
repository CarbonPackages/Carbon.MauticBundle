<?php

$configValue = [
    'name' => 'Neos Integration',
    'description' => 'Tooling to support Neos CMS integration',
    'version' => '0.2.0',
    'author' => 'David Spiola',

    'routes' => [
        'api' => [
            'mautic_api_ping' => [
                'path' => '/ping',
                'controller' => 'MauticPlugin\MauticCarbonBundle\Controller\Api\ToolingApiController::pingAction',
                'method' => 'GET',
            ],
            'mautic_api_sendexamplemail' => [
                'path' => '/emails/{id}/example',
                'controller' => 'MauticPlugin\MauticCarbonBundle\Controller\Api\EmailApiController::exampleAction',
                'method' => 'POST',
            ],
            'mautic_api_emailsettingsupdate' => [
                'path' => '/emails/{id}/settings',
                'controller' =>
                    'MauticPlugin\MauticCarbonBundle\Controller\Api\EmailApiController::updateSettingsAction',
                'method' => 'POST',
            ],
            'mautic_api_emailsettingget' => [
                'path' => '/emails/{id}/settings',
                'controller' => 'MauticPlugin\MauticCarbonBundle\Controller\Api\EmailApiController::getSettingsAction',
                'method' => 'GET',
            ],
        ],
    ],
];

return $configValue;
