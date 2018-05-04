Northwoods Entity Proxy
=======================

[![Become a Supporter](https://img.shields.io/badge/patreon-sponsor%20me-e6461a.svg)](https://www.patreon.com/shadowhand)
[![Latest Stable Version](https://img.shields.io/packagist/v/northwoods/entity-proxy.svg)](https://packagist.org/packages/northwoods/entity-proxy)
[![License](https://img.shields.io/packagist/l/northwoods/entity-proxy.svg)](https://github.com/northwoods/entity-proxy/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/northwoods/entity-proxy.svg)](https://travis-ci.org/northwoods/entity-proxy)
[![Code Coverage](https://scrutinizer-ci.com/g/northwoods/entity-proxy/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/northwoods/entity-proxy/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/northwoods/entity-proxy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/northwoods/entity-proxy/?branch=master)

A [reflection][php-reflection] based proxy for hydrating objects with private properties.

[php-reflection]: http://php.net/reflection

Attempts to be [PSR-1][psr-1], [PSR-2][psr-2], and [PSR-4][psr-4] compliant.

[psr-1]: http://www.php-fig.org/psr/psr-1/
[psr-2]: http://www.php-fig.org/psr/psr-2/
[psr-4]: http://www.php-fig.org/psr/psr-4/

## Install

```
composer require northwoods/entity-proxy
```

## Usage

```php
use Northwoods\EntityProxy\ProxyFactory;

// Create a new proxy factory
$factory = new ProxyFactory();

// Create a proxy to an existing class
$proxy = $factory->proxy(User::class);

// Write properties of the object
$proxy->set('id', 5);

// Also possible to use an array
$proxy->setArray(['username' => 'mary']);

// Get the object
$user = $proxy->reveal();
```

## Reasoning

In Domain Driven Design it is often recommended that entities use private
properties with getters to access state and setters to change state based on
business requirements. Since an entity is considered to be a persistent object,
its constructor should only be called **once for the lifetime of the entity**.
This allows for domain events to be triggered by the constructor to notify the
application that, for example, a new user has registered.

With this limitation in mind, the requirements for the hydrator are:

1. It must not call the entity constructor.
2. It must be able to set private/protected properties.
3. It must be as efficient as possible.

The easiest way to achieve these goals is to use reflection, which allows us to
[create objects without constuctor][php-ref-class], [make properties accessible][php-ref-access],
and [write property values][php-ref-set]. The reflection of every class should be
internally cached for the lifetime of the factory to maximize performance.

[php-ref-class]: https://php.net/manual/en/reflectionclass.newinstancewithoutconstructor.php
[php-ref-access]: https://php.net/manual/en/reflectionproperty.setaccessible.php
[php-ref-set]: https://php.net/manual/en/reflectionproperty.setvalue.php

If performance is of concern there are [other viable approaches][generated-hydrator]
that are faster but more complicated to setup and use.

[generated-hydrator]: https://packagist.org/packages/ocramius/generated-hydrator

## License

MIT
