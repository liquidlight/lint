# Liquid Light Linter

Lint your code against Liquid Light conventions (yes, we use tabs and not spaces).

```bash
wget XXX
mv lint.phar /usr/local/bin/lint
```

Uses:

- PHP Coding Standards
- ES Lint
- JSON Lint
- SCSS Stylelint
- TypoScript Lint

## Installation & Usage

You can download the phar file and use as a standalone application - alternatively you can clone the repository

### phar file

Download the phar and move to your shared `bin` folder

```bash
wget XXX
mv lint.phar /usr/local/bin/lint
```

To see a full list of commands, run

```bash
lint
```

To lint (and fix) the PHP in your application, for example, you can run

```bash
lint php:coding-standards --fix
```

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

## Building the phar

When releasing a new version (generally with a tag), a new phar should be built.

- Update the version numbers in `composer.json` and `package.json`
- Commit the modified files as `Release: X.X.X`
- `git tag X.X.X`
- `git push origin main --tags`
- Update any docker images and computers containing the image `lint self-update`
