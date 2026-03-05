<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Prodotti') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-brand"><?= PIZZERIA_NAME ?></div>
    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>/admin/dashboard">📊 Dashboard</a>
        <a href="<?= BASE_URL ?>/admin/categories">📂 Categorie</a>
        <a href="<?= BASE_URL ?>/admin/products" class="active">🍕 Prodotti</a>
        <a href="<?= BASE_URL ?>/admin/messages">✉️ Messaggi</a>
        <a href="<?= BASE_URL ?>/" target="_blank">🌐 Vedi sito</a>
    </nav>
    <div class="sidebar-footer"><a href="<?= BASE_URL ?>/admin/logout">← Esci</a></div>
</aside>
<div class="main">
    <div class="topbar">
        <span class="topbar-title">Prodotti</span>
        <span class="topbar-user">Benvenuto, <span><?= htmlspecialchars($username ?? '') ?></span></span>
    </div>
    <div class="content">

        <?php if (!empty($flash)): ?>
            <div class="flash flash-<?= $flash['type'] ?>">
                <?= $flash['type'] === 'success' ? '✓' : '⚠' ?> <?= htmlspecialchars($flash['msg']) ?>
            </div>
        <?php endif; ?>

        <!-- Aggiungi prodotto -->
        <div class="table-wrap" style="margin-bottom:24px;">
            <div class="table-header">
                <h2>Nuovo Prodotto</h2>
                <?php if (empty($categories)): ?>
                    <span style="font-size:.8rem;color:var(--text-muted);">⚠ Crea prima una categoria</span>
                <?php endif; ?>
            </div>
            <div style="padding:20px 24px;">
                <form method="POST" action="<?= BASE_URL ?>/admin/products/store">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div class="form-group">
                            <label>Nome prodotto *</label>
                            <input type="text" name="name" required placeholder="es. Margherita">
                        </div>
                        <div class="form-group">
                            <label>Categoria *</label>
                            <select name="category_id" required>
                                <option value="">Seleziona...</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Prezzo (€) *</label>
                            <input type="number" name="price" step="0.01" min="0" required placeholder="0.00">
                        </div>
                        <div class="form-group">
                            <label>Ordinamento</label>
                            <input type="number" name="sort_order" value="0" min="0">
                        </div>
                        <div class="form-group" style="grid-column:1/-1;">
                            <label>Descrizione</label>
                            <textarea name="description" placeholder="Ingredienti e note..."></textarea>
                        </div>
                        <div class="form-group" style="grid-column:1/-1;">
                            <label class="form-check">
                                <input type="checkbox" name="is_available" value="1" checked>
                                Disponibile nel menu
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top:8px;">+ Aggiungi Prodotto</button>
                </form>
            </div>
        </div>

        <!-- Lista prodotti -->
        <div class="table-wrap">
            <div class="table-header">
                <h2>Prodotti (<?= count($products) ?>)</h2>
            </div>
            <?php if (empty($products)): ?>
                <div class="empty">
                    <div class="empty-icon">🍕</div>
                    <p>Nessun prodotto presente.</p>
                </div>
            <?php else: ?>
            <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Prezzo</th>
                        <th>Disponibile</th>
                        <th>Ord.</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td style="color:var(--text-muted)"><?= $p['id'] ?></td>
                        <td>
                            <strong><?= htmlspecialchars($p['name']) ?></strong>
                            <?php if (!empty($p['description'])): ?>
                                <div style="font-size:.75rem;color:var(--text-muted);margin-top:2px;"><?= htmlspecialchars(mb_substr($p['description'], 0, 60)) ?><?= mb_strlen($p['description']) > 60 ? '…' : '' ?></div>
                            <?php endif; ?>
                        </td>
                        <td style="color:var(--text-muted)"><?= htmlspecialchars($p['category_name']) ?></td>
                        <td>€ <?= number_format($p['price'], 2, ',', '.') ?></td>
                        <td><span class="badge <?= $p['is_available'] ? 'badge-yes' : 'badge-no' ?>"><?= $p['is_available'] ? 'Sì' : 'No' ?></span></td>
                        <td style="color:var(--text-muted)"><?= $p['sort_order'] ?></td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <button class="btn btn-ghost btn-sm" onclick="openEditProduct(<?= htmlspecialchars(json_encode($p), ENT_QUOTES) ?>)">✏️</button>
                                <form method="POST" action="<?= BASE_URL ?>/admin/products/delete" onsubmit="return confirm('Eliminare questo prodotto?')">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal modifica prodotto -->
<div class="modal-overlay" id="editProductModal">
    <div class="modal">
        <h3>Modifica Prodotto</h3>
        <form method="POST" action="<?= BASE_URL ?>/admin/products/update">
            <input type="hidden" name="id" id="ep_id">
            <div class="form-group">
                <label>Nome *</label>
                <input type="text" name="name" id="ep_name" required>
            </div>
            <div class="form-group">
                <label>Categoria *</label>
                <select name="category_id" id="ep_category" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Prezzo (€) *</label>
                <input type="number" name="price" id="ep_price" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label>Descrizione</label>
                <textarea name="description" id="ep_description"></textarea>
            </div>
            <div class="form-group">
                <label>Ordinamento</label>
                <input type="number" name="sort_order" id="ep_sort_order" min="0">
            </div>
            <div class="form-group">
                <label class="form-check">
                    <input type="checkbox" name="is_available" id="ep_available" value="1">
                    Disponibile nel menu
                </label>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-ghost" onclick="closeModal()">Annulla</button>
                <button type="submit" class="btn btn-primary">Salva</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditProduct(p) {
    document.getElementById('ep_id').value          = p.id;
    document.getElementById('ep_name').value        = p.name;
    document.getElementById('ep_category').value    = p.category_id;
    document.getElementById('ep_price').value       = p.price;
    document.getElementById('ep_description').value = p.description || '';
    document.getElementById('ep_sort_order').value  = p.sort_order;
    document.getElementById('ep_available').checked = p.is_available == 1;
    document.getElementById('editProductModal').classList.add('open');
}
function closeModal() {
    document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('open'));
}
document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', function(e) { if (e.target === this) closeModal(); });
});
</script>
</body>
</html>