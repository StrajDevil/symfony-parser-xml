<?php

namespace App\Service;

use XMLReader;

/**
 * Сервис для получения и разбора XML
 */
class Xml
{
    /**
     * Получение результата разбора XML
     *
     * @param string $uri
     * @return array|string
     */
    public static function get(string $uri): array|string
    {
        $xml = new XMLReader();
        $xml->open($uri);

        return self::parse($xml);
    }
    /**
     * Разбор XML
     *
     * @param XMLReader $xml Объект XML
     * @return array|string Выходной массив с данными
     */
    private static function parse(XMLReader $xml): array | string
    {
        $rootArray = [];
        while ($xml->read()) {
            switch ($xml->nodeType) {
                case XMLReader::END_ELEMENT:
                    return $rootArray;
                case XMLReader::ELEMENT:
                    $child = [];
                    if (!$xml->isEmptyElement) {
                        $child[$xml->localName] = self::parse($xml);
                    }
                    if ($xml->hasAttributes) {
                        $attributes = [];
                        while ($xml->moveToNextAttribute()) {
                            $attributes[$xml->localName] = $xml->value;
                        }
                        $xml->moveToElement();
                        if (isset($child[$xml->localName]) && is_string($child[$xml->localName])) {
                            $child[$xml->localName] = (array) $child[$xml->localName];
                        }
                        $child[$xml->localName]['attributes'] = $attributes;
                    }
                    if (isset($child[$xml->localName]) && isset($rootArray[$xml->localName])) {
                        if (isset($rootArray[$xml->localName]['attributes'])) {
                            $child[$xml->localName]['attributes'] = $rootArray[$xml->localName]['attributes'];
                        }
                        if (!isset($rootArray[$xml->localName][0])) {
                            array_splice(
                                $rootArray[$xml->localName],
                                0,
                                count($rootArray[$xml->localName]),
                                [$rootArray[$xml->localName]]
                            );
                        } elseif (!is_array($rootArray[$xml->localName])) {
                            $rootArray[$xml->localName] = (array) $rootArray[$xml->localName];
                        }
                        $rootArray[$xml->localName][] = $child[$xml->localName];
                        break;
                    }
                    $rootArray += $child;
                    break;
                case XMLReader::TEXT:
                case XMLReader::CDATA:
                    $rootArray = $xml->value;
            }
        }

        return $rootArray;
    }
}