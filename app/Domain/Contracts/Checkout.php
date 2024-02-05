<?php

namespace App\Domain\Contracts;

interface Checkout
{
    public function auth(): array;
}
