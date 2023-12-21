<?php

class ArrayUtil
{
    // Permet de vérifier la présence d'une clé spécifiée dans un tableau
    public static function keyExists(array $array, $key)
    {
        return array_key_exists($key, $array);
    }

    // Trie le tableau par ordre croissant
    public static function sortAsc(array $array)
    {
        sort($array);
        return $array;
    }

    // Trie le tableau par ordre décroissant
    public static function sortDesc(array $array)
    {
        rsort($array);
        return $array;
    }

    // Ajoute une nouvelle paire clé/valeur à un tableau
    public static function add(array &$array, $key, $value)
    {
        if (!array_key_exists($key, $array)) {
            $array[$key] = $value;
        }
    }

    // Supprime un paire clé/valeur à un tableau
    public static function remove(array &$array, array $keys)
    {
        foreach ($keys as $key) {
            unset($array[$key]);
        }
    }

    // Transforme un tableau de tableaux en un seul tableau
    public static function flatten(array $arrayOfArrays)
    {
        return array_reduce($arrayOfArrays, function ($carry, $item) {
            return array_merge($carry, $item);
        }, []);
    }

    // Permet de récupérer la valeur associée à une séquence de clés imbriquées dans un tableau.
    public static function getValueByKeys(array $array, array $keys)
    {
        foreach ($keys as $nestedKey) {
            if (is_array($array) && array_key_exists($nestedKey, $array)) {
                $array = $array[$nestedKey];
            } else {
                return null;
            }
        }

        return $array;
    }

    // Retourne une valeur aléatoire du tableau 
    public static function getRandomValue(array $inputArray)
    {
        $randomKey = array_rand($inputArray);

        return $inputArray[$randomKey];
    }

    // Retourne le premier élément du tableau s'il existe,    
    public static function getFirstElement(array $inputArray)
    {
        $firstElement = reset($inputArray);

        if ($firstElement !== false) {
            return $firstElement;
        } else {
            return null;
        }
    }

    // Retourne le dernier élément du tableau s'il existe,
    public static function getLastElement(array $inputArray)
    {
        $lastElement = end($inputArray);

        if ($lastElement !== false) {
            return $lastElement;
        } else {
            return null;
        }
    }

    // Filtre le tableau original pour ne conserver que les éléments correspondant aux clés spécifiées
    public static function filterByKey(array $inputArray, array $keysToKeep)
    {
        $filteredArray = [];

        foreach ($keysToKeep as $key) {
            if (array_key_exists(
                $key,
                $inputArray
            )) {
                $filteredArray[$key] = $inputArray[$key];
            }
        }

        return $filteredArray;
    }

    // Filtre le tableau original pour ne supprimer que les éléments correspondant aux clés spécifiées
    public static function removeByKey(array &$inputArray, array $keysToRemove)
    {
        foreach ($keysToRemove as $key) {
            if (array_key_exists($key, $inputArray)) {
                unset($inputArray[$key]);
            }
        }

        return $inputArray;
    }
}
