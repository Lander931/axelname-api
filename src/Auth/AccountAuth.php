<?php
/**
 * Created by PhpStorm.
 * User: dmitry
 * Date: 08.11.2018
 * Time: 9:14
 * Contact: lander931@mail.ru
 */

namespace Lander931\Axelname\Auth;


class AccountAuth implements AuthInterface
{
    private $username;
    private $password;

    /**
     * LoginPasswordAuth constructor.
     * @param $username
     * @param $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function toArray()
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }

}