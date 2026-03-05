<aside style="width:240px;background:#242424;border-right:1px solid rgba(255,255,255,.06);display:flex;flex-direction:column;padding:32px 0;flex-shrink:0;">
    <div style="font-family:'Playfair Display',serif;color:#E8820C;font-size:.95rem;letter-spacing:.15em;text-transform:uppercase;padding:0 24px 32px;border-bottom:1px solid rgba(255,255,255,.06);">
        <?= PIZZERIA_NAME ?>
    </div>
    <nav style="padding:24px 0;flex:1;">
        <?php
        $current = $_SERVER['REQUEST_URI'];
        $links = [
            '/admin/dashboard'  => ['📊', 'Dashboard'],
            '/admin/categories' => ['📂', 'Categorie'],
            '/admin/products'   => ['🍕', 'Prodotti'],
            '/admin/messages'   => ['✉️', 'Messaggi'],
        ];
        foreach ($links as $path => $item):
            $active = strpos($current, $path) !== false;
            $style = $active
                ? 'display:flex;align-items:center;gap:10px;padding:11px 22px;color:#F0EDE8;background:rgba(232,130,12,.08);border-left:2px solid #E8820C;text-decoration:none;font-size:.875rem;'
                : 'display:flex;align-items:center;gap:10px;padding:11px 24px;color:#9A9080;text-decoration:none;font-size:.875rem;';
        ?>
            <a href="<?= BASE_URL . $path ?>" style="<?= $style ?>"><?= $item[0] ?> <?= $item[1] ?></a>
        <?php endforeach; ?>
        <a href="<?= BASE_URL ?>/" target="_blank" style="display:flex;align-items:center;gap:10px;padding:11px 24px;color:#9A9080;text-decoration:none;font-size:.875rem;">🌐 Vedi sito</a>
    </nav>
    <div style="padding:16px 24px;border-top:1px solid rgba(255,255,255,.06);">
        <a href="<?= BASE_URL ?>/admin/logout" style="color:#9A9080;text-decoration:none;font-size:.8rem;">← Esci</a>
    </div>
</aside>