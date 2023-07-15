
FROM php:8.2-cli-alpine3.16

ARG APP_PATH

WORKDIR /

COPY --chmod=755 ${APP_PATH}/bin/requirements /requirements

RUN set -eux \
	&& apk add --no-cache curl bash \
	&& /requirements

COPY --chmod=755 ${APP_PATH}/bin/lint /lint

CMD ["/lint"]
