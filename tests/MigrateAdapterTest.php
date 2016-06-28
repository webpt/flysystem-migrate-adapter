<?php


class MigrateAdapterTest extends PHPUnit_Framework_TestCase
{
    public function testMethodWriteWillWriteToDestination()
    {

    }

    public function testMethodWriteStreamWillWriteToDestination()
    {

    }
    // update
    public function testMethodUpdateWillWriteToDestinationIfNotInDestination()
    {
        
    }
    
    public function testMethodUpdateWillUpdateDestination()
    {
        
    }
    
    public function testMethodUpdateWillUpdateSource()
    {
        
    }
    
    public function testMethodUpdateWillNotUpdateSourceIfNotInSource()
    {
        
    }

    // updateStream
    public function testMethodUpdateStreamWillWriteStreamToDestinationIfNotInDestination()
    {

    }

    public function testMethodUpdateStreamWillUpdateStreamDestination()
    {

    }

    public function testMethodUpdateStreamWillUpdateStreamSource()
    {

    }

    public function testMethodUpdateStreamWillNotUpdateStreamSourceIfNotInSource()
    {

    }
    
    // rename
    public function testMethodRenameWillRenameDestination()
    {
        
    }

    public function testMethodRenameWillCopyToDestinationIfNotInDestination()
    {

    }

    public function testMethodRenameWillDeleteSource()
    {

    }

    public function testMethodRenameWillNotModifySourceIfNotInSource()
    {

    }

    public function testMethodRenameReturnsFalseIfNotInSourceOrDestination()
    {

    }

    // copy
    public function testMethodCopyWillCopyFromDestinationToDestination()
    {

    }

    public function testMethodCopyWillCopyFromSourceToDestinationIfNotInDestination()
    {

    }

    public function testMethodCopyWillNotCopyToSource()
    {

    }

    public function testMethodCopyWillReturnFalseIfNotInSourceOrDestination()
    {

    }

    // delete
    public function testMethodDeleteDeletesFromDestination()
    {

    }

    public function testMethodDeleteDeletesFromSource()
    {

    }

    public function testMethodDeleteReturnsFalseIfNotInSourceOrDestination()
    {

    }

    // deleteDir
    public function testMethodDeleteDirDeletesFromDestination()
    {

    }

    public function testMethodDeleteDirDeletesFromSource()
    {

    }

    public function testMethodDeleteDirReturnsFalseIfNotInSourceOrDestination()
    {

    }

    // createDir
    public function testMethodCreateDirCreatesDirInDestination()
    {

    }

    public function testMethodCreateDirDoesNotCreateDirInSource()
    {

    }

    // setVisibility
    public function testMethodSetVisibilitySetsVisibilityOnSource()
    {

    }

    public function testMethodSetVisibilitySetsVisibilityOnDestination()
    {

    }

    public function testMethodSetVisibilityReturnsFalseIfNotAbleToSetVisibilityOnSource()
    {

    }

    public function testMethodSetVisibilityReturnsFalseIfNotAbleToSetVisibilityOnDestination()
    {

    }

    // getVisibility
    public function testMethodGetVisibilityGetsVisibilityOnDestination()
    {

    }

    public function testMethodGetsVisibilityGetsVisibilityOnSourceIfNotInDestination()
    {

    }

    public function testMethodGetVisibilityReturnsFalseIfNotInSourceOrDestination()
    {

    }

    // has
    public function testMethodHasReturnsTrueIfInDestination()
    {

    }

    public function testMethodHasReturnsTrueIfInSource()
    {

    }

    public function testMethodHasReturnsFalseIfNotInSourceOrDestination()
    {

    }

    // read
    public function testMethodReadReadsFromDestination()
    {

    }

    public function testMethodReadCopiesFromSourceThenReadsFromDestinationIfNotInDestination()
    {

    }

    public function testMethodReadReturnsFalseIfNotInSourceOrDestination()
    {

    }

    // readStream
    public function testMethodReadStreamReadsStreamFromDestination()
    {

    }

    public function testMethodReadStreamCopiesFromSourceThenReadsStreamFromDestinationIfNotInDestination()
    {

    }

    public function testMethodReadStreamReturnsFalseIfNotInSourceOrDestination()
    {

    }

    // listContents
    public function testMethodListContentsListsMergedAndDedupedContentsFromSourceAndDestination()
    {

    }

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
    public function testMethodCallCopiesFromSourceThenCallsAgainstDestination($method, $path)
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
