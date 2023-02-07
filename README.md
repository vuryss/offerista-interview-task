# Offerista interview task

## Task description

Write a program that prints out a multiplication table of the first 10 prime numbers. The program must run from the 
command line and print one table to STDOUT. The first row and column of the table should have the 10 primes, with each 
cell containing the product of the primes for the corresponding row and column. Notes • Consider complexity. How fast 
does your code run? How does it scale? • Consider cases where we want N primes. • Do not use the Prime class from stdlib 
(write your own code). • Write tests. Try to demonstrate TDD/BDD. When you're done Put your code on GitHub or email us a
zip/tarball.

## Notes

- Consider complexity. How fast does your code run? How does it scale? • Consider cases where we want N primes.
    - Using Sieve of Eratosthenes as efficient enough algorithm for filtering prime numbers in given integer range. This
        sieve has complexity of O(n log log n) and is used behind an interface, making usage of another method available
        should this solution needs to be even faster.
    - The generation of output table is O(n^2) and it's hard to make that more performant. The only optimization there
        is that calculating the same product is done only once and reused across the table. That halves the number of
        computations, but the time complexity is still O(n^2) because at the end of the day we have to multiply each
        prime number to itself and all the rest.
    - Considering we want high number of primes contradicts with the desired output method - console formatted table.
        There is limited amount of space on a computer screen, and you can only scale so much using this medium. If we
        want to scale it further - we should consider Excel table, CSV or other structured format that can be paged
        correctly for the data size.
- Write tests. Try to demonstrate TDD/BDD.
    - Unit tests are included, but TDD is not easily demonstrated because it's not visible in the final result. You
        cannot prove that you have written the tests before the functionality.
    - Including test library like Behat to demonstrate the BDD is possible but the actual result will duplicate the 
        already existing unit tests, so I decided not to include it. If you want those tests to be included - please
        contact me and I will write them.

## Executing the command

### Build the container

`docker build . -t offerista-task`

### Installing project dependencies

`docker run -itu 1000 --rm -v "$PWD":/app -w /app offerista-task composer install`

### Running the command

`docker run -itu 1000 --rm -v "$PWD":/app -w /app offerista-task bin/console app:prime-multiplication-table 10`
