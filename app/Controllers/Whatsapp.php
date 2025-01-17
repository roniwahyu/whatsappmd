<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class WhatsApp extends Controller
{
    // URL Baileys service
    protected $baileysUrl = "http://localhost:3000";

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    // Fungsi untuk mengirim pesan
    public function sendMessage()
    {
        // Ambil data dari request
        $to = $this->request->getVar("to");
        $message = $this->request->getVar("message");

        if (empty($to) || empty($message)) {
            return $this->response->setJSON([
                "status" => "error",
                "message" => "Parameter 'to' dan 'message' harus diisi!",
            ]);
        }

        // Kirim permintaan ke Baileys service
        $client = \Config\Services::curlrequest();
        try {
            $response = $client->post($this->baileysUrl . "/send-message", [
                "json" => [
                    "to" => $to,
                    "message" => $message,
                ],
            ]);

            // Ambil respons dari Baileys service
            $responseData = json_decode($response->getBody(), true);
            return $this->response->setJSON($responseData);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                "status" => "error",
                "message" => "Gagal mengirim pesan: " . $e->getMessage(),
            ]);
        }
    }

    // Fungsi untuk memeriksa status koneksi WhatsApp
    public function checkConnection()
    {
        // Kirim permintaan ke Baileys service
        $client = \Config\Services::curlrequest();
        try {
            $response = $client->get($this->baileysUrl . "/check-connection");
            $responseData = json_decode($response->getBody(), true);
            return $this->response->setJSON($responseData);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                "status" => "error",
                "message" => "Gagal memeriksa koneksi: " . $e->getMessage(),
            ]);
        }
    }
}