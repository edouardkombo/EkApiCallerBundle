<?php

/**
 * Main docblock
 *
 * PHP version 5
 *
 * @category  Exception
 * @package   EkApiCallerBundle
 * @author    Edouard Kombo <edouard.kombo@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   GIT: 1.0.0
 * @link      http://creativcoders.wordpress.com
 * @since     0.0.0
 */
namespace EdouardKombo\EkApiCallerBundle\Exception;

/**
 * Curl exception
 *
 * @category Exception
 * @package  EkApiCallerBundle
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://creativcoders.wordpress.com
 */
class CurlException extends \RuntimeException implements \Serializable
{
    
    /**
     * Serialize datas
     * 
     * @return array
     */
    public function serialize()
    {
        return serialize([
            $this->code,
            $this->message,
            $this->file,
            $this->line,
        ]);
    }

    /**
     * Unserialize datas
     * 
     * @param string $string
     */
    public function unserialize($string)
    {
        list(
            $this->token,
            $this->code,
            $this->message,
            $this->file,
            $this->line
        ) = unserialize($string);
    }

    /**
     * Get message Key
     * 
     * @return string
     */
    public function getMessageKey()
    {
        return 'A curl exception has occurred.';
    }

    /**
     * Get message data
     * 
     * @return array
     */
    public function getMessageData()
    {
        return array();
    }
}