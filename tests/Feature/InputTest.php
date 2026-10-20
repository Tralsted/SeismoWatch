<?php

use function Pest\Laravel\get;

// below minimum filter value
test('rejects value less than 2.5', function() {
    get('/?min_magnitude=2.4')
        ->assertSessionHasErrors(['min_magnitude']);
});

// minimum filter value
test('accepts value equal to 2.5', function() {
    get('/?min_magnitude=2.5')
        ->assertSessionHasNoErrors();
});

// above minimum filter value
test('accepts value greater than 2.5', function() {
    get('/?min_magnitude=2.6')
        ->assertSessionHasNoErrors();
});
