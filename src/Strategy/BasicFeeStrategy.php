<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Strategy;

use PragmaGoTech\Interview\Interface\FeeStrategy;

class BasicFeeStrategy extends AbstractStrategy implements FeeStrategy
{
    private const AMOUNT = 'amount';
    private const FEE = 'fee';

    /**
     * @throws Exception if the provided amount is out of bounds for term.
     */
    public function getCost(int $term, float $amount): float
    {

        if (isset($this->feeTermsStructure[$term][$amount])) {
            return $this->feeTermsStructure[$term][$amount];
        }

        $lowerBound = null;
        $upperBound = null;

        foreach ($this->feeTermsStructure[$term] as $key => $value) {
            if ($key <= $amount) {
                $lowerBound = [self::AMOUNT => $key, self::FEE => $value];
            }
            if ($key > $amount && !$upperBound) {
                $upperBound = [self::AMOUNT => $key, self::FEE => $value];
            }
            if ($lowerBound && $upperBound) {
                break;
            }
        }

        if ($lowerBound && $upperBound) {
            $convertedToInt = $this->convertToInt($amount);
            $interpolatedFee = $this->interpolate($convertedToInt, $lowerBound, $upperBound);
            $roundenFee = $this->roundFee($interpolatedFee);
            return $this->convertToFloat($roundenFee);
        }

        throw new \Exception("Amount out of bounds for term.");
    }

    /**
     * @throws InvalidArgumentException if the provided Lower and upper bounds cannot have the same amount.
     */
    private function interpolate(int $amount, array $lowerBound, array $upperBound): int
    {
        $x1 = $this->convertToInt($lowerBound[self::AMOUNT]);
        $y1 = $this->convertToInt($lowerBound[self::FEE]);
        $x2 = $this->convertToInt($upperBound[self::AMOUNT]);
        $y2 = $this->convertToInt($upperBound[self::FEE]);

        if ($x2 == $x1) {
            throw new \InvalidArgumentException("Lower and upper bounds cannot have the same amount.");
        }

        $interpolatedFee = $y1 + (($amount - $x1) * ($y2 - $y1)) / ($x2 - $x1);

        return $interpolatedFee;
    }
}
