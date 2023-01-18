<?php

declare(strict_types=1);

namespace Cookapp\Php\Application\Container;

use Cookapp\Php\Infrastructure\Dispatcher\ListenerProvider;
use Psr\EventDispatcher\ListenerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use DI;

class ContainerBuilder implements ContainerBuilderInterface
{
    public function __construct(private Request $request, private array $configuration)
    {
    }

    public function build(): Container
    {
        $builder = new \DI\ContainerBuilder();
        $builder->useAnnotations(true);

        $listenerProvider = $this->getListenerProvider();

        $builder->addDefinitions([
            'configuration' => DI\value($this->configuration),
            'Psr\EventDispatcher\EventDispatcherInterface' =>
                DI\autowire('Cookapp\Php\Infrastructure\Dispatcher\EventDispatcher')
                    ->constructorParameter('listenerProvider', $listenerProvider),
            'Cookapp\Php\Domain\Factory\FactoryDishFactoryInterface' =>
                DI\autowire('Cookapp\Php\Application\Factory\FactoryDishFactory'),
            'Cookapp\Php\Domain\Factory\ObserverFactoryInterface' =>
                DI\autowire('Cookapp\Php\Application\Factory\ObserverFactory'),
        ]);

        $container = $builder->build();

        return new Container($container);
    }

    private function getListenerProvider(): ListenerProviderInterface
    {
        $listenerProvider = new ListenerProvider();
        foreach ($this->configuration['listeners'] as $listener => $event) {
            $listenerProvider->addListener($event['event'], new $listener());
        }

        return $listenerProvider;
    }
}