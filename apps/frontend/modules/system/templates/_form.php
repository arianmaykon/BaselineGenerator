<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('system/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('system/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'system/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['name']->renderLabel() ?></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['acronym']->renderLabel() ?></th>
        <td>
          <?php echo $form['acronym']->renderError() ?>
          <?php echo $form['acronym'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['jiraComponent']->renderLabel() ?></th>
        <td>
          <?php echo $form['jiraComponent']->renderError() ?>
          <?php echo $form['jiraComponent'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['dependencies']->renderLabel() ?></th>
        <td>
          <?php echo $form['dependencies']->renderError() ?>
          <?php echo $form['dependencies'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['svnCopyFolder']->renderLabel() ?></th>
        <td>
          <?php echo $form['svnCopyFolder']->renderError() ?>
          <?php echo $form['svnCopyFolder'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['sourceFolderCompressionType']->renderLabel() ?></th>
        <td>
          <?php echo $form['sourceFolderCompressionType']->renderError() ?>
          <?php echo $form['sourceFolderCompressionType'] ?>
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
