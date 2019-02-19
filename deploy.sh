#!/bin/bash

# Установим зависимости
composer install

# Расставим нужные права
chmod -R 777 assets
chmod -R 777 runtime
chmod -R 777 web/assets

