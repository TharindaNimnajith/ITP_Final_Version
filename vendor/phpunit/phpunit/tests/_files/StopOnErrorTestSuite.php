<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;

class StopOnErrorTestSuite extends TestCase
{
    public function testIncomplete()
    {
        $this->markTestIncomplete();
    }

    public function testWithError()
    {
        $this->assertTrue(true);

        throw new Error('StopOnErrorTestSuite_error');
    }

    public function testThatIsNeverReached()
    {
        $this->assertTrue(true);
    }
}
