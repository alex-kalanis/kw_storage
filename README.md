# kw_storage

[![Build Status](https://app.travis-ci.com/alex-kalanis/kw_storage.svg?branch=master)](https://app.travis-ci.com/github/alex-kalanis/kw_storage)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_storage/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_storage/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_storage/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_storage)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_storage.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_storage)
[![License](https://poser.pugx.org/alex-kalanis/kw_storage/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_storage)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_storage/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_storage/?branch=master)

Simple system for accessing key-value storages. Original is part of UploadPerPartes,
where it's necessary for store states of upload.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_storage": "4.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)

## Changes

* 4.0 - Redefine factories and some key classes
* 3.0 - Redefine interfaces for targets
* 2.0 - Redefine Key-Value storing data
  * Remove formats and cache support (that should not be a problem of storage)
  * Added stream variant support
  * Added interface for catching content with sub-content (so directories) on storage-level
* 1.0 - Initial version, with basics and cache support


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote services.

3.) Connect the "kalanis\kw_storage\Storage" or "kalanis\kw_storage\Helper" into your app. Extends it for setting your case, especially dirs.

4.) Extend your libraries by interfaces inside the package.

5.) Just use inside your app.

#### Notes

Listing output contains storage separators. Asked root record is empty, the rest
has that separator at least on the beginning. It depends on storage and class
if the listing came with complete tree with sub-entries or just first level.
