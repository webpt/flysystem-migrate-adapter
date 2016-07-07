<?php


class MigrateAdapterTest extends PHPUnit_Framework_TestCase
{
    // write

    // write stream

    // update

    // updateStream

    // rename

    // copy

    // delete

    // deleteDir

    // createDir

    // setVisibility

    // getVisibility

    // has

    // read

    // readStream

    // listContents

    // getMetadata, getSize, getMimetype, getTimestamp

    /**
     * @dataProvider methodCallProvider
     * @param string $method
     * @param string $path
     */
    public function testMethodCallCallsAgainstDestination($method, $path)
    {

    }

    /**
     * @dataProvider methodCallProvider
     * @param string $method
     * @param string $path
     */
    public function testMethodCallCallsAgainstSourceIfFileDoesNotExistInDestination($method, $path)
    {

    }

    /**
     * @dataProvider methodCallProvider
     * @param string $method
     * @param string $path
     */
    public function testMethodCallReturnsFalseIfNotInSourceOrDestination($method, $path)
    {

    }

    public function methodCallProvider()
    {
        return [
            'getMetadata' => ['getMetadata', '/path/to/file'],
            'getSize' => ['getSize', '/path/to/file'],
            'getMimetype' => ['getMimetype', '/path/to/file'],
            'getTimestamp' => ['getTimestamp', '/path/to/file']
        ];
    }
}
