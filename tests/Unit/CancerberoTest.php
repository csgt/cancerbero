<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Csgt\Cancerbero\Cancerbero;

class CancerberoTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $returno = Cancerbero::can('catalogos.usuarios.index');
        $this->assert($returno, 'catalogos.usuarios');
    }
}
