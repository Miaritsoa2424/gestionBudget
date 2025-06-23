<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Discussion Messenger-like</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      background-color: #f0f2f5;
      font-family: 'Segoe UI', sans-serif;
      font-size: 18px;
      margin: 0;
      padding: 20px;
      color: #050505;
    }

    .chat-container {
      border: 10px solid #d1d1d1;
      border-radius: 15px;
      background-color: #fff;
      padding: 0;
      max-width: 600px;
      margin: 0 auto;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      display: flex;
      flex-direction: column;
      height: 90vh;
      overflow: hidden;
    }

    .chat-header {
      display: flex;
      align-items: center;
      padding: 15px 20px;
      background-color: #ffffff;
      border-bottom: 1px solid #ccc;
    }

    .chat-header img {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .chat-header .name {
      font-weight: bold;
      font-size: 20px;
    }

    .chat-messages {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
      background-color: #f0f2f5;
    }

    .user {
      display: flex;
      align-items: flex-start;
      margin-bottom: 15px;
    }

    .user.right {
      flex-direction: row-reverse;
    }

    .user img {
      width: 45px;
      height: 45px;
      border-radius: 50%;
      margin: 0 10px;
    }

    .message {
      padding: 12px 16px;
      border-radius: 20px;
      max-width: 70%;
      line-height: 1.4;
      word-wrap: break-word;
      word-break: break-word;
      overflow-wrap: break-word;
    }

    .message.left {
      background-color: #e4e6eb;
      color: #050505;
    }

    .message.right {
      background-color: #0084ff;
      color: white;
    }

    .chat-box {
      display: flex;
      gap: 10px;
      border-top: 1px solid #ccc;
      padding: 15px 20px;
      align-items: center;
      background-color: #ffffff;
    }

    .chat-box textarea {
      flex: 1;
      padding: 10px 15px;
      font-size: 18px;
      border: 1px solid #ccc;
      border-radius: 20px;
      outline: none;
      resize: none;
      min-height: 40px;
      max-height: 150px;
      overflow-y: auto;
    }

    .chat-box button {
      background-color: #0084ff;
      border: none;
      color: white;
      padding: 10px 16px;
      font-size: 18px;
      border-radius: 50px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .chat-box button i {
      margin-left: 4px;
    }
  </style>
</head>
<body>

  <div class="chat-container">
    <!-- En-tête -->
    <div class="chat-header">
      <img src="https://i.pravatar.cc/45?img=2" alt="Destinataire">
      <div class="name">Jean Rakoto</div>
    </div>

    <!-- Zone des messages -->
    <div class="chat-messages" id="chatMessages"></div>

    <!-- Zone de saisie -->
    <div class="chat-box">
      <textarea id="messageInput" placeholder="Écrire un message..." rows="1"></textarea>
      <button onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
    </div>
  </div>

  <script>
    const messages = [
      { user: 'user1', text: 'Salut, tu es dispo ce soir ?', avatar: 'https://i.pravatar.cc/45?img=1' },
      { user: 'user2', text: 'Oui, je finis à 19h 😊', avatar: 'https://i.pravatar.cc/45?img=2' }
    ];

    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');

    function renderMessages() {
      chatMessages.innerHTML = '';
      messages.forEach(msg => {
        const msgDiv = document.createElement('div');
        msgDiv.className = `user ${msg.user === 'user2' ? 'right' : ''}`;
        msgDiv.innerHTML = `
          <img src="${msg.avatar}" alt="${msg.user}">
          <div class="message ${msg.user === 'user2' ? 'right' : 'left'}">${msg.text}</div>
        `;
        chatMessages.appendChild(msgDiv);
      });
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function sendMessage() {
      const text = messageInput.value.trim();
      if (text !== '') {
        messages.push({
          user: 'user2',
          text: text,
          avatar: 'https://i.pravatar.cc/45?img=2'
        });
        messages.push({
            user: 'user1',
            text: 'Merci pour ta réponse ! On se voit ce soir alors.',
              avatar: 'https://i.pravatar.cc/45?img=2'
        });
        messageInput.value = '';
        renderMessages();
        messageInput.style.height = 'auto';
      }
    }

    // Entrée pour envoyer
    messageInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });

    // Auto-ajustement de la hauteur du textarea
    messageInput.addEventListener('input', function () {
      this.style.height = 'auto';
      this.style.height = this.scrollHeight + 'px';
    });

    renderMessages();
  </script>

</body>
</html>
