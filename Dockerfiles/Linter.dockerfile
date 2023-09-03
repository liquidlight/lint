FROM php:8.2-cli-alpine3.17

ARG APP_PATH

COPY ${APP_PATH} /lint
RUN chmod +x /lint/lint

WORKDIR /app

CMD ["/lint/lint", "run"]
