# Change Log for Fresh-Advance Sitemap module.

All notable changes to this project will be documented in this file.
The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [v1.1.0] - Unreleased

### Added
- Upgraded the phpunit to 11.5

### Fixed
- Notices if sitemap directory does not exist

### Removed
- PHP 8.1 support

## [v1.0.3] - Unreleased

### Fixed
- Do not install dev dependencies with the module.

## [v1.0.2] - 2025-04-27

### Fixed
- Correctly generate sitemap index file - namespace fixed.

## [v1.0.1] - 2024-05-14

### Changed
- Logo updated
- OXID Universal workflow used for ci

## [v1.0.0] - 2024-03-17

### Added
- Module setting for configuring the sitemap directory
- Module setting for additional urls list for easy configuring of urls like main page and possibly others not covered by current filters
- Variants case checked, seems our Product filter covers variants correctly, so this part added to current features

### Changed
- Reworked the General filter to handle Additional urls from module setting. Renamed to AdditionalChangeFilter
- One update step items limit increased from 100 to 1000, as it doesnt look too heavy for now.

### Fixed
- Do not apply timezone on saving the url information to database.

## [v0.2.0] - 2024-03-14

### Added
- Add outdated urls cleanup functionality
- UpdateAll command which updates and cleanups all currently registered object types

### Fixed
- Use correct module id during module activation migrations
- Fix fa_sitemap table object_id charset to fit other shop tables ids

## [v0.1.0] - 2024-02-10

[v1.0.3]: https://github.com/Fresh-Advance/Sitemap/compare/v1.0.2...v1.0.3
[v1.0.2]: https://github.com/Fresh-Advance/Sitemap/compare/v1.0.1...v1.0.2
[v1.0.1]: https://github.com/Fresh-Advance/Sitemap/compare/v1.0.0...v1.0.1
[v1.0.0]: https://github.com/Fresh-Advance/Sitemap/compare/v0.2.0...v1.0.0
[v0.2.0]: https://github.com/Fresh-Advance/Sitemap/compare/v0.1.0...v0.2.0
[v0.1.0]: https://github.com/Fresh-Advance/Sitemap/compare/03839403...v0.1.0
