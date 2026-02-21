<?php
/** @var array $details */

/** @var array $compDetails */
/** @var array $images */
/** @var array $certificate */
/** @var string $designTypesList */
/** @var string|null $prevLink , $nextLink */

/** @var int $year */

use App\Models\GalleryModel;

$model = new GalleryModel();
?>

<div class="fusion-fullwidth fullwidth-box nonhundred-percent-fullwidth non-hundred-percent-height-scrolling"
     style="background-color:transparent;padding:0;">
    <div class="fusion-builder-row fusion-row">
        <div class="fusion-column-first" style="width:70%;float:left;margin-bottom:20px;">
            <div class="fusion-column-wrapper">

                <!-- Breadcrumbs -->
                <p>
                    <a href="<?= site_url("gallery?year={$year}") ?>"><?= esc($compDetails['comp_year']) ?> Galleries</a>
                    //
                    <a href="<?= site_url("gallery?year={$year}&comp={$compDetails['comp_id']}") ?>">
                        <?= esc($compDetails['comp_year']) ?> Spark:
                        <?= esc($compDetails['comp_type_name']) ?>
                    </a>
                    //
                    <strong><?= esc($details['design_name']) ?></strong>
                </p>

                <!-- Title & Status -->
                <h2><?= esc($details['design_name']) ?></h2>
                <?php
                if ($details['entry_status'] !== 'Draft'): ?>
                    <h3>
                        <?= esc($details['entry_status']) ?>
                        <?php
                        if ((int)$details['winner_level'] !== 0): ?>
                            – <?= esc($model->getWinnerLevel((int)$details['winner_level'])) ?>
                        <?php
                        endif ?>
                    </h3>
                <?php
                endif ?>

                <!-- Meta Info -->
                <p>
                    <strong>Competition:</strong> Spark:<?= esc($compDetails['comp_type_name']) ?><br>
                    <strong>Designer:</strong>
                    <?= esc($details['designer_salutation']) ?>
                    <?= esc($details['designer_first_name']) ?>
                    <?= esc($details['designer_last_name']) ?>
                    <?php
                    if (!empty($details['designer_title'])): ?>
                        – <?= esc($details['designer_title']) ?>
                    <?php
                    endif ?><br>

                    <strong>Design Type:</strong>
                    <?= esc($designTypesList) ?>
                    <?php
                    if (!empty($designTypesList)): ?>,<?php
                    endif ?>
                    <?= esc($details['design_type']) ?><br>

                    <?php
                    if (!empty($details['company_name'])): ?>
                        <strong>Company / Organization / School:</strong>
                        <?= esc($details['company_name']) ?><br>
                    <?php
                    endif ?>

                    <?php
                    if (!empty($details['website'])): ?>
                        <strong>Website:</strong>
                        <a href="<?= esc($details['website']) ?>" target="_blank">
                            <?= esc($details['website']) ?>
                        </a><br>
                    <?php
                    endif ?>

                    <?php
                    if (!empty($details['additional_team_members'])): ?>
                        <strong>Team Members:</strong>
                        <?= esc($details['additional_team_members']) ?><br>
                    <?php
                    endif ?>
                </p>

                <!-- Description -->
                <p>
                    <?= nl2br(esc($details['full_description'] ?: $details['short_description'])) ?>
                </p>

                <!-- YouTube Embed -->
                <?php
                if (!empty($details['youtube_url'])): ?>
                    <div style="padding:15px 0;">
                        <iframe width="600"
                                height="450"
                                src="https://www.youtube.com/embed/<?= esc($details['youtube_url']) ?>"
                                frameborder="0"
                                allowfullscreen>
                        </iframe>
                    </div>
                <?php
                endif ?>

                <!-- Judges’ Comments -->
                <?php
                if (!empty($details['judges_comments'])): ?>
                    <div class="fusion-reading-box-container reading-box-container-1" style="margin-bottom:40px;">
                        <div class="reading-box"
                             style="background-color:#f6f6f6;
                        border-left:3px solid #008080;
                        border:1px solid #f6f6f6;">
                            <h3>JUDGES COMMENTS:</h3>
                            <p><em><?= nl2br(esc($details['judges_comments'])) ?></em></p>
                        </div>
                    </div>
                <?php
                endif ?>

            </div>
        </div>

        <!-- Sidebar: prev/next + certificate -->
        <div class="fusion-column-last" style="width:30%;float:right;margin-bottom:20px;">
            <div class="fusion-column-wrapper" style="text-align:right;">

                <p>
                    <?php
                    if ($prevLink): ?>
                        <a href="<?= esc($prevLink) ?>">&laquo; Previous Entry</a>
                    <?php
                    endif ?>

                    <?php
                    if ($prevLink && $nextLink): ?> &nbsp;|&nbsp; <?php
                    endif ?>

                    <?php
                    if ($nextLink): ?>
                        <a href="<?= esc($nextLink) ?>">Next Entry &raquo;</a>
                    <?php
                    endif ?>
                </p>

                <!-- Certificate Download -->
                <?php
                if (!empty($certificate)): ?>
                    <?php
                    foreach ($certificate as $cert): ?>
                        <p>
                            <a href="<?= esc($cert['entry_certificate']) ?>"
                               title="Download Official Certificate of Recognition"
                               target="_blank">
                                <img src="<?= esc($cert['entry_photo']) ?>"
                                     alt="Certificate of Recognition"
                                     width="300"
                                     style="border:1px solid #e0dede">
                                <br>
                                Certificate of Recognition
                            </a>
                        </p>
                    <?php
                    endforeach ?>
                <?php
                endif ?>

            </div>
        </div>
    </div>

    <!-- Image Gallery -->
    <div class="fusion-builder-row fusion-row">
        <div class="fusion-one-full fusion-column-first fusion-column-last" style="margin-bottom:20px;">
            <div class="fusion-column-wrapper">
                <div class="fusion-sep-clear"></div>
                <div class="fusion-separator fusion-full-width-sep sep-single sep-solid"
                     style="border-color:#e0dede;margin-bottom:20px;"></div>

                <div
                    class="fusion-gallery fusion-gallery-container fusion-grid-3 fusion-columns-total-0 fusion-gallery-layout-masonry fusion-gallery-1 fusion-masonry-has-vertical"
                    style="margin:-5px;">
                    <div
                        class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3 fusion-grid-sizer"></div>

                    <?php
                    $rowcntr = 0; ?>
                    <?php
                    foreach ($images as $img): ?>
                        <?php
                        $rowcntr++; ?>
                        <div
                            class="fusion-grid-column fusion-gallery-column fusion-gallery-column-3 fusion-element-grid"
                            style="padding:10px;">
                            <div class="fusion-gallery-image">
                                <a href="<?= esc($img['entry_photo']) ?>" rel="gal"
                                   title="<?= esc($img['entry_photo_caption']) ?>" class="gallery">
                                    <div class="fusion-masonry-element-container lazyloaded"
                                         data-bg="<?= esc($img['entry_photo']) ?>"
                                         style="
                                             padding-top: calc(80% + 6px);
                                             background-image:url('<?= esc($img['entry_photo']) ?>');
                                             background-size:cover;
                                             background-repeat:no-repeat;
                                             background-position:center;">
                                        <img
                                            src="data:image/svg+xml,%3Csvg%20xmlns%3D%27http://www.w3.org/2000/svg%27%20width%3D%27450%27%20height%3D%27450%27%3E%3Crect%20width%3D%27450%27%20height%3D%27450%27%20fill-opacity%3D%220%22/%3E%3C/svg%3E"
                                            data-orig-src="<?= esc($img['entry_photo']) ?>"
                                            alt="<?= esc($img['entry_photo_caption']) ?>"
                                            title="<?= esc($img['entry_photo_caption']) ?>"
                                            class="lazyload img-responsive"
                                            width="450"
                                            height="450">
                                    </div>
                                </a>
                            </div>
                        </div>

                        <?php
                        if ($rowcntr % 3 === 0): ?>
                            <div class="clearfix"></div>
                        <?php
                        endif ?>
                    <?php
                    endforeach ?>

                </div>
            </div>
        </div>
    </div>
</div>
