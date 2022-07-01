<?php

namespace Tests\Unit;

use Mockery;

abstract class MockeryBaseTestCase extends UtBaseTestCase
{
    /**
     * @inheritdoc
     */
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
