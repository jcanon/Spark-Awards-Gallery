<?= view('partials/header', [
    'metaTitle' => $metaTitle ?? null,
    'metaDescription' => $metaDescription ?? null,
    'canonicalUrl' => $canonicalUrl ?? null,
    'ogImage' => $ogImage ?? null,
]) ?>
<?= view('partials/nav') ?>

    <main id="main" class="clearfix">
        <div class="fusion-row">
            <section id="content" style="width:100%">
                <div class="page type-page status-publish hentry">
                    <div class="post-content">
                        <div class="fusion-fullwidth fullwidth-box" style="background-color:transparent;padding:0;">
                            <div class="fusion-builder-row fusion-row">
                                <div class="fusion-one-full fusion-column-first fusion-column-last">
                                    <div class="fusion-column-wrapper">

                                        <div class="fusion-fullwidth fullwidth-box"
                                             style="background-color:transparent;padding:0;margin:0;">
                                            <div class="fusion-builder-row fusion-row">
                                                <!-- Left: Title -->
                                                <div class="fusion_one_half fusion-column-first"
                                                     style="width:50%;float:left;margin-bottom:20px;">
                                                    <div class="fusion-column-wrapper">
                                                        <h1>
                                                            <?php
                                                            if (empty($search)): ?>
                                                                <?= esc($year) ?> Galleries
                                                            <?php
                                                            else: ?>
                                                                Gallery Search
                                                            <?php
                                                            endif ?>
                                                        </h1>
                                                    </div>
                                                </div>

                                                <!-- Right: Search Form -->
                                                <div class="fusion_one_half fusion-column-last"
                                                     style="width:50%;float:right;margin-bottom:20px;">
                                                    <div class="fusion-column-wrapper" style="text-align:right">
                                                        <?= form_open('gallery', ['method' => 'get']) ?>
                                                        <input
                                                            type="text"
                                                            name="search"
                                                            value="<?= esc($search) ?>"
                                                            placeholder="Gallery Search"
                                                            style="width:200px"
                                                        >
                                                        <button type="submit"
                                                                class="fusion-button button-flat button-small button-default">
                                                            Go
                                                        </button>
                                                        <?= form_close() ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        if (empty($search)): ?>
                                            <p>
                                                The Spark Gallery pages are one of our most popular design destinations,
                                                with thousands of visitors each year. Check out some of the latest Spark
                                                entries, in the galleries below.
                                            </p>

                                            <div class="fusion-button-wrapper">
                                                <?= form_open('gallery', ['method' => 'get']) ?>
                                                <select name="year" style="font-size:18px;">
                                                    <?php
                                                    for ($i = date('Y'); $i >= 2007; $i--): ?>
                                                        <option
                                                            value="<?= $i ?>" <?= $i === (int)$year ? 'selected' : '' ?>>
                                                            &nbsp; <?= $i ?> Galleries &nbsp;
                                                        </option>
                                                    <?php
                                                    endfor ?>
                                                </select>
                                                <button type="submit" name="submityear"
                                                        class="fusion-button button-flat button-small button-default">
                                                    Go
                                                </button>
                                                <?= form_close() ?>
                                            </div>
                                        <?php
                                        endif ?>

                                        <div class="fusion-sep-clear" style="margin-bottom:20px;"></div>

                                        <!-- Dynamic include -->
                                        <?php
                                        if ($entry): ?>
                                            <?= view('gallery/details', [
                                                'details' => $details,
                                                'images' => $images,
                                                'certificate' => $certificate,
                                                'compDetails' => $compDetails,
                                                'designTypesList' => $designTypesList,
                                                'prevLink' => $prevLink,
                                                'nextLink' => $nextLink,
                                                'year' => $year,
                                                'isWinnerContext' => $isWinnerContext,
                                                'youtubeEmbedId' => $youtubeEmbedId,
                                                'winnerLevelName' => $winnerLevelName,
                                                'backLink' => $backLink,
                                            ]) ?>

                                        <?php
                                        elseif ($search): ?>
                                            <?= view('gallery/search', ['results' => $results, 'search' => $search]) ?>

                                        <?php
                                        else: ?>
                                            <?= view('gallery/grid',
                                                [
                                                    'tiles' => $tiles,
                                                    'typeLabel' => $typeLabel,
                                                    'year' => $year,
                                                    'comp' => $comp,
                                                ]
                                            ) ?>
                                        <?php
                                        endif ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

<?= view('partials/footer') ?>
