const { useMultiFileAuthState, makeWASocket } = require("@whiskeysockets/baileys");
const express = require("express");
const qrcode = require("qrcode");
const app = express();
app.use(express.json());

let socket;
let qrData = null;
let qrAttempts = 0; // Menghitung jumlah percobaan QR code
const MAX_QR_ATTEMPTS = 6; // Batas maksimal percobaan QR code

async function startBaileys() {
    const { state, saveCreds } = await useMultiFileAuthState("auth_info");
    socket = makeWASocket({
        auth: state,
        printQRInTerminal: true,
        connectTimeoutMs: 60000, // Timeout 60 detik
    });

    socket.ev.on("connection.update", async (update) => {
        const { connection, qr, error } = update;
        if (connection === "open") {
            console.log("WhatsApp connected!");
            qrData = null; // Reset QR code setelah terhubung
            qrAttempts = 0; // Reset percobaan QR code
        }
        if (qr) {
            qrAttempts++; // Tambahkan jumlah percobaan
            if (qrAttempts > MAX_QR_ATTEMPTS) {
                console.error("Percobaan QR code melebihi batas. Silakan gunakan kode manual.");
                qrData = null;
            } else {
                console.log("QR code received. Attempt:", qrAttempts);
                qrData = await qrcode.toDataURL(qr);
            }
        }
        if (error) {
            console.error("Connection error:", error);
            // Coba ulang koneksi setelah 5 detik
            setTimeout(() => startBaileys(), 5000);
        }
    });

    socket.ev.on("creds.update", saveCreds);
}

startBaileys();

// Endpoint untuk mendapatkan QR code
app.get("/get-qr", (req, res) => {
    if (qrData) {
        res.json({ qr: qrData, attempts: qrAttempts });
    } else {
        res.status(404).json({ error: "QR code not available.", attempts: qrAttempts });
    }
});

// Endpoint untuk menghubungkan dengan kode manual
app.post("/connect-with-code", (req, res) => {
    const { code } = req.body;
    if (!code) {
        return res.status(400).json({ error: "Code is required." });
    }

    try {
        // Proses koneksi dengan kode manual
        // (Ini adalah contoh, Anda perlu menyesuaikan dengan logika Baileys)
        console.log("Connecting with code:", code);
        res.json({ success: true, message: "Connected successfully." });
    } catch (error) {
        res.status(500).json({ error: "Failed to connect.", details: error });
    }
});
// Endpoint untuk mereset percobaan QR code
app.get("/reset-qr-attempts", (req, res) => {
    qrAttempts = 0; // Reset jumlah percobaan
    res.json({ success: true, message: "QR attempts reset." });
});

// Jalankan server
const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Baileys service running on http://localhost:${PORT}`);
});