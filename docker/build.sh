#!/bin/bash
script_dir="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )";
context="${script_dir}/.."
tag=a3dmorteza/laravel-ecommerce-example

# build production image
docker build --build-arg APP_ENV=production --tag "${tag}:production" --tag "${tag}:latest" "${context}"

# build development image
docker build --build-arg APP_ENV=development --tag "${tag}:development" --tag "${tag}:local" "${context}"