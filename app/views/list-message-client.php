<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .content {
        padding: 0;
    }
    .list-message-box{
        border-radius: 10px;
    }
    .list-message-box .header{
        border-radius: 10px 10px 0 0;
    }
    .list-message-box .search-bar input {
        border-radius: 10px;
    }
</style>
<div class="list-message-box">
    <div class="header">
        <h1>Messages</h1>
        <i class="fas fa-cog" style="cursor: pointer;"></i>
    </div>

    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Rechercher un agent...">
    </div>

    <div class="client-list" id="clientList">
        <?php if (!empty($agents)): ?>
            <?php foreach ($agents as $agent): ?>
                <div class="client-item" data-id="<?= $agent['id_agent'] ?>" data-name="<?= strtolower($agent['nom'] . ' ' . $agent['prenom']) ?>">
                    <img src="https://i.pravatar.cc/45?u=<?= $agent['id_agent'] ?>" alt="<?= $agent['nom'] ?>" class="client-avatar">
                    <div class="client-info">
                        <div class="client-name"><?= htmlspecialchars($agent['nom'] . ' ' . $agent['prenom']) ?></div>
                        <div class="last-message"><?= htmlspecialchars($agent['last_message'] ?? 'Dernier message...') ?></div>
                    </div>
                    <div class="message-info">
                        <!-- Tu peux ajouter ici le temps, unread, etc. -->
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="padding: 20px; text-align: center; color: #666;">Aucun agent trouvé</div>
        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        document.querySelectorAll('.client-item').forEach(item => {
            const name = item.getAttribute('data-name');
            item.style.display = name.includes(searchTerm) ? '' : 'none';
        });
    });

    document.querySelectorAll('.client-item').forEach(item => {
        item.addEventListener('click', function() {
            const agentId = this.getAttribute('data-id');
            window.location.href = `messageClient?agent_id=${agentId}`;
        });
    });

    // Simulation de recherche
    document.querySelector('.search-bar input').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filteredClients = clients.filter(client =>
            client.name.toLowerCase().includes(searchTerm) ||
            client.lastMessage.toLowerCase().includes(searchTerm)
        );

        clientList.innerHTML = '';

        if (filteredClients.length === 0) {
            clientList.innerHTML = '<div style="padding: 20px; text-align: center; color: #666;">Aucun client trouvé</div>';
        } else {
            filteredClients.forEach(client => {
                const clientItem = document.createElement('div');
                clientItem.className = 'client-item';
                clientItem.innerHTML = `
                        <img src="${client.avatar}" alt="${client.name}" class="client-avatar">
                        <div class="client-info">
                            <div class="client-name">${client.name}</div>
                            <div class="last-message">${client.lastMessage}</div>
                        </div>
                        <div class="message-info">
                            <div class="message-time">${client.time}</div>
                            ${client.unread > 0 ? `<div class="unread-count">${client.unread}</div>` : ''}
                            ${client.hasRating ? '<div class="rating-indicator"><i class="fas fa-star"></i></div>' : ''}
                        </div>
                    `;
                clientList.appendChild(clientItem);
            });
        }
    });
</script>