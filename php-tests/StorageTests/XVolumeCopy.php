<?php

namespace tests\StorageTests;


use kalanis\kw_storage\Extras\TVolumeCopy;


class XVolumeCopy
{
    use TVolumeCopy;

    public function copy(string $source, string $dest): bool
    {
        return $this->xcopy($source, $dest);
    }
}
