#!/bin/bash
set -e

php bin/console make:migration

exec "$@"
