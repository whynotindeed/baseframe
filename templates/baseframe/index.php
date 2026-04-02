<?php
/**
 * BaseFrame — Universal Joomla Template Framework
 * One template, any CSS framework. Swap via template parameter.
 *
 * Clean semantic HTML. No framework-specific classes in the markup.
 * All styling handled by the CSS adapter layer.
 */
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$app       = Factory::getApplication();
$input     = $app->getInput();
$menu      = $app->getMenu();
$active    = $menu->getActive();
$isHome    = ($active === $menu->getDefault());
$view      = $input->getCmd('view', '');
$option    = $input->getCmd('option', '');

// Detect if we're truly on the homepage URL (not just a menu fallback for orphan pages)
$requestUri = $input->server->getString('REQUEST_URI', '/');
$isRealHome = $isHome && (preg_match('#^/(\?.*)?$#', parse_url($requestUri, PHP_URL_PATH) ?: '/'));

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

$siteName   = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$mediaBase  = Uri::root(true) . '/media/templates/site/' . $this->template;
$hasSidebar = $this->countModules('sidebar');
$hasHero    = $this->countModules('hero');

// ─── Framework config ──────────────────────────────────────────
// Allow URL override via ?fw= parameter for demo switching
$fwOverride = $input->getCmd('fw', '');
$framework  = (string) $this->params->get('framework', 'bulma');


$frameworks = [
    'bulma' => [
        'css'   => 'adapters/bulma.css',
        'lib'   => 'lib/bulma.min.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'Bulma',
        'url'   => 'https://bulma.io',
        'color' => '#00d1b2',
    ],
    'daisyui' => [
        'css'   => 'adapters/daisyui.css',
        'lib'   => 'lib/daisyui-full.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/daisyui@5/daisyui.css',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'DaisyUI',
        'url'   => 'https://daisyui.com',
        'color' => '#661AE6',
    ],
    'foundation' => [
        'css'   => 'adapters/foundation.css',
        'lib'   => 'lib/foundation.min.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/foundation-sites@6.9.0/dist/css/foundation.min.css',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'Foundation',
        'url'   => 'https://get.foundation',
        'color' => '#1779ba',
    ],
    'pico' => [
        'css'   => 'adapters/pico.css',
        'lib'   => 'lib/pico.min.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css',
        'fonts' => '',
        'label' => 'Pico',
        'url'   => 'https://picocss.com',
        'color' => '#e8890c',
    ],
    'uikit' => [
        'css'   => 'adapters/uikit.css',
        'lib'   => 'lib/uikit.min.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/uikit@3/dist/css/uikit.min.css',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'UIkit',
        'url'   => 'https://getuikit.com',
        'color' => '#1e87f0',
    ],
    'openprops' => [
        'css'   => 'adapters/openprops.css',
        'lib'   => 'lib/open-props.min.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/open-props@1/open-props.min.css',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'Open Props',
        'url'   => 'https://open-props.style',
        'color' => '#8338ec',
    ],
    'vanilla' => [
        'css'   => 'adapters/vanilla.css',
        'lib'   => '',
        'cdn'   => '',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'Vanilla',
        'url'   => '',
        'color' => '#333333',
    ],
    'nes' => [
        'css'   => 'adapters/nes.css',
        'lib'   => 'lib/nes.min.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/nes.css@2.3.0/css/nes.min.css',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap',
        'label' => 'NES.css',
        'url'   => 'https://nostalgic-css.github.io/NES.css/',
        'color' => '#209cee',
    ],
    'sakura' => [
        'css'   => 'adapters/sakura.css',
        'lib'   => 'lib/sakura.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/sakura.css/css/sakura.css',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'Sakura',
        'url'   => 'https://oxal.org/projects/sakura/',
        'color' => '#c9379d',
    ],
    'mvp' => [
        'css'   => 'adapters/mvp.css',
        'lib'   => 'lib/mvp.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/mvp.css/mvp.css',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'MVP.css',
        'url'   => 'https://andybrewer.github.io/mvp/',
        'color' => '#118bee',
    ],
    'halfmoon' => [
        'css'   => 'adapters/halfmoon.css',
        'lib'   => 'lib/halfmoon.min.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/halfmoon@1.1.1/css/halfmoon-variables.min.css',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'Halfmoon',
        'url'   => 'https://www.gethalfmoon.com/',
        'color' => '#8b5cf6',
    ],
    'fomantic' => [
        'css'   => 'adapters/fomantic.css',
        'lib'   => 'lib/fomantic.min.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/fomantic-ui/dist/semantic.min.css',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'Fomantic UI',
        'url'   => 'https://fomantic-ui.com/',
        'color' => '#2185d0',
    ],
    'chota' => [
        'css'   => 'adapters/chota.css',
        'lib'   => 'lib/chota.min.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/chota',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'Chota',
        'url'   => 'https://jenil.github.io/chota/',
        'color' => '#1a73e8',
    ],
    'cirrus' => [
        'css'   => 'adapters/cirrus.css',
        'lib'   => 'lib/cirrus.min.css',
        'cdn'   => 'https://cdn.jsdelivr.net/npm/cirrus-ui/dist/cirrus.min.css',
        'fonts' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        'label' => 'Cirrus',
        'url'   => 'https://cirrus-ui.com/',
        'color' => '#f03d4d',
    ],
];

// Auto-detect framework from menu item alias (/bulma, /daisyui, etc.)
$fwContext = "";
if (!$fwOverride && $active && isset($frameworks[$active->alias])) {
    $fwOverride = $active->alias;
    $fwContext = $active->alias;
} elseif ($fwOverride && !$isRealHome && !in_array($active ? $active->id : 0, [194])) {
    $fwContext = $fwOverride;
}

// Apply URL override if valid
if ($fwOverride && isset($frameworks[$fwOverride])) {
    $framework = $fwOverride;
}
$fw = $frameworks[$framework] ?? $frameworks['bulma'];
$themeColor = $fw['color'];
$fwLabel = $fw['label'];
$fwUrl = $fw['url'] ?? '';
$fwSafe = htmlspecialchars($fwContext, ENT_QUOTES, 'UTF-8');

// CSS source: local (default) or cdn (always latest)
$cssSource = (string) $this->params->get('cssSource', 'local');

// Load stylesheets
if ($fw['fonts']) $this->addStyleSheet($fw['fonts']);
if ($fw['lib'] || $fw['cdn']) {
    $libUrl = ($cssSource === 'cdn' && !empty($fw['cdn'])) ? $fw['cdn'] : $mediaBase . '/css/' . $fw['lib'];
    if ($libUrl) $this->addStyleSheet($libUrl);
}
$this->addStyleSheet('/media/system/css/joomla-fontawesome.min.css');
$this->addStyleSheet($mediaBase . '/css/base.css?v=5');
$this->addStyleSheet($mediaBase . '/css/' . $fw['css'] . '?v=4');
$this->addStyleSheet($mediaBase . '/css/custom.css?v=2');
$this->addScript($mediaBase . '/js/baseframe.js?v=2', [], ['defer' => true]);
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" data-framework="<?php echo htmlspecialchars($framework, ENT_QUOTES, 'UTF-8'); ?>" data-theme="<?php echo $framework === 'halfmoon' ? 'dark' : 'light'; ?>">
<head>
    <meta name="theme-color" content="<?php echo htmlspecialchars($themeColor, ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="color-scheme" content="light">
    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
    <jdoc:include type="scripts" />
</head>
<body class="bf <?php echo $isRealHome ? 'bf-home' : ''; ?> <?php echo htmlspecialchars($option, ENT_QUOTES, 'UTF-8'); ?> view-<?php echo htmlspecialchars($view, ENT_QUOTES, 'UTF-8'); ?><?php echo $framework === 'halfmoon' ? ' dark-mode' : ''; ?>">

    <a href="#bf-main" class="bf-skip">Skip to content</a>

    <!-- ─── Top bar ──────────────────────────────────────────── -->
    <div class="bf-topbar">
        <div class="bf-container bf-topbar-inner">
            <a href="https://theaidirector.win" class="bf-topbar-link">TheAIDirector.Win</a>
            <a href="https://claudejoomla.com" class="bf-topbar-link bf-topbar-active">ClaudeJoomla.com</a>
            <a href="https://claudetemplates.net" class="bf-topbar-link">ClaudeTemplates.net</a>
        </div>
    </div>

    <!-- ─── Header ──────────────────────────────────────────── -->
    <header class="bf-header" id="bf-header">
        <div class="bf-container bf-header-inner">
            <a class="bf-logo" href="/">
                <?php if ($isRealHome && !$fwContext): ?>
                <span class="bf-logo-label">BaseFrame</span>
                <span class="bf-logo-site">for Joomla</span>
                <?php else: ?>
                <?php if ($fwLabel === 'Vanilla'): ?>
                <span class="bf-logo-label">BaseFrame</span>
                <?php else: ?>
                <span class="bf-logo-label"><?php echo htmlspecialchars($fwLabel, ENT_QUOTES, 'UTF-8'); ?></span>
                <?php endif; ?>
                <span class="bf-logo-site"><?php echo $siteName; ?></span>
                <?php endif; ?>
            </a>

            <nav class="bf-nav" id="bf-nav" aria-label="Main">
            <?php if ($fwContext): ?>
                <ul class="mod-menu mod-list nav">
                    <li class="nav-item"><a href="/<?php echo $fwSafe; ?>">About</a></li>
                    <li class="nav-item"><a href="/">Home</a></li>
                    <li class="nav-item"><a href="/blog?fw=<?php echo $fwSafe; ?>">Blog</a></li>
                    <li class="nav-item"><a href="/forum?fw=<?php echo $fwSafe; ?>">Forum</a></li>
                    <li class="nav-item"><a href="/portfolio?fw=<?php echo $fwSafe; ?>">Portfolio</a></li>
                    <li class="nav-item"><a href="/contact?fw=<?php echo $fwSafe; ?>">Contact</a></li>
                    <li class="nav-item deeper parent"><button class="mod-menu__toggle-sub" aria-expanded="false" aria-controls="bf-fwnav-sub"><span class="mod-menu__heading nav-header">More</span><span class="icon-chevron-down" aria-hidden="true"></span></button>
                    <ul class="mod-menu__sub list-unstyled small" aria-hidden="true" id="bf-fwnav-sub">
                        <li class="nav-item"><a href="/more/gallery?fw=<?php echo $fwSafe; ?>">Gallery</a></li>
                        <li class="nav-item"><a href="/more/newsletter/archive/listing?fw=<?php echo $fwSafe; ?>">Newsletter</a></li>
                        <li class="nav-item"><a href="/more/articles-list?fw=<?php echo $fwSafe; ?>">Articles</a></li>
                        <li class="nav-item"><a href="/more/faq?fw=<?php echo $fwSafe; ?>">FAQ</a></li>
                        <li class="nav-item"><a href="/more/services?fw=<?php echo $fwSafe; ?>">Services</a></li>
                        <li class="nav-item"><a href="/more/pricing?fw=<?php echo $fwSafe; ?>">Pricing</a></li>
                        <li class="nav-item"><a href="/more/news-feeds?fw=<?php echo $fwSafe; ?>">News Feeds</a></li>
                        <li class="nav-item"><a href="/more/categories?fw=<?php echo $fwSafe; ?>">Categories</a></li>
                        <li class="nav-item"><a href="/more/tags?fw=<?php echo $fwSafe; ?>">Tags</a></li>
                        <li class="nav-item"><a href="/more/archive?fw=<?php echo $fwSafe; ?>">Archive</a></li>
                        <li class="nav-item"><a href="/more/search?fw=<?php echo $fwSafe; ?>">Search</a></li>
                        <li class="nav-item"><a href="/more/login?fw=<?php echo $fwSafe; ?>">Login</a></li>
                        <li class="nav-item"><a href="/more/typography?fw=<?php echo $fwSafe; ?>">Typography</a></li>
                        <li class="nav-item"><a href="/more/components?fw=<?php echo $fwSafe; ?>">Components</a></li>
                    </ul></li>
                </ul>
            <?php else: ?>
                <jdoc:include type="modules" name="menu" style="none" />
            <?php endif; ?>
            </nav>

            <button class="bf-hamburger" id="bf-hamburger" aria-label="Menu" aria-controls="bf-nav" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <!-- ─── Hero ────────────────────────────────────────────── -->
    <?php if ($hasHero): ?>
    <section class="bf-hero">
        <div class="bf-container">
            <jdoc:include type="modules" name="hero" style="none" />
        </div>
    </section>
    <?php endif; ?>

    <!-- ─── Main ────────────────────────────────────────────── -->
    <main id="bf-main" class="bf-main">
        <div class="bf-container">
            <jdoc:include type="message" />

            <?php if ($this->countModules('breadcrumbs')): ?>
            <jdoc:include type="modules" name="breadcrumbs" style="none" />
            <?php endif; ?>

            <?php if ($hasSidebar): ?>
            <div class="bf-layout">
                <div class="bf-content">
                    <jdoc:include type="component" />
                </div>
                <aside class="bf-sidebar">
                    <jdoc:include type="modules" name="sidebar" style="baseframe" />
                </aside>
            </div>
            <?php else: ?>
            <div class="bf-content">
                <jdoc:include type="component" />
            </div>
            <?php endif; ?>
        </div>
    <?php if ($isRealHome && $this->countModules('footer')): ?>
    <div class="bf-container" style="padding-bottom:1rem;">
        <jdoc:include type="modules" name="footer" style="none" />
    </div>
    <div class="bf-container bf-home-bottom-wrap">
        <section class="bf-home-bottom">
        <h2>Built Entirely with AI</h2>
        <p>Every line of CSS in BaseFrame &mdash; all 14 CSS adapter files, the base stylesheet, the template logic, the Kunena forum integration, the Phoca Gallery styling, the AcyMailing overrides &mdash; was written by <strong>Claude Code</strong> running inside VS Code. Not a single line was hand-coded.</p>
        <p>The entire workflow runs on a conversation: describe what you want, paste a screenshot or the deep debug CSS output, and Claude writes the fix. No context-switching between browser and editor. No manual CSS debugging. Just talk and ship.</p>
        <h2>The Secret Weapon: Stop Screenshotting CSS</h2>
        <p>The fastest way to get Claude Code to fix a CSS issue is to stop screenshotting your DevTools and start sending <strong>computed styles + matched rules + the DOM tree</strong> in one paste. This is the workflow that built BaseFrame &mdash; and it is covered in detail in <a href="https://theaidirector.win/stop-screenshotting-css" target="_blank" rel="noopener">Stop Screenshotting CSS</a> on The AI Director.</p>
        <p>That article explains the exact deep debug technique used to audit and polish every CSS framework adapter you see on this site. If you want to build or customize Joomla templates with AI, start there.</p>
        <h2>Built for Claude Code</h2>
        <p><a href="https://github.com/whynotindeed/baseframe" target="_blank" rel="noopener">BaseFrame for Joomla</a> is designed for developers using <strong>Claude Code</strong> (or any AI coding agent) to build and customize Joomla templates. Paste a deep debug CSS output, describe what you want, and Claude writes the adapter fix. Every CSS framework adapter on this site was built that way &mdash; no manual CSS debugging required.</p>
        <h2>Open Source</h2>
        <p>BaseFrame for Joomla is free and open source under the <strong>MIT License</strong>. Use it however you want &mdash; personal, commercial, no restrictions.</p>
        <div class="bf-home-cta">
            <a href="https://github.com/whynotindeed/baseframe" target="_blank" rel="noopener" class="bf-home-cta-btn bf-home-cta-primary">View on GitHub</a>
            <a href="https://github.com/whynotindeed/baseframe/releases/latest" target="_blank" rel="noopener" class="bf-home-cta-btn bf-home-cta-primary">Download ZIP</a>
            <a href="https://github.com/whynotindeed/baseframe#demo-content" target="_blank" rel="noopener" class="bf-home-cta-btn bf-home-cta-secondary">Demo Content</a>
        </div>
        </section>
    </div>
    <?php endif; ?>
    </main>

    <!-- ─── Framework bar ───────────────────────────────────── -->
    <?php if ($this->countModules('footer') && !$isRealHome): ?>
    <section class="bf-framework-section">
        <div class="bf-container">
            <jdoc:include type="modules" name="footer" style="none" />
        </div>
    </section>
    <?php endif; ?>

    <!-- ─── Footer ──────────────────────────────────────────── -->
    <footer class="bf-footer">
        <div class="bf-container">
            <?php if ($this->countModules('footer-a') || $this->countModules('footer-b') || $this->countModules('footer-c')): ?>
            <div class="bf-footer-cols">
                <?php if ($this->countModules('footer-a')): ?>
                <div class="bf-footer-col"><jdoc:include type="modules" name="footer-a" style="baseframe" /></div>
                <?php endif; ?>
                <?php if ($this->countModules('footer-b')): ?>
                <div class="bf-footer-col"><jdoc:include type="modules" name="footer-b" style="baseframe" /></div>
                <?php endif; ?>
                <?php if ($this->countModules('footer-c')): ?>
                <div class="bf-footer-col"><jdoc:include type="modules" name="footer-c" style="baseframe" /></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="bf-footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <a href="https://claudejoomla.com" style="color:inherit;text-decoration:none;">ClaudeJoomla.com</a></p>
                <p>Powered by <a href="https://www.joomla.org" target="_blank">Joomla</a>, <?php if ($fwUrl): ?><a href="<?php echo htmlspecialchars($fwUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank"><?php echo htmlspecialchars($fwLabel, ENT_QUOTES, 'UTF-8'); ?></a><?php else: ?><?php echo htmlspecialchars($fwLabel, ENT_QUOTES, 'UTF-8'); ?><?php endif; ?> &amp; <a href="https://github.com/whynotindeed/baseframe" target="_blank">BaseFrame</a> · <a href="https://weblio.no/?lang=en" style="color:inherit;opacity:.6;text-decoration:none;">weblio.no</a></p>
            </div>
        </div>
    </footer>

    <button class="bf-back-to-top" id="bf-back-to-top" aria-label="Back to top">&uarr;</button>
    <jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
