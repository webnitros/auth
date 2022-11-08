<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 07.11.2022
 * Time: 04:15
 */

namespace AuthModel;


class Auth
{
    /**
     * @var Guard
     */
    protected $guard;

    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    public function guard()
    {
        return $this->guard;
    }
}
