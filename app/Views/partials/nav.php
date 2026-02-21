<?php
// Retrieve the menu tree via our service
use App\Libraries\WpMenuService;

$menuService = new WpMenuService();
$menuTree    = $menuService->getMenuTree('main-navigation');

// Load our helper that defines render_fusion_menu()
helper('menu');
?>

<header class="fusion-header-wrapper">
    <div class="fusion-header-v3 fusion-logo-left fusion-sticky-menu-1 fusion-sticky-logo-1 fusion-mobile-logo-1 fusion-mobile-menu-design-modern">
        <div class="fusion-secondary-header">
            <div class="fusion-row">
                <div class="fusion-alignright">
                    <div class="fusion-social-links-header">
                        <div class="fusion-social-networks">
                            <div class="fusion-social-networks-wrapper">
                                <a class="fusion-social-network-icon fusion-tooltip fusion-linkedin awb-icon-linkedin" style="" title="LinkedIn" href="https://www.linkedin.com/company/spark-design-&amp;-architecture-awards/about/" target="_blank" rel="noopener noreferrer"><span class="screen-reader-text">LinkedIn</span></a><a class="fusion-social-network-icon fusion-tooltip fusion-youtube awb-icon-youtube" style="" title="YouTube" href="https://www.youtube.com/user/SparkDesignAwards" target="_blank" rel="noopener noreferrer"><span class="screen-reader-text">YouTube</span></a><a class="fusion-social-network-icon fusion-tooltip fusion-pinterest awb-icon-pinterest" style="" title="Pinterest" href="https://www.pinterest.com/sparkawards/" target="_blank" rel="noopener noreferrer"><span class="screen-reader-text">Pinterest</span></a><a class="fusion-social-network-icon fusion-tooltip fusion-instagram awb-icon-instagram" style="" title="Instagram" href="https://www.instagram.com/sparkdesignawards/" target="_blank" rel="noopener noreferrer"><span class="screen-reader-text">Instagram</span></a><a class="fusion-social-network-icon fusion-tooltip fusion-rss awb-icon-rss" style="" title="Rss" href="/feed/" target="_blank" rel="noopener noreferrer"><span class="screen-reader-text">Rss</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fusion-header-sticky-height"></div>

        <div class="fusion-header">
            <div class="fusion-row">
                <div class="fusion-logo" data-margin-top="10px" data-margin-bottom="10px" data-margin-left="0px" data-margin-right="0px">
                    <a class="fusion-logo-link" href="https://www.sparkawards.com/">
                        <img class="fusion-standard-logo"
                             src="https://www.sparkawards.com/wp-content/uploads/2019/07/sparklogo.jpg"
                             width="160" height="50"
                             alt="Spark Awards – International Design Competition Logo" />
                        <img class="fusion-mobile-logo"
                             src="https://www.sparkawards.com/wp-content/uploads/2019/07/sparklogo.jpg"
                             width="160" height="50"
                             alt="Spark Awards – International Design Competition Logo" />
                        <img class="fusion-sticky-logo"
                             src="https://www.sparkawards.com/wp-content/uploads/2019/07/sparklogo.jpg"
                             width="160" height="50"
                             alt="Spark Awards – International Design Competition Logo" />
                    </a>
                </div>

                <!-- MAIN MENU -->
                <nav class="fusion-main-menu" aria-label="Main Menu">
                    <ul id="menu-main-navigation" class="fusion-menu">
                        <?= render_fusion_menu($menuTree) ?>
                    </ul>
                </nav>

                <!-- STICKY MENU -->
                <nav class="fusion-main-menu fusion-sticky-menu" aria-label="Main Menu Sticky">
                    <ul id="menu-main-menu-1" class="fusion-menu">
                        <?= render_fusion_menu($menuTree) ?>
                    </ul>
                </nav>

                <div class="fusion-mobile-menu-icons">
                    <a href="#" class="fusion-icon awb-icon-bars"
                       aria-label="Toggle mobile menu" aria-expanded="false"></a>
                </div>

                <nav class="fusion-mobile-nav-holder fusion-mobile-menu-text-align-left"
                     aria-label="Main Menu Mobile"></nav>

                <nav class="fusion-mobile-nav-holder fusion-mobile-menu-text-align-left fusion-mobile-sticky-nav-holder"
                     aria-label="Main Menu Mobile Sticky"></nav>

                <div class="fusion-clearfix"></div>
            </div>
        </div>
    </div>
    <div class="fusion-clearfix"></div>
</header>

<div id="sliders-container"></div>

