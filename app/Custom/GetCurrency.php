<?php
namespace App\Custom;

use App\Services\GeoLocationService;
use Exception;
use Illuminate\Support\Facades\Log;

class GetCurrency
{

    // Función para obtener la moneda del país usando la API Restcountries
    /* public static function getCurrencyByCountryCode($countryCode)
    {

        ini_set('allow_url_fopen', 1);
        ini_set('default_socket_timeout', 15);

        // Desactivar la verificación SSL
        stream_context_set_default([
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
        ]);

        $url = "https://restcountries.com/v3.1/alpha/{$countryCode}";
        $response = file_get_contents($url);

        if (!$response) {
            throw new \Exception("No se pudo obtener datos de la API.");
        }

        $countryData = json_decode($response, true);

        // Asegúrate de que la clave 'currencies' está disponible
        if (isset($countryData[0]['currencies'])) {
            return $countryData[0]['currencies'];
        } else {
            return "Moneda no disponible";
        }
    }*/
    public static function getCurrencyByCountryCode($countryCode)
    {
        ini_set('allow_url_fopen', 1);
        ini_set('default_socket_timeout', 15);

        // Desactivar la verificación SSL (solo si es necesario)
        stream_context_set_default([
            "ssl" => [
                "verify_peer"      => false,
                "verify_peer_name" => false,
            ],
        ]);
        $money  = strtolower($countryCode);
        $url = "https://restcountries.com/v3.1/alpha/{$money}";

                                              // Realizar la solicitud a la API con manejo de errores.
        $response = @file_get_contents($url); // El @ suprime el warning si la URL falla.

        if ($response === false) {
            // Si no se puede obtener la respuesta, lanzar excepción.
            Log::info("No se pudo obtener datos de la API. Verifique la conexión ::".$money);
            throw new \Exception("No se pudo obtener datos de la API. Verifique la conexión.::".$money);
            self::countryData('CO');


        }

        // Decodificar la respuesta JSON.
        $countryData = json_decode($response, true);

        // Verificar si la decodificación fue exitosa.
        if ($countryData === null) {
            Log::info("Error al decodificar los datos JSON de la API.");
            throw new \Exception("Error al decodificar los datos JSON de la API.");
            self::countryData('CO');

        }

        if (is_array($countryData) && isset($countryData[0]['currencies'])) {
            foreach ($countryData[0]['currencies'] as $currency => $value) {
                $currencyName = $value["name"];  // Nombre de la moneda
                $currencySymbol = $value["symbol"];  // Símbolo de la moneda
                $typeCurrency  = $currency;
            }
            return ["currencyName"=>$currencyName,"currencySymbol"=>$currencySymbol,"typeCurrency"=>$typeCurrency];
        } else {
            Log::info("Moneda no disponible o datos mal formateados");
            return "Moneda no disponible o datos mal formateados";
        }

        /*// Verificar si 'currencies' está presente en la respuesta.
            if (isset($countryData[0]['currencies'])) {
                // Si la moneda está disponible, devolverla.
                return $countryData[0]['currencies'];
            } else {
                // Si no se encuentra la moneda, devolver un mensaje de error.
                Log::info("Moneda no disponible" );
                return "Moneda no disponible";
            }*/
    }

    public static function countryData($country_ref){
        return response()->json([
            [
                "name" => [
                    "common" => "Colombia",
                    "official" => "Republic of Colombia",
                    "nativeName" => [
                        "spa" => [
                            "official" => "República de Colombia",
                            "common" => "Colombia"
                        ]
                    ]
                ],
                "tld" => [".co"],
                "cca2" => "CO",
                "ccn3" => "170",
                "cca3" => "COL",
                "cioc" => "COL",
                "independent" => true,
                "status" => "officially-assigned",
                "unMember" => true,
                "currencies" => [
                    "COP" => ["name" => "Colombian peso", "symbol" => "$"]
                ],
                "capital" => ["Bogotá"],
                "region" => "Americas",
                "subregion" => "South America",
                "languages" => ["spa" => "Spanish"],
                "population" => 50882884,
                "flag" => "🇨🇴",
                "maps" => [
                    "googleMaps" => "https://goo.gl/maps/zix9qNFX69E9yZ2M6",
                    "openStreetMaps" => "https://www.openstreetmap.org/relation/120027"
                ],
                "timezones" => ["UTC-05:00"],
                "continents" => ["South America"],
                "flags" => [
                    "png" => "https://flagcdn.com/w320/co.png",
                    "svg" => "https://flagcdn.com/co.svg"
                ]
            ]
        ]);




    }

    public static function getGeoDataFromIp()
    {
        try {
            // Instanciar el servicio GeoLocationService
            $geoLocationService = app(GeoLocationService::class);

            // Llamar al método getGeoInfo de la clase GeoLocationService
            $geoData = $geoLocationService->getGeoInfo(self::getIpAdress());

            return $geoData; // Retorna los datos geo-localizados de la IP

        } catch (Exception $e) {
            // Maneja cualquier error
            return $e->getMessage();
        }
    }

    public static function getIpAdress(): string
    {
        return '191.89.132.89';

    }

}
