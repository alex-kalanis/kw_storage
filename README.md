# kw_storage

![Build Status](https://github.com/alex-kalanis/kw_storage/actions/workflows/code_checks.yml/badge.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_storage/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_storage/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_storage/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_storage)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_storage.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_storage)
[![License](https://poser.pugx.org/alex-kalanis/kw_storage/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_storage)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_storage/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_storage/?branch=master)

Simple system for accessing key-value storages. Original is part of UploadPerPartes,
where it's necessary for store states of upload. To data it behaves like simple key-value
storage. Which can derive to real flat storages like memory or redis or tree-like
structures like your normal filesystem. No streams here.

The main thing about this package are the interfaces. Especially ```IStorage``` which
represents all supported operations over storages and shall be used on upper layers as
the only necessary dependency.

It is also the correct way to get it via ```Access\Factory``` class which select the
best possible storage in accordance with passed params from your configuration. That
can be put inside your DI.

This package also contains translations interface. So you can customize error messages
for your devs and users.


## PHP Installation

```bash
composer.phar require alex-kalanis/kw_storage
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## Changes

* 6.0 - Use DateTime interfaces, tests for 8.4 and own namespaces
* 5.0 - Streams are on different level, not here
* 4.0 - Redefine factories and some key classes
* 3.0 - Redefine interfaces for targets
* 2.0 - Redefine Key-Value storing data
  * Remove formats and cache support (that should not be a problem of storage)
  * Added stream variant support
  * Added interface for catching content with sub-content (so directories) on storage-level
* 1.0 - Initial version, with basics and cache support


## PHP Usage

It partially depends on real storage. Can be local filesystem, can be remote service too.
But the interfaces in this package make them all equal in terms of usage. So...

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote services. Can be
    Redis or AWS or something else. Or nothing if it is only local FS.

3.) Connect either ```kalanis\kw_storage\Interfaces\IStorage```, ```kalanis\kw_storage\Storage```
    or ```kalanis\kw_storage\Helper``` into your app. That usually happens in DI. Extend it
    for setting your case, especially if you use tree with dirs.

4.) Extend your libraries by interfaces inside the package. Mainly
    ```kalanis\kw_storage\Interfaces\IStorage``` which represents that available actions
    or ```kalanis\kw_storage\Storage``` which packs it like facade.

5.) Just use inside your app.


#### Notes

Listing output contains storage separators. Asked root record is empty, the rest
has that separator at least on the beginning. It depends on storage and class
if the listing came with complete tree with sub-entries or just first level.
