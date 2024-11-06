<?php

declare(strict_types=1);

namespace PragmaGoTech\Interview;

use PragmaGoTech\Interview\Interface\FeeCalculator;
use PragmaGoTech\Interview\Interface\FeeStrategy;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Strategy\BasicFeeStrategy;

class Fee implements FeeCalculator
{
    private FeeStrategy $strategy;

    public function __construct()
    {
        $this->strategy = new BasicFeeStrategy();
    }
    /**
     * @return float The calculated total fee.
     */
    public function calculate(LoanProposal $application): float {
        return $this->strategy->getCost($application->term(), $application->amount());
    }
}
