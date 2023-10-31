FROM php:8.2-cli-alpine3.17

ARG ADDITIONAL_PACKAGES

# Copy artifaxcts from component images
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --update --no-cache ${ADDITIONAL_PACKAGES}

COPY ./ /lint
RUN chmod +x /lint/lint

WORKDIR /app

CMD ["/lint/lint", "run", "-v"]
