<?php
/**
 * @var $data array
 */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hello, world!</title>
</head>
<body>
<?php if (isset($data[0])): ?>
    <h2>Promotion: </h2>
    <p>ID: <?php echo $data[0]['id'] ?></p>
    <p>Name: <?php echo $data[0]['name'] ?></p>
    <p>Status: <?php echo $data[0]['status'] ? 'On' : 'Off' ?></p>
    <p>Start date: <?php echo date('d.m.Y', $data[0]['start_date']) ?></p>
    <p>End date: <?php echo date('d.m.Y', strtotime($data[0]['end_date'])) ?></p>
<?php endif; ?>
</body>
</html>
