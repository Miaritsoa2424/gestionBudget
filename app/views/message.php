<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .content{
      padding: 0;
    }
    
</style>

<div class="chat-container">
  <div class="chat-header">
    <i class="fas fa-arrow-left back-button" onclick="history.back()"></i>
    <img src="https://i.pravatar.cc/45?img=2" alt="Destinataire">
    <div class="name">Jean Rakoto</div>
    <button class="rate-button" onclick="sendRatingMessage()">
      <i class="fas fa-star"></i> Envoyer note
    </button>
  </div>

  <div class="chat-messages" id="chatMessages">
    <div id="ratingMessageContainer" style="display: none;">
      <div class="user right">
        <img src="https://i.pravatar.cc/45?img=2" alt="Vous">
        <div class="message rating-message">
          <div id="ratingStarsDisplay" class="rating-stars"></div>
          <div id="ratingCommentDisplay"></div>
        </div>
      </div>
    </div>
  </div>

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
  const ratingMessageContainer = document.getElementById('ratingMessageContainer');
  const ratingStarsDisplay = document.getElementById('ratingStarsDisplay');
  const ratingCommentDisplay = document.getElementById('ratingCommentDisplay');
  let currentRating = 0;

  function renderMessages() {
    chatMessages.innerHTML = '';
    messages.forEach(msg => {
      const msgDiv = document.createElement('div');
      msgDiv.className = `user ${msg.user === 'user2' ? 'right' : ''}`;
      const messageClass = msg.isRating ? 'rating-message' : (msg.user === 'user2' ? 'right' : 'left');
      const sendButton = msg.user === 'user1' ? 
        `<button class="send-button" onclick="forwardMessage('${msg.text}')">
           <i class="fas fa-share"></i>
         </button>` : '';
      msgDiv.innerHTML = `
        <img src="${msg.avatar}" alt="${msg.user}">
        <div class="message ${messageClass}">
          ${msg.text}
          ${sendButton}
        </div>
      `;
      chatMessages.appendChild(msgDiv);
    });
    
    if (ratingMessageContainer.style.display !== 'none') {
      chatMessages.appendChild(ratingMessageContainer);
    }
    
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
      messageInput.value = '';
      renderMessages();
      messageInput.style.height = 'auto';
    }
  }

  function forwardMessage(text) {
    alert('Message transféré: ' + text);
  }

  function sendRatingMessage() {
    messages.push({
      user: 'user2',
      text: `⭐⭐⭐⭐⭐\nFormulaire d'évaluation envoyé`,
      avatar: 'https://i.pravatar.cc/45?img=2'
    });
    renderMessages();
  }

  messageInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      sendMessage();
    }
  });

  messageInput.addEventListener('input', function () {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
  });

  renderMessages();
</script>