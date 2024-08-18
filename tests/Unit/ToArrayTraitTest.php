<?php

namespace Tests\Unit;

use App\Enums\TransactionType;
use PHPUnit\Framework\TestCase;

class ToArrayTraitTest extends TestCase
{
    public function test_names(): void
    {
        $this->assertEquals(TransactionType::names(), [
            'Expense',
            'Income',
        ]);
    }

    public function test_values(): void
    {
        $this->assertEquals(TransactionType::values(), [
            1,
            2,
        ]);
    }

    public function test_array(): void
    {
        $this->assertEquals(TransactionType::array(), [
            1 => "Expense",
            2 => "Income",
        ]);
    }

    public function test_from_name(): void
    {
        $this->assertEquals(TransactionType::fromName('Expense'), 1);
    }

    public function test_from_name_not_found(): void
    {
        $this->assertEquals(TransactionType::fromName('NoType'), null);
    }
}
