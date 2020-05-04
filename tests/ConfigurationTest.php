<?php

namespace Doctrine\DBAL\Tests;

use Doctrine\DBAL\Configuration;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for the configuration container.
 */
class ConfigurationTest extends TestCase
{
    /**
     * The configuration container instance under test.
     *
     * @var Configuration
     */
    protected $config;

    protected function setUp() : void
    {
        $this->config = new Configuration();
    }

    /**
     * Tests that the default auto-commit mode for connections can be retrieved from the configuration container.
     *
     * @group DBAL-81
     */
    public function testReturnsDefaultConnectionAutoCommitMode() : void
    {
        self::assertTrue($this->config->getAutoCommit());
    }

    /**
     * Tests that the default auto-commit mode for connections can be set in the configuration container.
     *
     * @group DBAL-81
     */
    public function testSetsDefaultConnectionAutoCommitMode() : void
    {
        $this->config->setAutoCommit(false);

        self::assertFalse($this->config->getAutoCommit());

        $this->config->setAutoCommit(0);

        self::assertFalse($this->config->getAutoCommit());
    }
}
