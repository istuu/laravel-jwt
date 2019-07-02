<?php

class VerifyHashTestCest
{
    protected $url = 'http://localhost:8888/api/v1/verify';

    /**
     * @param ApiTester $I
     */
    public function VerifyHash(ApiTester $I)
    {
        $I->wantToTest('Verify hash in process table. ');

        // create user data
        $user = factory(\App\User::class)->create([
            'email' => 'testing@avnos.io',
            'name' => 'Testing User',
            'username' => 'testing',
            'password' => bcrypt('testing123')
        ]);
        // create valid token
        $token = \Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);

        // set header token Authorization: Bearer {token}
        $I->amBearerAuthenticated($token);

        // send credential data
        $I->sendGET($this->url, ['hash' => \App\Models\Process::where('prc_get_vt_result',1)->first()->prc_hash]);

        // check expected response code
        // $I->seeResponseCodeIs(200);

        // check if response data is same with our init user data
        $I->seeResponseContainsJson();
    }
}
