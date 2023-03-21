# 1.5.0

**21st March 2023**

#### Task

- Add `.editorconfig` lint & fixer
- Add `--run` as an alias for `--fix`


# 1.4.1

**17th January 2023**

#### Bug

- Correctly release version
- Output version on self update

# 1.4.0

**17th January 2023**

#### Feature

- Add `package-json-lint`

#### Backend

- Change `composer.json` indentation to spaces

# 1.3.0

**8th December 2022**

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


# 1.2.0

**7th November 2022**

#### Dependencies

- Major updates for `eslint` & associated plugins
- Update composer dependencies

# 1.1.3

**4th November 2022**

#### Frontend

- Update NPM dependencies
- Add `no-constant-binary-expression` rule to ESLint

# 1.1.0

**4th August 2022**

#### Backend

- Add name & version in linter and output on each command (helps when debugging on CI)

# 1.0.1

**4th August 2022**

#### Bug

- Releasing new version to not conflict with old version 1.0.0

# 1.0.0

**4th August 2022**

- Versioned release
