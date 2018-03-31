# Files

| `master` | `develop` |
|----------|-----------|
| [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/?branch=master) | [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/?branch=develop) |
| [![Code Coverage](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/?branch=master) | [![Code Coverage](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/?branch=develop) |
| [![Build Status](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/badges/build.png?b=master)](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/build-status/master) | [![Build Status](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/PersonalGalaxy/Files/build-status/develop) |

Model to store files.

## Installation

```sh
composer require personal-galaxy/files
```

## Usage

The only entry point to use the model are the [commands](src/Command), you should use a [command bus](https://github.com/innmind/commandbus) in order to bind the commands to their handler.

You also need to implement the repository [interfaces](src/Repository) in order to persist the files and folders metadata.
