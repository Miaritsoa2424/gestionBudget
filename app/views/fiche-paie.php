<div class="header-actions">
    <h1>Fiche de paie - <?= htmlspecialchars($nom) ?></h1>
    <div class="filters">
        <form method="get" action="">
            <select name="month" onchange="this.form.submit()">
                <?php for($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= sprintf("%02d", $m) ?>" <?= $currentMonth == $m ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                    </option>
                <?php endfor; ?>
            </select>
            <select name="year" onchange="this.form.submit()">
                <?php for($y = date('Y'); $y >= date('Y')-2; $y--): ?>
                    <option value="<?= $y ?>" <?= $currentYear == $y ? 'selected' : '' ?>>
                        <?= $y ?>
                    </option>
                <?php endfor; ?>
            </select>
        </form>
    </div>
    <a href="list-agent" class="btn btn-secondary">Retour</a>
</div>

<div class="fiche-content">
    <table class="results-table">
        <thead>
            <tr>
                <th>ID Ticket</th>
                <th>Date</th>
                <th>Sujet</th>
                <th>Coût horaire</th>
                <th>Durée (heures)</th>
                <th>Montant total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($tickets)): ?>
                <tr class="empty">
                    <td colspan="6">Aucun ticket trouvé pour cet agent.</td>
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
                        <td><?= date('d/m/Y', strtotime($ticket['date_creation'])) ?></td>
                        <td><?= htmlspecialchars($ticket['sujet']) ?></td>
                        <td><?= number_format($ticket['cout_horaire'], 2) ?> €</td>
                        <td><?= $ticket['duree'] ?></td>
                        <td><?= number_format($montantTicket, 2) ?> €</td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row"></tr>
                    <td colspan="5" class="text-right"><strong>Total</strong></td>
                    <td><strong><?= number_format($totalGeneral, 2) ?> €</strong></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
