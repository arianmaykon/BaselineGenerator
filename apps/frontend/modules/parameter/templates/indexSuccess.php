<h1>Parameters List</h1>

<table>
  <thead>
    <tr>
      <th>Id</th>
      <th>Jira base url</th>
      <th>Svn base url</th>
      <th>Ftp host</th>
      <th>Ftp user</th>
      <th>Ftp password</th>
      <th>Ftp port</th>
      <th>Test baseline mail body</th>
      <th>Release baseline mail body</th>
      <th>Availability mail body</th>
      <th>Created at</th>
      <th>Updated at</th>
      <th>Created by</th>
      <th>Updated by</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($parameters as $parameter): ?>
    <tr>
      <td><a href="<?php echo url_for('parameter/edit?id='.$parameter->getId()) ?>"><?php echo $parameter->getId() ?></a></td>
      <td><?php echo $parameter->getJiraBaseUrl() ?></td>
      <td><?php echo $parameter->getSvnBaseUrl() ?></td>
      <td><?php echo $parameter->getFtpHost() ?></td>
      <td><?php echo $parameter->getFtpUser() ?></td>
      <td><?php echo $parameter->getFtpPassword() ?></td>
      <td><?php echo $parameter->getFtpPort() ?></td>
      <td><?php echo $parameter->getTestBaselineMailBody() ?></td>
      <td><?php echo $parameter->getReleaseBaselineMailBody() ?></td>
      <td><?php echo $parameter->getAvailabilityMailBody() ?></td>
      <td><?php echo $parameter->getCreatedAt() ?></td>
      <td><?php echo $parameter->getUpdatedAt() ?></td>
      <td><?php echo $parameter->getCreatedBy() ?></td>
      <td><?php echo $parameter->getUpdatedBy() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('parameter/new') ?>">New</a>
