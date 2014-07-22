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

use EdouardKombo\PhpObjectsContractBundle\Contract\Elements\Abstractions\SetGetAbstractions;

/**
 * ApiCaller SetGet Contract
 *
 * @category Contract
 * @package  EkApiCallerBundle
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://creativcoders.wordpress.com
 */
class SetGetContract extends SetGetAbstractions
{
    
    /**
     *
     * @var array
     */
    public $headers = false;
    
    /**
     *
     * @var boolean
     */
    public $verifySSLCertificates = false;
    
    /**
     *
     * @var string
     */
    public $url = '';
    
    /**
     *
     * @var array
     */
    public $datas = array();
    
    /**
     *
     * @var mixed
     */
    public $handle = '';
    
    /**
     *
     * @var boolean
     */
    public $cache = false;  
    
    /**
     *
     * @var integer
     */
    public $timeout = 90;
    
    /**
     *
     * @var integer
     */
    public $connectTimeout = 30;     
    
    /**
     *
     * @var string 
     */
    public $cursor = ''; 
    
    /**
     *
     * @var object 
     */
    private $firewall = '';     
    
    
    /**
     * Constructor
     * 
     * @param \EdouardKombo\EkApiCallerBundle\Firewall\ApiCallerFirewall Firewall class
     */
    public function __construct($firewall)
    {
        $this->firewall = $firewall;
    }
    
    /**
     * Set a value
     * 
     * @param mixed $value Value to be setted
     * 
     * @return \EdouardKombo\EkApiCallerBundle\Contract\SetGetContract
     */
    public function set($value)
    {
        $this->secure();
        
        $this->{$this->cursor} = $value;  
        
        return $this;
    }
    
    /**
     * Get a value
     * 
     * @return mixed
     */
    public function get()
    {
        $this->secure();
        
        return $this->{$this->cursor};        
    }
    
    /**
     * Secure by checking properties existence
     * 
     * @return mixed
     */
    public function secure()
    {
        return $this->firewall->checkIfPropertyExists($this->cursor, $this);
    }
    
}