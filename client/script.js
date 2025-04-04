const socket = new WebSocket("ws://localhost:8080");
const messagesContainer = document.getElementById("messages");
const messageInput = document.getElementById("messageInput");

socket.onmessage = (event) => {
  const message = JSON.parse(event.data);
  displayMessage(message.text);
};

function sendMessage() {
  const text = messageInput.value.trim();
  if (text !== "") {
    const message = { text };
    socket.send(JSON.stringify(message));
    displayMessage(text);
    messageInput.value = "";
  }
}

function displayMessage(text) {
  const messageElement = document.createElement("div");
  messageElement.classList.add("message");
  messageElement.textContent = text;
  messagesContainer.appendChild(messageElement);
  messagesContainer.scrollTop = messagesContainer.scrollHeight;
}
