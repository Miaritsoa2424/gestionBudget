
<style>
.filters {
    background: #f7fafd;
    border: 1px solid #e0e6ed;
    border-radius: 8px;
    padding: 12px 18px;
    display: inline-block;
    margin-top: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}
.filters label {
    font-size: 1.1em;
    color: #13325E;
    vertical-align: middle;
}
.filters select {
    padding: 6px 14px;
    margin-right: 8px;
    border-radius: 6px;
    border: 1px solid #bfc9d4;
    background: #fff;
    font-size: 1em;
    color: #13325E;
    outline: none;
    transition: border-color 0.2s;
}
.filters select:focus {
    border-color: #13325E;
}
</style>
<div class="header-actions">
    <h1>Fiche de paie de l'agent</h1>
    <div class="filters">
        <form method="get" action="">
            <label for="month" style="margin-right:8px;">
                <i class="fa fa-calendar"></i>
            </label>
            <select name="month" id="month" onchange="this.form.submit()">
                <?php for($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= sprintf("%02d", $m) ?>" <?= $currentMonth == $m ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                    </option>
                <?php endfor; ?>
            </select>
            <label for="year" style="margin:0 8px 0 16px;">
                <i class="fa fa-calendar-alt"></i>
            </label>
            <select name="year" id="year" onchange="this.form.submit()">
                <?php for($y = date('Y'); $y >= date('Y')-2; $y--): ?>
                    <option value="<?= $y ?>" <?= $currentYear == $y ? 'selected' : '' ?>>
                        <?= $y ?>
                    </option>
                <?php endfor; ?>
            </select>
        </form>
    </div>
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
