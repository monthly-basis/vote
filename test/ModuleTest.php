<?php
namespace MonthlyBasis\VoteTest;

use MonthlyBasis\LaminasTest\ModuleTestCase;
use MonthlyBasis\Vote\Module;

class ModuleTest extends ModuleTestCase
{
    protected function setUp(): void
    {
        $this->module = new Module();
    }
}
