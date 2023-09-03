FROM php:8.2-cli-alpine3.17

COPY ./ /lint
RUN chmod +x /lint/lint

WORKDIR /app

CMD ["/lint/lint", "run"]
