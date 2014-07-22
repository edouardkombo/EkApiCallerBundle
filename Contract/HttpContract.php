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

use EdouardKombo\PhpObjectsContractBundle\Contract\Elements\Abstractions\HttpAbstractions;

/**
 * ApiCaller Http Contract
 *
 * @category Contract
 * @package  EkApiCallerBundle
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://creativcoders.wordpress.com
 */
class HttpContract extends HttpAbstractions
{
    
    /**
     *
     * @var object 
     */
    public $helper;
    
    /**
     * Constructor
     */
    public function __construct($helper)
    {
        $this->helper = $helper;
    }

    /**
     * Check if property exists and set the value to the property
     * 
     * @param string $property Property we want to reach
     * @param mixed  $value    Value to assign to the property
     * 
     * @return \EdouardKombo\EkApiCallerBundle\Helper\ApiCallerHelper
     */
    public function setParameter($property, $value)
    {
        $setGetContract = $this->helper->setGetContract;      
        
        $setGetContract->cursor = $property;
        $setGetContract->set($value);
        
        return $this;
    }    
    
    /**
     * Send something via $_GET method
     * 
     * @return mixed
     */
    public function get()
    {
        return $this->helper->curlMethod('get');
    }
    
    
    
    /**
     * Send something via $_POST method
     * 
     * @return mixed
     */
    public function post()
    {
        return $this->helper->curlMethod('post');
    }
    
    /**
     * Send something via $_PUT method
     * 
     * @return mixed
     */
    public function put()
    {
       return ''; 
    }
    
    /**
     * Send something via $_HEAD method
     * 
     * @return mixed
     */
    public function head()
    {
        return '';
    }
    
    /**
     * Send something via $_DELETE method
     * 
     * @return mixed
     */
    public function delete()
    {
        return $this->helper->curlMethod('delete');
    }   
}