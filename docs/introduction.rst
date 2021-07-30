.. _IntroductionAnchor:

======================
What is  FileBrowser?
======================

.. index:: FileBrowser

`FileBrowser <https://filebrowser.linuxforphp.net>`__ is a free,
`open-source <https://github.com/linuxforphp/filebrowser>`__,
self-hosted web application for managing files and folders.

You can manage files inside your local repository folder (on your
server’s hard drive) or connect to other storage adapters (see below).

FileBrowser has multi-user support, so you can have administrators and other
users managing their files with different access permissions, roles and
home folders.

All basic file operations are supported: copy, move, rename, create,
delete, zip, unzip, download, upload.

If allowed, users can download multiple files or folders at once.

File upload supports drag&drop, progress bar, pause and resume. Upload
is chunked so you should be able to upload large files regardless of
your server’s configuration.

----------------
Features & Goals
----------------

-  Multiple storage adapters (Local, FTP, Amazon S3, Dropbox, DO Spaces,
   Azure Blob and many others via
   `Flysystem <https://github.com/thephpleague/flysystem>`__),
-  Multiple authentication adapters with roles and permissions (store users in
   a json file, database, or use WordPress),
-  Multiple session adapters (native file, Pdo, Redis, MongoDB,
   Memcached, and others via
   `Symfony <https://github.com/symfony/symfony/tree/4.4/src/Symfony/Component/HttpFoundation/Session/Storage/Handler>`__),
-  Single page front-end (built with
   `Vue.js <https://github.com/vuejs/vue>`__,
   `Bulma <https://github.com/jgthms/bulma>`__ and
   `Buefy <https://github.com/buefy/buefy>`__),
-  Chunked uploads (built with
   `Resumable.js <https://github.com/23/resumable.js>`__),
-  Zip and bulk download support,
-  Highly extensible, decoupled and tested code,
-  No database required.

--------------------------
Why Open Source on GitHub?
--------------------------

There are several reasons why we switched to the open source model.

Basically, we wanted to increase:

-  Code quality by bringing more developers to the project,
-  Code stability,
-  Security,
-  Project lifetime.

At the end, the more people can see and test some code, the more
likely any flaws will be caught and fixed quickly.

-----------------
Show Your Support
-----------------

-  Please star this repository on
   `GitHub <https://github.com/linuxforphp/filebrowser/stargazers>`__ if
   this project helped you!

-------
License
-------

Copyright 2021, `Foreach Code Factory <https://etista.com/>`__.
Copyright 2018-2021, `Milos Stojanovic <https://github.com/alcalbg>`__.

This project is Apache-2.0 licensed.
