<?php

test('test 1 + 1 = 2', function () {
    $result = 1 + 1;

    expect($result)->toBe(2);
});

it('performs sums', function () {
    $result = 1 + 2;

    expect($result)->toBe(3);
});

// describe('multiTest', function () {
//     it('2+2', function () {
//         $result = 2 + 2;

//         expect($result)->toBe(4);
//     });

//     it('2*2', function () {
//         $result = 2 * 2;

//         expect($result)->toBe(4);
//     });
// });

// Call to undefined function describe()