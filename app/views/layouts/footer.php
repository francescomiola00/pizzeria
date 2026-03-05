<footer class="footer">
    <div class="footer-inner">
        <div>
            <div class="footer-brand"><?= PIZZERIA_NAME ?></div>
            <p class="footer-text">Autentica pizza napoletana a Caldogno, Vicenza. Impasto a lenta lievitazione, ingredienti selezionati ogni giorno.</p>
        </div>
        <div>
            <div class="footer-title">Navigazione</div>
            <ul class="footer-list">
                <li><a href="<?= BASE_URL ?>/#about">Chi Siamo</a></li>
                <li><a href="<?= BASE_URL ?>/menu">Menu</a></li>
                <li><a href="<?= BASE_URL ?>/#gallery">Galleria</a></li>
                <li><a href="<?= BASE_URL ?>/#contacts">Contatti</a></li>
            </ul>
        </div>
        <div>
            <div class="footer-title">Informazioni</div>
            <ul class="footer-list">
                <li>📍 <?= PIZZERIA_ADDRESS ?></li>
                <li>📞 <?= PIZZERIA_PHONE ?></li>
                <li>🕐 Lun, Mer-Dom: 17:00–22:00</li>
                <li>❌ Martedì: Chiuso</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> <?= PIZZERIA_NAME ?>. Tutti i diritti riservati.</p>
        <p>Realizzato con ❤ a Caldogno</p>
    </div>
</footer>

<script>
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1 });
document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
</script>
</body>
</html>