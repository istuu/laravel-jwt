<?php

class UserAuthTestCest
{
    protected $url = 'http://localhost:8888/api/v1/auth/login';

    // tests
    public function testLoginIsSuccess(ApiTester $I)
    {
        $I->wantToTest('Login is success.');

        // send credential data
        $I->sendPOST($this->url, ['email' => 'avnos@avnos.io', 'password' => 'avnos123']);

        // login success
        $I->seeResponseCodeIs(200);

        // check if returned user data is contain expected email
        $I->seeResponseContainsJson();
    }

    public function testLoginIsFailed(ApiTester $I)
    {
        $I->wantToTest('Login is failed.');

        // send credential data
        $I->sendPOST($this->url, ['email' => 'testing@avnos.io', 'password' => 'testing123']);

        // check expected response code
        $I->seeResponseCodeIs(401);
    }


}
