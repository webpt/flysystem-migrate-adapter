# Flysystem Adapter for Migration.
This adapter's use is for a scenario where you have a long running process of copying content from a source data store 
to a destination data store. To keep things simple you will copy via rsync mechanism -- which will copy a file from source 
to destination when the file does not exist in the destination or the last updated time of the destination file is less than the last updated time of the source file. 

In order to make use of your new storage mechanism and to prevent migration issues, you want your application to follow these rules:
 
  * Content that has been copied to the destination data store should be served from the destination data store.
  * Content that has not yet been copied over should be served from the source data store. 
  * New content should be written directly to the destination data store.
  * Updates should be applied to the destination data store file (if it exists) OR the source data store file.
  * Renames should be applied to the destination data store file (if it exists) AND the source data store file.
  * Deletes should be applied to the destination data store file (if it exists) AND the source data store file.

## Behavior Documentation
The following use case scenario documents actions against the filesystem and the expected results.

### Scenario setup
Each of the file system actions listed below will be performed against this example setup:

```
  # directory structure
  source/
    fileA.txt
    fileB.txt
  dest/
    fileB.txt
  
  # content of fileA.txt
  hello
  # content of fileB.txt
  fizzbuzz
```  

`$filesystem = new MigrateAdapter(new Local('source/'), new Local('dest/'));`

#### write
`$filesystem->write('fileC.txt', 'hello');`

Creates the file `dest/fileC.txt` with the content `hello`.
#### update
`$filesystem->update('fileA.txt', 'world');`

Appends the file `source/fileA.txt` with the content `world`.

`$filesystem->update('fileB.txt', 'bar');`

Appends the file `dest/fileB.txt` with the content `bar`.
#### read
`$filesystem->read('fileB.txt');`

Returns `dest/fileB.txt` content.

`$filesystem->read('fileA.txt');`

Returns `source/fileA.txt` content.
#### copy
`$filesystem->copy('fileA.txt', 'fileD.txt');`

Copies the file `source/fileA.txt` to `source/fileD.txt`.

`$filesystem->copy('fileB.txt', 'fileD.txt');`

Copies the file `dest/fileB.txt` to `dest/fileD.txt`.
#### rename
`$filesystem->rename('fileA.txt', 'fileE.txt');`

Renames the file `source/fileA.txt` to `source/fileE.txt`.

`$filesystem->rename('fileB.txt', 'fileE.txt');`

Renames the file `dest/fileB.txt` to `dest/fileE.txt`.
#### delete
`$filesystem->delete('fileA.txt');`

Deletes the file `source/fileA.txt`.

`$filesystem->delete('fileB.txt');`

Deletes the file `dest/fileB.txt` and `source/fileB.txt`.

## Installation

```bash
composer require WebPT/flysystem-migrate-adapter
```

## Usage

```php
$source = new League\Flysystem\Adapter\Local(...);
$replica = new League\Flysystem\Adapter\AwsS3(...);
$adapter = new WebPT\Flysystem\Migrate\MigrateAdapter($source, $replica);
```