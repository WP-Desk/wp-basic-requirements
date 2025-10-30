## [3.8.1] - 2025-10-30
### Removed
- Translation on class existence requirement check: Function _load_textdomain_just_in_time was called incorrectly.

## [3.8.0] - 2025-09-08
### Added
- Class existence requirements

## [3.7.2] - 2025-08-25
### Fixed
- Plugin slug for a repository install link

## [3.7.1] - 2025-06-06
### Fixed
- Replace text domain.
- Add escaping function.

## [3.7.0] - 2025-05-16
### Fixed
- Remove of the plugin_api filter as prohibited for use in the plugin review.

## [3.6.3] - 2024-04-16
### Fixed
- Prevent error notice

## [3.6.2] - 2023-06-29
### Fixed
- Exact comparison for X.Y.Z semver version doesn't result in notices when the required version is met. Previously, requiring plugin in 1.1.1 version and activating dependend plugin in such version would result in admin notice and disabling the plugin, actually letting to use the plugin only from 1.1.2 version.

## [3.6.1] - 2023-06-22
### Changed
- Plugin info transient changed to auto loaded option

## [3.5.2] - 2023-02-10
### Changed
- Removed arrows from user-facing messages.

## [3.5.1] - 2022-08-30
### Fixed
- de_DE translators

## [3.5.0] - 2022-08-16
### Added
- en_CA, en_GB translators

## [3.4.0] - 2022-08-16
### Added
- de_DE translators

## [3.3.0] - 2022-08-09
### Added
- en_AU translators

## [3.2.8] - 2022-07-18
### Added
- __DIR__ for requires

## [3.2.7] - 2021-03-01
### Fixed
- Update message and translation

## [3.2.6] - 2021-03-01
### Fixed
- Update message and translation

## [3.2.5] - 2021-02-26
### Fixed
- PHP Notice:  Undefined property: stdClass::$version

## [3.2.4] - 2021-02-26
### Fixed
- removed plugin version from plugin api

## [3.2.3] - 2020-10-05
### Fixed
- WC tested shows invalid info

## [3.2.2] - 2019-12-17
### Fixed
- Plugin version should be checked only in needed

## [3.2.1] - 2019-11-15
### Fixed
- Fixed plugin version notice
- Fixed required plugin name display in admin notices

## [3.2.0] - 2019-11-14
### Added
- Minimum required plugin version notice

## [3.1.0] - 2019-11-13
### Changed
- Removed .mo file
- Translation set in composer extra section

## [3.0.5] - 2019-09-20
### Fixed
- Fixed missing wp_create_nonce function

## [3.0.4] - 2019-09-20
### Fixed
- Fixed missing wp_nonce_url function

## [3.0.3] - 2019-09-20
### Fixed
- Fixed "" in translation

## [3.0.2] - 2019-09-18
### Fixed
- Better error message display for temporary disabling
- Installation url

## [3.0.1] - 2019-09-18
### Fixed
- Better new error messages display
- get_plugins function loaded from wp-admin
- Faster checks

## [3.0.0] - 2019-09-17
### Changed
- Plugin classes moved to wp-builder
### Added
- Factory can create checker from requirement array
- Support for update suggestion when required plugin not found
- WPDesk_Basic_Requirement_Checker_With_Update_Disable can temporarily say that requirements are not met when required plugin is in the process of being updated
- Translations

## [2.4.0] - 2019-06-04
### Added
- Plugin name in plugin info

## [2.3.1] - 2019-03-25
### Fixed
- Backward compatibility

## [2.3.0] - 2019-03-25
### Added
- Factory
- Interface
### Changed
- Minor internal action renaming
