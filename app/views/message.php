
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .content{
      padding: 0;
    }
    
</style>

<div class="chat-container">
  <div class="chat-header">
    <i class="fas fa-arrow-left back-button" onclick="history.back()"></i>
    <img src="https://i.pravatar.cc/45?u=<?= $client ? $client->getId() : 0 ?>" alt="Destinataire">
    <div class="name"><?= $client ? htmlspecialchars($client->getNom() . ' ' . $client->getPrenom()) : '' ?></div>
    <button class="rate-button" onclick="sendRatingMessage()">
      <i class="fas fa-star"></i> Envoyer note
    </button>
  </div>
<div class="chat-messages" id="chatMessages">
  <?php if (!empty($messages)): 
    ?>
    <?php foreach ($messages as $msg): ?>
      <?php
        $isAgent = ($msg['client_agent'] == 1);
        // $isAgent = ($msg['id_envoyeur'] == $_SESSION['id_agent']);
        $avatar = $isAgent
          ? 'https://i.pravatar.cc/45?img=2'
          : 'https://i.pravatar.cc/45?u=' . ($client ? $client->getId() : 0);
        // Afficher le bouton seulement pour les messages du client
        $showForward = !$isAgent;
      ?>
      <div class="user <?= $isAgent ? 'right' : 'left' ?>">
        <img src="<?= $avatar ?>" alt="">
        <div class="message">
          <?= htmlspecialchars($msg['contenu'] ?? '') ?>
          <?php if ($showForward): ?>
            <button class="send-button" onclick="forwardMessage('<?= htmlspecialchars(addslashes($msg['contenu'] ?? '')) ?>')">
              <i class="fas fa-share"></i>
            </button>
          <?php endif; ?>
        </div>
      </div>


    <form id="sendMessageForm" style="display:none;">
        <input type="hidden" name="id_client" value="<?= $client ? $client->getId() : 0 ?>">
        <input type="hidden" name="contenu" id="hiddenContenu">
    </form>
    <?php endforeach; ?>
  <?php else: ?>
    <div style="text-align:center;color:#888;">Aucun message pour cette conversation.</div>
  <?php endif; ?>
</div>


  <div class="chat-box">
    <textarea id="messageInput" placeholder="Écrire un message..." rows="1"></textarea>
    <button onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
  </div>
</div>


<script>

  const chatMessages = document.getElementById('chatMessages');
  const messageInput = document.getElementById('messageInput');
  const ratingMessageContainer = document.getElementById('ratingMessageContainer');
  const ratingStarsDisplay = document.getElementById('ratingStarsDisplay');
  const ratingCommentDisplay = document.getElementById('ratingCommentDisplay');
  let currentRating = 0;

  

  function sendMessage() {
    const text = messageInput.value.trim();
    if (text === '') return;

    // Prépare les données à envoyer
    const formData = new FormData();
    formData.append('id_client', <?= $client ? $client->getId() : 0 ?>);
    formData.append('contenu', text);

    fetch('send-message', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Ajoute le message dans le chat sans recharger
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
  function forwardMessage(text) {
      const idClient = <?= $client ? $client->getId() : 0 ?>;
      const formData = new FormData();
      formData.append('title', 'Transfert de message');
      formData.append('description', text);
      formData.append('id_client', idClient);

      fetch('submit-report', {
          method: 'POST',
          body: formData
      })
      .then(response => {
          // Si l'API retourne du HTML, tu peux afficher une notification ou recharger la page
          if (response.ok) {
              alert('Message transféré comme rapport client !');
          } else {
              alert('Erreur lors du transfert du message.');
          }
      })
      .catch(() => {
          alert('Erreur lors du transfert du message.');
      });
  }

  // Petite fonction pour éviter les injections HTML
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

function sendRatingMessage() {
    const idClient = <?= $client ? $client->getId() : 0 ?>;
    const formData = new FormData();
    formData.append('id_client', idClient);

    fetch('end-discussion', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Discussion terminée !');
            document.querySelector('.chat-box textarea').disabled = true;
            disableForwardButtons(); // Désactive les boutons de transfert
        } else {
            alert('Erreur lors de la terminaison de la discussion.');
        }
    })
    .catch(() => {
        alert('Erreur lors de la terminaison de la discussion.');
    });
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