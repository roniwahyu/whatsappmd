const { useSingleFileAuthState, makeWASocket, delay } = require("@whiskeysockets/baileys");
const express = require("express");
const app = express();
app.use(express.json());

// Variabel global untuk menyimpan state koneksi
let sock = null;
let isConnected = false;
let qrTimeout = null;

// Fungsi untuk memeriksa koneksi internet
const checkInternetConnection = async () => {
  try {
    await require("dns").promises.resolve("google.com");
    return true;
  } catch (error) {
    return false;
  }
};

// Fungsi untuk membuat koneksi WhatsApp
const connectToWhatsApp = async () => {
  const { state, saveState } = useSingleFileAuthState("auth_info.json");

  sock = makeWASocket({
    auth: state,
    printQRInTerminal: true,
  });

  // Handle koneksi WhatsApp
  sock.ev.on("connection.update", async (update) => {
    const { connection, qr, isNewLogin, lastDisconnect } = update;

    // Cek koneksi internet
    const isOnline = await checkInternetConnection();
    if (!isOnline) {
      console.log("Tidak ada koneksi internet!");
      return;
    }

    // Handle QR Code
    if (qr) {
      console.log("Scan QR Code ini di aplikasi WhatsApp Anda:");
      startQRTimeout(); // Mulai timeout untuk QR Code
    }

    // Handle koneksi sukses
    if (connection === "open") {
      console.log("WhatsApp connected!");
      isConnected = true;
      clearQRTimeout(); // Hentikan timeout jika berhasil terhubung
    }

    // Handle koneksi terputus
    if (connection === "close") {
      if (lastDisconnect?.error?.output?.statusCode !== 401) {
        console.log("Mencoba menghubungkan kembali...");
        connectToWhatsApp(); // Reconnect
      } else {
        console.log("Koneksi WhatsApp terputus. Silakan scan QR Code lagi.");
        isConnected = false;
      }
    }

    // Handle auth code (jika QR Code gagal)
    if (isNewLogin) {
      console.log("Masukkan auth code dari WhatsApp:");
      process.stdin.once("data", (data) => {
        const authCode = data.toString().trim();
        sock.authState.creds.registered = true;
        sock.authState.creds.authCode = authCode;
        saveState();
        console.log("Auth code berhasil disimpan.");
      });
    }
  });

  // Simpan state saat ada perubahan
  sock.ev.on("creds.update", saveState);
};

// Fungsi untuk memulai timeout QR Code
const startQRTimeout = () => {
  qrTimeout = setTimeout(() => {
    console.log("QR Code timeout. Silakan coba lagi.");
    process.exit(1); // Keluar dari proses jika timeout
  }, 60000); // Timeout 60 detik
};

// Fungsi untuk menghentikan timeout QR Code
const clearQRTimeout = () => {
  if (qrTimeout) {
    clearTimeout(qrTimeout);
    qrTimeout = null;
  }
};
app.get("/check-connection", (req, res) => {
    res.json({
      status: "success",
      isConnected: isConnected,
      message: isConnected ? "WhatsApp terhubung!" : "WhatsApp belum terhubung!",
    });
  });
// Endpoint untuk mengirim pesan
app.post("/send-message", async (req, res) => {
  if (!isConnected) {
    return res.status(400).json({ status: "error", message: "WhatsApp belum terhubung!" });
  }

  const { to, message } = req.body;
  try {
    await sock.sendMessage(to, { text: message });
    res.json({ status: "success", message: "Pesan terkirim!" });
  } catch (error) {
    res.status(500).json({ status: "error", message: error.message });
  }
});

// Jalankan server Express
app.listen(3000, () => {
  console.log("Baileys service berjalan di http://localhost:3000");
  connectToWhatsApp(); // Mulai koneksi WhatsApp
});