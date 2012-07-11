<?php if ($sf_user->hasFlashes()): ?>
  <?php include_partial('vjGuardADAuth/flashes') ?>
<?php endif; ?>
<div id="login">
  <div class="login_title"><?php echo __('Authentication', array(), 'vjGuardAD') ?></div>
  <form name="form_login" id="form_login" method="post" action="<?php echo url_for('@vjGuardADAuthLogin') ?>">
    <table id="login_form">
      <?php echo $form ?>
      <tr>
        <td colspan="2">
          <input type="submit" value="<?php echo __('Connect', array(), 'vjGuardAD') ?>" id="login_submit" />
        </td>
      </tr>
      <?php if(sfConfig::get('app_ad_ntlm_active')): ?>
      <tr>
        <td colspan="2">
          <?php echo link_to(__('Automatic connection', array(), 'vjGuardAD'),'@vjGuardADAuthLoginNtlm') ?>
        </td>
      </tr>
      <? endif ?>
    </table>
  </form>
</div>