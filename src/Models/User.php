<?php

namespace AuthModel\Models;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\Authenticatable;

class User
{
    /**
     * @var array
     */
    public $attributes = [];
    public $id = 1;
    public $email = null;
    public $password = null;
    public $wasRecentlyCreated = true;

    /**
     * @return UserFactory
     */
    public static function factory()
    {
        return new UserFactory(new User());
    }

    /**
     * @return UserFactory
     */
    public function update(array $data)
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'password':
                    $this->password = $value;
                    break;
                case 'email':
                    $this->email = $value;
                    break;
                default:
                    break;
            }
            $this->attributes[$key] = $value;
        }
        return true;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        return null;
    }

    /**
     * Вернет true если емаил адрес подтвержден
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return true;
    }

    public function toArray()
    {
        return ['id' => $this->id] + $this->attributes;
    }



}
