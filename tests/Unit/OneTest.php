<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class OneTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {

        $collection = collect(['taylor', 'abigail', null])->first();
        dd($collection);


    }
}
