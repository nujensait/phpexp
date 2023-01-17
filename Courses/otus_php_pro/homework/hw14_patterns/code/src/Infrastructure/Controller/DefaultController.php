<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

class DefaultController implements ControllerInterface
{
    public function __invoke($request)
    {
        $consoleCommand = $request->server->get('argv')[1] ?? '';
        echo 'Controller not found for command: ' . $consoleCommand . PHP_EOL;
    }
}