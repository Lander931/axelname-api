<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 08.11.2018
 * Time: 9:14
 * Contact: lander931@mail.ru
 */

namespace Lander931\Axelname\Auth;


class TokenAuth implements AuthInterface
{
    private $token;

    /**
     * TokenAuth constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function toArray()
    {
        return ['token' => $this->token];
    }
}