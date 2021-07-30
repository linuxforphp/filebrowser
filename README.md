<p align="center">
    <img src="https://raw.githubusercontent.com/linuxforphp/filebrowser/master/dist/img/logo.png">
</p>

<p align="center">
    <a href="https://github.com/linuxforphp/filebrowser/actions"><img src="https://github.com/linuxforphp/filebrowser/workflows/PHP/badge.svg?branch=master" alt="Build Status PHP master"></a>
    <a href="https://github.com/linuxforphp/filebrowser/actions"><img src="https://github.com/linuxforphp/filebrowser/workflows/Node/badge.svg?branch=master" alt="Build Status Node master"></a>
    <a href="https://codecov.io/gh/linuxforphp/filebrowser"><img src="https://codecov.io/gh/linuxforphp/filebrowser/branch/master/graph/badge.svg?token=X4QTVJLTF0"/></a>
    <a href="https://opensource.org/licenses/Apache-2.0"><img src="https://img.shields.io/badge/Apache-2.0-green.svg" alt="License"></a>
</p>

https://filebrowser.linuxforphp.net

## FileBrowser - Powerful Multi-User File Manager

FileBrowser is a free, open-source, self-hosted web application for managing files and folders.

You can manage files inside your local repository folder (on your server's hard drive) or connect to other storage adapters (see below).

FileBrowser has multi-user support, so you can have administrators and other users managing their files with different access permissions, roles and home folders.

All basic file operations are supported: copy, move, rename, edit, create, delete, preview, zip, unzip, download, upload.

If allowed, users can download multiple files or folders at once.

File upload supports drag&drop, progress bar, pause and resume. Upload is chunked so you should be able to upload large files regardless of your server configuration.

## Typical Use Cases
- Share a folder with colleagues, your team, friends or family,
- Give students access to upload their work,
- Allow workers to upload field data / docs / images,
- Use as cloud backup,
- Manage cdn with multiple people,
- Use as ftp/sftp replacement,
- Manage s3 or other 3rd party cloud storage,
- Use to quickly zip and download remote files.

## Documentation
[Check out the documentation](https://filebrowser.linuxforphp.net/documentation) here:

https://filebrowser.linuxforphp.net/documentation

## Features & Goals
- Multiple storage adapters (Local, FTP, Amazon S3, Dropbox, DO Spaces, Azure Blob and many others via [Flysystem](https://github.com/thephpleague/flysystem)),
- Multiple authentication adapters with roles and permissions (store users in a json file, database, or use WordPress),
- Multiple session adapters (native file, Pdo, Redis, MongoDB, Memcached, and others via [Symfony](https://github.com/symfony/symfony/tree/4.4/src/Symfony/Component/HttpFoundation/Session/Storage/Handler)),
- Single page front-end (built with [Vue.js](https://github.com/vuejs/vue), [Bulma](https://github.com/jgthms/bulma) and [Buefy](https://github.com/buefy/buefy)),
- Chunked uploads (built with [Resumable.js](https://github.com/23/resumable.js)),
- Zip and bulk download support,
- Highly extensible, decoupled and tested code,
- No database required.

## Minimum Requirements
- PHP 7.2.5+ (with php-zip extension)

## Download Pre-Compiled Builds
Pre-compiled builds are created for non-developers.
With this version of the FileBrowser,
the front end code (HTML, CSS and Javascript) is already pre-compiled for you, and the source
code is removed, so that the final archive file contains only what is required
to run the application on your server.

-  Download the [latest release](https://filebrowser.linuxforphp.net/download),
-  Unzip the files, and upload them to your PHP server,
-  Make sure your web server can read and write to the `filebrowser/repository/` and `filebrowser/private/` folders,
-  Set the website document root to the `filebrowser/dist/` directory (this is also known as ‘public’ folder),
-  Visit the web page, and if something goes wrong, please check `filebrowser/private/logs/app.log`,
-  Login with default credentials `admin/admin123`,
-  Change default admin’s password.

NOTE: For security reasons, the ``/dist`` folder is the ONLY folder you want to be
exposed to the Web. Everything else should be outside of your web
root, this way people can’t access any of your important files through
the Web browser.

## Project Setup for Development (Linux)

You must have `git`, `php`, `npm`, and `composer` installed.

If you have `Docker` and `Linux for Composer` (https://github.com/linuxforphp/linuxforcomposer) on your computer, you can start the container with the following command:

```
git clone https://github.com/linuxforphp/filebrowser.git
cd filebrowser
composer install --ignore-platform-reqs
vendor/bin/linuxforcomposer docker:run start
```

When you are ready to stop the container, enter the following command:

```
vendor/bin/linuxforcomposer docker:run stop-force
```

Otherwise, you can install the application manually, using the following commands:

```
git clone https://github.com/linuxforphp/filebrowser.git
cd filebrowser
cp configuration_sample.php configuration.php
chmod -R 775 private/
chmod -R 775 repository/
composer install --ignore-platform-reqs
npm install
npm run build
```

## Compiles and Hot Reloads

The following command will launch the back end and the front end of the application on ports 8081 and 8080 respectively:

```
npm run serve
```
Once everything is ready visit: `http://localhost:8080`

## Run Tests & Static Analysis

Testing requires xdebug, php-zip and sqlite php extensions.

```
vendor/bin/phpunit
vendor/bin/phpstan analyse ./backend
npm run lint
npm run e2e
```

## Deployment

Set the website document root to the ``/dist`` directory. This is also known as the ‘public’ folder.

NOTE: For security reasons, the ``/dist`` folder is the ONLY folder you want to be
exposed to the Web. Everything else should be outside of your web
root. This way, people won't be able to access any of your important files through
the Web browser.

## Security

If you discover any security related issues, please email us at services@etista.com instead of using the issue tracker.

## License

Copyright 2021 [Foreach Code Factory](https://etista.com/).
Copyright 2019 [Milos Stojanovic](https://github.com/alcalbg). MIT License.

This project is licensed under the Terms of the Apache 2.0 license.
