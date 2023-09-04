FROM php:8.2-cli-alpine3.17

ARG CACHEBUST=1

COPY ./ /lint
RUN chmod +x /lint/lint

WORKDIR /app

CMD ["/lint/lint", "run", "--verbose"]
