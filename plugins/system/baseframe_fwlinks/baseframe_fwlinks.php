<?php
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\Event\SubscriberInterface;

class PlgSystemBaseframe_fwlinks extends CMSPlugin implements SubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return ['onAfterRender' => 'onAfterRender'];
    }

    public function onAfterRender($event = null)
    {
        $app = Factory::getApplication();
        if (!$app->isClient('site')) return;

        $fw = $app->getInput()->getCmd('fw', '');

        // Also detect from menu alias
        if (!$fw) {
            $active = $app->getMenu()->getActive();
            if ($active) {
                $frameworks = ['bulma','uikit','foundation','fomantic','daisyui','halfmoon','openprops','cirrus','pico','mvp','sakura','chota','nes','vanilla'];
                if (in_array($active->alias, $frameworks)) {
                    $fw = $active->alias;
                }
            }
        }

        if (!$fw) return;

        // Validate fw against allowlist (defense-in-depth — getCmd already strips non-alnum)
        $allowed = ['bulma','uikit','foundation','fomantic','daisyui','halfmoon','openprops','cirrus','pico','mvp','sakura','chota','nes','vanilla'];
        if (!in_array($fw, $allowed, true)) return;

        $body = $app->getBody();

        // Append ?fw=X to <a> tag href links only (not <link>, canonical, hreflang etc.)
        $body = preg_replace_callback(
            '/<a(\s[^>]*?)href="(\/[^"]*)"/',
            function ($matches) use ($fw) {
                $attrs = $matches[1];
                $href = $matches[2];
                // Skip if already has fw=, or is a framework landing page
                if (strpos($href, 'fw=') !== false) return $matches[0];
                if (preg_match('#^/(bulma|uikit|foundation|fomantic|daisyui|halfmoon|openprops|cirrus|pico|mvp|sakura|chota|nes|vanilla)$#', $href)) return $matches[0];
                $sep = (strpos($href, '?') !== false) ? '&' : '?';
                return '<a' . $attrs . 'href="' . $href . $sep . 'fw=' . $fw . '"';
            },
            $body
        );

        // Inject hidden fw input into GET forms so search etc. preserves the framework
        $fwEscaped = htmlspecialchars($fw, ENT_QUOTES, 'UTF-8');
        $body = preg_replace(
            '/(<form\b[^>]*method="get"[^>]*>)/i',
            '$1<input type="hidden" name="fw" value="' . $fwEscaped . '">',
            $body
        );

        $app->setBody($body);
    }
}
