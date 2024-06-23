# LintKit: PHP Coding Standards

A preconfigured [PHP Coding Standards](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) linter implementation.

## Usage

### GitLab

```yaml
# Lint the PHP
.php:coding-standards:
  image: ghcr.io/lintkit/php-coding-standards:latest
  script:
    - /lintkit
```

### GitHub

```yaml
- name: Lint PHP
  uses: lintkit/php-coding-standards@v1
```

### Local

```bash
docker pull ghcr.io/lintkit/php-coding-standards:latest
docker run -it --rm -v $(pwd):/app ghcr.io/lintkit/php-coding-standards
```
