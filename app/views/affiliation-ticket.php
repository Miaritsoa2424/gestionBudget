<div class="affiliation-ticket">
    <div class="affiliation-grid">
        <div class="ticket-details">
            <h2>Affilier un ticket</h2>
            <div class="ticket-card email-style">
                <div class="email-header">
                    <img src="https://i.pravatar.cc/45?img=1" alt="Client" class="sender-avatar">
                    <div class="email-meta">
                        <p class="sender"><?= $client->getNom().' '.$client->getPrenom()?></p>
                        <p class="date">
                            <?= date('Y-m-d', strtotime($ticket->getDateCreation())) ?>
                        </p>
                    </div>
                </div>
                <div class="email-content">
                    <h3 class="email-subject"><?= $ticket->getSujet()?></h3>
                    <p class="email-category">Catégorie: <?= $nomCategorie?></p>
                    <div class="email-body">
                        <?= $description ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="agents-section">
            <h2>Agents disponibles</h2>
            <!-- Champ de recherche pour filtrer les agents -->
            <div class="form-group">
                <input type="text" id="agent_search" placeholder="Rechercher un agent...">
            </div>
            <div class="agents-list">
                <?php foreach ($agents as $agent): ?>
                <div class="agent-card" data-id="<?= $agent->getIdAgent() ?>" data-name="<?= $agent->getNom() ?>">
                    <img src="https://i.pravatar.cc/45?img=2" class="agent-image" alt="<?= $agent->getNom() ?>">
                    <span class="agent-name"><?= $agent->getNom(). ' ' . $agent->getPrenom() ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <form class="affiliation-form" action="<?php echo Flight::get('flight.base_url')?>/doAffiliation" method="post">
        <div class="form-group">
            <label>Agent sélectionné</label>
            <select id="agent_select" name="agent_id" required>
                <option value="">Sélectionner un agent</option>
                <?php foreach ($agents as $agent): ?>
                    <option value="<?= $agent->getIdAgent() ?>">
                        <?= $agent->getNom() . ' ' . $agent->getPrenom() ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="duree">Durée (heures)</label>
            <input type="number" id="duree" name="duree" onchange="calculateTotal()" required>
        </div>
        <div class="form-group">
            <label for="cout_horaire">Coût horaire (Ar)</label>
            <input type="number" id="cout_horaire" name="cout_horaire" onchange="calculateTotal()" required>
        </div>
        <div class="total-section">
            <h4>Total: <span id="total">0</span> Ar</h4>
        </div>
        <input type="hidden" name="ticket_id" value="<?= $ticket->getId() ?>">
        <button class="submit-btn" type="submit">Affilier le ticket</button>
    </form>
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
        const select = document.getElementById('agent_select');
        select.value = agentId;
    });
});

// Recherche dynamique des agents
document.getElementById('agent_search').addEventListener('input', function() {
    const search = this.value.toLowerCase();
    document.querySelectorAll('.agent-card').forEach(card => {
        const name = card.querySelector('.agent-name').textContent.toLowerCase();
        if (name.includes(search)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>

<?php if (!empty($successMessage)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
<?php endif; ?>
<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
<?php endif; ?>
