<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 06.11.2022
 * Time: 20:02
 */

namespace AuthModel;


use AuthModel\Models\User;
use Database\Factories\UserFactory;
use function DeepCopy\deep_copy;

class Guard
{

    /**
     * @var User
     */
    protected $user;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function guest()
    {

    }

    public function logout()
    {

    }

    public function login(User $user)
    {
        $this->setUser($user);
        /*$response = $this->modx->runProcessor('security/login', $login_data);
        if ($response->isError()) {
            $errors = $this->_formatProcessorErrors($response);
            $this->modx->log(modX::LOG_LEVEL_INFO,
                '[Office] unable to login user "' . $data['username'] . '". Message: ' . $errors
            );

            return $this->error($this->modx->lexicon('office_auth_err_login', array('errors' => $errors)));
        } else {
            event_mindbox_bg_script('authorization', [
                'id' => $user->get('id'),
                'email' => $profile->get('email'),
                'phone' => $profile->get('mobilephone'),
            ]);
            return $this->success(
                $this->modx->lexicon('office_auth_success'),
                array('refresh' => $this->_getLoginLink())
            );
        }*/
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Вернет true если пользователь загружен
     * @return bool
     */
    public function check()
    {
        $user = $this->user();
        return !is_null($user);
    }

    /**
     * Здесь добавляем пользователя из сессии
     */
    public function startSession()
    {
        return false;
    }

    public function create(array $all)
    {
        $user = new User();
        $user::factory()->create($all, $user);
        return $user;
    }

    public function update(array $all)
    {
        $user = $this->user();
        $user->update($all);
    }

    public function forgotPassword()
    {
        return true;
    }

    public function sendResetLinkEmail()
    {
        return true;
    }

    /**
     * Проверка подтверждения email адреса
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return !is_null($this->user()->get('email_verified_at'));
    }

    /**
     * Пометка email адреса как подтвержденного
     */
    public function markEmailAsVerified()
    {
    }

    /**
     * Получения пользователя по id введенному в url
     * @param $get
     */
    public function getUserIsId(int $id)
    {
        if (!$this->check()) {

        }

    }

    public function getUserIsEmail(string $email)
    {
        return $this->user();
    }
}
