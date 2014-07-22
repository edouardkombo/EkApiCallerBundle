<?php

/**
 * Main docblock
 *
 * PHP version 5
 *
 * @category  Handler
 * @package   EkApiCallerBundle
 * @author    Edouard Kombo <edouard.kombo@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   GIT: 1.0.0
 * @link      http://creativcoders.wordpress.com
 * @since     0.0.0
 */
namespace EdouardKombo\EkApiCallerBundle\Helper;

/**
 * Api Caller Helper
 *
 * @category Helper
 * @package  EkApiCallerBundle
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://creativcoders.wordpress.com
 */
class ApiCallerHelper
{
    
    /**
     *
     * @var object
     */
    public $setGetContract;
    
    /**
     *
     * @var object
     */
    public $firewall;
    
    /**
     *
     * @var object
     */
    public $comm;    
    
    /**
     * COnstructor
     * 
     * @param \EdouardKombo\PhpObjectsContractBundle\Contract\SetGetCOntract        $setGetContract SetGet Contrat
     * @param array                                                                 $parameters     EkApiCaller parameters config
     * @param \EdouardKombo\PhpObjectsContractBundle\Contract\FirewallContract      $firewall       Class that throws exceptions
     * @param \EdouardKombo\PhpObjectsContractBundle\Contract\CommunicationCOntract $comm           Communication Contract
     */
    public function __construct($setGetContract, $parameters, $firewall, $comm)
    {
        $this->comm             = $comm;
        
        $this->firewall         = $firewall;
        $this->firewall->isCurlEnabled();
        
        $this->setGetContract   = $setGetContract;
        
        $this->setGetContract->cursor = 'verifySSLCertificates';
        $this->setGetContract->set($parameters['verify_ssl_certificates']);
        $this->setGetContract->cursor = 'cache';
        $this->setGetContract->set($parameters['cache']);
        $this->setGetContract->cursor = 'timeout';
        $this->setGetContract->set($parameters['timeout']);
        $this->setGetContract->cursor = 'connectTimeout';
        $this->setGetContract->set($parameters['connect_timeout']);        
    }  
    
    /**
     * Encode datas
     * 
     * @param  array       $data   Url ldatas to encode
     * @param  null|string $prefix Datas prefix
     * 
     * @return string
     */
    private function encodeDatas(array $data = array(), $prefix = null)
    {
        $parameters = [];

        foreach ($data as $key => $value) {
            if (is_null($value)) {
                continue;
            }

            if ($prefix !== null && $key && !is_int($key)) {
                $key = $prefix . '[' . $key . ']';
            } else if ($prefix !== null) {
                $key = $prefix . '[]';
            }

            if (is_array($value)) {
                $parameters[] = $this->encodeDatas($value, $key);
            } else {
                $parameters[] = urlencode($key) . '=' . urlencode($value);
            }
        }

        return implode('&', $parameters);
    }    
    
    /**
     * Main method for sending curl request, needs curlMethodSetOpt
     * 
     * @param string $method Http method
     * 
     * @return mixed
     */
    public function curlMethod($method)
    {
        $url            = $this->setGetContract->url;
        $datas          = $this->setGetContract->datas;
        $encodedDatas   = $this->encodeDatas($datas);
        $handle         = curl_init($url);
       
        $nUrl = $this->curlMethodSetopt($url, $datas, $encodedDatas, $handle, 
                $method);       
        
        $this->setGetContract->cursor = 'url';
        $this->setGetContract->set($nUrl);
        
        $this->setGetContract->cursor = 'handle';
        $this->setGetContract->set($handle);       
        
        $this->comm->handle = $handle;
        list($response, $code, $errorNumber, $errorMessage) 
                = $this->comm->send();        
        
        if (false === $response) {
            $this->firewall->handleCurlError($errorNumber, $errorMessage);
        }         
        
        return $this->firewall->getResponse($response, $code);
    }
    
    /**
     * Method that sets curlSeptOpt requests
     * 
     * @param string $url          Url to target
     * @param array  $datas        Url params
     * @param string $encodedDatas Url params encoded
     * @param mixed  $handle       Curl url return
     * @param string $method       Http method
     * 
     * @return string
     */
    private function curlMethodSetopt($url, $datas, $encodedDatas, $handle, 
            $method)
    {
        $c = $this->setGetContract;
        
        if ($method === 'get') {
            curl_setopt($handle, CURLOPT_HTTPGET, 1);
            
        } else if ($method === 'post') {
            curl_setopt($handle, CURLOPT_POST, 1);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $encodedDatas);
            
        } else if ($method === 'delete') {
            curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE'); 
        }
 
        $newUrl = (count($datas) > 0) ? $url.'?'.$encodedDatas : $url;         
        
        curl_setopt($handle, CURLOPT_FRESH_CONNECT,  $c->cache);
        curl_setopt($handle, CURLOPT_URL,            $newUrl);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $c->connectTimeout);
        curl_setopt($handle, CURLOPT_TIMEOUT       , $c->timeout);
        if (is_array($c->headers) && !empty($c->headers)) {
            curl_setopt($handle, CURLOPT_HTTPHEADER,     $c->headers);
        }
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, $c->verifySSLCertificates);
        
        return $newUrl;
    }       
}