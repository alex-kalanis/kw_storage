<?php

namespace kalanis\kw_storage\Storage\Target;


use DateTimeInterface;
use kalanis\kw_storage\Extras\TRemoveCycle;
use kalanis\kw_storage\Extras\TVolumeCopy;
use kalanis\kw_storage\Interfaces\IStTranslations;
use kalanis\kw_storage\Interfaces\Target\ITargetVolume;
use kalanis\kw_storage\StorageException;
use kalanis\kw_storage\Traits\TLang;
use Traversable;


/**
 * Class Volume
 * @package kalanis\kw_storage\Storage\Target
 * Store content onto volume
 */
class Volume implements ITargetVolume
{
    use TOperations;
    use TRemoveCycle;
    use TVolumeCopy;
    use TLang;

    public function __construct(?IStTranslations $lang = null)
    {
        $this->setStLang($lang);
    }

    public function check(string $key): bool
    {
        $sepPos = mb_strrpos($key, DIRECTORY_SEPARATOR);
        $path = (false === $sepPos) ? substr($key, 0) : substr($key, 0, intval($sepPos));
        if (!is_dir($path)) {
            if (file_exists($path)) {
                unlink($path);
            }
            return mkdir($path, 0777);
        }
        return true;
    }

    public function exists(string $key): bool
    {
        return @file_exists($key);
    }

    public function isDir(string $key): bool
    {
        return @is_dir($key);
    }

    public function isFile(string $key): bool
    {
        return @is_file($key);
    }

    public function isReadable(string $key): bool
    {
        return @is_readable($key);
    }

    public function isWritable(string $key): bool
    {
        return @is_writable($key);
    }

    public function mkDir(string $key, bool $recursive = false): bool
    {
        return @mkdir($key, 0777, $recursive);
    }

    public function rmDir(string $key, bool $recursive = false): bool
    {
        return $recursive ? $this->removeCycle($key) : @rmdir($key);
    }

    public function load(string $key): string
    {
        $content = @file_get_contents($key);
        if (false === $content) {
            throw new StorageException($this->getStLang()->stCannotReadFile());
        }
        return strval($content);
    }

    public function save(string $key, string $data, ?int $timeout = null): bool
    {
        return (false !== @file_put_contents($key, $data));
    }

    public function copy(string $source, string $dest): bool
    {
        return $this->xcopy($source, $dest);
    }

    public function move(string $source, string $dest): bool
    {
        $v1 = $this->copy($source, $dest);
        $v2 = $this->removeCycle($source);
        return $v1 && $v2;
    }

    public function remove(string $key): bool
    {
        return @unlink($key);
    }

    public function size(string $key): ?int
    {
        $size = @filesize($key);
        return (false === $size) ? null : $size;
    }

    public function created(string $key): ?DateTimeInterface
    {
        $created = @filemtime($key);
        $dateObj = (false === $created) ? false : date_create_immutable('@' . $created);
        return (false === $dateObj) ? null : $dateObj;
    }

    public function lookup(string $path): Traversable
    {
        $real = realpath($path);
        if (false === $real) {
            return;
        }
        $files = @scandir($real);
        if (!empty($files)) {
            foreach ($files as $file) {
                if (empty($file) || '.' == $file) {
                    yield '';
                } elseif ('..' == $file) {
                    // pass
                } else {
                    yield DIRECTORY_SEPARATOR . $file;
                }
            }
        }
    }

    public function increment(string $key, int $step = 1): bool
    {
        try {
            $number = intval($this->load($key)) + $step;
        } catch (StorageException $ex) {
            // no file
            $number = 1;
        }
        $this->remove($key); // hanging pointers
        return $this->save($key, strval($number));
    }

    public function decrement(string $key, int $step = 1): bool
    {
        try {
            $number = intval($this->load($key)) - $step;
        } catch (StorageException $ex) {
            // no file
            $number = 0;
        }
        $this->remove($key); // hanging pointers
        return $this->save($key, strval($number));
    }
}
