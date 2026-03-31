<?php
/**
 * BaseFrame — Blog category layout
 * Clean semantic HTML. All styling handled by CSS adapters.
 */
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
?>
<div class="bf-blog" itemscope itemtype="https://schema.org/Blog">

    <?php if ($this->params->get('show_page_heading')): ?>
    <h1 class="bf-page-title"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php endif; ?>

    <?php if (!empty($this->lead_items)): ?>
    <div class="bf-blog-leading">
        <?php foreach ($this->lead_items as $item): ?>
            <?php $this->item = $item; echo $this->loadTemplate('item'); ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($this->intro_items)): ?>
    <div class="bf-blog-grid">
        <?php foreach ($this->intro_items as $key => $item): ?>
            <?php $this->item = $item; echo $this->loadTemplate('item'); ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($this->link_items)): ?>
    <div class="bf-blog-links">
        <?php echo $this->loadTemplate('links'); ?>
    </div>
    <?php endif; ?>

    <?php if (($this->params->def('show_pagination', 1) == 1 || $this->params->get('show_pagination') == 2) && $this->pagination->pagesTotal > 1): ?>
    <nav class="bf-pagination" aria-label="Pagination">
        <?php echo $this->pagination->getPagesLinks(); ?>
    </nav>
    <?php endif; ?>
</div>
