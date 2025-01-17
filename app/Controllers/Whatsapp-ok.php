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
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    // Function untuk mengambil QR code
    public function getQR()
    {
        $client = \Config\Services::curlrequest();
        $response = $client->get('http://localhost:3000/get-qr');

        $data = json_decode($response->getBody(), true);

        if (isset($data['qr'])) {
            return $this->response->setJSON([
                'success' => true,
                'qr' => $data['qr'], // QR code dalam bentuk base64
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'QR code not available.',
            ]);
        }
    }
    public function showQR()
    {
        $client = \Config\Services::curlrequest();
        try {
            $response = $client->get('http://localhost:3000/get-qr');
            $data = json_decode($response->getBody(), true);

            if (isset($data['qr'])) {
                $qrCode = $data['qr'];
                $attempts = $data['attempts'];
            } else {
                $qrCode = null;
                $attempts = $data['attempts'];
            }
        } catch (\Exception $e) {
            return view('whatsapp-qr', [
                'error' => 'Gagal terhubung ke server Node.js.',
                'qrCode' => null,
                'attempts' => 0,
            ]);
        }

        return view('whatsapp-qr', [
            'qrCode' => $qrCode,
            'attempts' => $attempts,
            'error' => null,
        ]);
    }
    public function retryQR()
    {
        // Reset percobaan QR code di server Node.js (opsional)
        $client = \Config\Services::curlrequest();
        try {
            $client->get('http://localhost:3000/reset-qr-attempts'); // Endpoint untuk reset percobaan
        } catch (\Exception $e) {
            // Tangani error jika server Node.js tidak merespons
        }

        // Redirect kembali ke halaman QR code
        return redirect()->to('/whatsapp/qr');
    }
    // Function untuk menampilkan halaman QR code
    public function showQRok()
    {
        // Cek koneksi ke server Node.js
        if (!$this->checkNodeJsServer()) {
            return view('whatsapp-qr', [
                'error' => 'Server Node.js tidak tersedia. Silakan coba lagi nanti.',
                'qrCode' => null,
            ]);
        }

        // Ambil QR code dari layanan Baileys
        $client = \Config\Services::curlrequest();
        try {
            $response = $client->get('http://localhost:3000/get-qr');
            $data = json_decode($response->getBody(), true);

            if (isset($data['qr'])) {
                $qrCode = $data['qr'];
            } else {
                $qrCode = null;
            }
        } catch (\Exception $e) {
            // Tangani error jika server Node.js tidak merespons
            return view('whatsapp-qr', [
                'error' => 'Gagal terhubung ke server Node.js. Pastikan server Baileys sedang berjalan.',
                'qrCode' => null,
            ]);
        }

        // Kirim data QR code ke view
        return view('whatsapp-qr', [
            'qrCode' => $qrCode,
            'error' => null,
        ]);
    }
    // Function untuk menampilkan halaman QR code
    public function showQRx()
    {
        // Cek koneksi ke server Node.js
        if (!$this->checkNodeJsServer()) {
            return view('whatsapp-qr', [
                'error' => 'Server Node.js tidak tersedia. Silakan coba lagi nanti.',
                'qrCode' => null,
            ]);
        }
        // Ambil QR code dari layanan Baileys
        $client = \Config\Services::curlrequest();
        $response = $client->get('http://localhost:3000/get-qr');

        $data = json_decode($response->getBody(), true);

        if (isset($data['qr'])) {
            $qrCode = $data['qr'];
        } else {
            $qrCode = null;
        }

        // Kirim data QR code ke view
        return view('whatsapp-qr', ['qrCode' => $qrCode]);
    }
    // / Function untuk mengecek ketersediaan server Node.js
    public function checkserv()
    {
        // Cek koneksi ke server Node.js
        if (!$this->checkNodeJsServer()) {
            return view('whatsapp-qr', [
                'error' => 'Server Node.js tidak tersedia. Silakan coba lagi nanti.',
                'qrCode' => null,
            ]);
        } else {
            print_r($this->checkNodeJsServer());
        }
    }
    private function checkNodeJsServer()
    {
        $client = \Config\Services::curlrequest();
        try {
            // Coba melakukan ping ke server Node.js
            $response = $client->get('http://localhost:3000');
            return ($response->getStatusCode() === 200);
        } catch (\Exception $e) {
            return false;
        }
    }
}
