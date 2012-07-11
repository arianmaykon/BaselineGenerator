<h1>Baselines List</h1>

<table border='1'>
  <thead>
    <tr>
      <th>Id</th>
      <!-- <th>Generate</th> -->
      <th>System</th>
      <th>Name</th>
      <th>Type</th>
      <th>Publish to ftp</th>
      <th>Send mail</th>
      <th>Send availability mail</th>
      <th>Issues</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Created by</th>
      <th>Updated by</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($baselines as $baseline): ?>
    <tr>
      <td><a href="<?php echo url_for('baseline/edit?id='.$baseline->getId()) ?>"><?php echo $baseline->getId() ?></a></td>
<!--      <td>
        <?php if ($baseline->getGeneratedAt()) : ?>
        Gerada em <?php echo $baseline->getGeneratedAt(); ?>
        <?php else: ?>
        <a href="<?php echo url_for('baseline/generate?id=' . $baseline->getId()) ?>">Gerar</a>
        <?php endif; ?>
      </td> -->
      <td><?php echo $baseline->getSystem()->getName() ?></td>
      <td><?php echo $baseline->getName() ?></td>
      <td><?php echo $baseline->getType() ?></td>
      <td><?php echo $baseline->getPublishToFTP() ?></td>
      <td><?php echo $baseline->getSendMail() ?></td>
      <td><?php echo $baseline->getSendAvailabilityMail() ?></td>
      <td><?php echo $baseline->getIssues() ?></td>
      <td><?php echo $baseline->getCreatedAt() ?></td>
      <td><?php echo $baseline->getUpdatedAt() ?></td>
      <td><?php echo $baseline->getCreatedBy() ?></td>
      <td><?php echo $baseline->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('baseline/new') ?>">New</a>
