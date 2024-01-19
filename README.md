# php QR Code generator library

* Generate QRcode from a single PHP file. MIT license.
* Output to raw PNG or base64 encoded data

## Install

```bash
composer require apirone/php-qr-code
```

## Usage

```php

require_once('../vendor/autoload.php';

use Apirone\Lib\PhpQrCode\QrCode;

// Quick static method with base64 encoded PNG

$data = 'Lorem ipsum dolor sit amet';
$options = [
    's' => 'qrm',
    'fc' => '#000000',
    'bc' => '#FFFFFF',
    // ...
];

$base64_qr_encoded = QrCode::png($data, $options);
echo '<img src="' . $base64_qr_encoded . '"> ';

// Create and use qr instant
$qr = QRCode::init($data, $options); // $data & $options are optional

// Also you can use chain to set some options (not all)
$options['s'] = 'qrq';
$image_encoded = $qr->data($data)->options($options)->base64();

echo '<img src="' . $image_encoded . '"> ';

$image_raw = QRCode::init()
    ->data($data)
    ->levelHigh()
    ->density(0.5)
    ->raw();

echo '<img src="data:image/png;base64,' . base64_encode($image_raw) . '"> ';

```

## Options

Use options array to initialize class:

```php
$options = [
    's' => 'qrl',
    'fc' => '#000000',
    'bc' => '#FFFFFF',
    // ...
];
```

### Available options keys

You can define option as `[key => value, ...]` or use the option name as a property `$qr->s = 'qrl'`

* `s` - QR error correction level. Available values:
  * `qrl` - Level L (Low) 7% of data bytes can be restored.
  * `qrm` - Level M (Medium) 15% of data bytes can be restored.
  * `qrq` - Level Q (Quartile) 25% of data bytes can be restored.
  * `qrh` - Level H (High) 30% of data bytes can be restored.

* `w` - Width of image. Overrides `sf` or `sx`.
* `h` - Height of image. Overrides `sf` or `sy`.
* `sf` - Scale factor. Default 4.
* `sx` - Horizontal scale factor. Overrides `sf`.
* `sy` - Vertical scale factor. Overrides `sf`.
* `p`  - Padding. Default is 0.
* `pv` - Top and bottom padding. Default is value of `p``.
* `ph` - Left and right padding. Default is value of `p`.
* `pt` - Top padding. Default is value of `pv`.
* `pl` - Left padding. Default is value of `ph`.
* `pr` - Right padding. Default is value of `ph`.
* `pb` - Bottom padding. Default is value of `pv`.
* `fc` - Foreground color in `#RRGGBB` format.
* `bc` - Background color in `#RRGGBB` format.
* `md` - Module density. A number between 0 and 1. Default is 1.
* `wq` - Width of quiet area units. Default is 1. Use 0 to suppress quiet area.
* `wm` - Width of narrow modules and spaces. Default is 1.

## Methods

### Init methods. Static.

* `png($data, $options = [])` - Convenience method to quickly generate an base64 encoded PNG. Static.
* `init($data = '', $options = [])` - Init QR code instance. Static.

### Set error correction levels

* `levelLow()` - Set `s` option to `qrl`.
* `levelMid()` - Set `s` option to `qrm`.
* `levelQrt()` - Set `s` option to `qrq`.
* `levelHigh()` - Set `s` option to `qrh`.
* `levelAuto()` - Unset `s` option.

### Some parameters setup methods

Call methods without params to clear options value.

* `data($data = '')` - Set QR code data
* `options($options = [])` - Set QR code options
* `size($size = null)` - Generated image size. Sets both `h` and `w` options to the same value.
* `scale($scale = null)` - Set `sf` option value.
* `padding($padding = null)` - Set `p` option.
* `color($color = null)`  - Set `fc` option.
* `background($color = null)` - Set `bc` option.
* `quietZone($size = null)` - Set `wq` option.
* `density($density = null)` - Set `md` option.

### Generate QR methods
* `render_image()` - Return generated GD resource.
* `raw()` - Return raw PNG image data.
* `base64()` - Return bse64 encoded PNG image data.
