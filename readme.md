# Liquid Light Linter

Lint your code against Liquid Light conventions (yes, we use tabs and not spaces).


Uses:

- PHP Coding Standards
- ES Lint
- JSON Lint
- SCSS Stylelint
- TypoScript Lint

## Installation & Usage

You can download the phar file and use as a standalone application - alternatively you can clone the repository

### Git repository

To use the Git repo as the source, you will need to download & install dependencies, which requires `composer` and `npm` running.

```bash
git clone git@gitlab.lldev.co.uk:devops/lint.git
cd lint
composer install --no-dev && npm i
```

You can then move to the directory you wish to lint and run

```
/path/to/lint/directory/lint.php
```

If you wish for this to be globally runnable, you can symlink the `lint.php` file

```
cd /usr/local/bin
ln -s  /path/to/lint/directory/lint.php lint
```

Then it can be used as above.
