FROM php:8.2-cli-alpine3.17

# Copy artifaxcts from component images
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./ /lint
RUN chmod +x /lint/lint

WORKDIR /app

CMD ["/lint/lint", "run", "-vv"]
