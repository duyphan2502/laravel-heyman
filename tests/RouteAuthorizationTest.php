<?php

use Imanghafoori\HeyMan\Facades\HeyMan;

class RouteAuthorizationTest extends TestCase
{
    public function testUrlIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl('welcome')->youShouldHaveRole('reader')->beCareful();
        HeyMan::whenVisitingUrl('welcome1')->youShouldHaveRole('writer')->beCareful();

        $this->get('welcome')->assertStatus(403);
    }

    public function testWhenVisitingUrlCanAcceptArray()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl(['welcome', 'welcome_'])->youShouldHaveRole('reader')->beCareful();
        HeyMan::whenVisitingUrl('welcome1')->youShouldHaveRole('writer')->beCareful();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized657()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl(['welcome_', 'welcome',])->youShouldHaveRole('reader')->beCareful();
        HeyMan::whenVisitingUrl('welcome1')->youShouldHaveRole('writer')->beCareful();

        $this->get('welcome')->assertStatus(403);
    }

    public function testUrlIsAuthorized1()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl('welcome')->youShouldHaveRole('reader')->beCareful();
        HeyMan::whenVisitingUrl('welcome2')->youShouldHaveRole('reader')->beCareful();

        $this->get('/welcome1')->assertSuccessful();
    }

    public function testUrlIsAuthorized2()
    {
        setUp::run($this);

        HeyMan::whenVisitingUrl('welcome')->youShouldHaveRole('writer')->beCareful();
        HeyMan::whenVisitingUrl('welcome1')->youShouldHaveRole('reader')->beCareful();

        $this->get('/welcome')->assertSuccessful();
    }

    public function testRouteNameIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenVisitingRoute('welcome.name')->youShouldHaveRole('writer')->beCareful();
        HeyMan::whenVisitingRoute('welcome1.name')->youShouldHaveRole('reader')->beCareful();
        $this->get('welcome')->assertSuccessful();
    }

    public function testRouteNameIsAuthorized1()
    {
        setUp::run($this);

        HeyMan::whenVisitingRoute('welcome.name')->youShouldHaveRole('reader')->beCareful();
        $this->get('welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized()
    {
        setUp::run($this);

        HeyMan::whenCallingAction(HomeController::class.'@index')->youShouldHaveRole('reader')->beCareful();

        $this->get('welcome')->assertStatus(403);
    }

    public function testControllerActionIsAuthorized1()
    {
        setUp::run($this);

        HeyMan::whenCallingAction(HomeController::class.'@index')->youShouldHaveRole('writer')->beCareful();

        $this->get('welcome')->assertStatus(200);
    }
}