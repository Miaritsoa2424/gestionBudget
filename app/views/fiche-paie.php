<div class="header-actions">
    <h1>Fiche de paie - <?= htmlspecialchars($nom) ?></h1>
    <a href="list-agent" class="btn btn-secondary">Retour</a>
</div>

<div class="fiche-content">
    <table class="results-table">
        <thead>
            <tr>
                <th>ID Ticket</th>
                <th>Sujet</th>
                <th>Coût horaire</th>
                <th>Durée (heures)</th>
                <th>Montant total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($tickets)): ?>
                <tr class="empty">
                    <td colspan="5">Aucun ticket trouvé pour cet agent.</td>
                </tr>
            <?php else: ?>
                <?php $totalGeneral = 0; ?>
                <?php foreach ($tickets as $ticket): ?>
                    <?php 
                        $montantTicket = $ticket['cout_horaire'] * $ticket['duree'];
                        $totalGeneral += $montantTicket;
                    ?>
                    <tr>
                        <td><?= $ticket['id_ticket'] ?></td>
                        <td><?= htmlspecialchars($ticket['sujet']) ?></td>
                        <td><?= number_format($ticket['cout_horaire'], 2) ?> €</td>
                        <td><?= $ticket['duree'] ?></td>
                        <td><?= number_format($montantTicket, 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                    <td><strong><?= number_format($totalGeneral, 2) ?> €</strong></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
