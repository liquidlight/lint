
FROM alpine:3.18

ARG APP_PATH

WORKDIR /

COPY --chmod=755 ${APP_PATH}/bin/requirements /requirements

RUN set -eux \
	&& apk add --no-cache curl bash \
	&& /requirements

COPY --chmod=755 ${APP_PATH}/bin/lint /lint

CMD ["/lint"]
