# File Creator Service

With the File Creator Service you can create files easily.

## Table of Contents

- [Getting started](#getting-started)
	- [Requirements](#requirements)
	- [Highlights](#highlights)
    - [Simple Example](#simple-example)
- [Documentation](#documentation)
	- [File Creator](#file-creator)
    - [Writers](#writers)
        - [Writer Interface](#writer-interface)
        - [CSV Writer](#csv-writer)
    - [Formatters](#formatters)
        - [Printr Formatter](#printr-formatter)
- [Credits](#credits)
___

# Getting started

Add the latest version of the File Creator service project running this command.

```
composer require tobento/service-file-creator
```

## Requirements

- PHP 8.0 or greater

## Highlights

- Framework-agnostic, will work with any project
- Decoupled design

## Simple Example

Here is a simple example of how to use the Menu service.

```php
use Tobento\Service\FileCreator\FileCreator;
use Tobento\Service\FileCreator\FileCreatorException;

try {
    (new FileCreator())
        ->content('Lorem ipsum')
        ->newline()
        ->content('Lorem ipsum')
        ->create('home/public/files/filename.txt', FileCreator::CONTENT_NEW);
    // it is ok.
} catch (FileCreatorException $e) {
    // it failed.
}
```

# Documentation

## File Creator

The create method has the following default parameter values:

```php
use Tobento\Service\FileCreator\FileCreator;
use Tobento\Service\FileCreator\FileCreatorException;

try {
    (new FileCreator())
        ->content('Lorem ipsum')
        ->create(
            file: 'home/public/files/filename.txt',
            handling: FileCreator::NO_OVERWRITE,
            modeFile: 0644,
            modeDir: 0755
        );
    // it is ok.
} catch (FileCreatorException $e) {
    // it failed.
}
```

The following parameters are available for the handling:

| Handling | Description |
| --- | --- |
| FileCreator::NO_OVERWRITE | Cannot overwrite existing file. If the file exist, it throws FileCreatorException |
| FileCreator::CONTENT_APPEND | Append content if file exists, otherwise creates new file |
| FileCreator::CONTENT_NEW | Creates new file with the content |

The create method returns a new instance allowing the following:

```php
use Tobento\Service\FileCreator\FileCreator;
use Tobento\Service\FileCreator\FileCreatorException;

try {
    (new FileCreator())
        ->content('Lorem ipsum')
        ->newline()
        ->content('Lorem ipsum')
        ->create('home/public/files/filename.txt', FileCreator::CONTENT_NEW)
        ->newline(num: 2)
        ->content('Lorem ipsum')
        ->create('home/public/files/filename.txt', FileCreator::CONTENT_APPEND);
    // it is ok.
} catch (FileCreatorException $e) {
    // it failed.
}
```

## Writers

### Writer Interface

Writers must implement the following interface.

```php
namespace Tobento\Service\FileCreator;

/**
 * WriterInterface
 */
interface WriterInterface
{
    /**
     * Write the content.
     *
     * @param resource $resource
     * @return void
     */
    public function write($resource): void;
}
```

### CSV Writer

```php
use Tobento\Service\FileCreator\FileCreator;
use Tobento\Service\FileCreator\FileCreatorException;
use Tobento\Service\FileCreator\Writer\Csv;

$items = [
    ['id' => 1, 'title' => 'cars'],
    ['id' => 2, 'title' => 'plants'],
];

$csvWriter = new Csv(
    items: $items,
    delimiter: ',', // default
    enclosure: '"', // default
    escapeChar: '\\', // default
);

try {
    (new FileCreator())
        ->writer($csvWriter)
        ->create('home/public/files/filename.csv', FileCreator::CONTENT_NEW);
    // it is ok.
} catch (FileCreatorException $e) {
    // it failed.
}
```

## Formatters

### Printr Formatter

```php
use Tobento\Service\FileCreator\FileCreator;
use Tobento\Service\FileCreator\FileCreatorException;
use Tobento\Service\FileCreator\Formatter\Printr;

$items = [
    ['id' => 1, 'title' => 'cars'],
    ['id' => 2, 'title' => 'plants'],
];

try {
    (new FileCreator())
        ->content((new Printr())->format($items))
        ->create('home/public/files/filename.txt', FileCreator::CONTENT_NEW);
    // it is ok.
} catch (FileCreatorException $e) {
    // it failed.
}
```

# Credits

- [Tobias Strub](https://www.tobento.ch)
- [All Contributors](../../contributors)