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
    height: 85vh;
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
  width: 70%;
  border-radius: 15px;
  margin: 15px auto;
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
  box-sizing: border-box;
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
  <div class="chat-header">
    <i class="fas fa-arrow-left back-button" onclick="history.back()"></i>
    <img src="https://i.pravatar.cc/45?u=<?= $agent ? $agent->getIdAgent() : 0 ?>" alt="Destinataire">
    <div class="name"><?= $agent ? htmlspecialchars($agent->getNom() . ' ' . $agent->getPrenom()) : '' ?></div>
  </div>
  <div class="chat-messages" id="chatMessages">
    <?php if (!empty($messages)): ?>
      <?php foreach ($messages as $msg): ?>
        <?php
          $isClient = ($msg['client_agent'] == 0); // 0 = client, 1 = agent
          $avatar = $isClient
            ? 'https://i.pravatar.cc/45?img=2'
            : 'https://i.pravatar.cc/45?u=' . ($agent ? $agent->getIdAgent() : 0);
          $showForward = !$isClient;
        ?>
        <div class="user <?= $isClient ? 'right' : 'left' ?>">
          <img src="<?= $avatar ?>" alt="">
          <div class="message">
            <?= htmlspecialchars($msg['contenu'] ?? '') ?>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if ($msg['discu_termine'] == 1): ?>
          <div id="ratingFormContainer" class="rating-form">
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
      <?php endif; ?>
    <?php else: ?>
      <div style="text-align:center;color:#888;">Aucun message pour cette conversation.</div>
    <?php endif; ?>
  </div>

    <form id="sendMessageForm" style="display:none;">
        <input type="hidden" name="id_client" value="<?= $agent ? $agent->getIdAgent() : 0 ?>">
        <input type="hidden" name="contenu" id="hiddenContenu">
    </form>

  <div class="chat-box">
    <textarea id="messageInput" placeholder="Écrire un message..." rows="1"></textarea>
    <button onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
  </div>
</div>

<script>
  const chatMessages = document.getElementById('chatMessages');
  const messageInput = document.getElementById('messageInput');

  function sendMessage() {
    const text = messageInput.value.trim();
    if (text === '') return;

    const formData = new FormData();
    formData.append('id_agent', <?= $agent ? $agent->getIdAgent() : 0 ?>);
    formData.append('contenu', text);

    fetch('send-message-client', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const msgDiv = document.createElement('div');
            msgDiv.className = 'user right';
            msgDiv.innerHTML = `
                <img src="https://i.pravatar.cc/45?img=2" alt="">
                <div class="message">${escapeHtml(text)}</div>
            `;
            chatMessages.appendChild(msgDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            messageInput.value = '';
            messageInput.style.height = 'auto';
        } else {
            
            alert('Erreur lors de l\'envoi du message.');
        }
    })
    .catch(() => {
        alert('Erreur lors de l\'envoi du message.');
    });
  }

  function escapeHtml(text) {
      var div = document.createElement('div');
      div.innerText = text;
      return div.innerHTML;
  }

  function disableForwardButtons() {
      document.querySelectorAll('.send-button').forEach(btn => {
          btn.disabled = true;
          btn.classList.add('disabled');
          btn.title = "Discussion terminée";
      });
  }

function submitRating() {
    const stars = document.querySelectorAll('.rating-stars-input i.active').length;
    const comment = document.getElementById('ratingCommentInput').value.trim();
    if (stars === 0) {
        alert('Merci de donner une note.');
        return;
    }
    const idAgent = <?= $agent ? $agent->getIdAgent() : 0 ?>;
    // Envoie la note et le commentaire au backend
    fetch('submit-rating', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            id_agent: idAgent,
            note: stars,
            commentaire: comment
        })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            alert('Merci pour votre retour !');
            document.getElementById('ratingFormContainer').style.display = 'none';
        } else {
            alert('Erreur lors de l\'envoi de la note.');
        }
    })
    .catch(() => alert('Erreur lors de l\'envoi de la note.'));
}

  messageInput.addEventListener('input', function () {
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
  });

  document.querySelectorAll('.rating-stars-input i').forEach(star => {
    star.addEventListener('click', function() {
        const rating = parseInt(this.getAttribute('data-rating'));
        document.querySelectorAll('.rating-stars-input i').forEach((s, idx) => {
            s.classList.toggle('active', idx < rating);
        });
    });
});
</script>