<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Observer;

use Nikolai\Php\Domain\Observer\DishStateObserver;
use Nikolai\Php\Domain\Model\AbstractDish;

class SandwichObserver implements DishStateObserver
{
    public function update(AbstractDish $dish): void
    {
        fwrite(STDOUT, 'Наблюдатель: SandwichObserver, Состояние: ' . $dish->getStringState() . PHP_EOL);
    }
}