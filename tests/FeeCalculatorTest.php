<?php

declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use PragmaGoTech\Interview\Fee;
use PragmaGoTech\Interview\Model\LoanProposal;

class FeeCalculatorTest extends TestCase
{
    /**
     * @dataProvider itemsProvider
     */
    public function testBasicFeeStrategy(int $term, int $amount, float $expectedFee): void
    {
        $calculator = new Fee();

        $application = new LoanProposal($term, $amount);
        $fee = $calculator->calculate($application);

        $this->assertEquals($expectedFee, $fee);
    }

    public function itemsProvider(): array
    {
        return [
            // Fixed data
            [24, 2750, 115],

            // Exact matches for Term 12
            [12, 1000, 50],
            [12, 5000, 100],
            [12, 20000, 400],

            // Exact matches for Term 24
            [24, 1000, 70],
            [24, 5000, 200],
            [24, 20000, 800],

            // Interpolated values for Term 12
            [12, 5500, 110],  // Between 5000 and 6000
            [12, 7500, 150],  // Between 7000 and 8000
            [12, 12500, 250], // Between 12000 and 13000

            // Interpolated values for Term 24
            [24, 5500, 220],  // Between 5000 and 6000
            [24, 7500, 300],  // Between 7000 and 8000
            [24, 12500, 500], // Between 12000 and 13000

            // Rounding tests to check that (amount + fee) is a multiple of 5
            [12, 5555, 110], // Interpolated and rounded
            [24, 15555, 620], // Interpolated and rounded
            [24, 9999, 400],  // Interpolated and rounded to multiple of 5
        ];
    }
}
