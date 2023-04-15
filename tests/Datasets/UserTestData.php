<?php
dataset('admin', function () {
    yield fn() => actingAsAdmin();
});

dataset('user', function () {
    yield fn() => actingAsUser();
});

