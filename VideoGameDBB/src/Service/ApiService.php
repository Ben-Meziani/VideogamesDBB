<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class ApiService
{
    public function getToken()
    {
        $ch = curl_init();

        $queryString = http_build_query([
            'client_id'     => 'iqyfswd35518044vioxjkvdmsgvq1w',
            'client_secret' => '2rwr0vxj1p66oa8oksd06quz0drpxs',
            'grant_type'    => 'client_credentials'
        ]);
        
        $curlOptions = [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => 'https://id.twitch.tv/oauth2/token',
            CURLOPT_POSTFIELDS     => $queryString
        ];
        
        curl_setopt_array(
            $ch, 
            $curlOptions
        );
        
        $responseInJsonFormat = curl_exec($ch);
        
        curl_close($ch);
        
        $responseInArrayFormat = json_decode(
            $responseInJsonFormat, 
            true, 
            512, 
            JSON_THROW_ON_ERROR
        );
        
        return $responseInArrayFormat;
    }

    public function curlApi($endEndpoint)
    {
        // dd($endEndpoint);
        $token = self::getToken();
        $tokenBearer = $token['access_token'];
        $client_id = 'iqyfswd35518044vioxjkvdmsgvq1w';
        $body = 'fields *; limit 500;';
        $url = 'https://api.igdb.com/v4/'.$endEndpoint;
        $curl = curl_init();
        $headers = array(
            'Client-ID: ' . $client_id,
            'Authorization: Bearer ' . $tokenBearer,
        );

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        $responseInJsonFormat = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($responseInJsonFormat, true);
        return $response;
    }
}
