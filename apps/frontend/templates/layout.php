<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
</head>
<body>
    <?php if ($sf_user->isAuthenticated()) : ?>
    <table border='1' widh='100%'>
        <tr>
            <td>
                <?php echo link_to('Baseline', 'baseline/index');?>
            </td>
            <td>
                <?php echo link_to('System', 'system/index');?>
            </td>
            <td>
                <?php echo link_to('Parameter', 'parameter/index');?>
            </td>
        </tr>
    </table>
    <?php endif; ?>
    <?php echo $sf_content ?>
</body>
</html>