<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('parameter/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
          <?php echo $form->renderHiddenFields(false) ?>
          &nbsp;<a href="<?php echo url_for('parameter/index') ?>">Back to list</a>
          <?php if (!$form->getObject()->isNew()): ?>
            &nbsp;<?php echo link_to('Delete', 'parameter/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?')) ?>
          <?php endif; ?>
          <input type="submit" value="Save" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><?php echo $form['jiraBaseUrl']->renderLabel() ?></th>
        <td>
          <?php echo $form['jiraBaseUrl']->renderError() ?>
          <?php echo $form['jiraBaseUrl'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['svnBaseUrl']->renderLabel() ?></th>
        <td>
          <?php echo $form['svnBaseUrl']->renderError() ?>
          <?php echo $form['svnBaseUrl'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['ftpHost']->renderLabel() ?></th>
        <td>
          <?php echo $form['ftpHost']->renderError() ?>
          <?php echo $form['ftpHost'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['ftpUser']->renderLabel() ?></th>
        <td>
          <?php echo $form['ftpUser']->renderError() ?>
          <?php echo $form['ftpUser'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['ftpPassword']->renderLabel() ?></th>
        <td>
          <?php echo $form['ftpPassword']->renderError() ?>
          <?php echo $form['ftpPassword'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['ftpPort']->renderLabel() ?></th>
        <td>
          <?php echo $form['ftpPort']->renderError() ?>
          <?php echo $form['ftpPort'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['testBaselineMailBody']->renderLabel() ?></th>
        <td>
          <?php echo $form['testBaselineMailBody']->renderError() ?>
          <?php echo $form['testBaselineMailBody'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['releaseBaselineMailBody']->renderLabel() ?></th>
        <td>
          <?php echo $form['releaseBaselineMailBody']->renderError() ?>
          <?php echo $form['releaseBaselineMailBody'] ?>
        </td>
      </tr>
      <tr>
        <th><?php echo $form['availabilityMailBody']->renderLabel() ?></th>
        <td>
          <?php echo $form['availabilityMailBody']->renderError() ?>
          <?php echo $form['availabilityMailBody'] ?>
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
