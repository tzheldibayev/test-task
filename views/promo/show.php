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
<?php if (isset($data['randomPromo'])): ?>
    <h2>Random Promotion: </h2>
    <p>ID: <?php echo $data['randomPromo']['id'] ?></p>
    <p>Name: <?php echo $data['randomPromo']['name'] ?></p>
    <p>Status: <?php echo $data['randomPromo']['status'] ? 'On' : 'Off' ?></p>
    <p>Start date: <?php echo date('d.m.Y', $data['randomPromo']['start_date']) ?></p>
    <p>End date: <?php echo date('d.m.Y', strtotime($data['randomPromo']['end_date'])) ?></p>
<?php endif; ?>
</body>
</html>
