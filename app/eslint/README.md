# LintKit: PHP Coding Standards

An opinionated configuration of [eslint](https://eslint.org/).

## Usage

### GitLab

```yaml
# Lint the PHP
.js:eslint:
  image: ghcr.io/lintkit/eslint:latest
  script:
    - /lintkit
```

### GitHub

```yaml
- name: Lint PHP
  uses: lintkit/eslint@v1
```

### Local

```bash
docker pull ghcr.io/lintkit/eslint:latest
docker run -it --rm -v $(pwd):/app ghcr.io/lintkit/eslint
```
