<?php use_helper('I18N') ?>
<div id="sf_admin_container">
  <?php if ($sf_user->hasFlash('notice')): ?>
    <div class="notice"><?php echo __($sf_user->getFlash('notice'), array(), 'admin') ?></div>
  <?php endif; ?>

  <?php if ($sf_user->hasFlash('error')): ?>
    <div class="error"><?php echo __($sf_user->getFlash('error'), array(), 'admin') ?></div>
  <?php endif; ?>
</div>
