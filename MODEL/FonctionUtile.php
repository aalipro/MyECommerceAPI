<?php
    class FonctionUtile{
        public static function  getMethodsOf($nomClasse) {
            $reflection = new ReflectionClass($nomClasse);
            $methodNames = [];
            $methods = $reflection->getMethods();
            foreach ($methods as $method) {
                $methodNames[] = $method->getName();
            }
            return $methods;
        }
        public static function getAttributsOf($nomClasse) {
            $reflection = new ReflectionClass($nomClasse);
            $attributeNames = [];
        
            $attributes = $reflection->getProperties();
            foreach ($attributes as $attribute) {
                $attributeNames[] = $attribute->getName();
                // echo "<p>{$attribute->getName()} <p>";
            }
            return $attributeNames;
        }
    }
?>