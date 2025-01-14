<?php

namespace App\Core\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory as FactoriesHasFactory;

trait HasFactory
{
    use FactoriesHasFactory;

    /**
     * Get a new factory instance for the model.
     * Modified to get Factories from Module
     *
     * @param  mixed  $parameters
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function factory(...$parameters)
    {
        $factory_class = self::factoryNameResolver(get_called_class());
        $factory = $factory_class::new();

        return $factory
            ->count(is_numeric($parameters[0] ?? null) ? $parameters[0] : null)
            ->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }

    /**
     * @param mixed $modelName
     *
     * @return string
     */
    public static function factoryNameResolver(mixed $modelName): string
    {
        $modelArray = explode("\\", $modelName);
        $moduleName = $modelArray[1] ?: "Core";
        $modelName = $modelArray[count($modelArray) - 1] ?: $modelName;

        return "\\Modules\\{$moduleName}\\Database\\factories\\{$modelName}Factory";
    }
}
