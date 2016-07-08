<?php


namespace WebPT\Flysystem\Migrate;


use League\Flysystem\AdapterInterface;
use League\Flysystem\Config;

class MigrateAdapter implements AdapterInterface
{
    /** @var  AdapterInterface */
    private $source;
    /** @var  AdapterInterface */
    private $destination;

    /**
     * MigrateAdapter constructor.
     * @param AdapterInterface $source
     * @param AdapterInterface $destination
     */
    public function __construct(AdapterInterface $source, AdapterInterface $destination)
    {
        $this->source = $source;
        $this->destination = $destination;
    }

    /**
     * Write a new file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function write($path, $contents, Config $config)
    {
        return $this->destination->write($path, $contents, $config);
    }

    /**
     * Write a new file using a stream.
     *
     * @param string $path
     * @param resource $resource
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function writeStream($path, $resource, Config $config)
    {
        return $this->destination->writeStream($path, $resource, $config);
    }

    /**
     * Update a file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function update($path, $contents, Config $config)
    {
        return $this->preferDestination($path)->update($path, $contents, $config);
    }

    /**
     * Update a file using a stream.
     *
     * @param string $path
     * @param resource $resource
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function updateStream($path, $resource, Config $config)
    {
        return $this->preferDestination($path)->updateStream($path, $resource, $config);
    }

    /**
     * Rename a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function rename($path, $newpath)
    {
        $result = false;
        if ($this->destination->has($path)) {
            $result = $this->destination->rename($path, $newpath);
        }
        if ($this->source->has($path)) {
            return $this->source->rename($path, $newpath);
        }
        return $result;
    }

    /**
     * Copy a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function copy($path, $newpath)
    {
        return $this->preferDestination($path)->copy($path, $newpath);
    }

    /**
     * Delete a file.
     *
     * @param string $path
     *
     * @return bool
     */
    public function delete($path)
    {
        $result = false;
        if ($this->destination->has($path)) {
            $result = $this->destination->delete($path);
        }
        if ($this->source->has($path)) {
            return $this->source->delete($path);
        }
        return $result;
    }

    /**
     * Delete a directory.
     *
     * @param string $dirname
     *
     * @return bool
     */
    public function deleteDir($dirname)
    {
        $result = false;
        if ($this->destination->has($dirname)) {
            $result = $this->destination->deleteDir($dirname);
        }
        if ($this->source->has($dirname)) {
            return $this->source->deleteDir($dirname);
        }
        return $result;
    }

    /**
     * Create a directory.
     *
     * @param string $dirname directory name
     * @param Config $config
     *
     * @return array|false
     */
    public function createDir($dirname, Config $config)
    {
        return $this->destination->createDir($dirname, $config);
    }

    /**
     * Set the visibility for a file.
     *
     * @param string $path
     * @param string $visibility
     *
     * @return array|false file meta data
     */
    public function setVisibility($path, $visibility)
    {
        return $this->preferDestination($path)->setVisibility($path, $visibility);
    }

    /**
     * Check whether a file exists.
     *
     * @param string $path
     *
     * @return array|bool|null
     */
    public function has($path)
    {
        if ($this->destination->has($path) || $this->source->has($path)) {
            return true;
        }
        return false;
    }

    /**
     * Read a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function read($path)
    {
        return $this->preferDestination($path)->read($path);
    }

    /**
     * Read a file as a stream.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function readStream($path)
    {
        return $this->preferDestination($path)->readStream($path);
    }

    /**
     * List contents of a directory.
     *
     * @param string $directory
     * @param bool $recursive
     *
     * @return array
     */
    public function listContents($directory = '', $recursive = false)
    {
        $merged = $this->destination->listContents($directory, $recursive);

        $contains = function($path, $list) {
            foreach($list as $entry) {
                if ($entry['path'] === $path) {
                    return true;
                }
            }
            return false;
        };

        foreach ($this->source->listContents($directory, $recursive) as $file) {
            if(! $contains($file['path'], $merged)) {
                $merged[] = $file;
            }
        }

        $compare = function ($entryA, $entryB) {
            return strcmp($entryA['path'], $entryB['path']);
        };

        usort($merged, $compare);
        return $merged;
    }

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMetadata($path)
    {
        return $this->preferDestination($path)->getMetadata($path);
    }

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getSize($path)
    {
        return $this->preferDestination($path)->getSize($path);
    }

    /**
     * Get the mimetype of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMimetype($path)
    {
        return $this->preferDestination($path)->getMimetype($path);
    }

    /**
     * Get the timestamp of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getTimestamp($path)
    {
        return $this->preferDestination($path)->getTimestamp($path);
    }

    /**
     * Get the visibility of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getVisibility($path)
    {
        return $this->preferDestination($path)->getVisibility($path);
    }

    /**
     * Prefer to use the destination adapter if it contains the requested path
     * otherwise use the source adapter
     * @param string $path
     * @return AdapterInterface
     */
    private function preferDestination($path)
    {
        if ($this->destination->has($path)) {
            return $this->destination;
        }
        return $this->source;
    }
}