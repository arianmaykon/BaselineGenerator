<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Documento sem título</title>
</head>
<body>



<?php
  $issues = $sf_data->getRaw('issues');

  printIssues($issues['demands']     , 'DEMANDAS');
  printIssues($issues['crs']         , 'SOLICITAÇÕES DE MUDANÇA');
  printIssues($issues['improvements'], 'MELHORIAS IMPLEMENTADAS');
  printIssues($issues['bugs']        , 'BUGS CORRIGIDOS');

  function printIssues($data, $title) {
  if (count($data['issues'])) :
?>

<h1><font size="3"><?php echo $title;?></font></h1>

<table border="1">
  <tbody>
    <tr>
      <td >
        <b>Issue</b>
      </td>
      <td>
        <b>Descrição</b>
      </td>
    </tr>
<?php
      for($x=0; $x<count($data['issues']); $x++) :
        $key = $data['issues'][$x];
        $summary = $data['description'][$x];
?>
    <tr>
      <td>
        <?php echo $key;?>
      </td>
      <td>
        <?php echo $summary;?>
      </td>
    </tr>
    <?php endfor; ?>
  </tbody>
</table>

<?php
    endif;
  }
?>


</body>
</html>