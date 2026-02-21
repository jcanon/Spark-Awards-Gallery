<?php
/** @var int $year */

/** @var string|null $comp */

use App\Models\GalleryModel;

$model = new GalleryModel();
$rowcntr = 0;
?>

<?php
if ($year && $comp): ?>

<?php
if ($comp === 'Winners'): ?>

<!-- Winners Gallery “Winners” -->
<p>
    <a href="<?= site_url('gallery?year=' . $year) ?>"><?= esc($year) ?> Galleries</a>
    // <strong><?= esc($year) ?> Winners</strong>
</p>

<div class="awb-gallery-wrapper awb-gallery-wrapper-1 button-span-no">
    <div
        class="fusion-gallery fusion-gallery-container fusion-grid-3 fusion-columns-total-4 fusion-gallery-layout-grid fusion-gallery-1">
        <div class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3"></div>

        <?php
        foreach ($model->getGalleryWinners((string)$year) as $row): ?>
            <?php
            $rowcntr++;
            $entryImages = $model->getTopGalleryImages((string)$row['entry_id']);
            ?>

            <?php
            if (!empty($entryImages)): ?>
                <div style="padding:10px;"
                     class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3 fusion-element-grid">
                    <div class="fusion-gallery-image">
                        <a href="<?= site_url('gallery?year=' . $year . '&entry=' . $row['entry_id']) ?>">
                            <div
                                class="fusion-masonry-element-container lazyloaded"
                                data-bg="<?= esc($entryImages[0]['entry_photo']) ?>"
                                style="
                                    padding-top: calc(80% + 6px);
                                    background-image: url('<?= esc($entryImages[0]['entry_photo']) ?>');
                                    ">
                                <img
                                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='450' height='450'%3E%3Crect width='450' height='450' fill-opacity='0'/%3E%3C/svg%3E"
                                    data-orig-src="<?= esc($entryImages[0]['entry_photo']) ?>"
                                    alt=""
                                    class="lazyload img-responsive"
                                    width="450"
                                    height="450"
                                />
                            </div>
                        </a>
                        <div style="padding:5px; text-align:center;">
                            <a href="<?= site_url('gallery?year=' . $year . '&entry=' . $row['entry_id']) ?>">
                                <?= esc($row['design_name']) ?>
                            </a>
                        </div>
                    </div>
                </div>

                <?php
                if ($rowcntr % 3 === 0): ?>
                    <div class="clearfix"></div>
                <?php
                endif; ?>
            <?php
            endif; ?>

        <?php
        endforeach; ?>

        <?php
        else: ?>

        <!-- Competition-Specific Gallery (not Winners) -->
        <?php
        $compDetails = $model->getCompByID((int)$comp); ?>

        <p style="padding-bottom:30px; clear:both;">
            <a href="<?= site_url('gallery?year=' . $year) ?>"><?= esc($year) ?> Galleries</a>
            // <strong><?= esc($year) ?> Spark:<?= esc($compDetails['comp_type_name']) ?></strong>
        </p>

        <div class="awb-gallery-wrapper awb-gallery-wrapper-1 button-span-no">
            <div
                class="fusion-gallery fusion-gallery-container fusion-grid-3 fusion-columns-total-4 fusion-gallery-layout-grid fusion-gallery-1">
                <div class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3"></div>

                <!-- Inject a single “Winners” tile for this competition -->
                <?php
                $allWinners = $model->getGalleryWinners((string)$year);
                $filtered = array_filter(
                    $allWinners,
                    fn($r) => (string)$r['comp_type_id'] === (string)$comp
                );
                ?>

                <?php
                if (!empty($filtered)): ?>
                    <?php
                    $randRow = $filtered[array_rand($filtered)];
                    $rowcntr++;
                    $entryImages = $model->getTopGalleryImages((string)$randRow['entry_id']);
                    ?>

                    <?php
                    if (!empty($entryImages)): ?>
                        <div style="padding:10px;"
                             class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3 fusion-element-grid">
                            <div class="fusion-gallery-image">
                                <a href="<?= site_url('gallery?year=' . $year . '&comp=Winners') ?>">
                                    <div
                                        class="fusion-masonry-element-container lazyloaded"
                                        data-bg="<?= esc($entryImages[0]['entry_photo']) ?>"
                                        style="
                                            padding-top: calc(80% + 6px);
                                            background-image: url('<?= esc($entryImages[0]['entry_photo']) ?>');
                                            ">
                                        <img
                                            src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='450' height='450'%3E%3Crect width='450' height='450' fill-opacity='0'/%3E%3C/svg%3E"
                                            data-orig-src="<?= esc($entryImages[0]['entry_photo']) ?>"
                                            alt=""
                                            class="lazyload img-responsive"
                                            width="450"
                                            height="450"
                                        />
                                    </div>
                                </a>
                                <div style="padding:5px; text-align:center;">
                                    <a href="<?= site_url('gallery?year=' . $year . '&comp=Winners') ?>">
                                        <?= esc($year) ?> Winners
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($rowcntr % 3 === 0): ?>
                            <div class="clearfix"></div>
                        <?php
                        endif; ?>
                    <?php
                    endif; ?>
                <?php
                endif; ?>

                <!-- Masonry grid-sizer -->
                <div
                    class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3 hover-type-zoomin fusion-grid-sizer"></div>

                <!-- Then the competition’s entries -->
                <?php
                foreach ($model->getGalleryEntries((string)$year, (string)$compDetails['comp_type_id']) as $row): ?>
                    <?php
                    $rowcntr++;
                    $entryImages = $model->getTopGalleryImages((string)$row['entry_id']);
                    ?>

                    <?php
                    if (!empty($entryImages)): ?>
                        <div style="padding:10px;"
                             class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3 fusion-element-grid">
                            <div class="fusion-gallery-image">
                                <a href="<?= site_url('gallery?year=' . $year . '&entry=' . $row['entry_id']) ?>">
                                    <div
                                        class="fusion-masonry-element-container lazyloaded"
                                        data-bg="<?= esc($entryImages[0]['entry_photo']) ?>"
                                        style="
                                            padding-top: calc(80% + 6px);
                                            background-image: url('<?= esc($entryImages[0]['entry_photo']) ?>');
                                            ">
                                        <img
                                            src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='450' height='450'%3E%3Crect width='450' height='450' fill-opacity='0'/%3E%3C/svg%3E"
                                            data-orig-src="<?= esc($entryImages[0]['entry_photo']) ?>"
                                            alt=""
                                            class="lazyload img-responsive"
                                            width="450"
                                            height="450"
                                        />
                                    </div>
                                </a>
                                <div style="padding:5px; text-align:center;">
                                    <a href="<?= site_url('gallery?year=' . $year . '&entry=' . $row['entry_id']) ?>">
                                        <?= esc($row['design_name']) ?>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($rowcntr % 3 === 0): ?>
                            <div class="clearfix"></div>
                        <?php
                        endif; ?>
                    <?php
                    endif; ?>
                <?php
                endforeach; ?>

                <?php
                endif; ?>

                <?php
                else: ?>

                <!-- Default Gallery (no comp selected) -->

                <!-- Masonry grid-sizer -->
                <div class="awb-gallery-wrapper awb-gallery-wrapper-1 button-span-no">
                    <div
                        class="fusion-gallery fusion-gallery-container fusion-grid-3 fusion-columns-total-4 fusion-gallery-layout-grid fusion-gallery-1">
                        <div class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3"></div>
                        <div
                            class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3 hover-type-zoomin fusion-grid-sizer"></div>

                        <!-- Winner tile first -->
                        <?php
                        $allWinners = $model->getGalleryWinners((string)$year);
                        ?>

                        <?php
                        if (!empty($allWinners)): ?>
                            <?php
                            $randWinner = $allWinners[array_rand($allWinners)];
                            $rowcntr++;
                            $entryImages = $model->getTopGalleryImages((string)$randWinner['entry_id']);
                            ?>

                            <?php
                            if (!empty($entryImages)): ?>
                                <div style="padding:10px;"
                                     class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3 fusion-element-grid">
                                    <div class="fusion-gallery-image">
                                        <a href="<?= site_url('gallery?year=' . $year . '&comp=Winners') ?>">
                                            <div
                                                class="fusion-masonry-element-container lazyloaded"
                                                data-bg="<?= esc($entryImages[0]['entry_photo']) ?>"
                                                style="
                                                    padding-top: calc(80% + 6px);
                                                    background-image: url('<?= esc($entryImages[0]['entry_photo']) ?>');
                                                    ">
                                                <img
                                                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='450' height='450'%3E%3Crect width='450' height='450' fill-opacity='0'/%3E%3C/svg%3E"
                                                    data-orig-src="<?= esc($entryImages[0]['entry_photo']) ?>"
                                                    alt=""
                                                    class="lazyload img-responsive"
                                                    width="450"
                                                    height="450"
                                                />
                                            </div>
                                        </a>
                                        <div style="padding:5px; text-align:center;">
                                            <a href="<?= site_url('gallery?year=' . $year . '&comp=Winners') ?>">
                                                <?= esc($year) ?> Winners
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if ($rowcntr % 3 === 0): ?>
                                    <div class="clearfix"></div>
                                <?php
                                endif; ?>
                            <?php
                            endif; ?>
                        <?php
                        endif; ?>

                        <!-- Competition-Type Tiles -->
                        <?php
                        $galleryGrid = $model->getGalleryGrid((string)$year);
                        ?>

                        <?php
                        foreach ($galleryGrid as $row): ?>
                            <?php
                            $rowcntr++;
                            $photoset = $model->getRandomFeaturedPhotos(
                                (string)$row['comp_year'],
                                (string)$row['comp_type_id']
                            )
                                ?: $model->getRandomPhotos((string)$row['comp_year'], (string)$row['comp_type_id']);
                            ?>

                            <?php
                            if (!empty($photoset)): ?>
                                <?php
                                $rand = $photoset[array_rand($photoset)]; ?>
                                <div style="padding:10px;"
                                     class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3 fusion-element-grid">
                                    <div class="fusion-gallery-image">
                                        <a href="<?= site_url(
                                            'gallery?year=' . $row['comp_year'] . '&comp=' . $row['comp_id']
                                        ) ?>">
                                            <div
                                                class="fusion-masonry-element-container lazyloaded"
                                                data-bg="<?= esc($rand['entry_photo']) ?>"
                                                style="
                                                    padding-top: calc(80% + 6px);
                                                    background-image: url('<?= esc($rand['entry_photo']) ?>');
                                                    ">
                                                <img
                                                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='450' height='450'%3E%3Crect width='450' height='450' fill-opacity='0'/%3E%3C/svg%3E"
                                                    data-orig-src="<?= esc($rand['entry_photo']) ?>"
                                                    alt=""
                                                    class="lazyload img-responsive"
                                                    width="450"
                                                    height="450"
                                                />
                                            </div>
                                        </a>
                                        <div style="padding:5px; text-align:center;">
                                            <a href="<?= site_url(
                                                'gallery?year=' . $row['comp_year'] . '&comp=' . $row['comp_id']
                                            ) ?>">
                                                <?= esc($row['comp_year']) ?> Spark:<?= esc($row['comp_type_name']) ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if ($rowcntr % 3 === 0): ?>
                                    <div class="clearfix"></div>
                                <?php
                                endif; ?>
                            <?php
                            endif; ?>
                        <?php
                        endforeach; ?>

                        <?php
                        endif; ?>

                    </div>
                </div>
            </div>
