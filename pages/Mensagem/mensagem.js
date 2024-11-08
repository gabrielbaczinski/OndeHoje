var menuButton = document.getElementById("menu-button");
var menu = document.getElementById("menu");

menuButton.addEventListener("click", function() {
  if (menu.classList.contains("menu-show")) {
    menu.classList.remove("menu-show");
    menu.classList.add("menu-hide");
  } else {
    menu.classList.remove("menu-hide");
    menu.classList.add("menu-show");
  }
});

function getBotResponse(message) {
  const lowerCaseMessage = message.toLowerCase();

  if (lowerCaseMessage.includes("olá") || lowerCaseMessage.includes("oi")) {
      return "Olá! Como posso ajudar?";
  } else if (lowerCaseMessage.includes("dúvida")) {
      return "Claro! Me conte sua dúvida que irei ajudar.";
    } else if (lowerCaseMessage.includes("tudo bem")) {
      return "Tudo e você?";
  } else if (lowerCaseMessage.includes("obrigado") || lowerCaseMessage.includes("valeu")) {
      return "De nada! Sempre que precisar, estou aqui.";
  } else if (lowerCaseMessage.includes("adeus") || lowerCaseMessage.includes("tchau")) {
      return "Até mais! Foi bom falar com você.";
  } else {
      return "Desculpe, ainda estou aprendendo e não entendi sua pergunta.";
  }
}

function sendMessage() {
  const inputField = document.querySelector(".chat-input input");
  const message = inputField.value.trim();

  if (message) {
      // Exibir a mensagem do usuário
      addMessageToChat("user", message);

      // Obter resposta do "bot"
      const botResponse = getBotResponse(message);
      setTimeout(() => {
          addMessageToChat("bot", botResponse);
      }, 500); // Simular um pequeno delay de resposta

      // Limpar o campo de entrada
      inputField.value = "";
  }
}

// Função para adicionar mensagens ao chat
function addMessageToChat(sender, message) {
  const chatMessages = document.querySelector(".chat-messages");
  const messageElement = document.createElement("div");

  messageElement.classList.add("message");
  messageElement.classList.add(sender);
  messageElement.textContent = message;

  chatMessages.appendChild(messageElement);

  // Rolar para baixo automaticamente
  chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Event listener para o botão de enviar
document.querySelector(".chat-input button").addEventListener("click", sendMessage);

// Event listener para a tecla Enter
document.querySelector(".chat-input input").addEventListener("keypress", function (event) {
  if (event.key === "Enter") {
      sendMessage();
  }
});
