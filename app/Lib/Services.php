<?php

namespace App\Lib;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;

class Services
{
    private static $instance;
    private $baseUrlWa;
    private $tokenWa;

    public function __construct()
    {
        $this->baseUrlWa = 'https://solo.wablas.com/api/';
        $this->tokenWa = '';
    }

    private static function header()
    {
        return [
            'Authorization' => self::$instance->tokenWa,
            // 'Content-Type' => 'application/json',
        ];
    }

    public static function singleSendTextWA($phone, $msg)
    {
        try {
            self::$instance = new Services;
            $client = new Client();
            $endpoint = "send-message";
            $params = [
                'headers' => self::header(),
                'form_params' => [
                    'phone' => $phone,
                    'message' => $msg
                ]
            ];


            $response = $client->post(self::$instance->baseUrlWa . $endpoint, $params);
            $responseData = json_decode($response->getBody()->getContents(), true);; // Mengambil konten langsung tanpa dekoding json
            return $responseData;
        } catch (ClientException $e) {
            // Tangani kesalahan dari klien (HTTP status code 4xx)
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorMessage = $response->getBody()->getContents();

            return [
                'success' => false,
                'message' => 'Client Error: ' . $statusCode . ' - ' . $errorMessage,
            ];
        } catch (\Exception $e) {
            // Tangani kesalahan umum
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }
    }
    public static function MasterMigrasi($endpoint)
    {
        $baseurl = 'http://119.2.50.170/sendpusk/api/migrasi/sip/';
        $client = new Client();

        try {
            $reponse = $client->get($baseurl . $endpoint);
            $data = $reponse->getBody()->getContents();
            $hasil = json_decode($data, true);
            return $hasil;
        } catch (ClientException $th) {
            //throw $th;
            echo "Error: " . $th->getMessage();
        }
    }
    public static function MasterSnomedct($page = null, $limit = null, $term = null)
    {
        $baseurl = 'http://103.101.52.65:9000/data';
        $client = new Client();
        try {
            $reponse = $client->get(
                $baseurl,
                [
                    'query' => [
                        'page' => $page,
                        'limit' => $limit,
                        'term' => $term
                    ]
                ]
            );
            $data = $reponse->getBody()->getContents();
            $hasil = json_decode($data, true);
            return $hasil;
        } catch (ClientException $th) {
            //throw $th;
            echo "Error: " . $th->getMessage();
        }
    }
    public static function MasterNegara()
    {
        $baseurl = 'https://country-code-au6g.vercel.app/Country.json';
        $client = new Client();

        try {
            $reponse = $client->get($baseurl);
            $data = $reponse->getBody()->getContents();
            $hasil = json_decode($data, true);
            return $hasil;
        } catch (ClientException $th) {
            //throw $th;
            echo "Error: " . $th->getMessage();
        }
    }

    public static function MasterMigrasiKFA($jenis, $perPage = null, $page = null)
    {
        $baseurl = 'http://119.2.50.170:9094/satu-sehat/api/master/kfa-full?jenis=' . $jenis . '&perPage=' . $perPage . '&page=' . $page;
        $client = new Client();

        try {
            $response = $client->get($baseurl);
            $data = $response->getBody()->getContents();
            $hasil = json_decode($data, true);
            return $hasil;
        } catch (ClientException $th) {
            // Log or handle the error appropriately
            echo "Error: " . $th->getMessage();
            return null;
        }
    }
    public static function sendWa($data, $no)
    {
        try {
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/json'
            ];
            $body = json_encode([
                'api_key' => 'Q1OTKLXL7XXJJZHS',
                'number_key' => 'bKESRct1CeZWmNrq',
                'phone_no' => $no,
                'message' => $data
            ]);

            // Mengirim request
            $request = new Request('POST', 'https://api.watzap.id/v1/send_message', $headers, $body);
            $res = $client->sendAsync($request)->wait();
            Log::info('WhatsApp message sent successfully', [
                'status_code' => $res->getStatusCode(),
                'response_body' => json_decode($res->getBody(), true),
            ]);
            // Mengembalikan hasil respon
            return [
                'success' => true,
                'status' => $res->getStatusCode(),
                'message' => 'Message sent successfully',
                'data' => json_decode($res->getBody(), true)
            ];
        } catch (ClientException $e) {
            // Menangkap error dari server (response body dan status code)
            $response = $e->getResponse();
            $responseBody = $response ? json_decode($response->getBody(), true) : null;
            Log::error('WhatsApp message failed to send (ClientException)', [
                'status_code' => $response ? $response->getStatusCode() : null,
                'response_body' => $responseBody,
                'exception_message' => $e->getMessage(),
            ]);
            return [
                'success' => false,
                'status' => $response ? $response->getStatusCode() : 500,
                'message' => $responseBody['message'] ?? 'An error occurred',
                'error' => $responseBody
            ];
        } catch (\Exception $e) {
            // Menangkap error umum lainnya
            Log::error('WhatsApp message failed to send (Exception)', [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
            ]);
            return [
                'success' => false,
                'status' => 500,
                'message' => $e->getMessage(),
                'error' => null
            ];
        }
    }
}
