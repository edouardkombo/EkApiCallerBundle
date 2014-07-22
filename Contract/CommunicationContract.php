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

use EdouardKombo\PhpObjectsContractBundle\Contract\Elements\Abstractions\CommunicationAbstractions;

/**
 * ApiCaller Communication Contract
 *
 * @category Contract
 * @package  EkApiCallerBundle
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://creativcoders.wordpress.com
 */
class CommunicationContract extends CommunicationAbstractions
{
         
    /**
     *
     * @var mixed
     */
    public $handle;
    
    /**
     * Send something
     * 
     * @return mixed
     */
    public function send()
    {
        $handle         = $this->handle;
        $response       = curl_exec($handle);
        $response_code  = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $errorNumber    = curl_errno($handle);
        $errorMessage   = curl_error($handle);

        curl_close($handle);

        return [$response, $response_code, $errorNumber, $errorMessage];        
    }
    
    /**
     * Receive something
     * 
     * @return mixed
     */
    public function receive()
    {
        
    }   
}