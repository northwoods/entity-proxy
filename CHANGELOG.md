# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) 
and this project adheres to [Semantic Versioning](http://semver.org/).

## [2.1.0]

### Added

- Proxy::get() to read object values

## [2.0.0]

### Added

- ProxyFactory::create() for empty objects
- ProxyFactory::modify() for existing objects

### Changed

- ProxyFactory changed to a static singleton

### Removed

- ProxyFactory::proxy() removed in favor of ProxyFactory::create()

## [1.1.0]

### Added

- Add `setArray()` method to proxy

## [1.0.0]

Initial release.
