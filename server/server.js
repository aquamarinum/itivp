import { WebSocketServer } from "ws";
import { v4 as uuid } from "uuid";
import { writeFile, readFileSync, existsSync } from "fs";
const clients = {};
const log = existsSync("log.json") && readFileSync("log.json", "utf-8");
const messages = log ? JSON.parse(log) : [];

const wss = new WebSocketServer({ port: 8000 });
let connectionCount = 0;

wss.on("connection", (ws) => {
  const id = uuid();
  clients[id] = ws;
  connectionCount++;

  if (connectionCount > 3) {
    ws.send(
      JSON.stringify({
        code: 500,
        message: "Превышено количество пользователей сервера",
      })
    );
    ws.close();
    connectionCount--;
    return;
  } else {
    ws.send(JSON.stringify({ key: id }));
  }

  console.log(`New client ${id}`);

  ws.send(JSON.stringify(messages));

  ws.on("message", (rawMessage) => {
    const { name, message } = JSON.parse(rawMessage);
    messages.push({ name, message });
    for (const id in clients) {
      clients[id].send(JSON.stringify([{ name, message }]));
    }
  });

  ws.on("close", () => {
    delete clients[id];
    console.log(`Client is closed ${id}`);
  });
});

process.on("SIGINT", () => {
  wss.close();
  writeFile("log.json", JSON.stringify(messages), (err) => {
    if (err) {
      console.log(err);
    }
    process.exit();
  });
});
