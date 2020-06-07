<?php
require 'vendor/autoload.php';

define('SITE_URL', 'http://localhost/paypal');
//todo dentro del paypal sdk usa namespaces
$credencial = new \PayPal\Auth\OAuthTokenCredential(
    'AQ-2Og_yAGyWU8-Hieuoa9FsrtfsElnaPVsEjsTo71qkjAxiOKhUtS_XKHtlLCSBUF24B7oQZIEC0cPy',
    'ENOPrSObIt2Oo86wieYZUxtXVBIpSonSudNf84AqvL7Kk5uRbAVi8r2zUQuzoQp1Ev5zSZOg2yvwX0Nz'
);
$paypal = new \PayPal\Rest\ApiContext($credencial);
