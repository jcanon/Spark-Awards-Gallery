<?php /** @var array $results */ /** @var string $search */ ?>

<?php if (empty($results)): ?>
    <h3>
        No results found for
        "<strong><?= esc($search) ?></strong>".
        Please try your search again.
    </h3>
<?php else: ?>
    <h3>
        Displaying <strong><?= count($results) ?></strong>
        results for "<strong><?= esc($search) ?></strong>"
    </h3>

    <ul>
        <?php foreach ($results as $r): ?>
            <li>
                <a href="<?= esc($r['link']) ?>">
                    <?= esc($r['design_name']) ?>
                </a>
                (<?= esc($r['comp_year']) ?> Spark:<?= esc($r['comp_type_name']) ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
