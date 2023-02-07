<?php

declare(strict_types=1);

namespace App\PrimeGenerator;

interface PrimeGeneratorInterface
{
    /**
     * @return array<int>
     */
    public function generateFirstPrimes(int $primeNumberCount): array;
}
