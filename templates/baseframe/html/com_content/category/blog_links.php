<?php
defined('_JEXEC') or die;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;
?>
<?php if (!empty($this->link_items)): ?>
<ul class="bf-link-list">
    <?php foreach ($this->link_items as $item): ?>
    <li><a href="<?php echo Route::_(RouteHelper::getArticleRoute($item->slug, $item->catid, $item->language)); ?>"><?php echo $this->escape($item->title); ?></a></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>
