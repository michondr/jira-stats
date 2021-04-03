<?php

declare(strict_types = 1);

namespace Api;

class JiraClient
{

    private ResponseDeserializer $responseDeserializer;

    public function __construct(
        ResponseDeserializer $responseDeserializer
    )
    {
        $this->responseDeserializer = $responseDeserializer;
    }

    public function callApi(string $jiraCompany, string $authUserEmail, string $authApiToken, int $from, int $itemsPerPage): array
    {
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => sprintf(
                    'https://%s.atlassian.net/rest/api/latest/search?maxResults=%s&startAt=%s',
                    $jiraCompany,
                    $itemsPerPage,
                    $from
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Authorization: Basic ' . base64_encode($authUserEmail . ':' . $authApiToken),
                ),
            )
        );

        $response = curl_exec($curl);

        $error = curl_error($curl);
        if ($error !== '') {
            throw new \Exception('error: ' . $error);
        }

        curl_close($curl);

        return $this->responseDeserializer->deserialize($response);
    }
}