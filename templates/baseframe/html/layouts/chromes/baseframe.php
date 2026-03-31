<?php
defined('_JEXEC') or die;
$module = $displayData['module'];
$params = $displayData['params'];
if ((string) $module->content === '') return;
$headerTag = htmlspecialchars($params->get('header_tag', 'h3'), ENT_QUOTES, 'UTF-8');
$sfx = trim($params->get('moduleclass_sfx', ''));
?>
<div class="bf-module <?php echo htmlspecialchars($sfx); ?>">
    <?php if ((string) $module->title !== ''): ?>
    <<?php echo $headerTag; ?> class="bf-module-title"><?php echo htmlspecialchars($module->title, ENT_QUOTES, 'UTF-8'); ?></<?php echo $headerTag; ?>>
    <?php endif; ?>
    <?php echo $module->content; ?>
</div>
