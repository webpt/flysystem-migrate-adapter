<?php


class MigrateAdapterTest extends PHPUnit_Framework_TestCase
{
    // write
    public function testWriteMethodWrapsDestination_Write()
    {

    }

    // write stream
    public function testWriteStreamMethodWrapsDestinationWriteStream()
    {

    }

    // update
    public function testUpdateMethodWrapsDestinationUpdateIfDestinationHasPath()
    {

    }

    public function testUpdateMethodWrapsSourceUpdateIfDestinationDoesNotHavePath()
    {

    }

    // updateStream
    public function testUpdateStreamMethodWrapsDestinationUpdateStreamIfDestinationHasPath()
    {

    }

    public function testUpdateStreamMethodWrapsSourceUpdateStreamIfDestinationDoesNotHavePath()
    {

    }

    // rename
    public function testRenameMethodWrapsSourceAndDestinationRename()
    {

    }

    public function testRenameMethodDoesNotWrapDestinationRenameIfDestinationDoesNotHavePath()
    {

    }

    public function testRenameMethodDoesNotWrapSourceRenameIfSourceDoesNotHavePath()
    {

    }

    // copy
    public function testCopyMethodWrapsDestinationCopyMethod()
    {

    }

    public function testCopyMethodWrapsSourceCopyMethodIfDestinationDoesNotHavePath()
    {

    }

    // delete
    public function testDeleteMethodWrapsSourceAndDestinationDelete()
    {

    }

    public function testDeleteMethodDoesNotWrapDestinationDeleteWhenDestinationDoesNotHavePath()
    {

    }

    public function testDeleteMethodDoesNotWrapSourceDeleteWhenSourceDoesNotHavePath()
    {

    }

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
