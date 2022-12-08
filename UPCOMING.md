# Minor

#### Task

- Add `composer:lint`
- Allow setting linter to dev branch (e.g `lint self-update --dev`)
- Allow specifying the lint commands in `composer.json` (`run` will run these)
- Add `-w | --whisper` to each command to allow silencing the linter inside without silencing the linter
- Add `php:rector:typo3` to allow upgrade & refactoring suggestions for TYPO3 versions
- Add `php:rector` for upgrading PHP versions

#### Backend

- Remove linter version and name from every call
- Improve output of commands to be less "in your face"

#### Dependencies

- Update Typoscript linter

#### Bug

- Fix Yaml find command
