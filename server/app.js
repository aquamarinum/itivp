const WebSocket = require("ws");

const wss = new WebSocket.Server({ port: 8080 });

wss.on("connection", (ws) => {
    console.log("Новый клиент подключен");

    ws.on("message", (message) => {
        console.log(`Получено сообщение: ${message}`);
        
        // Рассылка сообщения всем подключённым клиентам
        wss.clients.forEach(client => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(message);
            }
        });
    });

    ws.on("close", () => {
        console.log("Клиент отключился");
    });
});

console.log("WebSocket сервер запущен на ws://localhost:8080");
