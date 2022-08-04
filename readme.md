# Liquid Light Linter

Lint your code against Liquid Light conventions (yes, we use tabs and not spaces).

Commands:

```
js
	js:eslint             [js:lint] ESLint
json
	json:lint             JSON Linting
php
	php:coding-standards  [php:cs|php:lint] PHP Coding Standards
	php:stan              PHPStan
scss
	scss:stylelint        [scss:lint|css:lint] Stylelint
ts
	ts:lint               [typoscript:lint] Typoscript Lint
yaml
	yaml:lint             YAML Lint
```

## Installation & Usage

How to install:

### Git repository

To use the Git repo as the source, you will need to download & install dependencies, which requires `composer` and `npm` running.

```bash
git clone git@gitlab.lldev.co.uk:devops/lint.git
cd lint
composer install --no-dev && npm i
```

You can then move to the directory you wish to lint and run

```
/path/to/lint/cloned/directory/lint.php
```

If you wish for this to be globally runnable, you can symlink the `lint.php` file

```
cd /usr/local/bin
ln -s  /path/to/lint/directory/lint.php lint
```

Then it can be used as above.
