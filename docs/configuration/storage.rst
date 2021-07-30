.. _StorageAnchor:

=======
Storage
=======

.. index:: Storage

All of the basic configuration for storage adapters is done in the ``configuration.php`` file.

--------
Adapters
--------

.. index:: Storage adapters

Different storage adapters are provided through the versatile
`Flysystem <https://github.com/thephpleague/flysystem>`__ library.

You can use the local filesystem (default), FTP, SFTP, Amazon S3,
DigitalOcean Spaces, Microsoft Azure Blob, Dropbox, and many others.

Please check the Flysystem
`documentation <https://flysystem.thephpleague.com/v1/docs/>`__ for the exact
setup that is required for each adapter.

.. note:: Some adapters do not support, or only support in a very limited way, some folder operations.

--------------------------
Default Local Disk Adapter
--------------------------

.. index:: Storage local adapter

.. index:: Storage fastzip option

For the default adapter, you only need to configure the location of your
``repository`` folder in the ``configuration.php`` file. This folder will
then serve as the root folder of all the files and folders of the repository.

If you wish to use the ``zip`` and ``unzip`` binaries directly, without using the Flysystem per se,
you can set the ``fastzip`` option to ``true`` (default). Zipping with this option is not only faster,
but will also manage any Unix special files (symlinks, sparse files, etc.) appropriately.

::

    'storage' => [
        'driver' => [
            'config' => [
                'separator' => '/',
                'config' => [],
                'adapter' => function () {
                    return new \League\Flysystem\Adapter\Local(
                        REPOSITORY_ROOT
                    );
                },
            ],
            'fastzip' => true // LOCAL ONLY! If true, it will override the \League\Flysystem\Adapter\Local adapter, and use the zip and unzip binaries directly.
        ],
    ],

-----------
FTP Adapter
-----------

.. index:: Storage FTP adapter

Please see the official
`documentation <https://flysystem.thephpleague.com/v1/docs/adapter/ftp/>`__.

Sample configuration:

::

    'storage' => [
        'driver' => [
            'config' => [
               'separator' => '/',
               'config' => [],
               'adapter' => function () {
                 return new \League\Flysystem\Adapter\Ftp([
                     'host' => 'example.com',
                     'username' => 'demo',
                     'password' => 'password',
                     'port' => 21,
                     'timeout' => 10,
                 ]);
               },
           ],
        ],
    ],

------------
SFTP Adapter
------------

.. index:: Storage SFTP adapter

You must require an additional library in order to use this adapter:

::

    composer require league/flysystem-sftp

For more advanced options like using your private key or changing the
document root, please see the official
`documentation <https://flysystem.thephpleague.com/v1/docs/adapter/sftp/>`__.

Sample configuration:

::

    'storage' => [
        'driver' => [
            'config' => [
               'separator' => '/',
               'config' => [],
               'adapter' => function () {
                 return new \League\Flysystem\Sftp\SftpAdapter([
                     'host' => 'example.com',
                     'port' => 22,
                     'username' => 'demo',
                     'password' => 'password',
                     'timeout' => 10,
                 ]);
               },
            ],
        ],
    ],

---------------
Dropbox Adapter
---------------

.. index:: Storage Dropbox adapter

You must require an additional library in order to use this adapter:

::

    composer require spatie/flysystem-dropbox

Please see the official
`documentation <https://flysystem.thephpleague.com/v1/docs/adapter/dropbox/>`__.

Sample configuration:

::

    'storage' => [
        'driver' => [
            'config' => [
               'separator' => '/',
               'config' => [
                   'case_sensitive' => false,
               ],
               'adapter' => function () {
                 $authorizationToken = '1234';
                 $client = new \Spatie\Dropbox\Client($authorizationToken);

                 return new \Spatie\FlysystemDropbox\DropboxAdapter($client);
               },
           ],
        ],
    ],

----------------------
Amazon S3 Adapter (v3)
----------------------

.. index:: Storage Amazon S3 adapter

You must require an additional library in order to use this adapter:

::

    composer require league/flysystem-aws-s3-v3

Please see the official
`documentation <https://flysystem.thephpleague.com/v1/docs/adapter/aws-s3/>`__.

Sample configuration:

::

    'storage' => [
        'driver' => [
            'config' => [
               'separator' => '/',
               'config' => [],
               'adapter' => function () {
                   $client = new \Aws\S3\S3Client([
                       'credentials' => [
                           'key' => '123456',
                           'secret' => 'secret123456',
                       ],
                       'region' => 'us-east-1',
                       'version' => 'latest',
                   ]);

                   return new \League\Flysystem\AwsS3v3\AwsS3Adapter($client, 'my-bucket-name');
               },
           ],
        ],
    ],

-------------------
DigitalOcean Spaces
-------------------

.. index:: Storage DigitalOcean adapter

You must require an additional library in order to use this adapter:

::

    composer require league/flysystem-aws-s3-v3

The DigitalOcean Spaces API are compatible with those of S3.

Please see the official
`documentation <https://flysystem.thephpleague.com/v1/docs/adapter/digitalocean-spaces/>`__.

Sample configuration:

::

    'storage' => [
        'driver' => [
            'config' => [
               'separator' => '/',
               'config' => [],
               'adapter' => function () {
                   $client = new \Aws\S3\S3Client([
                       'credentials' => [
                           'key' => '123456',
                           'secret' => 'secret123456',
                       ],
                       'region' => 'us-east-1',
                       'version' => 'latest',
                       'endpoint' => 'https://nyc3.digitaloceanspaces.com',
                   ]);

                   return new \League\Flysystem\AwsS3v3\AwsS3Adapter($client, 'my-bucket-name');
               },
           ],
        ],
    ],

----------------------------
Microsoft Azure Blob Storage
----------------------------

.. index:: Storage Azure Blob adapter

You must require an additional library in order to use this adapter:

::

    composer require league/flysystem-azure-blob-storage

Please see the official
`documentation <https://flysystem.thephpleague.com/v1/docs/adapter/azure/>`__.

Sample configuration:

::

    'storage' => [
        'driver' => [
            'config' => [
               'separator' => '/',
               'config' => [],
               'adapter' => function () {
                   $accountName = 'your_storage_account_name';
                   $accountKey = '123456';
                   $containerName = 'my_container';

                   $client = \MicrosoftAzure\Storage\Blob\BlobRestProxy::createBlobService(
                       "DefaultEndpointsProtocol=https;AccountName=${accountName};AccountKey=${accountKey};"
                   );

                   return new \League\Flysystem\AzureBlobStorage\AzureBlobStorageAdapter($client, $containerName);
               },
           ],
        ],
    ],

-----------------
Replicate Adapter
-----------------

.. index:: Storage Replicate adapter

You must require an additional library in order to use this adapter:

::

    composer require league/flysystem-replicate-adapter


The ReplicateAdapter facilitates smooth transitions between adapters,
allowing an application to stay functional and migrate its files from
one adapter to another. The adapter takes two other adapters, a source
and a replica. Every change is delegated to both adapters, while all the
read operations are passed onto the source only.

Please see the official
`documentation <https://flysystem.thephpleague.com/v1/docs/adapter/replicate/>`__.

Sample configuration:

::

    'storage' => [
        'driver' => [
            'config' => [
               'separator' => '/',
               'config' => [
                   'case_sensitive' => false,
               ],
               'adapter' => function () {
                   $authorizationToken = '1234';
                   $client = new \Spatie\Dropbox\Client($authorizationToken);

                   $source = new \Spatie\FlysystemDropbox\DropboxAdapter($client);
                   $replica = new \League\Flysystem\Adapter\Local(__DIR__.'/repository');

                   return new League\Flysystem\Replicate\ReplicateAdapter($source, $replica);
               },
           ],
        ],
    ],
