# Flysystem Adapter for Migration.

## Behavior
### use case scenario
```
  # directory structure
  source/
    fileA.txt
  dest/
  
  # content of fileA.txt
  hello
```  

`$filesystem = new MigrateAdapter(new Local('source/'), new Local('dest/'));`

#### write
`$filesystem->write('fileB.txt', 'hello');`

Creates the file `dest/fileB.txt` with the content `hello`.
#### update
`$filesystem->write('fileA.txt', 'world');`

Copies `source/fileA.txt` to `dest/fileA.txt`.

Appends the file `dest/fileA.txt` with the content `world`.

Copies `dest/fileA.txt` to `source/fileA.txt`.
#### read
`$filesystem->read('fileA.txt');`

Copies the file `source/fileA.txt` to `dest/fileA.txt`.

Returns `dest/fileA.txt` content.
#### copy
`$filesystem->copy('fileA.txt', 'fileB.txt');`

Copies the file `source/fileA.txt` to `dest/fileB.txt`.
#### rename
`$filesystem->rename('fileA.txt', 'fileB.txt');`

Copies the file `source/fileA.txt` to `dest/fileB.txt`.

Deletes the file `source/fileA.txt`.
#### delete
`$filesystem->delete('fileA.txt');`

Deletes the file `dest/fileA.txt` if it exists.

Deletes the file `source/fileA.txt`.
## Installation

```bash
composer require WebPT/flysystem-migrate-adapter
```

## Usage

```php
$source = new League\Flysystem\Adapter\AwsS3(...);
$replica = new League\Flysystem\Adapter\Local(...);
$adapter = new WebPT\Flysystem\Migrate\MigrateAdapter($source, $replica);
```