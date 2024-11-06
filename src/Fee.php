<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Interface\FeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;

class Fee implements FeeCalculator
{
    /**
     * @return float The calculated total fee.
     */
    public function calculate(LoanProposal $application): float {
        return 0.00;
    }
}
