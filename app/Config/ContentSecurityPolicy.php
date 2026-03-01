<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Stores the default settings for the ContentSecurityPolicy, if you
 * choose to use it. The values here will be read in and set as defaults
 * for the site. If needed, they can be overridden on a page-by-page basis.
 *
 * Suggested reference for explanations:
 *
 * @see https://www.html5rocks.com/en/tutorials/security/content-security-policy/
 */
class ContentSecurityPolicy extends BaseConfig
{
    // -------------------------------------------------------------------------
    // Broadbrush CSP management
    // -------------------------------------------------------------------------

    /**
     * Default CSP report context
     */
    public bool $reportOnly = false;

    /**
     * Specifies a URL where a browser will send reports
     * when a content security policy is violated.
     */
    public ?string $reportURI = null;

    /**
     * Instructs user agents to rewrite URL schemes, changing
     * HTTP to HTTPS. This directive is for websites with
     * large numbers of old URLs that need to be rewritten.
     */
    public bool $upgradeInsecureRequests = false;

    // -------------------------------------------------------------------------
    // Sources allowed
    // NOTE: once you set a policy to 'none', it cannot be further restricted
    // -------------------------------------------------------------------------

    /**
     * Will default to self if not overridden
     *
     * @var list<string>|string|null
     */
    public $defaultSrc = [
        'self',
        'https://sparkawards.com',
        'https://*.sparkawards.com',
    ];

    /**
     * Lists allowed scripts' URLs.
     *
     * @var list<string>|string
     */
    public $scriptSrc = [
        'self',
        'https://www.sparkawards.com',
        'https://sparkawards.com',
        'https://*.sparkawards.com',
        'https://competitions.sparkawards.com',
        'https://www.youtube.com',
    ];

    /**
     * Lists allowed stylesheets' URLs.
     *
     * @var list<string>|string
     */
    public $styleSrc = [
        'self',
        'https://sparkawards.com',
        'https://*.sparkawards.com',
        'https://fonts.googleapis.com',
        'unsafe-inline',
    ];

    /**
     * Defines the origins from which images can be loaded.
     *
     * @var list<string>|string
     */
    public $imageSrc = [
        'self',
        'data:',
        'https://www.sparkawards.com',
        'https://sparkawards.com',
        'https://*.sparkawards.com',
        'https://competitions.sparkawards.com',
        'https://img.youtube.com',
        'https://i.ytimg.com',
        'https://i.vimeocdn.com',
    ];

    /**
     * Restricts the URLs that can appear in a page's `<base>` element.
     *
     * Will default to self if not overridden
     *
     * @var list<string>|string|null
     */
    public $baseURI;

    /**
     * Lists the URLs for workers and embedded frame contents
     *
     * @var list<string>|string
     */
    public $childSrc = [
        'self',
        'https://sparkawards.com',
        'https://*.sparkawards.com',
    ];

    /**
     * Limits the origins that you can connect to (via XHR,
     * WebSockets, and EventSource).
     *
     * @var list<string>|string
     */
    public $connectSrc = [
        'self',
        'https://sparkawards.com',
        'https://*.sparkawards.com',
        'https://vimeo.com',
        'https://www.vimeo.com',
        'https://www.youtube.com',
        'https://ilightbox.net',
    ];

    /**
     * Specifies the origins that can serve web fonts.
     *
     * @var list<string>|string
     */
    public $fontSrc = [
        'self',
        'data:',
        'https://fonts.gstatic.com',
        'https://fonts.googleapis.com',
        'https://www.sparkawards.com',
        'https://*.sparkawards.com',
        'https://competitions.sparkawards.com',
        'https://sparkawards.com',
        'https://spark-awards-gallery.local',
        'https://spark-awards-competition.local',
    ];

    /**
     * Lists valid endpoints for submission from `<form>` tags.
     *
     * @var list<string>|string
     */
    public $formAction = 'self';

    /**
     * Specifies the sources that can embed the current page.
     * This directive applies to `<frame>`, `<iframe>`, `<embed>`,
     * and `<applet>` tags. This directive can't be used in
     * `<meta>` tags and applies only to non-HTML resources.
     *
     * @var list<string>|string|null
     */
    public $frameAncestors;

    /**
     * The frame-src directive restricts the URLs which may
     * be loaded into nested browsing contexts.
     *
     * @var list<string>|string|null
     */
    public $frameSrc = [
        'self',
        'https://sparkawards.com',
        'https://*.sparkawards.com',
        'https://www.youtube.com',
        'https://www.youtube-nocookie.com',
        'https://player.vimeo.com',
    ];

    /**
     * Restricts the origins allowed to deliver video and audio.
     *
     * @var list<string>|string|null
     */
    public $mediaSrc = [
        'self',
        'https://sparkawards.com',
        'https://*.sparkawards.com',
    ];

    /**
     * Allows control over Flash and other plugins.
     *
     * @var list<string>|string
     */
    public $objectSrc = 'none';

    /**
     * @var list<string>|string|null
     */
    public $manifestSrc = [
        'self',
        'https://sparkawards.com',
        'https://*.sparkawards.com',
    ];

    /**
     * Limits the kinds of plugins a page may invoke.
     *
     * @var list<string>|string|null
     */
    public $pluginTypes;

    /**
     * List of actions allowed.
     *
     * @var list<string>|string|null
     */
    public $sandbox;

    /**
     * Nonce tag for style
     */
    public string $styleNonceTag = '{csp-style-nonce}';

    /**
     * Nonce tag for script
     */
    public string $scriptNonceTag = '{csp-script-nonce}';

    /**
     * Replace nonce tag automatically
     */
    public bool $autoNonce = true;
}
