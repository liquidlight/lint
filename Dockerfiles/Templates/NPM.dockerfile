
FROM alpine:3.16 as builder

ARG PACKAGE

# Install node
RUN set -eux \
	&& apk add --no-cache \
		nodejs-current \
		npm

RUN set -eux \
	&& npm install -g --omit=dev --no-audit --no-bin-links ${PACKAGE}

# Remove unecessary files
RUN set -eux \
	&& find /usr/local/lib/node_modules -type d -iname 'test' -prune -exec rm -rf '{}' \; \
	&& find /usr/local/lib/node_modules -type d -iname 'tests' -prune -exec rm -rf '{}' \; \
	&& find /usr/local/lib/node_modules -type d -iname 'testing' -prune -exec rm -rf '{}' \; \
	&& find /usr/local/lib/node_modules -type d -iname '.bin' -prune -exec rm -rf '{}' \; \
	\
	&& find /usr/local/lib/node_modules -type f -iname '.*' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname 'LICENSE*' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname 'Makefile*' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.bnf' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.css' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.def' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.flow' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.html' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.info' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.jst' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.lock' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.map' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.markdown' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.md' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.mjs' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.mli' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.png' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.ts' -exec rm {} \; \
	&& find /usr/local/lib/node_modules -type f -iname '*.yml' -exec rm {} \;

# Build new image
FROM alpine:3.16

ARG COMMAND
ARG FILE

COPY --from=builder /usr/local/lib/node_modules/ /usr/local/lib/node_modules/
COPY ./resources/config/ /config

RUN set -eux \
	&& apk add --no-cache nodejs-current \
	&& echo '#!/bin/sh' >> ${FILE} \
	&& echo 'FOLDER=${1:-/app}' >> ${FILE} \
	&& echo ${COMMAND} >> ${FILE} \
	&& chmod +x ${FILE}
