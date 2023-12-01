# Sitemap module for OXID eShop

[![Development](https://github.com/Fresh-Advance/Sitemap/actions/workflows/trigger.yml/badge.svg?branch=b-7.0.x)](https://github.com/Fresh-Advance/Sitemap/actions/workflows/trigger.yml)
[![Latest Version](https://img.shields.io/packagist/v/Fresh-Advance/Sitemap?logo=composer&label=latest&include_prereleases&color=orange)](https://packagist.org/packages/Fresh-Advance/Sitemap)
[![PHP Version](https://img.shields.io/packagist/php-v/Fresh-Advance/Sitemap)](https://github.com/Fresh-Advance/Sitemap)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Fresh-Advance_Sitemap&metric=alert_status)](https://sonarcloud.io/dashboard?id=Fresh-Advance_Sitemap)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Fresh-Advance_Sitemap&metric=coverage)](https://sonarcloud.io/dashboard?id=Fresh-Advance_Sitemap)
[![Technical Debt](https://sonarcloud.io/api/project_badges/measure?project=Fresh-Advance_Sitemap&metric=sqale_index)](https://sonarcloud.io/dashboard?id=Fresh-Advance_Sitemap)

**In development**

## Features

* Selectors implemented for:
  * Active categories
  * Active products (variants not checked yet)
  * Active content pages from 'User information' folder

## Compatibility

* Branch b-7.0.x is compatible with OXID Shop compilation 7.0.0-rc.2 and up

## What to expect in next versions

* Sitemap access without modifying the .htaccess
* Configurable sitemap directory
* Usability improvements
* Variants selectors
* Multilanguage support
* Multishop support
* Removal of the urls by removal of the related objects

## Installation

Module is available on packagist and installable via composer

```
composer require fresh-advance/sitemap
```

## Usage

There is a table (fa_sitemap) which contains the list of all sitemap urls.
Urls are updated and added during the "fa:sitemap:update" command.
The sitemap is generated by "fa:sitemap:generate" command.

## License

Please make sure you checked the License before using the module.
