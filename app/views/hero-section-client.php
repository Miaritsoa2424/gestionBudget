<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<section class="hero-section">
    <div class="hero-content">
        <h1>Votre avis compte pour nous</h1>
        <h2>Ensemble, améliorons nos services</h2>
        <p>Aidez-nous à améliorer nos services en partageant votre expérience avec nos produits. Votre feedback est essentiel pour notre croissance continue et le développement de solutions qui répondent parfaitement à vos besoins.</p>
        <p class="sub-text">✓ Rapport simple et rapide<br>
           ✓ Suivi personnalisé<br>
           ✓ Réponse sous 24h</p>
        <button class="report-btn">
            <a href="<?= Flight::get('flight.base_url') ?>/report-client" style="text-decoration: none; color: white;">
            <i class="fas fa-paper-plane"></i>    
            Envoyer un report</a>
        </button>
    </div>
    <div class="hero-image">
        
    </div>
</section>

<style>
    .hero-section {
        display: flex;
        justify-content: space-between;
        align-items: stretch;
        padding: 0;
        background-color: #EAF9FF;
    }

    .hero-content {
        flex: 0 0 50%;
        padding: 4rem;
    }

    h1 {
        color: #021734;
        font-size: 3.2rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    h2 {
        color: #021734;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
        font-weight: 500;
        opacity: 0.9;
    }

    p {
        color: #555;
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .sub-text {
        color: #021734;
        font-size: 1.1rem;
        line-height: 2;
        margin-bottom: 2rem;
        opacity: 0.8;
    }

    .report-btn {
        background-color: #021734;
        color: white;
        padding: 1rem 2.5rem;
        border: none;
        border-radius: 5px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: opacity 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .report-btn:hover {
        opacity: 0.9;
    }

    .report-btn i {
        font-size: 1rem;
    }

    .hero-image {
        flex: 1;
        padding: 0;
        background-color:rgb(70, 104, 124);
    }

    @media (max-width: 768px) {
        .hero-section {
            flex-direction: column;
            min-height: auto;
        }

        .hero-content, .hero-image {
            flex: 0 0 100%;
            padding: 2rem;
        }

        .image-placeholder {
            height: 300px;
            border-left: none;
            border: 2px dashed #021734;
            border-radius: 10px;
        }
    }
</style>
