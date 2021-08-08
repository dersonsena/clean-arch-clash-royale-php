<?php

namespace Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCast;
use Faker\Generator;
use Faker\Factory as Faker;

/**
 * This is the base class for all yii framework unit tests.
 */
abstract class TestCase extends PHPUnitTestCast
{
    protected Generator $faker;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = Faker::create('pt_BR');
    }
}
