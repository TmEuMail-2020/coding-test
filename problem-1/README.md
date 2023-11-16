# Solution to problem 1

## After assignment reflection

I really enjoy doing this assignment/kata! I applied TDD technique developing it. Also, I learned Slim framework v4
because of this assignment.

As always, as a nerdy dev myself, I still see many things I want to improve:

1. The current discount strategy is designed with the assumption that only one strategy can be applied at a time. In
   other words, the strategies can not be chained/combined.
    - Although [the instruction](https://github.com/teamleadercrm/coding-test/blob/master/1-discounts.md#how-discounts-work)
    did not explicitly say discount can or can not be chained/combined.
    - But I feel in the real world the discount should behave chainable. Hence, I see it as an important improvement to
      do next.
2. The rounding error can be handled more gracefully. Now it is quite scattered, I would like to use `value object`
   pattern to model the money better.
3. Lastly, although it is developed by TDD technique, I can sense there are still bugs somewhere...

All in all, really thankful for this assignment (also my wife's support to allow me sitting in front of computer for
many hours :p)

Hope to hear from interviewers soon!

## How to run

### Project Requirement

- PHP: ^8.1
- **IMPORTANT NOTE**: all the path below is relative to `/problem-1` directory

### 1. Run the test

`vendor/bin/phpunit`

### 2. Start the web app

`php -S localhost:8080 -t public`

### 3. Mock the incoming HTTP requests with example-orders

If you have PhpStorm

- please go to `tools` folder, then open one of mock-requests-xyz.http file 
    - ex: [mock-requests-Over1000TotalThen10PercentDiscount.http](tools%2Fmock-requests-Over1000TotalThen10PercentDiscount.http)
- then click green plan icon on the gutter to fire request

If you don't have PhpStorm

- you can use sample cURL command in `tools` folder
    - ex: [mock-requests-sample-cURL-commands.txt](tools%2Fmock-requests-sample-cURL-commands.txt)
- then copy and paste into your terminal

