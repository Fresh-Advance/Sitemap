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
        'de' => 'Sitemap-Modul für OXID eShop.',
    ],
    'version'     => '1.0.0',
    'author'       => 'Anton Fedurtsya',
    'email'        => 'anton@fedurtsya.com',
    'url'         => '',
    'controllers' => [
    ],
    'extend'      => [
    ],
    'settings' => [
        /** Main */
        [
            'group' => 'fa_sitemap_main',
            'name' => \FreshAdvance\Sitemap\Settings\ModuleSettings::SETTING_SITEMAP_DIRECTORY,
            'type' => 'str',
            'value' => 'sitemap'
        ],

        /** Additional */
        [
            'group' => 'fa_sitemap_additional',
            'name' => \FreshAdvance\Sitemap\Settings\ModuleSettings::SETTING_ADDITIONAL_SITEMAP_URLS,
            'type' => 'arr',
            'value' => ['/']
        ],
    ],
    'events' => [
        'onActivate' => '\FreshAdvance\Sitemap\Events::onActivate',
        'onDeactivate' => '\FreshAdvance\Sitemap\Events::onDeactivate'
    ]
];
