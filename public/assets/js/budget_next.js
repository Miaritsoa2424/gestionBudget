let currentPage = 1;
const rowsPerPage = 1; // Une table par page
const tables = document.querySelectorAll('.tablePage'); // Récupère toutes les tables
const totalPages = Math.ceil(tables.length / rowsPerPage); // Calcul du nombre total de pages

// Affiche la table correspondant à la page actuelle
function displayTable(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    // Masquer toutes les tables
    tables.forEach((table, index) => {
        if (index >= start && index < end) {
            table.style.display = 'block';
        } else {
            table.style.display = 'none';
        }
    });

    // Met à jour le texte de la page
    document.getElementById('pageNumber').innerText = `Page ${page}`;
}

// Fonction pour changer de page
function changePage(direction) {
    const newPage = currentPage + direction;

    if (newPage >= 1 && newPage <= totalPages) {
        currentPage = newPage;
        displayTable(currentPage);
    }
}

// Initialisation
displayTable(currentPage);