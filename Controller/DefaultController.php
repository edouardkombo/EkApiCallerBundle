<?php

namespace EdouardKombo\EkApiCallerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user_agent = [
            'bindings_version' => '1.0.0',
            'lang'             => 'php',
            'lang_version'     => PHP_VERSION,
            'publisher'        => 'scribe',
            'uname'            => php_uname(),
        ];

        $headers = [
            'X-Stripe-Client-User-Agent: '    . json_encode($user_agent),
            'User-Agent: Stripe/v1 ScribeStripeBundle/' . '1.0.0',
            'Authorization: Bearer '          . '',
            'Stripe-Version: '                . '2014-01-31'
        ];        
        
        $curl = $this->get('ek_api_caller.contract.http');
        $curl->setParameter('url', 'https://api.stripe.com/v1/charges');      
        $curl->setParameter('headers', $headers);        
        $curl->setParameter('datas', [
            'amount'   => 5500,
                'currency' => 'EUR',
                'card' => [
                    'number'    => '4242424242424242',
                    'exp_month' => '10',
                    'exp_year'  => '16',
                    'cvc'       => '123',
                ],           
            ]
        );
        $result = $curl->post();
        
        echo var_dump($result);
        
        return $this->render('EkApiCallerBundle:Default:index.html.twig');
    }
}
