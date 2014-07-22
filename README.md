Ek Api Caller Bundle
====================

About
-----

This bundle helps you call any web api easily via Curl.
Designed with CABIN design pattern (Concrete ABstraction of INterfaces), it offers clear, logic code syntax validating S.O.L.I.D principles.


CABIN principle? What's that?
-----------------------------

CABIN stands for Concrete ABstraction of INterfaces, more informations here: https://creativcoders.wordpress.com/2014/05/10/cabin-principle-or-how-to-define-an-object-oriented-code/


Requirements
------------

Require PHP version 5.3 or greater.


Installation
------------

Register the bundle in your composer.json

    {
        "require": {
            "edouardkombo/ek-api-caller-bundle": "dev-master"
        }
    }

Now, install the vendor

    php composer.phar install


Register MultiStepFormsBundle namespace in your app/appKernel.php

    new EdouardKombo\EkApiCallerBundle\EkApiCallerBundle(),


Set config parameters in app/config/config.php

    ek_api_caller:
        cache:                   true
        verify_ssl_certificates: false
        timeout:                 90 #Maximum time of curl request
        connect_timeout:         30 #Wait x seconds before reconnect


Documentation
-------------

How to use it? 
Inside your controller, call the httpContract service like this:

    $curl = $this->get('ek_api_caller.contract.http');
    $curl->setParameter('url',     $url);      
    $curl->setParameter('headers', $httpHeaders); //$httpHeaders => array       
    $curl->setParameter('datas',   $urlDatas);   //$urlDatas   => array
    
    //Available methods for request are post, get, delete
    //These methods return an array of two values (response message, and http status code)
    //You can use these values to generate your api specific errors 
    $curl->post();

    //$urlDatas array are automatically encoded, just specify an array of key => values
    //Example for stripe api
    $urlDatas = [
        'amount'   => 5500,
        'currency' => 'EUR',
        'card' => [
            'number'    => '4242424242424242',
            'exp_month' => '10',
            'exp_year'  => '16',
            'cvc'       => '123',
        ],           
    ];
    

    //$httpHeaders must be array to, but without key values
    //Example for stripe api
    $user_agent = [
        'bindings_version' => '1.0.0',
        'lang'             => 'php',
        'lang_version'     => PHP_VERSION,
        'publisher'        => 'scribe',
        'uname'            => php_uname(),
    ];

    $httpHeaders = [
        'X-Stripe-Client-User-Agent: '    . json_encode($user_agent),
        'User-Agent: Stripe/v1 ScribeStripeBundle/' . '1.0.0',
        'Authorization: Bearer '          . 'STRIPE_SECRET_KEY',
        'Stripe-Version: '                . '2014-01-31'
    ];     

    
Contributing
-------------

If you want to help me improve this bundle, please make sure it conforms to the PSR coding standard. The easiest way to contribute is to work on a checkout of the repository, or your own fork, rather than an installed version.

Issues
------

Bug reports and feature requests can be submitted on the [Github issues tracker](https://github.com/edouardkombo/EkApiCallerBundle/issues).

For further informations, contact me directly at edouard.kombo@gmail.com.

