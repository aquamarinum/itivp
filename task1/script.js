const maxUsers = 2;
let users = JSON.parse(localStorage.getItem("chatUsers")) || [];
const messagesContainer = document.getElementById("messages");
const messageInput = document.getElementById("message-input");
const sendButton = document.getElementById("send-button");
const loginContainer = document.getElementById("login-container");
const chatContainer = document.getElementById("chat-container");
const errorMessage = document.getElementById("error-message");
let currentUser = sessionStorage.getItem("currentUser") || "";

window.addEventListener("load", () => {
  const username = sessionStorage.getItem("currentUser");
  if (username && users.includes(username)) {
    currentUser = username;
    loginContainer.style.display = "none";
    chatContainer.style.display = "block";
    loadMessages();
    messageInput.addEventListener("input", handleInput);
    sendButton.addEventListener("click", sendMessage);
    window.addEventListener("storage", syncMessages);
  } else if (users.length >= maxUsers) {
    errorMessage.textContent = "Чат переполнен, попробуйте позже.";
  }
});

document.getElementById("login-form").addEventListener("submit", (event) => {
  event.preventDefault();
  const username = document.getElementById("username").value.trim();
  if (validateUsername(username)) {
    if (!users.includes(username)) {
      if (users.length < maxUsers) {
        users.push(username);
        localStorage.setItem("chatUsers", JSON.stringify(users));
      } else {
        errorMessage.textContent = "Чат переполнен, попробуйте позже.";
        return;
      }
    }
    currentUser = username;
    sessionStorage.setItem("currentUser", currentUser);
    loginContainer.style.display = "none";
    chatContainer.style.display = "block";
    loadMessages();
    messageInput.addEventListener("input", handleInput);
    sendButton.addEventListener("click", sendMessage);
    window.addEventListener("storage", syncMessages);
  }
});

function validateUsername(username) {
  if (!username || username.length > 20) {
    errorMessage.textContent = "Имя должно быть от 1 до 20 символов.";
    return false;
  }
  return true;
}

function loadMessages() {
  const messages = JSON.parse(localStorage.getItem("chatMessages")) || [];
  messagesContainer.innerHTML = messages
    .map((msg) => {
      const { user, text } = msg;
      const ownMessage = user === currentUser;
      return `<div style="color: ${ownMessage ? "blue" : "black"};">
                    <strong style="color: ${
                      ownMessage ? "blue" : "black"
                    };">${user}:</strong> ${text}
                </div>`;
    })
    .join("");
}

// function handleInput() {
//   sendButton.disabled = !validateMessage(messageInput.value.trim());
// }

function handleInput() {
  const originalValue = messageInput.value;
  const trimmedStart = originalValue.replace(/^\s+/, "");
  if (originalValue !== trimmedStart) {
    messageInput.value = trimmedStart;
  }

  sendButton.disabled = !validateMessage(messageInput.value.trim());
}

function validateMessage(message) {
  return message && message.length <= 120;
}

let debounceTimeout;
document.getElementById("message-form").addEventListener("submit", (event) => {
  event.preventDefault();
  sendMessage();
});

function sendMessage() {
  clearTimeout(debounceTimeout);
  debounceTimeout = setTimeout(() => {
    const message = messageInput.value.trim();
    if (validateMessage(message)) {
      const messages = JSON.parse(localStorage.getItem("chatMessages")) || [];
      messages.push({ user: currentUser, text: message });
      localStorage.setItem("chatMessages", JSON.stringify(messages));
      loadMessages();
      messageInput.value = "";
      sendButton.disabled = true;
    }
  }, 300);
}

function syncMessages(event) {
  if (event.key === "chatMessages") {
    loadMessages();
  }
}
