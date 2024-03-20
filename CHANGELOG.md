# 2.6.0

#### Features

- Lint playwright tests

#### Dependencies

- Several package updates
- Update Symfony to v7

# 2.5.0

**12th January 2024**

#### Feature

- Update scss styleling `@if/@else` rules for better syntax

# 2.4.0

**11th January 2024**

#### Dependencies

- `friendsofphp/php-cs-fixer` to 3.46.0
- `symfony` packages to 6.4.2
- `armin/editorconfig-cli` to v2
- Docker to PHP 8.3
- `stylelint` to v16
- `eslint` to 8.56.0
- `ssch/typo3-rector` to 1.5.2

# 2.3.0

**16th November 2023**

#### Feature

- Delete cache file contents when upgrading linter

#### Dependencies

- Update `stylelint-config-standard-scss` to 11.1.0
- Update `symfony` to 6

# 2.2.0

**15th November 2023**

#### Feature

- Update SCSS placeholders rules to use lowerCamelCase `%buttonAlt`
- Remove deprecated Stylelint property `at-import-no-partial-leading-underscore`

#### Dependencies

- Update `friendsofphp/php-cs-fixer` to 3.38.2
- Update `eslint` to 8.53.0
- Update `stylelint-scss` to 5.3.1
- Update `symphony` to 5.4.31

#### Bug

- Use PHP binary to run sub-commands

# 2.1.0

**3rd November 2023**

#### Dependencies

- Upgrade `friendsofphp/php-cs-fixer` to 3.37.1
- Upgrade `stylelint-scss` to 5.3.0
- Upgrade `symfony` to 5.4.30

# 2.0.0

**30th October 2023**

#### Feature

- Package each linter into it's own `app` folder
- Create docker images for Linters
- ⚠️ Runs on PHP 8.2 as a minimum
- Update all linters & dependencies to use recent versions

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
