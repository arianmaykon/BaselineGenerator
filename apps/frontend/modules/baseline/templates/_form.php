<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('baseline/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('baseline/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'baseline/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['fk_system']->renderLabel() ?></th>
        <td>
          <?php echo $form['fk_system']->renderError() ?>
          <?php echo $form['fk_system'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['type']->renderLabel() ?></th>
        <td>
          <?php echo $form['type']->renderError() ?>
          <?php echo $form['type'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['publishToFTP']->renderLabel() ?></th>
        <td>
          <?php echo $form['publishToFTP']->renderError() ?>
          <?php echo $form['publishToFTP'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['sendMail']->renderLabel() ?></th>
        <td>
          <?php echo $form['sendMail']->renderError() ?>
          <?php echo $form['sendMail'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['sendAvailabilityMail']->renderLabel() ?></th>
        <td>
          <?php echo $form['sendAvailabilityMail']->renderError() ?>
          <?php echo $form['sendAvailabilityMail'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['issues']->renderLabel() ?></th>
        <td>
          <?php echo $form['issues']->renderError() ?>
          <?php echo $form['issues'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['created_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_at']->renderError() ?>
          <?php echo $form['created_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['updated_at']->renderLabel() ?></th>
        <td>
          <?php echo $form['updated_at']->renderError() ?>
          <?php echo $form['updated_at'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['created_by']->renderLabel() ?></th>
        <td>
          <?php echo $form['created_by']->renderError() ?>
          <?php echo $form['created_by'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['updated_by']->renderLabel() ?></th>
        <td>
          <?php echo $form['updated_by']->renderError() ?>
          <?php echo $form['updated_by'] ?>
        </td>
      </tr>
    </tbody>
  </table>
</form>
