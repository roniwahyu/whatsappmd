const { useMultiFileAuthState, makeWASocket } = require("@whiskeysockets/baileys");
const express = require("express");
const app = express();
app.use(express.json());

let socket;

async function startBaileys() {
    const { state, saveCreds } = await useMultiFileAuthState("auth_info");
    socket = makeWASocket({
        auth: state,
        printQRInTerminal: true,
    });

    socket.ev.on("connection.update", (update) => {
        const { connection, qr } = update;
        if (connection === "open") {
            console.log("WhatsApp connected!");
        }
        if (qr) {
            console.log("Scan QR code to connect.");
        }
    });

    socket.ev.on("creds.update", saveCreds);
}

startBaileys();

// Endpoint untuk mengirim pesan
app.post("/send-message", async (req, res) => {
    const { number, message } = req.body;
    if (!number || !message) {
        return res.status(400).json({ error: "Number and message are required." });
    }

    try {
        const id = `${number}@s.whatsapp.net`;
        await socket.sendMessage(id, { text: message });
        res.json({ success: true, message: "Message sent successfully." });
    } catch (error) {
        res.status(500).json({ error: "Failed to send message.", details: error });
    }
});

// Jalankan server
const PORT = 3000;
app.listen(PORT, () => {
    console.log(`Baileys service running on http://localhost:${PORT}`);
});