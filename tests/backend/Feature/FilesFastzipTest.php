<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@linuxforphp.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Tests\Feature;

use Filebrowser\App;
use Filebrowser\Config\Config;
use Filebrowser\Container\Container;
use Filebrowser\Kernel\Request;
use Tests\FakeResponse;
use Tests\FakeStreamedResponse;
use Tests\TestCase;

/**
 * @internal
 */
class FilesFastzipTest extends TestCase
{
    protected $timestamp;

    protected function setUp(): void
    {
        $this->resetTempDir();

        $this->timestamp = time();
    }

    protected function tearDown(): void
    {
        $this->resetTempDir();
    }

    public function bootFreshApp($config = null, $request = null, $response = null, $mock_users = false)
    {
        $config = require __DIR__ . DIR_SEP . '..' . DIR_SEP . 'configuration.fastzip.php';
        $config = new Config($config);

        $request = $request ?: new Request();

        return new App($config, $request, new FakeResponse(), new FakeStreamedResponse(), new Container());
    }

    // @here
    public function testZipFilesOnlyWithFastzip()
    {
        $username = 'admin@example.com';
        $this->signIn($username, 'admin123');

        touch(TEST_REPOSITORY.'/a.txt', $this->timestamp);
        touch(TEST_REPOSITORY.'/b.txt', $this->timestamp);
        mkdir(TEST_REPOSITORY.'/john');

        $items = [
            0 => [
                'type' => 'file',
                'path' => '/a.txt',
                'name' => 'a.txt',
                'time' => $this->timestamp,
            ],
            1 => [
                'type' => 'file',
                'path' => '/b.txt',
                'name' => 'b.txt',
                'time' => $this->timestamp,
            ],
        ];

        $this->sendRequest('POST', '/zipitems', [
            'name' => 'compressed.zip',
            'items' => $items,
            'destination' => '/john',
        ]);

        $this->assertOk();

        $this->assertFileExists(TEST_REPOSITORY.'/a.txt');
        $this->assertFileExists(TEST_REPOSITORY.'/b.txt');
        $this->assertFileExists(TEST_REPOSITORY.'/john/compressed.zip');
    }

    public function testZipFilesAndDirectoriesWithFastzip()
    {
        $username = 'admin@example.com';
        $this->signIn($username, 'admin123');

        touch(TEST_REPOSITORY.'/a.txt', $this->timestamp);
        touch(TEST_REPOSITORY.'/b.txt', $this->timestamp);
        mkdir(TEST_REPOSITORY.'/sub');
        mkdir(TEST_REPOSITORY.'/jane');

        $items = [
            0 => [
                'type' => 'file',
                'path' => '/a.txt',
                'name' => 'a.txt',
                'time' => $this->timestamp,
            ],
            1 => [
                'type' => 'file',
                'path' => '/b.txt',
                'name' => 'b.txt',
                'time' => $this->timestamp,
            ],
            2 => [
                'type' => 'dir',
                'path' => '/sub',
                'name' => 'sub',
                'time' => $this->timestamp,
            ],
        ];

        $this->sendRequest('POST', '/zipitems', [
            'name' => 'compressed2.zip',
            'items' => $items,
            'destination' => '/jane',
        ]);

        $this->assertOk();

        $this->assertFileExists(TEST_REPOSITORY.'/a.txt');
        $this->assertFileExists(TEST_REPOSITORY.'/b.txt');
        $this->assertDirectoryExists(TEST_REPOSITORY.'/sub');
        $this->assertFileExists(TEST_REPOSITORY.'/jane/compressed2.zip');
    }

    public function testZipInvalidFilesReturnsErrorOutputWithFastzip()
    {
        $username = 'admin@example.com';
        $this->signIn($username, 'admin123');

        $items = [
            0 => [
                'type' => 'file',
                'path' => '/missin.txt',
                'name' => 'missina.txt',
                'time' => $this->timestamp,
            ],
        ];

        $this->sendRequest('POST', '/zipitems', [
            'name' => 'compressed.zip',
            'items' => $items,
            'destination' => '/',
        ]);

        $this->assertEquals(
            ['data' => 'Could not create the zip file'],
            json_decode($this->response->getContent(), true)
        );
    }

    public function testUnzipArchiveWithFastzip()
    {
        $username = 'admin@example.com';
        $this->signIn($username, 'admin123');

        copy(TEST_ARCHIVE, TEST_REPOSITORY.'/c.zip');
        mkdir(TEST_REPOSITORY.'/jane');

        $this->sendRequest('POST', '/unzipitem', [
            'item' => '/c.zip',
            'destination' => '/jane',
        ]);

        $this->assertOk();

        $this->assertFileExists(TEST_REPOSITORY.'/jane/one.txt');
        $this->assertFileExists(TEST_REPOSITORY.'/jane/two.txt');
        $this->assertDirectoryExists(TEST_REPOSITORY.'/jane/onetwo');
        $this->assertFileExists(TEST_REPOSITORY.'/jane/onetwo/three.txt');
    }

    public function testUnzipInvalidFileReturnsErrorOutputWithFastzip()
    {
        $username = 'admin@example.com';
        $this->signIn($username, 'admin123');

        $this->sendRequest('POST', '/unzipitem', [
            'item' => '/jane/missin.zip',
            'destination' => '/jane',
        ]);

        $this->assertEquals(
            ['data' => 'Could not unzip the file'],
            json_decode($this->response->getContent(), true)
        );
    }

    public function testDownloadMultipleItemsWithFastzip()
    {
        $username = 'john@example.com';
        $this->signIn($username, 'john123');

        mkdir(TEST_REPOSITORY.'/john');
        touch(TEST_REPOSITORY.'/john/john.txt', $this->timestamp);
        mkdir(TEST_REPOSITORY.'/john/johnsub');
        touch(TEST_REPOSITORY.'/john/johnsub/sub.txt', $this->timestamp);
        mkdir(TEST_REPOSITORY.'/john/johnsub/sub2');

        $items = [
            0 => [
                'type' => 'dir',
                'path' => '/johnsub',
                'name' => 'johnsub',
                'time' => $this->timestamp,
            ],
            1 => [
                'type' => 'file',
                'path' => '/john.txt',
                'name' => 'john.txt',
                'time' => $this->timestamp,
            ],
        ];

        $this->sendRequest('POST', '/batchdownload', [
            'items' => $items,
        ]);

        $this->assertOk();

        $res = json_decode($this->response->getContent());
        $uniqid = $res->data->uniqid;

        $this->sendRequest('GET', '/batchdownload', [
            'uniqid' => $uniqid,
        ]);

        $this->assertOk();

        // test headers
        $this->response->getContent();
        $headers = $this->streamedResponse->headers;
        $this->assertEquals('application/octet-stream', $headers->get('content-type'));
        $this->assertEquals('attachment; filename=archive.zip', $headers->get('content-disposition'));
        $this->assertEquals('binary', $headers->get('content-transfer-encoding'));
        $this->assertEquals(622, $headers->get('content-length'));
    }

    public function testDownloadMultipleItemsInvalidFilesReturnsErrorOutputWithFastzip()
    {
        $username = 'john@example.com';
        $this->signIn($username, 'john123');

        mkdir(TEST_REPOSITORY.'/john');

        $items = [
            0 => [
                'type' => 'dir',
                'path' => '/missin/missinsub',
                'name' => 'missinsub',
                'time' => $this->timestamp,
            ],
            1 => [
                'type' => 'file',
                'path' => '/missin/fail.txt',
                'name' => 'fail.txt',
                'time' => $this->timestamp,
            ],
        ];

        $this->sendRequest('POST', '/batchdownload', [
            'items' => $items,
        ]);

        $this->assertStringContainsString(
            'Cannot batch download these files',
            json_decode($this->response->getContent(), true)['data']
        );
    }
}
