<?php
/**
 * BaseFrame — Blog item card
 * Clean semantic HTML. CSS adapters handle all visual styling.
 */
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

$item = $this->item;
$link = Route::_(RouteHelper::getArticleRoute($item->slug, $item->catid, $item->language));
$images = json_decode($item->images ?? '{}');
$hasImage = !empty($images->image_intro);
$pubDate = $item->publish_up ?? $item->created ?? '';
?>
<article class="bf-card" itemscope itemtype="https://schema.org/BlogPosting">

    <?php if ($hasImage): ?>
    <a href="<?php echo $link; ?>" class="bf-card-image">
        <img src="<?php echo htmlspecialchars($images->image_intro); ?>"
             alt="<?php echo htmlspecialchars($images->image_intro_alt ?? $item->title); ?>"
             loading="lazy">
    </a>
    <?php endif; ?>

    <div class="bf-card-body">
        <?php if (!empty($item->tags->itemTags)): ?>
        <div class="bf-card-tags">
            <?php foreach ($item->tags->itemTags as $tag): ?>
            <span class="bf-tag"><?php echo htmlspecialchars($tag->title); ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <h2 class="bf-card-title">
            <a href="<?php echo $link; ?>" itemprop="url"><?php echo $this->escape($item->title); ?></a>
        </h2>

        <?php if ($pubDate): ?>
        <time class="bf-card-date" datetime="<?php echo htmlspecialchars($pubDate); ?>" itemprop="datePublished">
            <?php echo HTMLHelper::_('date', $pubDate, 'j M Y'); ?>
        </time>
        <?php endif; ?>

        <div class="bf-card-text" itemprop="articleBody">
            <?php echo $item->introtext; ?>
        </div>

        <a href="<?php echo $link; ?>" class="bf-card-readmore">Read More</a>
    </div>
</article>
