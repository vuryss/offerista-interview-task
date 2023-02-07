<?php

declare(strict_types=1);

namespace App\PrimeGenerator;

use Ds\Set;
use InvalidArgumentException;

class EratosthenesSievePrimeGenerator implements PrimeGeneratorInterface
{
    public function generateFirstPrimes(int $primeNumberCount): array
    {
        if ($primeNumberCount < 1) {
            throw new InvalidArgumentException('You should generate at least one primary number');
        }

        $minPrime = 2;
        $sieveUpperBound = $this->upperBoundForEratosthenesSieve($primeNumberCount);

        $primes = [];
        $numberSet = new Set(range($minPrime, $sieveUpperBound));

        while ($numberSet->count() > 0) {
            $prime = $numberSet->first();
            $primes[] = $prime;

            for ($i = $prime; $i <= $sieveUpperBound; $i += $prime) {
                $numberSet->remove($i);
            }
        }

        return array_slice($primes, 0, $primeNumberCount);
    }

    /**
     * @link https://en.wikipedia.org/wiki/Prime-counting_function#Inequalities
     */
    private function upperBoundForEratosthenesSieve(int $primeNumberCount): int
    {
        if ($primeNumberCount <= 6) {
            return 15;
        }

        return (int) ceil($primeNumberCount * log($primeNumberCount * log($primeNumberCount)));
    }
}
