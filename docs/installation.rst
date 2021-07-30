.. _InstallationAnchor:

============
Installation
============

.. index:: Installation

--------------------
Minimum Requirements
--------------------

.. index:: Requirements

-  PHP 7.2.5+ (with php-zip extension)

-----------------------------
Download a Pre-Compiled Build
-----------------------------

.. index:: Pre-compiled build

The pre-compiled builds are created for non-developers. With this version of the FileBrowser,
the front end code (HTML, CSS and Javascript) is already pre-compiled for you, and the source
code is removed, so that the final archive file contains only what is required
to run the application on your server.

-  Download the `latest
   release <https://filebrowser.linuxforphp.net/download>`__,
-  Unzip the files, and upload them to your PHP server,
-  Make sure your web server can read and write to the
   ``filebrowser/repository/`` and ``filebrowser/private/`` folders,
-  Set the website document root to the ``filebrowser/dist/`` directory
   (this is also known as ‘public’ folder),
-  Visit the web page, and if something goes wrong, please check
   ``filebrowser/private/logs/app.log``,
-  Login with default credentials ``admin/admin123``,
-  Change default admin’s password.

NOTE: For security reasons, the ``/dist`` folder is the ONLY folder you want to be
exposed to the Web. Everything else should be outside of your web
root. This way, people won't be able to access any of your important files through
the Web browser.

Install on fresh Ubuntu 18.04 or Debian 10.3
--------------------------------------------

.. index:: Ubuntu (installation)

.. index:: Debian (installation)

On a new server, login as root and enter
this into the shell:

::

    apt update
    apt install -y wget unzip php apache2 libapache2-mod-php php-zip

    cd /var/www/
    wget https://filebrowser.linuxforphp.com/files/filebrowser_latest.zip
    unzip filebrowser_latest.zip && rm filebrowser_latest.zip

    chown -R www-data:www-data filebrowser/
    chmod -R 775 filebrowser/

    echo "
    <VirtualHost *:80>
       DocumentRoot /var/www/filebrowser/dist
    </VirtualHost>
    " >> /etc/apache2/sites-available/filebrowser.conf

    a2dissite 000-default.conf
    a2ensite filebrowser.conf
    systemctl restart apache2

    exit

Open your browser and go to http://your_server_ip_address

-------
Upgrade
-------

.. index:: Upgrade

Since version 7 is completely rewritten from scratch, there is no clear
upgrade path from older versions.

If you have an older version of FileBrowser please backup everything and
install the script again.

Upgrade instructions for non-developers:

-  Backup everything,
-  Download the latest version,
-  Replace all files and folders except ``repository/`` and ``private/``.

To discover which version of the FileBrowser you are running,
please look for ``APP_VERSION`` inside ``dist/index.php`` file
