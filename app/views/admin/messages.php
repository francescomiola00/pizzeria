<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Messaggi') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-brand"><?= PIZZERIA_NAME ?></div>
    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>/admin/dashboard">📊 Dashboard</a>
        <a href="<?= BASE_URL ?>/admin/categories">📂 Categorie</a>
        <a href="<?= BASE_URL ?>/admin/products">🍕 Prodotti</a>
        <a href="<?= BASE_URL ?>/admin/messages" class="active">✉️ Messaggi</a>
        <a href="<?= BASE_URL ?>/" target="_blank">🌐 Vedi sito</a>
    </nav>
    <div class="sidebar-footer"><a href="<?= BASE_URL ?>/admin/logout">← Esci</a></div>
</aside>
<div class="main">
    <div class="topbar">
        <span class="topbar-title">Messaggi</span>
        <div style="display:flex;align-items:center;gap:16px;">
            <span style="font-size:1rem;color:var(--text-muted);">Benvenuto, <strong style="color:var(--text);font-size:1.05rem;"><?= htmlspecialchars($username ?? '') ?></strong></span>
            <a href="<?= BASE_URL ?>/admin/logout" style="background:rgba(224,85,85,.12);color:#F08080;border:1px solid rgba(224,85,85,.25);padding:7px 14px;border-radius:5px;font-size:.8rem;letter-spacing:.06em;text-transform:uppercase;text-decoration:none;" onmouseover="this.style.background='rgba(224,85,85,.22)'" onmouseout="this.style.background='rgba(224,85,85,.12)'">← Logout</a>
        </div>
    </div>
    <div class="content">

        <?php if (!empty($flash)): ?>
            <div class="flash flash-<?= $flash['type'] ?>">
                <?= $flash['type'] === 'success' ? '✓' : '⚠' ?> <?= htmlspecialchars($flash['msg']) ?>
            </div>
        <?php endif; ?>

        <div class="table-wrap">
            <div class="table-header">
                <h2>Messaggi (<?= count($messages) ?>)</h2>
            </div>
            <?php if (empty($messages)): ?>
                <div class="empty">
                    <div class="empty-icon">✉️</div>
                    <p>Nessun messaggio ricevuto.</p>
                </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Stato</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Oggetto</th>
                        <th>Data</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($messages as $msg): ?>
                    <tr style="<?= !$msg['is_read'] ? 'background:rgba(232,130,12,.04)' : '' ?>">
                        <td><span class="badge <?= $msg['is_read'] ? 'badge-read' : 'badge-unread' ?>"><?= $msg['is_read'] ? 'Letto' : 'Nuovo' ?></span></td>
                        <td><strong><?= htmlspecialchars($msg['name']) ?></strong></td>
                        <td style="color:var(--text-muted)"><?= htmlspecialchars($msg['email']) ?></td>
                        <td><?= htmlspecialchars($msg['subject'] ?: '–') ?></td>
                        <td style="color:var(--text-muted);white-space:nowrap;"><?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?></td>
                        <td>
                            <div style="display:flex;gap:6px;">
                                <button class="btn btn-ghost btn-sm" onclick="openMessage(<?= htmlspecialchars(json_encode($msg), ENT_QUOTES) ?>)">👁 Leggi</button>
                                <?php if (!$msg['is_read']): ?>
                                <form method="POST" action="<?= BASE_URL ?>/admin/messages/read">
                    <?= $csrf ?>
                                    <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                                    <button type="submit" class="btn btn-ghost btn-sm">✓ Segna letto</button>
                                </form>
                                <?php endif; ?>
                                <form method="POST" action="<?= BASE_URL ?>/admin/messages/delete" onsubmit="return confirm('Eliminare questo messaggio?')">
                    <?= $csrf ?>
                                    <input type="hidden" name="id" value="<?= $msg['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">🗑</button>
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

<!-- Modal lettura messaggio -->
<div class="modal-overlay" id="msgModal">
    <div class="modal" style="max-width:560px;">
        <h3 id="modal-subject">Messaggio</h3>
        <div class="msg-meta">Da: <span id="modal-name"></span> &lt;<span id="modal-email"></span>&gt;</div>
        <div class="msg-meta">Ricevuto: <span id="modal-date"></span></div>
        <div class="msg-body" id="modal-body"></div>
        <div class="modal-actions">
            <button type="button" class="btn btn-ghost" onclick="closeModal()">Chiudi</button>
        </div>
    </div>
</div>

<script>
function openMessage(msg) {
    document.getElementById('modal-subject').textContent = msg.subject || 'Nessun oggetto';
    document.getElementById('modal-name').textContent    = msg.name;
    document.getElementById('modal-email').textContent   = msg.email;
    document.getElementById('modal-date').textContent    = msg.created_at;
    document.getElementById('modal-body').textContent    = msg.message;
    document.getElementById('msgModal').classList.add('open');
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