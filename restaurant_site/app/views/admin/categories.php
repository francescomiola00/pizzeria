<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Categorie') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-brand"><?= PIZZERIA_NAME ?></div>
    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>/admin/dashboard">📊 Dashboard</a>
        <a href="<?= BASE_URL ?>/admin/categories" class="active">📂 Categorie</a>
        <a href="<?= BASE_URL ?>/admin/products">🍕 Prodotti</a>
        <a href="<?= BASE_URL ?>/admin/messages">✉️ Messaggi</a>
        <a href="<?= BASE_URL ?>/" target="_blank">🌐 Vedi sito</a>
    </nav>
    <div class="sidebar-footer"><a href="<?= BASE_URL ?>/admin/logout">← Esci</a></div>
</aside>
<div class="main">
    <div class="topbar">
        <span class="topbar-title">Categorie</span>
        <span class="topbar-user">Benvenuto, <span><?= htmlspecialchars($username ?? '') ?></span></span>
    </div>
    <div class="content">

        <?php if (!empty($flash)): ?>
            <div class="flash flash-<?= $flash['type'] ?>">
                <?= $flash['type'] === 'success' ? '✓' : '⚠' ?> <?= htmlspecialchars($flash['msg']) ?>
            </div>
        <?php endif; ?>

        <!-- Aggiungi categoria -->
        <div class="table-wrap" style="margin-bottom:24px;">
            <div class="table-header">
                <h2>Nuova Categoria</h2>
            </div>
            <div style="padding:20px 24px;">
                <form method="POST" action="<?= BASE_URL ?>/admin/categories/store" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;">
                    <div class="form-group" style="flex:1;min-width:200px;margin:0;">
                        <label>Nome categoria</label>
                        <input type="text" name="name" required placeholder="es. Pizze Rosse">
                    </div>
                    <div class="form-group" style="width:120px;margin:0;">
                        <label>Ordinamento</label>
                        <input type="number" name="sort_order" value="0" min="0">
                    </div>
                    <button type="submit" class="btn btn-primary">+ Aggiungi</button>
                </form>
            </div>
        </div>

        <!-- Lista categorie -->
        <div class="table-wrap">
            <div class="table-header">
                <h2>Categorie (<?= count($categories) ?>)</h2>
            </div>
            <?php if (empty($categories)): ?>
                <div class="empty">
                    <div class="empty-icon">📂</div>
                    <p>Nessuna categoria presente.</p>
                </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Ordinamento</th>
                        <th>Creata il</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td style="color:var(--text-muted)"><?= $cat['id'] ?></td>
                        <td><?= htmlspecialchars($cat['name']) ?></td>
                        <td><?= $cat['sort_order'] ?></td>
                        <td style="color:var(--text-muted)"><?= date('d/m/Y', strtotime($cat['created_at'])) ?></td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <button class="btn btn-ghost btn-sm" onclick="openEditCategory(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name'], ENT_QUOTES) ?>', <?= $cat['sort_order'] ?>)">✏️ Modifica</button>
                                <form method="POST" action="<?= BASE_URL ?>/admin/categories/delete" onsubmit="return confirm('Eliminare questa categoria? Verranno eliminati anche tutti i prodotti associati.')">
                                    <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">🗑 Elimina</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal modifica -->
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <h3>Modifica Categoria</h3>
        <form method="POST" action="<?= BASE_URL ?>/admin/categories/update">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-group">
                <label>Nome</label>
                <input type="text" name="name" id="edit_name" required>
            </div>
            <div class="form-group">
                <label>Ordinamento</label>
                <input type="number" name="sort_order" id="edit_sort_order" min="0">
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-ghost" onclick="closeModal()">Annulla</button>
                <button type="submit" class="btn btn-primary">Salva</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditCategory(id, name, sortOrder) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_sort_order').value = sortOrder;
    document.getElementById('editModal').classList.add('open');
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