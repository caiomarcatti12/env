<?php
//
//namespace CaioMarcatti12\Env;
//
//use CaioMarcatti12\Core\Bean\Exception\BadSearchFrameworkDirectoryException;
//use CaioMarcatti12\Core\Validation\Assert;
//
//class PropertyCloudLoader
//{
//    /**
//     * @throws BadSearchFrameworkDirectoryException
//     */
//    public function load(): bool
//    {
//        $propertiesGlobal = $this->parseFile('');
//        $propertiesEnvironment = [];
//
//        if(Env::has('ENVIRONMENT')){
//            $propertiesEnvironment = $this->parseFile(Env::get('ENVIRONMENT'));
//        }
//
//        $propertiesMerged = [];
//
//        $this->mergeRecursiveArray($propertiesMerged, $propertiesGlobal);
//        $this->mergeRecursiveArray($propertiesMerged, $propertiesEnvironment);
//
//        $this->addProperty($propertiesMerged);
//
//        return true;
//    }
//
//    /**
//     * @throws BadSearchFrameworkDirectoryException
//     */
//    private function parseFile(string $environment): array
//    {
//        $path = $this->getPathResources();
//
//        if (Assert::isNotEmpty($environment)) $path .= "application-$environment.yaml";
//        else $path .= "application.yaml";
//
//        if (file_exists($path)) {
//            return \yaml_parse_file($path);
//        }
//
//        return [];
//    }
//
//    /**
//     * @throws BadSearchFrameworkDirectoryException
//     */
//    private function getPathResources(): string
//    {
//        $listsDirecory = [
//            $GLOBALS['_application_root'].'/resources/',
//            $GLOBALS['_application_root'].'/../resources/',
//            $GLOBALS['_application_root'].'/../../resources/',
//            $GLOBALS['_application_root'].'/../../../resources/',
//            $GLOBALS['_application_root'].'/../../../../resources/'
//        ];
//
//        foreach ($listsDirecory as $directory) {
//            if (is_dir($directory)) return $directory;
//        }
//
//        return '';
//    }
//
//    private function mergeRecursiveArray(array &$propertiesMerged, array $properties): void
//    {
//        foreach ($properties as $key => $value) {
//            if (is_array($value)) {
//                if (!isset($propertiesMerged[$key])) $propertiesMerged[$key] = [];
//
//                $this->mergeRecursiveArray($propertiesMerged[$key], $value);
//            } else {
//                $propertiesMerged[$key] = $value;
//            }
//        }
//    }
//
//    private function addProperty(array $properties): void
//    {
//        array_map(
//            function ($key, $value) {
//                Property::add($key, $value);
//            },
//            array_keys($properties),
//            array_values($properties)
//        );
//    }
//}