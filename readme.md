# Liquid Light Linter

Lint your code against Liquid Light conventions (yes, we use tabs and not spaces).

- [Liquid Light Linter](#liquid-light-linter)
    - [Usage](#usage)
        - [`lint run`](#lint-run)
        - [`self-update`](#self-update)
    - [Docker](#docker)
        - [Linters](#linters)
    - [Installation](#installation)
    - [Adding Linters](#adding-linters)
    - [Releasing](#releasing)

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

### `self-update`

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

## Docker

The linker builds and makes available several docker containers. Should you wish to use these instead, you can run something like the following:

```bash
export DOCKER_DEFAULT_PLATFORM=linux/amd64; docker run -it --rm -v $(pwd):/app registry.gitlab.lldev.co.uk/devops/lint:js-eslint-dev "/js-eslint"
```

_TODO:_ Hopefully make it easier to use the docker images instead of installing the linter


### Linters

For a list of all the linters run `lint`

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


## Adding Linters

When adding a new linter please:

- Name the linter the name of the tool it is using, rather than a generic "lint" name (e.g. `php:coding-standards` instead of `php:lint`)
- If it is the only, or most common linter for that language, feel free to alias `lint`
- The linter should report by default and fix if `--fix` is added (sometimes is involves adding `--dry-run` by default and removing if fixing is required)
- Add the linter to the list above

## Releasing

Before the release run the following:

- `composer update` - commit
- `ncu` and then `npm update` - commit
- Then prepare the release:
    - Move `UPCOMING` to `CHANGELOG`, set version & add date
    - Update the version in `composer.json`
    - Update the version `package.json`
    - Run a `composer update`
    - Run a `npm update`
    - Commit the result as `Release: X.X.X`
    - Git tag

Once you have released, set the version in `composer.json` back to `dev-main` and commit
