
FROM alpine:3.18 as builder

ARG APP_PATH

WORKDIR /

COPY ${APP_PATH}/package.json .

# Install node
RUN set -eux \
	&& apk add --no-cache \
		nodejs-current \
		npm

RUN set -eux \
	&& npm install --omit=dev --no-audit --no-bin-links

# Remove unecessary files
RUN set -eux \
	&& find /node_modules -type d -iname 'test' -prune -exec rm -rf '{}' \; \
	&& find /node_modules -type d -iname 'tests' -prune -exec rm -rf '{}' \; \
	&& find /node_modules -type d -iname 'testing' -prune -exec rm -rf '{}' \; \
	&& find /node_modules -type d -iname '.bin' -prune -exec rm -rf '{}' \; \
	\
	&& find /node_modules -type f -iname '.*' -exec rm {} \; \
	&& find /node_modules -type f -iname 'LICENSE*' -exec rm {} \; \
	&& find /node_modules -type f -iname 'Makefile*' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.bnf' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.css' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.def' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.flow' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.html' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.info' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.jst' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.lock' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.map' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.markdown' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.md' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.mjs' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.mli' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.png' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.ts' -exec rm {} \; \
	&& find /node_modules -type f -iname '*.yml' -exec rm {} \;

# Build new image
FROM alpine:3.18

ARG APP_PATH

COPY --from=builder /node_modules/ /node_modules/
COPY ${APP_PATH}/resources/config/ /config
COPY --chmod=755 ${APP_PATH}/bin/lint /lint

RUN set -eux \
	&& apk add --no-cache nodejs-current
