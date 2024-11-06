<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Interface;

interface FeeStrategy
{
    /**
     * @return float The calculated total fee.
     */
    public function getCost(int $term, float $amount): float;
}
