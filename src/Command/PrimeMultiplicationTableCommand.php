<?php

declare(strict_types=1);

namespace App\Command;

use App\PrimeGenerator\PrimeGeneratorInterface;
use InvalidArgumentException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:prime-multiplication-table')]
class PrimeMultiplicationTableCommand extends Command
{
    public function __construct(private readonly PrimeGeneratorInterface $primeGenerator)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'count',
            InputArgument::REQUIRED,
            'How many of the first prime numbers to include in the table?'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $numberOfPrimes = $this->getNumberOfPrimes($input);

        $primes = $this->primeGenerator->generateFirstPrimes($numberOfPrimes);

        $multiplicationTable = array_fill(0, $numberOfPrimes + 1, array_fill(0, $numberOfPrimes + 1, ''));
        $multiplicationTable[0] = ['', ...$primes];

        for ($i = 0; $i < $numberOfPrimes; $i++) {
            $multiplicationTable[$i + 1][0] = $primes[$i];
            for ($j = $i; $j < $numberOfPrimes; $j++) {
                $product = $primes[$i] * $primes[$j];
                $multiplicationTable[$i + 1][$j + 1] = $product;
                $multiplicationTable[$j + 1][$i + 1] = $product;
            }
        }

        $table = new Table($output);
        $table->addRows($multiplicationTable);
        $table->render();

        return Command::SUCCESS;
    }

    private function getNumberOfPrimes(InputInterface $input): int
    {
        $inputNumber = $input->getArgument('count');

        if (!is_string($inputNumber) || !ctype_digit($inputNumber)) {
            throw new InvalidArgumentException('Invalid value given for `count` of prime numbers');
        }

        $inputNumber = (int) $inputNumber;

        if ($inputNumber < 1 || $inputNumber > 100000 /* Be realistic */) {
            throw new InvalidArgumentException('Invalid value given for `count` of prime numbers');
        }

        return $inputNumber;
    }
}
