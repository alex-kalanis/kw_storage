# kw_storage

Simple system for accessing key-value storages. Original is part of UploadPerPartes,
where it's necessary for store states of upload.

# PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_storage": "dev-master"
    },
    "repositories": [
        {
            "type": "http",
            "url":  "https://github.com/alex-kalanis/kw_storage.git"
        }
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


# PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote services.

3.) Connect the "kalanis\kw_storage\Storage" or "kalanis\kw_storage\StaticCache" into your app. Extends it for setting your case.

4.) Extend your libraries by interfaces inside the package.

5.) Just use inside your app.

# Python Installation

into your "setup.py":

```
    install_requires=[
        'kw_storage',
    ]
```

# Python Usage

1.) Connect the "kw_storage.storage" into your app. When it came necessary
you can extends every library to comply your use-case, mainly format of storage.
