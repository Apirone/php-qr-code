<html lang="en">
<head>
<title>qrcode.php qr code test</title>
<style>
    body {
        font-family: Helvetica, sans-serif;
        padding: 1em;
    }

    img {
        border: 1px solid #aaa;
    }
</style>
</head>
<body>

<?php
require_once '../vendor/autoload.php';
use Apirone\Lib\PhpQRCode\QRCode;

function pa($mixed, $title = '')
{
    $title = $title ? $title . ': ' : '';
    if (is_bool($mixed)) {
        $mixed = $mixed ? 'true' : 'false';
    }
    echo '<pre>' . $title . print_r($mixed, true) . '</pre>';
}

$data = 'bitcoin-testnet%3A2MtGk8WbbNB8Pbi2ZcrLg9bthbVk47T1Zie%3Famount%3D0.00007328';
$inputs = [
    $data,
    rawurldecode('Lorem Ipsum - "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit..."'),
];

$sizes = [
    'qrl', 'qrm', 'qrq', 'qrh'
];

echo '<h2>Use options array for settings</h2>';

foreach($inputs as $input) {
    echo '<h3>' . $input . '</h3>';

    foreach ($sizes as $size) {
        echo sprintf('<p>Option size - "s" set to "%s"', $size);
        echo '<p>';
        echo sprintf('<img src="%s">', QRCode::png($input, ['s' => $size]));
        echo '</p>';
    }
}

echo '<h2>Use `object style` to set some options</h2>';
?>
<pre>
QRCode::init($data)
    ->levelHigh()
    ->density(0.5)
    ->quietZone(0)
    ->background('dddddd')
    ->color('ff00ff')
    ->padding(20)
    ->base64();
</pre>
<?php
echo sprintf('<img src="%s">', QRCode::init($data)
    ->levelHigh()
    ->density(0.5)
    ->quietZone(0)
    ->background('dddddd')
    ->color('ff00ff')
    ->padding(20)
    ->scale(8)
    ->base64());
?>

</body>
</html>