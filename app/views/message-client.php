<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .content{
      padding: 0;
    }
    .chat-container {
    font-family: 'Segoe UI', sans-serif;
    font-size: 18px;
    border-radius: 10px;
    background-color: #F0F4FA;
    display: flex;
    flex-direction: column;
    height: 100%;
    overflow: hidden;
    }

.chat-header {
  display: flex;
  align-items: center;
  padding: 15px 20px;
  background-color: #ffffff;
  border-bottom: 1px solid #ccc;
  color: #021734;
}

.back-button {
  cursor: pointer;
  margin-right: 15px;
  font-size: 20px;
  color: #666;
}

.back-button:hover {
  color: #0084ff;
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
  position: relative;
}

.message.left {
  background-color: #e4e6eb;
  color: #021734;
}

.message.right {
  background-color: #13325E;
  color: white;
}

.message.rating-message {
  background-color: #F9DC5A;
  color: #13325E;
}

.rating-stars {
  color: #13325E;
  margin-bottom: 5px;
  font-size: 24px;
  letter-spacing: 2px;
}

.message .send-button {
  position: absolute;
  top: -10px;
  right: -10px;
  background-color: #F9DC5A;
  border: none;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 12px;
  color: #13325E;
}

.message .send-button:hover {
  background-color: #f4d03f;
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
  background-color: #13325E;
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

.rate-button {
  background-color: #F9DC5A;
  color: #13325E;
  border: none;
  padding: 8px 15px;
  border-radius: 5px;
  cursor: pointer;
  margin-left: auto;
  margin-right: 15px;
  font-weight: bold;
}

/* Styles pour le formulaire d'évaluation */
.rating-form {
  display: flex;
  flex-direction: column;
  background-color: #e4e6eb;
  padding: 15px;
  width: 25%;
  border-radius: 15px;
  margin-bottom: 15px;
  position: absolute;
  right: 25px;
}

.rating-stars-input {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin: 10px 0;
}

.rating-stars-input i {
  font-size: 24px;
  color: #13325E;
  cursor: pointer;
}

.rating-stars-input i.active {
  color: #FFD700;
}

.rating-comment {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border-radius: 10px;
  border: 1px solid #13325E;
  resize: none;
  font-family: inherit;
  font-size: 16px;
}

.rating-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

.rating-buttons button {
  padding: 8px 15px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  font-weight: bold;
}

.rating-buttons .cancel {
  background-color: #e4e6eb;
  color: #13325E;
}

.rating-buttons .submit {
  background-color: #13325E;
  color: white;
}
</style>

<div class="chat-container">
  <!-- En-tête avec bouton "Envoyer note" -->
  <div class="chat-header">
    <i class="fas fa-arrow-left back-button" onclick="history.back()"></i>
    <img src="https://i.pravatar.cc/45?img=2" alt="Destinataire">
    <div class="name">Jean Rakoto</div>
    <button class="rate-button" onclick="showRatingForm()">
      <i class="fas fa-star"></i> Envoyer note
    </button>
  </div>

  <!-- Zone des messages -->
  <div class="chat-messages" id="chatMessages">
    <!-- L'évaluation sera affichée ici comme un message -->
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

  <!-- Zone de saisie -->
  <div class="chat-box">
    <textarea id="messageInput" placeholder="Écrire un message..." rows="1"></textarea>
    <button onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
  </div>

  <!-- Formulaire d'évaluation -->
  <div id="ratingFormContainer" class="rating-form" style="display: none;">
    <div style="text-align: center; font-weight: bold; color: #13325E;">Noter la conversation</div>
    <div class="rating-stars-input">
      <i class="fas fa-star" data-rating="1"></i>
      <i class="fas fa-star" data-rating="2"></i>
      <i class="fas fa-star" data-rating="3"></i>
      <i class="fas fa-star" data-rating="4"></i>
      <i class="fas fa-star" data-rating="5"></i>
    </div>
    <textarea id="ratingCommentInput" class="rating-comment" placeholder="Laissez un commentaire..." rows="3"></textarea>
    <div class="rating-buttons">
      <button class="cancel" onclick="cancelRating()">Annuler</button>
      <button class="submit" onclick="submitRating()">Envoyer</button>
    </div>
  </div>
</div>

<script>
  const messages = [
    { user: 'user1', text: 'Salut, tu es dispo ce soir ?', avatar: 'https://i.pravatar.cc/45?img=1' },
    { user: 'user2', text: 'Oui, je finis à 19h 😊', avatar: 'https://i.pravatar.cc/45?img=2' }
  ];

  const chatMessages = document.getElementById('chatMessages');
  const messageInput = document.getElementById('messageInput');
  const ratingFormContainer = document.getElementById('ratingFormContainer');
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
    
    // Ajouter le formulaire ou le message d'évaluation si nécessaire
    if (ratingMessageContainer.style.display !== 'none') {
      chatMessages.appendChild(ratingMessageContainer);
    } else if (ratingFormContainer.style.display !== 'none') {
      chatMessages.appendChild(ratingFormContainer);
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

//   Gestion de l'évaluation
  function showRatingForm() {
    ratingFormContainer.style.display = 'block';
    ratingMessageContainer.style.display = 'none';
    renderMessages();
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  function cancelRating() {
    ratingFormContainer.style.display = 'none';
    renderMessages();
  }

  function submitRating() {
    const comment = document.getElementById('ratingCommentInput').value;
    
    if (currentRating === 0) {
      alert('Veuillez sélectionner une note');
      return;
    }

    // Afficher l'évaluation comme un message
    ratingStarsDisplay.innerHTML = '★'.repeat(currentRating) + '☆'.repeat(5 - currentRating);
    ratingCommentDisplay.textContent = comment || 'Aucun commentaire';
    
    ratingFormContainer.style.display = 'none';
    ratingMessageContainer.style.display = 'block';
    
    renderMessages();
    
    // Réinitialiser le formulaire
    document.getElementById('ratingCommentInput').value = '';
    currentRating = 0;
    updateStarRating();
    
    // Faire défiler vers le bas pour voir le message d'évaluation
    setTimeout(() => {
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }, 100);
  }

  // Gestion des étoiles
  document.querySelectorAll('.rating-stars-input i').forEach(star => {
    star.addEventListener('click', function() {
      currentRating = parseInt(this.getAttribute('data-rating'));
      updateStarRating();
    });
  });

  function updateStarRating() {
    const stars = document.querySelectorAll('.rating-stars-input i');
    stars.forEach(star => {
      const starValue = parseInt(star.getAttribute('data-rating'));
      if (starValue <= currentRating) {
        star.classList.add('active');
      } else {
        star.classList.remove('active');
      }
    });
  }

  // Initialisation
  renderMessages();
</script>