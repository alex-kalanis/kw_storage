<?php

namespace kalanis\kw_storage;


use Traversable;


/**
 * Class Storage
 * @package kalanis\kw_storage
 * Main storage class
 */
class Storage
{
    /** @var Storage\Storage|null */
    protected $storage = null;
    /** @var Storage\Factory */
    protected $storageFactory = null;

    public function __construct(Storage\Factory $storageFactory)
    {
        $this->storageFactory = $storageFactory;
    }

    /**
     * @param Interfaces\IStorage|array|string|null $storageParams
     */
    public function init($storageParams)
    {
        $this->storage = $this->storageFactory->getStorage($storageParams);
    }

    /**
     * If entry exists in storage
     * @param string $key
     * @return boolean
     * @throws StorageException
     */
    public function exists(string $key): bool
    {
        $this->checkStorage();
        return $this->storage->exists($key);
    }

    /**
     * Get data from storage
     * @param string $key
     * @return mixed
     * @throws StorageException
     */
    public function get(string $key)
    {
        $this->checkStorage();
        $content = $this->storage->read($key);
        return empty($content) ? null : $content ;
    }

    /**
     * Set data to storage
     * @param string $key
     * @param mixed $value
     * @param int $expire
     * @return boolean
     * @throws StorageException
     */
    public function set(string $key, $value, ?int $expire = 8600): bool
    {
        $this->checkStorage();
        return $this->storage->write($key, $value, $expire);
    }

    /**
     * Add data to storage
     * @param string $key
     * @param mixed $value
     * @param int $expire
     * @return boolean
     * @throws StorageException
     */
    public function add(string $key, $value, ?int $expire = 8600): bool
    {
        $this->checkStorage();
        // safeadd for multithread at any system
        if ($this->storage->write($key, $value, $expire)) {
            return ( $value == $this->get($key) );
        }
        return false;
    }

    /**
     * Increment value by key
     * @param string $key
     * @return boolean
     * @throws StorageException
     */
    public function increment(string $key): bool
    {
        $this->checkStorage();
        return $this->storage->increment($key);
    }

    /**
     * Decrement value by key
     * @param string $key
     * @return boolean
     * @throws StorageException
     */
    public function decrement(string $key): bool
    {
        $this->checkStorage();
        return $this->storage->decrement($key);
    }

    /**
     * Return all active storage keys
     * @return Traversable for foreach()
     * @throws StorageException
     */
    public function getAllKeys(): Traversable
    {
        $this->checkStorage();
        return $this->storage->lookup('');
    }

    /**
     * Delete data by key from storage
     * @param string $key
     * @return boolean
     * @throws StorageException
     */
    public function delete(string $key): bool
    {
        $this->checkStorage();
        return $this->storage->remove($key);
    }

    /**
     * Delete multiple keys from storage
     * @param string[] $keys
     * @return string[]
     * @throws StorageException
     */
    public function deleteMulti(array $keys)
    {
        $this->checkStorage();
        return $this->storage->removeMulti($keys);
    }

    /**
     * Delete all data from storage where key starts with prefix
     * @param string $prefix
     * @param boolean $inverse - if true remove all data where keys doesn't starts with prefix
     * @throws StorageException
     * @codeCoverageIgnore mock has no keys for now
     */
    public function deleteByPrefix(string $prefix, $inverse = false): void
    {
        $keysToDelete = [];
        foreach ($this->getAllKeys() as $memKey) {
            $find = strpos($memKey, $prefix);
            if ((! $inverse && $find === 0) || ($inverse && ($find === false || $find !== 0))) {
                $keysToDelete[] = $memKey;
            }
        }
        $this->deleteMulti($keysToDelete);
    }

    /**
     * Check connection status to storage
     * @return boolean
     * @throws StorageException
     */
    public function isConnected(): bool
    {
        $this->checkStorage();
        return $this->storage->canUse();
    }

    /**
     * @throws StorageException
     */
    protected function checkStorage(): void
    {
        if (empty($this->storage)) {
            throw new StorageException('Storage not initialized');
        }
    }
}
