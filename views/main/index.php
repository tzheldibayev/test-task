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
<h1>Promotions!</h1>
    <?php if (isset($data['tableExists']) && $data['tableExists'] == 1): ?>
        <?php echo 'Table exists.' ?>
    <?php endif; ?>
<hr>
<?php if (isset($data['randomPromo'])): ?>
    <h2>Random Promotion: </h2>
    <p>ID: <?php echo $data['randomPromo']['id'] ?></p>
    <p>Name: <?php echo $data['randomPromo']['name'] ?></p>
    <p>Status: <?php echo $data['randomPromo']['status'] ? 'On' : 'Off' ?></p>
    <p>Start date: <?php echo date('d.m.Y', $data['randomPromo']['start_date']) ?></p>
    <p>End date: <?php echo date('d.m.Y', strtotime($data['randomPromo']['end_date'])) ?></p>
<?php endif; ?>

<?php if (count($data['promotions'])) : ?>
    <h2>All promotions: </h2>
    <?php foreach($data['promotions'] as $promo): ?>
        <p>ID: <?php echo $promo['id'] ?></p>
        <p>Name: <?php echo $promo['name'] ?></p>
        <p>Status: <?php echo $promo['status'] ? 'On' : 'Off' ?></p>
        <p>Start date: <?php echo date('d.m.Y', $promo['start_date']) ?></p>
        <p>End date: <?php echo date('d.m.Y', strtotime($promo['end_date'])) ?></p>

    <hr>
    <?php endforeach ?>
<?php endif; ?>
</body>
</html>
