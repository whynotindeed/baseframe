<?php
defined('_JEXEC') or die;
$errorCode = $this->error->getCode();
$siteName = \Joomla\CMS\Factory::getApplication()->get('sitename', 'BaseFrame');
?><!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo (int) $errorCode; ?> — <?php echo htmlspecialchars($siteName); ?></title>
<style>
  body { font-family: system-ui, sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; background: #f5f5f5; color: #333; }
  .error { text-align: center; }
  .error h1 { font-size: 6rem; margin: 0; font-weight: 700; color: #999; }
  .error p { font-size: 1.2rem; margin: 1rem 0 2rem; }
  .error a { display: inline-block; padding: .75rem 2rem; background: #333; color: #fff; text-decoration: none; border-radius: .5rem; }
  .error a:hover { background: #555; }
</style>
</head>
<body>
<div class="error">
  <h1><?php echo (int) $errorCode; ?></h1>
  <?php
  $safeMessages = [403 => 'Access denied.', 404 => 'Page not found.', 500 => 'Something went wrong.'];
  $msg = $safeMessages[$errorCode] ?? 'Something went wrong.';
  ?>
  <p><?php echo $msg; ?></p>
  <a href="/">Back to Home</a>
</div>
</body>
</html>
