# Liquid Light Linter

Lint your code against Liquid Light conventions (yes, we use tabs and not spaces).

- [Liquid Light Linter](#liquid-light-linter)
	- [Usage](#usage)
		- [`lint run`](#lint-run)
	- [Installation](#installation)
	- [Updating](#updating)
	- [Available Linters](#available-linters)
	- [Adding Linters](#adding-linters)

## Usage

Once [installed](#installation), run the `lint` command to see the linters available. Most linters have functionality to fix most of the issues found, this can be run by adding `--fix` to the command

e.g.

```
lint php:coding-standards --fix
```

### `lint run`

Out of the box, running a `lint run` will run

- `scss:lint`
- `js:lint`
- `php:coding-standards`

If, however, you want to run different linters (or lints with specific parameters), add a `lint` array to a `scripts` block in your `composer.json`. An example can be seen in the linter `composer.json`.

## Installation

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

## Updating

To update the linter once installed, run `self-update`

```bash
lint self-update
```

If you wish to be on the bleeding edge (or a feature branch), you can use the `--dev` option

The following will put you on the `main` branch

```bash
lint self-update --dev
```

Or you can go onto an active feature branch with the following:

```bash
lint self-update --dev [branch name]
```

e.g.

```bash
lint self-update --dev develop
```

## Available Linters

### `composer:normalize`

**Uses**: https://github.com/ergebnis/composer-normalize

**Options**:

- `--fix`

## Adding Linters

When adding a new linter please:

- Name the linter the name of the tool it is using, rather than a generic "lint" name (e.g. `php:coding-standards` instead of `php:lint`)
- If it is the only, or most common linter for that language, feel free to alias `lint`
- The linter should report by default and fix if `--fix` is added (sometimes is involves adding `--dry-run` by default and removing if fixing is required)
