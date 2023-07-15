
FROM php:7.4-cli-alpine3.16

ARG APP_PATH

WORKDIR /

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY ${APP_PATH}/composer.json .

RUN set -eux \
	&& apk add --no-cache bash \
	&& composer install --no-dev --no-interaction --no-scripts --no-progress --optimize-autoloader --ansi

RUN set -eux \
	&& find /usr/local/lib -type d -iname 'test' -prune -exec rm -rf '{}' \; \
	&& find /usr/local/lib -type d -iname 'doc' -prune -exec rm -rf '{}' \; \
	&& find /usr/local/lib -type d -iname 'docs' -prune -exec rm -rf '{}' \; \
	&& find /vendor -type d -iname '.github' -prune -exec rm -rf '{}' \; \
	&& find /vendor -type d -iname 'doc' -prune -exec rm -rf '{}' \; \
	&& find /vendor -type d -iname 'docs' -prune -exec rm -rf '{}' \; \
	&& find /vendor -type d -iname 'test' -prune -exec rm -rf '{}' \; \
	&& find /vendor -type d -iname 'tests' -prune -exec rm -rf '{}' \; \
	&& find /vendor -type d -iname 'testing' -prune -exec rm -rf '{}' \; \
	&& find /vendor -type d -iname '.bin' -prune -exec rm -rf '{}' \; \
	\
	&& find /vendor -type f -iname '.*' -exec rm {} \; \
	&& find /vendor -type f -iname 'LICENSE*' -exec rm {} \; \
	&& find /vendor -type f -iname 'Makefile*' -exec rm {} \; \
	&& find /vendor -type f -iname '*.bnf' -exec rm {} \; \
	&& find /vendor -type f -iname '*.css' -exec rm {} \; \
	&& find /vendor -type f -iname '*.def' -exec rm {} \; \
	&& find /vendor -type f -iname '*.flow' -exec rm {} \; \
	&& find /vendor -type f -iname '*.html' -exec rm {} \; \
	&& find /vendor -type f -iname '*.info' -exec rm {} \; \
	&& find /vendor -type f -iname '*.jst' -exec rm {} \; \
	&& find /vendor -type f -iname '*.lock' -exec rm {} \; \
	&& find /vendor -type f -iname '*.map' -exec rm {} \; \
	&& find /vendor -type f -iname '*.markdown' -exec rm {} \; \
	&& find /vendor -type f -iname '*.md' -exec rm {} \; \
	&& find /vendor -type f -iname '*.mjs' -exec rm {} \; \
	&& find /vendor -type f -iname '*.mli' -exec rm {} \; \
	&& find /vendor -type f -iname '*.png' -exec rm {} \; \
	&& find /vendor -type f -iname '*.ts' -exec rm {} \; \
	&& find /vendor -type f -iname '*.yml' -exec rm {} \;

COPY ${APP_PATH}/resource[s]/confi[g]/ /config
COPY --chmod=755 ${APP_PATH}/bin/lint /lint

CMD ["/lint"]
