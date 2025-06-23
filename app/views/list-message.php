<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .content {
        padding: 0;
    }
</style>
<div class="list-message-box">
    <div class="header">
        <h1>Messages</h1>
        <i class="fas fa-cog" style="cursor: pointer;"></i>
    </div>

    <div class="search-bar">
        <input type="text" placeholder="Rechercher un client...">
    </div>

    <div class="client-list" id="clientList">
        <!-- Les clients seront ajoutés ici dynamiquement -->
    </div>
</div>

<script>
    // Données des clients et leurs derniers messages
    const clients = [{
            id: 1,
            name: "Jean Rakoto",
            avatar: "https://i.pravatar.cc/45?img=2",
            lastMessage: "Oui, je finis à 19h 😊",
            time: "10:30",
            unread: 2,
            hasRating: true
        },
        {
            id: 2,
            name: "Marie Claire",
            avatar: "https://i.pravatar.cc/45?img=5",
            lastMessage: "Je vous enverrai les documents demain",
            time: "Hier",
            unread: 0,
            hasRating: false
        },
        {
            id: 3,
            name: "Paul Randria",
            avatar: "https://i.pravatar.cc/45?img=8",
            lastMessage: "Merci pour votre aide!",
            time: "Hier",
            unread: 0,
            hasRating: true
        },
        {
            id: 4,
            name: "Sophie Ranaivo",
            avatar: "https://i.pravatar.cc/45?img=11",
            lastMessage: "Pouvez-vous m'envoyer plus d'informations?",
            time: "Lundi",
            unread: 3,
            hasRating: false
        },
        {
            id: 5,
            name: "Luc Andria",
            avatar: "https://i.pravatar.cc/45?img=13",
            lastMessage: "Je suis intéressé par votre offre",
            time: "Dimanche",
            unread: 0,
            hasRating: true
        }
    ];

    const clientList = document.getElementById('clientList');

    function renderClientList() {
        clientList.innerHTML = '';

        clients.forEach(client => {
            const clientItem = document.createElement('div');
            clientItem.className = 'client-item';

            // Ajouter un gestionnaire de clic pour ouvrir le chat
            clientItem.addEventListener('click', () => {
                window.location.href = `message`;
            });

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

    // Initialisation
    renderClientList();

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