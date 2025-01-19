const baileys = require("@whiskeysockets/baileys");
const { makeWASocket, initAuthCreds, BufferJSON } = baileys;
const express = require("express");
const fs = require("fs");

const app = express();
app.use(express.json());

const STATE_FILE = "auth_info.json";

// Fungsi untuk memuat dan menyimpan state
const loadState = () => {
  if (fs.existsSync(STATE_FILE)) {
    return JSON.parse(fs.readFileSync(STATE_FILE, { encoding: "utf-8" }), BufferJSON.reviver);
  }
  return { creds: initAuthCreds() };
};

const saveState = (state) => {
  fs.writeFileSync(STATE_FILE, JSON.stringify(state, BufferJSON.replacer, 2));
};

// Inisialisasi state
const state = loadState();
let sock = null;
let isConnected = false;

const connectToWhatsApp = async () => {
  sock = makeWASocket({
    auth: state,
    printQRInTerminal: true,
  });

  sock.ev.on("connection.update", (update) => {
    const { connection, qr } = update;

    if (qr) {
      console.log("Scan QR Code ini di aplikasi WhatsApp Anda.");
    }

    if (connection === "open") {
      console.log("WhatsApp connected!");
      isConnected = true;
    }

    if (connection === "close") {
      console.log("Koneksi terputus!");
      isConnected = false;
    }
  });

  sock.ev.on("creds.update", () => saveState(state));
};

app.get("/check-connection", (req, res) => {
  res.json({
    status: "success",
    isConnected: isConnected,
    message: isConnected ? "WhatsApp terhubung!" : "WhatsApp belum terhubung!",
  });
});

app.listen(3000, () => {
  console.log("Baileys service berjalan di http://localhost:3000");
  connectToWhatsApp();
});
