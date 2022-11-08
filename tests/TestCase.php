<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 24.03.2021
 * Time: 22:49
 */

namespace Tests;

use AuthModel\Foundation\InteractsWithAuthentication;
use AuthModel\Foundation\MakesHttpRequests;
use AuthModel\Models\User;
use Mockery\Adapter\Phpunit\MockeryTestCase;

abstract class TestCase extends MockeryTestCase
{
    use MakesHttpRequests;
    use InteractsWithAuthentication;

    /**
     * The Illuminate application instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $app;

    protected function setUp(): void
    {
        $app = require __DIR__ . '/../bootstrap/app.php';
        $this->app = $app;
        parent::setUp();
    }


    /**
     * @return User
     */
    protected function user()
    {
        return $this->app->make('user');
    }

    /**
     * @param null $attribetes
     * @return User
     */
    protected function userFactory($attribetes = null)
    {
        return $this->user()::factory()->create($attribetes);
    }
}
