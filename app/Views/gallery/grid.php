<?php
/** @var array<int, array<string, mixed>> $tiles */
/** @var int $year */
/** @var string|null $comp */
/** @var string|null $typeLabel */

$rowcntr = 0;
?>

<?php if ($comp !== ''): ?>
<p style="padding-bottom:30px; clear:both;">
    <a href="<?= site_url('gallery?year=' . $year) ?>"><?= esc($year) ?> Galleries</a>
    <?php if ($typeLabel): ?>
        // <strong><?= esc($typeLabel) ?></strong>
    <?php endif; ?>
</p>
<?php endif; ?>

<div class="awb-gallery-wrapper awb-gallery-wrapper-1 button-span-no">
    <div class="fusion-gallery fusion-gallery-container fusion-grid-3 fusion-columns-total-4 fusion-gallery-layout-grid fusion-gallery-1">
        <div class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3"></div>
        <div class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3 hover-type-zoomin fusion-grid-sizer"></div>

        <?php foreach ($tiles as $tile): ?>
            <?php
            $photo = (string) ($tile['photo'] ?? '');
            if ($photo === '') {
                continue;
            }
            $photoUrl = gallery_media_url($photo);
            $rowcntr++;
            ?>
            <div style="padding:10px;" class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3 fusion-element-grid js-infinite-item">
                <div class="fusion-gallery-image">
                    <a href="<?= esc((string) $tile['link']) ?>">
                        <div
                            class="fusion-masonry-element-container lazyloaded"
                            data-bg="<?= esc($photoUrl) ?>"
                            style="padding-top: calc(80% + 6px); background-image: url('<?= esc($photoUrl) ?>');">
                            <img
                                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='450' height='450'%3E%3Crect width='450' height='450' fill-opacity='0'/%3E%3C/svg%3E"
                                data-orig-src="<?= esc($photoUrl) ?>"
                                alt=""
                                class="lazyload img-responsive"
                                width="450"
                                height="450"
                            />
                        </div>
                    </a>
                    <div class="gallery-card-title-wrap">
                        <a
                            class="gallery-card-title"
                            href="<?= esc((string) $tile['link']) ?>"
                            title="<?= esc((string) ($tile['label'] ?? '')) ?>">
                            <?= esc((string) ($tile['label'] ?? '')) ?>
                        </a>
                    </div>
                </div>
            </div>

            <?php if ($rowcntr % 3 === 0): ?>
                <div class="clearfix"></div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
<div class="gallery-infinite-sentinel" aria-hidden="true"></div>
