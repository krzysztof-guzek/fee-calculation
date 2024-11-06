<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Interface;

use PragmaGoTech\Interview\Model\LoanProposal;

interface FeeCalculator
{
    /**
     * @return float The calculated total fee.
     */
    public function calculate(LoanProposal $application): float;
}
