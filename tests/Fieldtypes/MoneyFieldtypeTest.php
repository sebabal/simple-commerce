<?php

namespace DoubleThreeDigital\SimpleCommerce\Tests\Fieldtypes;

use DoubleThreeDigital\SimpleCommerce\Fieldtypes\MoneyFieldtype;
use DoubleThreeDigital\SimpleCommerce\Tests\TestCase;

class MoneyFieldtypeTest extends TestCase
{
    /** @test */
    public function can_preload_currency()
    {
        $preload = (new MoneyFieldtype())->preload();

        $this->assertIsArray($preload);
        $this->assertArrayHasKey('code', $preload);
        $this->assertArrayHasKey('name', $preload);
        $this->assertArrayHasKey('symbol', $preload);
    }

    /** @test */
    public function can_pre_process_data()
    {
        $value = 2550;

        $process = (new MoneyFieldtype())->preProcess($value);

        $this->assertSame('25.50', $process);
    }

    /** @test */
    public function can_process_data()
    {
        $value = '12.65';

        $process = (new MoneyFieldtype())->process($value);

        $this->assertSame(1265, $process);
    }

    /** @test */
    public function has_a_title()
    {
        $title = (new MoneyFieldtype())->title();

        $this->assertSame('Money', $title);
    }

    /** @test */
    public function has_a_component()
    {
        $title = (new MoneyFieldtype())->component();

        $this->assertSame('money', $title);
    }

    /** @test */
    public function can_augment_data()
    {
        $value = 1945;

        $augment = (new MoneyFieldtype())->augment($value);

        $this->assertSame('£19.45', $augment);
    }
}
