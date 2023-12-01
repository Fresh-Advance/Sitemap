<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

/**
 * Metadata version
 */
$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id'          => \FreshAdvance\Sitemap\Module::MODULE_ID,
    'title'       => 'Sitemap',
    'description'  => [
        'en' => 'Sitemap module for OXID eShop.',
    ],
    'version'     => '0.1.0',
    'author'       => 'Anton Fedurtsya',
    'email'        => 'anton@fedurtsya.com',
    'url'         => '',
    'controllers' => [
    ],
    'extend'      => [
    ],
    'settings' => [

    ],
    'events' => [
        'onActivate' => '\FreshAdvance\Sitemap\Events::onActivate',
        'onDeactivate' => '\FreshAdvance\Sitemap\Events::onDeactivate'
    ]
];
