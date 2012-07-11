<h1>Systems List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Name</th>
      <th>Acronym</th>
      <th>Jira component</th>
      <th>Dependencies</th>
      <th>Svn copy folder</th>
      <th>Source folder compression type</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Created by</th>
      <th>Updated by</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($systems as $system): ?>
    <tr>
      <td><a href="<?php echo url_for('system/edit?id='.$system->getId()) ?>"><?php echo $system->getId() ?></a></td>
      <td><?php echo $system->getName() ?></td>
      <td><?php echo $system->getAcronym() ?></td>
      <td><?php echo $system->getJiraComponent() ?></td>
      <td><?php echo $system->getDependencies() ?></td>
      <td><?php echo $system->getSvnCopyFolder() ?></td>
      <td><?php echo $system->getSourceFolderCompressionType() ?></td>
      <td><?php echo $system->getCreatedAt() ?></td>
      <td><?php echo $system->getUpdatedAt() ?></td>
      <td><?php echo $system->getCreatedBy() ?></td>
      <td><?php echo $system->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('system/new') ?>">New</a>
