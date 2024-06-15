# LintKit: PHP Coding Standards

## Usage

### GitLab

```yaml
# Lint the PHP
.composer:normalize:
  image: ghcr.io/lintkit/composer-normalize:latest
  script:
    - /lintkit
```

### GitHub

```yaml
- name: Composer Lint
  uses: lintkit/composer-normalize@v1
```

### Local

```bash
docker pull ghcr.io/lintkit/composer-normalize:latest
docker run -it --rm -v $(pwd):/app ghcr.io/lintkit/composer-normalize
```
