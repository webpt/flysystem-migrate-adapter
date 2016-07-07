<?php
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Clarkeash\Vfs\Adapter;
use org\bovigo\vfs\vfsStream;
use WebPT\Flysystem\Migrate\MigrateAdapter;
use PHPUnit_Framework_Assert as PHPUnit;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    const SOURCE_FOLDER = 'source';
    const DESTINATION_FOLDER = 'destination';

    /** @var  \org\bovigo\vfs\vfsStreamDirectory */
    private $sourceRoot;
    /** @var  \org\bovigo\vfs\vfsStreamDirectory */
    private $destinationRoot;
    /** @var  \League\Flysystem\FilesystemInterface */
    private $filesystem;
    /** @var  string */
    private $result;

    private $stream = null;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->initializeSourceRoot();
        $this->initializeDestinationRoot();

        $this->filesystem = new \League\Flysystem\Filesystem(new MigrateAdapter(
            new Adapter($this->sourceRoot->url()),
            new Adapter($this->destinationRoot->url())
        ));
    }

    /**
     * @Given /^an empty source$/
     */
    public function anEmptySource()
    {
        $this->initializeSourceRoot();
    }

    /**
     * @Given /^an empty destination$/
     */
    public function anEmptyDestination()
    {
        $this->initializeDestinationRoot();
    }

    private function initializeSourceRoot()
    {
        $this->sourceRoot = vfsStream::setup('/tmp' . DIRECTORY_SEPARATOR . self::SOURCE_FOLDER);
    }

    private function initializeDestinationRoot()
    {
        $this->destinationRoot = vfsStream::setup('/tmp' . DIRECTORY_SEPARATOR . self::DESTINATION_FOLDER);
    }

    /**
     * @When /^I write "([^"]*)" to the file "([^"]*)"$/
     */
    public function iWriteToTheFile($content, $fileName)
    {
        $this->filesystem->write($fileName, $content);
    }

    /**
     * @Then /^I should see the "([^"]*)" in the destination$/
     */
    public function iShouldSeeTheInTheDestination($fileName)
    {
        PHPUnit::assertFileExists($this->destinationRoot->url() . DIRECTORY_SEPARATOR . $fileName);
    }

    /**
     * @Given /^the contents of "([^"]*)" in the destination should be "([^"]*)"$/
     */
    public function theContentsOfInTheDestinationShouldBe($fileName, $expectedContents)
    {
        $contents = file_get_contents($this->destinationRoot->url() . DIRECTORY_SEPARATOR . $fileName);
        PHPUnit::assertEquals($expectedContents, $contents);
    }

    /**
     * @Given /^the source should not contain "([^"]*)"$/
     */
    public function theSourceShouldNotContain($fileName)
    {
        PHPUnit::assertFileNotExists($this->sourceRoot->url() . DIRECTORY_SEPARATOR . $fileName);
    }

    /**
     * @When /^I open a stream for "([^"]*)"$/
     */
    public function iOpenAStreamFor($fileName)
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }

        $this->stream = fopen($fileName, 'r+');
    }

    /**
     * @Given /^I write the stream to "([^"]*)"$/
     */
    public function iWriteTheStreamTo($fileName)
    {
        $this->filesystem->writeStream($fileName, $this->stream);
        fseek($this->stream, 0); // reset for reading again
    }

    /**
     * @Given /^the source contains "([^"]*)" with contents "([^"]*)"$/
     */
    public function theSourceContainsWithContents($fileName, $contents)
    {
        file_put_contents($this->sourceRoot->url() . DIRECTORY_SEPARATOR . $fileName, $contents);
    }

    /**
     * @Given /^I update "([^"]*)" with the stream$/
     */
    public function iUpdateWithTheStream($fileName)
    {
        $this->filesystem->updateStream($fileName, $this->stream);
        fseek($this->stream, 0);
    }

    /**
     * @Then /^the contents of "([^"]*)" in the source should be "([^"]*)"$/
     */
    public function theContentsOfInTheSourceShouldBe($fileName, $expectedContents)
    {
        $contents = file_get_contents($this->sourceRoot->url() . DIRECTORY_SEPARATOR . $fileName);
        PHPUnit::assertEquals($expectedContents, $contents);
    }

    /**
     * @Given /^the destination contains "([^"]*)" with contents "([^"]*)"$/
     */
    public function theDestinationContainsWithContents($fileName, $content)
    {
        file_put_contents($this->destinationRoot->url() . DIRECTORY_SEPARATOR . $fileName, $content);
    }

    /**
     * @When /^I update the file "([^"]*)" with "([^"]*)"$/
     */
    public function iUpdateTheFileWith($fileName, $content)
    {
        $this->filesystem->update($fileName, $content);
    }

    /**
     * @When /^I read the file "([^"]*)"$/
     */
    public function iReadTheFile($fileName)
    {
        $this->result = $this->filesystem->read($fileName);
    }

    /**
     * @Then /^I should see "([^"]*)"$/
     */
    public function iShouldSee($expectedValue)
    {
        PHPUnit::assertEquals($expectedValue, $this->result);
    }

    /**
     * @When /^I read "([^"]*)" into a stream$/
     */
    public function iReadIntoAStream($fileName)
    {
        $this->stream = $this->filesystem->readStream($fileName);
    }

    /**
     * @Then /^the stream should contain "([^"]*)"$/
     */
    public function theStreamShouldContain($expectedContent)
    {
        PHPUnit::assertEquals($expectedContent, stream_get_contents($this->stream));
    }

    /**
     * @When /^I copy "([^"]*)" to "([^"]*)"$/
     */
    public function iCopyTo($fileName, $copyName)
    {
        $this->filesystem->copy($fileName, $copyName);
    }

    /**
     * @Given /^the source should contain "([^"]*)"$/
     */
    public function theSourceShouldContain($fileName)
    {
        PHPUnit::assertFileExists($this->sourceRoot->url() . DIRECTORY_SEPARATOR . $fileName);
    }

    /**
     * @Given /^the destination should contain "([^"]*)"$/
     */
    public function theDestinationShouldContain($fileName)
    {
        PHPUnit::assertFileExists($this->destinationRoot->url() . DIRECTORY_SEPARATOR . $fileName);
    }

    /**
     * @When /^I rename "([^"]*)" to "([^"]*)"$/
     */
    public function iRenameTo($fileName, $newName)
    {
        $this->filesystem->rename($fileName, $newName);
    }

    /**
     * @Given /^the destination should not contain "([^"]*)"$/
     */
    public function theDestinationShouldNotContain($fileName)
    {
        PHPUnit::assertFileNotExists($this->destinationRoot->url() . DIRECTORY_SEPARATOR . $fileName);
    }

    /**
     * @When /^I delete "([^"]*)"$/
     */
    public function iDelete($fileName)
    {
        $this->filesystem->delete($fileName);
    }

    /**
     * @When /^I check if "([^"]*)" exists$/
     */
    public function iCheckIfExists($fileName)
    {
        $this->result = $this->filesystem->has($fileName);
    }

    /**
     * @Then /^it should say the file exists$/
     */
    public function itShouldSayTheFileExists()
    {
        PHPUnit::assertTrue($this->result);
    }

    /**
     * @When /^I create the directory "([^"]*)"$/
     */
    public function iCreateTheDirectory($directoryName)
    {
        $this->filesystem->createDir($directoryName);
    }

    /**
     * @Then /^the destination should contain the directory "([^"]*)"$/
     */
    public function theDestinationShouldContainTheDirectory($directoryName)
    {
        PHPUnit::assertTrue(is_dir($this->destinationRoot->url() . DIRECTORY_SEPARATOR . $directoryName));
    }

    /**
     * @Given /^the source contains the directory "([^"]*)"$/
     */
    public function theSourceContainsTheDirectory($directoryName)
    {
        $dir = $this->sourceRoot->url() . DIRECTORY_SEPARATOR . $directoryName;
        if(!@mkdir($dir) && !is_dir($dir)) {
            throw new \RuntimeException("Could not create directory for test");
        }
    }

    /**
     * @When /^I delete the directory "([^"]*)"$/
     */
    public function iDeleteTheDirectory($directoryName)
    {
        $this->filesystem->deleteDir($directoryName);
    }

    /**
     * @Then /^the source should not contain the directory "([^"]*)"$/
     */
    public function theSourceShouldNotContainTheDirectory($fileName)
    {
        PHPUnit::assertFalse(is_dir($this->sourceRoot->url() . DIRECTORY_SEPARATOR . $fileName));
    }

    /**
     * @Given /^the destination contains the directory "([^"]*)"$/
     */
    public function theDestinationContainsTheDirectory($directoryName)
    {
        $dir = $this->destinationRoot->url() . DIRECTORY_SEPARATOR . $directoryName;
        if(!@mkdir($dir) && !is_dir($dir)) {
            throw new \RuntimeException("Could not create directory for test");
        }
    }

    /**
     * @Then /^the destination should not contain the directory "([^"]*)"$/
     */
    public function theDestinationShouldNotContainTheDirectory($fileName)
    {
        PHPUnit::assertFalse(is_dir($this->destinationRoot->url() . DIRECTORY_SEPARATOR . $fileName));
    }

    /**
     * @When /^I list the contents of "([^"]*)"$/
     */
    public function iListTheContentsOf($directoryName)
    {
        $this->result = $this->filesystem->listContents($directoryName);
    }

    /**
     * @When /^I check the file size of "([^"]*)"$/
     */
    public function iCheckTheFileSizeOf($fileName)
    {
        $this->result = $this->filesystem->getSize($fileName);
    }

    /**
     * @When /^I get the metadata for "([^"]*)"$/
     */
    public function iGetTheMetadataFor($fileName)
    {
        $this->result = $this->filesystem->getMetadata($fileName);
    }

    /**
     * @When /^I get the timestamp for "([^"]*)"$/
     */
    public function iGetTheTimestampFor($fileName)
    {
        $this->result = $this->filesystem->getTimestamp($fileName);
    }

    /**
     * @When /^I get the mimetype for "([^"]*)"$/
     */
    public function iGetTheMimetypeFor($fileName)
    {
        $this->result = $this->filesystem->getMimetype($fileName);
    }


}
