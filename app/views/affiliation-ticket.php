<div class="affiliation-ticket">
    <div class="affiliation-grid">
        <div class="ticket-details">
            <h2>Affilier un ticket</h2>
            <div class="ticket-card email-style">
                <div class="email-header">
                    <img src="https://i.pravatar.cc/45?img=1" alt="Client" class="sender-avatar">
                    <div class="email-meta">
                        <p class="sender">Jean Dupont</p>
                        <p class="date">01/01/2024</p>
                    </div>
                </div>
                <div class="email-content">
                    <h3 class="email-subject">Problème de connexion à l'application mobile - Urgent</h3>
                    <p class="email-category">Catégorie: Support technique</p>
                    <div class="email-body">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                </div>
            </div>
        </div>

        <div class="agents-section">
            <h2>Agents disponibles</h2>
            <div class="agents-list">
                <div class="agent-card" data-id="1" data-name="Marie Martin">
                    <img src="https://i.pravatar.cc/45?img=2" class="agent-image" alt="Marie">
                    <span class="agent-name">Marie Martin</span>
                </div>
                <div class="agent-card" data-id="2" data-name="Pierre Durant">
                    <img src="https://i.pravatar.cc/45?img=3" class="agent-image" alt="Pierre">
                    <span class="agent-name">Pierre Durant</span>
                </div>
                <div class="agent-card" data-id="3" data-name="Sophie Bernard">
                    <img src="https://i.pravatar.cc/45?img=4" class="agent-image" alt="Sophie">
                    <span class="agent-name">Sophie Bernard</span>
                </div>
                <div class="agent-card" data-id="4" data-name="Paul Dubois">
                    <img src="https://i.pravatar.cc/45?img=5" class="agent-image" alt="Paul">
                    <span class="agent-name">Paul Dubois</span>
                </div>
                <div class="agent-card" data-id="5" data-name="Julie Martin">
                    <img src="https://i.pravatar.cc/45?img=6" class="agent-image" alt="Julie">
                    <span class="agent-name">Julie Martin</span>
                </div>
            </div>
        </div>
    </div>

    <div class="affiliation-form">
        <div class="form-group">
            <label>Agent sélectionné</label>
            <select id="agent_select" required>
                <option value="">Sélectionner un agent</option>
                <option value="1">Marie Martin</option>
                <option value="2">Pierre Durant</option>
                <option value="3">Sophie Bernard</option>
            </select>
        </div>
        <div class="form-group">
            <label for="duree">Durée (heures)</label>
            <input type="number" id="duree" onchange="calculateTotal()">
        </div>
        <div class="form-group">
            <label for="cout_horaire">Coût horaire (Ar)</label>
            <input type="number" id="cout_horaire" onchange="calculateTotal()">
        </div>
        <div class="total-section">
            <h4>Total: <span id="total">0</span> Ar</h4>
        </div>
        <button class="submit-btn">Affilier le ticket</button>
    </div>
</div>


<script>
function calculateTotal() {
    const duree = document.getElementById('duree').value || 0;
    const coutHoraire = document.getElementById('cout_horaire').value || 0;
    const total = duree * coutHoraire;
    document.getElementById('total').textContent = total.toFixed(2);
}

document.querySelectorAll('.agent-card').forEach(card => {
    card.addEventListener('click', () => {
        const agentId = card.dataset.id;
        const agentName = card.dataset.name;
        const select = document.getElementById('agent_select');
        select.value = agentId;
    });
});
</script>
