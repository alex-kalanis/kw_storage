<?php

namespace StorageTests;


use CommonTestClass;
use kalanis\kw_storage\Storage\Target;
use kalanis\kw_storage\StorageException;


class VolumeDeepTest extends CommonTestClass
{
    public function tearDown(): void
    {
        $this->rmFile($this->mockTestFile('', false));
        $this->rmFile($this->mockTestFile('2', false));
        $this->rmFile($this->mockTestFile('3', false));
        $this->rmFile($this->mockTestFile('4', false));
        $this->rmFile($this->mockTestFile('5', false));
        $this->rmDir($this->mockTestFile('', false));
        $this->rmDir('some');
        parent::tearDown();
    }

    /**
     * @throws StorageException
     */
    public function testLookup(): void
    {
        $volume = new Target\VolumeTargetFlat();
        $this->assertTrue($volume->check($this->getTestDir()));
        $testFiles = [
            'dummyFile.tst' => $this->getTestDir() . 'dummyFile.tst',
            'dummyFile.0.tst' => $this->getTestDir() . 'dummyFile.0.tst',
            'dummyFile.1.tst' => $this->getTestDir() . 'dummyFile.1.tst',
            'dummyFile.2.tst' => $this->getTestDir() . 'dummyFile.2.tst',
        ];
        $removal = $volume->removeMulti($testFiles);
        $this->assertEquals([
            'dummyFile.tst' => false,
            'dummyFile.0.tst' => false,
            'dummyFile.1.tst' => false,
            'dummyFile.2.tst' => false,
        ], $removal);

        file_put_contents($this->getTestDir() . 'dummyFile.tst', 'asdfghjklqwertzuiopyxcvbnm');
        file_put_contents($this->getTestDir() . 'dummyFile.0.tst', 'asdfghjklqwertzuiopyxcvbnm');
        file_put_contents($this->getTestDir() . 'dummyFile.1.tst', 'asdfghjklqwertzuiopyxcvbnm');
        file_put_contents($this->getTestDir() . 'dummyFile.2.tst', 'asdfghjklqwertzuiopyxcvbnm');

        // non-existent path
        $this->assertEquals(0, count(array_filter(array_filter(iterator_to_array($volume->lookup('this path does not exists'))), [$this, 'dotDirs'])));

        // empty path - must show everything
        // 5 -> + gitkeep; but here goes into exec path, so the results are environment-dependent
//        $this->assertEquals(5, count(array_filter(array_filter(iterator_to_array($volume->lookup(''))), [$this, 'dotDirs'])));

        $files = iterator_to_array($volume->lookup($this->getTestDir()));
        sort($files);
        $files = array_filter(array_filter($files), [$this, 'dotDirs']);

        $this->assertEquals(count($testFiles) + 1, count($files)); // because gitkeep
        $this->assertEquals(DIRECTORY_SEPARATOR . '.gitkeep', reset($files));
        $this->assertEquals(DIRECTORY_SEPARATOR . 'dummyFile.0.tst', next($files));
        $this->assertEquals(DIRECTORY_SEPARATOR . 'dummyFile.1.tst', next($files));
        $this->assertEquals(DIRECTORY_SEPARATOR . 'dummyFile.2.tst', next($files));
        $this->assertEquals(DIRECTORY_SEPARATOR . 'dummyFile.tst', next($files));

        $removal = $volume->removeMulti($testFiles);
        $this->assertFalse($volume->exists($this->getTestDir() . 'dummyFile.tst'));
        $this->assertFalse($volume->exists($this->getTestDir() . 'dummyFile.0.tst'));
        $this->assertFalse($volume->exists($this->getTestDir() . 'dummyFile.1.tst'));
        $this->assertFalse($volume->exists($this->getTestDir() . 'dummyFile.2.tst'));

        $this->assertEquals([
            'dummyFile.tst' => true,
            'dummyFile.0.tst' => true,
            'dummyFile.1.tst' => true,
            'dummyFile.2.tst' => true,
        ], $removal);
    }

    public function dotDirs(string $path): bool
    {
        return !in_array($path, ['.', '..', DIRECTORY_SEPARATOR . '.', DIRECTORY_SEPARATOR . '..']);
    }
}
