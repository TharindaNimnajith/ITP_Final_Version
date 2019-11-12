<?php

namespace Faker\Test\Provider\tr_TR;

use Faker\Generator;
use Faker\Provider\tr_TR\Company;

class CompanyTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Generator
     */
    private $faker;

    public function setUp()
    {
        $faker = new Generator();
        $faker->addProvider(new Company($faker));
        $this->faker = $faker;
    }

    public function testCompany()
    {
        $company = $this->faker->companyField;
        $this->assertNotNull($company);
    }
}
