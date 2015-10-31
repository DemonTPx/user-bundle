<?php

$autoloadLocations = array(
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../../../vendor/autoload.php',
);

foreach ($autoloadLocations as $autoloadFile) {
    if (is_file($autoloadFile)) {
        require $autoloadFile;

        return;
    }
}

throw new \LogicException('Could not find autoload.php in vendor/. Did you run "composer install --dev"?');

