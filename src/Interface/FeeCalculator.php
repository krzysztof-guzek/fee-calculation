<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview\Interface;

use PragmaGoTech\Interview\Model\LoanProposal;

interface FeeCalculator
{
    public const MIN_AMOUNT_LOAN = 1000;
    public const MAX_AMOUNT_LOAN = 20000;

    public const TERM_YEAR = 12;
    public const TERM_TWO_YEARS = 24;
    
    /**
     * @return float The calculated total fee.
     */
    public function calculate(LoanProposal $application): float;
}
