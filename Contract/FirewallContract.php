<?php

/**
 * Main docblock
 *
 * PHP version 5
 *
 * @category  Contract
 * @package   EkApiCallerBundle
 * @author    Edouard Kombo <edouard.kombo@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   GIT: 1.0.0
 * @link      http://creativcoders.wordpress.com
 * @since     0.0.0
 */
namespace EdouardKombo\EkApiCallerBundle\Contract;

use EdouardKombo\PhpObjectsContractBundle\Contract\Elements\Abstractions\FirewallAbstractions;

use EdouardKombo\EkApiCallerBundle\Exception\CurlException;

/**
 * Api Caller Firewall
 *
 * @category Contract
 * @package  EkApiCallerBundle
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://creativcoders.wordpress.com
 */
class FirewallContract extends FirewallAbstractions
{
    
    /**
     * Check if curl extension is enabled
     * 
     * @return boolean
     * 
     * @throws CurlException
     */
    public function isCurlEnabled()
    {
        if (function_exists('curl_version')) {
          return true;
        }
        
        throw new CurlException('Firewall: Curl extension must be enabled!');       
    }   
    
    /**
     * Check if property exists in class
     * 
     * @param string $property Class propertyy
     * 
     * @return boolean
     * @throws CurlException
     */
    public function checkIfPropertyExists($property, $class)
    {
        $message = "EkApiCaller Exception: Unknown property '$property'. ";
        $message .= "To list valid properties, open SetGetContract class"; 

        if (!isset($class->{$property})) {
            throw new CurlException($message); 
        }           
        
        return true;
    }    
    
    /**
     * Show Curl Error
     * 
     * @param type $error_number
     * @param type $error_message
     * 
     * @throws CurlException
     */
    public function handleCurlError($error_number, $error_message)
    {
        switch ($error_number) {
            case CURLE_COULDNT_CONNECT:
            case CURLE_COULDNT_RESOLVE_HOST:
            case CURLE_OPERATION_TIMEOUTED:
                $message = 'Internet connection error, please try again !';
                break;
            case CURLE_SSL_CACERT:
            case CURLE_SSL_PEER_CERTIFICATE:
            case 77:
                $message  = 'Peer certificate or CA cert issue. Try to bypass ';
                $message .= 'CURLE_SSL_PEER_CERTIFICATE.';
                break;
            default:
                $message = 'Unexpected error communicating with API.';
                break;
        }
        $exception  = 'Curl network error #' . $error_number . ': ' . $message;
        $exception .= ' (' . $error_message . ')';
        
        throw new CurlException($exception);
    }   
    
    /**
     * Get Curl http Response
     * 
     * @param  string $response Curl http response
     * @param  mixed  $code     Curl http code response
     * 
     * @return array
     * @throws CurlException
     */
    public function getResponse($response, $code)
    {
        try {
            $response_decoded = json_decode($response, true);
            
        } catch (CurlException $e) {
            $message  = "Invalid body API response (HTTP code ' . $code . '): ";
            $message .= $response;
            
            throw new CurlException($message);
        }     
        
        return array($response_decoded, $code);
    }   
}