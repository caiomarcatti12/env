<?php

namespace CaioMarcatti12\Env;

use CaioMarcatti12\Core\Launcher\Annotation\Launcher;
use CaioMarcatti12\Core\Launcher\Enum\LauncherPriorityEnum;
use CaioMarcatti12\Core\Launcher\Interfaces\LauncherInterface;
use CaioMarcatti12\Core\Validation\Assert;
use CaioMarcatti12\Env\Objects\Property;
use Composer\Autoload\ClassLoader;


#[Launcher(LauncherPriorityEnum::BEFORE_LOAD_FRAMEWORK)]
class PropertyLoader implements LauncherInterface
{
    public function handler(): void
    {
        $propertiesGlobal = $this->parseFile('');
        $propertiesEnvironment = [];

        if(Env::has('ENVIRONMENT')){
            $propertiesEnvironment = $this->parseFile(Env::get('ENVIRONMENT'));
        }

        $propertiesMerged = [];

        $this->mergeRecursiveArray($propertiesMerged, $propertiesGlobal);
        $this->mergeRecursiveArray($propertiesMerged, $propertiesEnvironment);

        $this->addProperty($propertiesMerged);
    }

    private function parseFile(string $environment): array
    {
        $path = $this->getPathResources();

        if (Assert::isNotEmpty($environment)) $path .= "application-$environment.yaml";
        else $path .= "application.yaml";

        if (file_exists($path)) {
            return \yaml_parse_file($path);
        }

        return [];
    }

    private function getPathResources(): string
    {
        $reflection = new \ReflectionClass(ClassLoader::class);
        $vendorDir = dirname(dirname($reflection->getFileName()));

        return $vendorDir.'/../';
    }

    private function mergeRecursiveArray(array &$propertiesMerged, array $properties): void
    {
        foreach ($properties as $key => $value) {
            if (is_array($value)) {
                if (!isset($propertiesMerged[$key])) $propertiesMerged[$key] = [];

                $this->mergeRecursiveArray($propertiesMerged[$key], $value);
            } else {
                $propertiesMerged[$key] = $value;
            }
        }
    }

    private function addProperty(array $properties): void
    {
        array_map(
            function ($key, $value) {
                Property::add($key, $value);
            },
            array_keys($properties),
            array_values($properties)
        );
    }
}