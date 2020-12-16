<?php

declare(strict_types=1);

namespace App\TaskModule\Infrastructure\DependencyInjection;

use App\TaskModule\Domain\Report\ReportFormatter;
use App\TaskModule\Domain\Report\ReportGeneratorBag;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ReportFormattersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(ReportGeneratorBag::class)) {
            return;
        }

        $definition = $container->findDefinition(ReportGeneratorBag::class);

        $taggedServices = $container->findTaggedServiceIds(ReportFormatter::TAG);

        foreach ($taggedServices as $id => $taggedService) {
            $definition->addMethodCall('add', [new Reference($id)]);
        }
    }
}
