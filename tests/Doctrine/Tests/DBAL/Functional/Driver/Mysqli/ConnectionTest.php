<?php

namespace Doctrine\Tests\DBAL\Functional\Driver\Mysqli;

use Doctrine\DBAL\Driver\Mysqli\Driver;
use Doctrine\DBAL\Driver\Mysqli\MysqliConnection;
use Doctrine\DBAL\Driver\Mysqli\MysqliException;
use Doctrine\Tests\DbalFunctionalTestCase;
use Doctrine\Tests\TestUtil;
use function extension_loaded;
use const MYSQLI_OPT_CONNECT_TIMEOUT;

class ConnectionTest extends DbalFunctionalTestCase
{
    protected function setUp() : void
    {
        if (! extension_loaded('mysqli')) {
            $this->markTestSkipped('mysqli is not installed.');
        }

        parent::setUp();

        if ($this->connection->getDriver() instanceof Driver) {
            return;
        }

        $this->markTestSkipped('MySQLi only test.');
    }

    protected function tearDown() : void
    {
        parent::tearDown();
    }

    public function testDriverOptions() : void
    {
        $driverOptions = [MYSQLI_OPT_CONNECT_TIMEOUT => 1];

        $connection = $this->getConnection($driverOptions);
        self::assertInstanceOf(MysqliConnection::class, $connection);
    }

    public function testUnsupportedDriverOption() : void
    {
        $this->expectException(MysqliException::class);

        $this->getConnection(['hello' => 'world']); // use local infile
    }

    public function testPing() : void
    {
        $conn = $this->getConnection([]);
        self::assertTrue($conn->ping());
    }

    /**
     * @param mixed[] $driverOptions
     */
    private function getConnection(array $driverOptions) : MysqliConnection
    {
        $params = TestUtil::getConnectionParams();

        return new MysqliConnection(
            $params,
            $params['user'] ?? '',
            $params['password'] ?? '',
            $driverOptions
        );
    }
}
