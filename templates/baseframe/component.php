<?php
defined('_JEXEC') or die;
$mediaBase = \Joomla\CMS\Uri\Uri::root(true) . '/media/templates/site/' . $this->template;
?><!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?php echo $mediaBase; ?>/css/base.css">
<jdoc:include type="metas" /><jdoc:include type="styles" /><jdoc:include type="scripts" />
</head>
<body class="bf-component">
<div class="bf-container" style="padding:2rem 1.5rem">
<jdoc:include type="message" /><jdoc:include type="component" />
</div>
</body>
</html>
