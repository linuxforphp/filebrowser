#!/usr/bin/env bash
# IMPORTANT: CHANGE THE LINUXFORCOMPOSER MOUNT POINT TO /srv/filebrowser
export FILEBROWSER_PKG_VERSION=8.0.1
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
--exclude='filebrowser/CHANGELOG.md' \
--exclude='filebrowser/CODE_OF_CONDUCT.md' \
--exclude='filebrowser/configuration.php' \
--exclude='filebrowser/CONTRIBUTING.md' \
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
mkdir -p /srv/zip
cd /srv/zip || exit 1
tar -xvf /srv/filebrowser-$FILEBROWSER_PKG_VERSION.tar.gz
zip -r filebrowser-$FILEBROWSER_PKG_VERSION.zip filebrowser/
mv filebrowser-$FILEBROWSER_PKG_VERSION.zip ..
cd /srv || exit 1
rm -rf zip/
mv filebrowser-$FILEBROWSER_PKG_VERSION.tar.gz /srv/filebrowser/data
mv filebrowser-$FILEBROWSER_PKG_VERSION.zip /srv/filebrowser/data
chown 1000:1000 /srv/filebrowser/data/filebrowser-$FILEBROWSER_PKG_VERSION.tar.gz
chown 1000:1000 /srv/filebrowser/data/filebrowser-$FILEBROWSER_PKG_VERSION.zip
cd
