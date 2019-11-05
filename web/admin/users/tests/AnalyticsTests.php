<?php
require '../partners-subdomain/config.php';
require '../partners-subdomain/classes/Model.php';
require '../partners-subdomain/models/analytics.php';
use PHPUnit\Framework\TestCase;

class AnalyticsTests extends TestCase {
	public function testIndex () {
        // Create a stub for the analytics class.
        $stub = $this->createMock(AnalyticsModel::class);

        // Configure the stub.
        $stub->method('index')
             ->willReturn('');

        // Calling $stub->index() will now return ''.
        $this->assertEquals('', $stub->index());
    }
}
?>
