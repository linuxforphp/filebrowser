#!/usr/bin/env bash
# IMPORTANT: CHANGE THE LINUXFORCOMPOSER MOUNT POINT TO /srv/filebrowser
export FILEBROWSER_PKG_VERSION=8.0.0
tar -C /srv --exclude='filebrowser/.github' \
--exclude='filebrowser/.git' \
--exclude='filebrowser/.gitignore' \
--exclude='filebrowser/.idea' \
--exclude='filebrowser/docs' \
--exclude='filebrowser/frontend' \
--exclude='filebrowser/node_modules' \
--exclude='filebrowser/tests' \
--exclude='filebrowser/.eslintrc.js' \
--exclude='filebrowser/.php_cs' \
--exclude='filebrowser/.phpunit.result.cache' \
--exclude='filebrowser/babel.config.js' \
--exclude='filebrowser/configuration.php' \
--exclude='filebrowser/couscous.yml' \
--exclude='filebrowser/cypress.json' \
--exclude='filebrowser/data' \
--exclude='filebrowser/jest.config.js' \
--exclude='filebrowser/linuxforcomposer.json' \
--exclude='filebrowser/phpunit.xml' \
--exclude='filebrowser/postcss.config.js' \
--exclude='filebrowser/README.md' \
--exclude='filebrowser/vue.config.js' \
--exclude='filebrowser/repository/.gitignore' \
-czvf /srv/filebrowser-$FILEBROWSER_PKG_VERSION.tar.gz \
filebrowser/
