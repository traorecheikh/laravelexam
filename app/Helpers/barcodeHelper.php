<?php

use Milon\Barcode\DNS1D;

if (!function_exists('generateBarcode')) {
    function generateBarcode($reference)
    {
        return app(DNS1D::class)->getBarcodePNG($reference, 'C39');
    }
}
