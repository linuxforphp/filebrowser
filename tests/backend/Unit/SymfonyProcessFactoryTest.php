<?php

/*
 * This file is part of the FileBrowser package.
 *
 * Copyright 2021, Foreach Code Factory <services@linuxforphp.com>
 * Copyright 2018-2021, Milos Stojanovic <alcalbg@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 */

namespace Tests\Unit;

use Filebrowser\Services\Process\SymfonyProcessFactory;
use Tests\TestCase;

/**
 * @internal
 */
class SymfonyProcessFactoryTest extends TestCase
{
    public function testCreatingASymfonyProcessWithSuccess()
    {
        $command[] = '/bin/true';
        $symfonyProcess = (new SymfonyProcessFactory())->createService($command);
        $symfonyProcess->start();

        while ($symfonyProcess->isRunning()) {
            // waiting for process to finish
        }

        $this->assertEquals('Symfony\Component\Process\Process', get_class($symfonyProcess));
        $this->assertEquals('\'/bin/true\'', $symfonyProcess->getCommandLine());
        $this->assertTrue($symfonyProcess->isSuccessful());
        $this->assertEquals(0, $symfonyProcess->getExitCode());
    }

    public function testCreatingASymfonyProcessWithFailure()
    {
        // Intended error
        $command[] = 'zip -r ' . TEST_DIR . DIR_SEP . 'fail.zip foo.txt bar.txt baz.txt';

        $symfonyProcess = (new SymfonyProcessFactory())->createService($command);

        $this->assertEquals('Symfony\Component\Process\Process', get_class($symfonyProcess));
        $this->assertStringContainsString('zip -r', $symfonyProcess->getCommandLine());
    }
}
