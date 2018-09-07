<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\Authorization;
use App\Http\Transformers\AuthorizationTransformer;
use App\Http\Requests\Api\Authorization\StoreRequest;

/**
 * Class AuthorizationController
 * @package App\Http\Controllers\Api
 */
class AuthorizationController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return $this
     */
    public function store(StoreRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['is_admin'] = 1;
        return $this->userLogin($credentials);
    }

    public function corporateLogin(StoreRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['is_corporate'] = 1;
        
        return $this->userLogin($credentials);
    }

    private function userLogin(array $credentials)
    {
        if (!$token = Auth::attempt($credentials)) {
            abort(401, '用户名或密码错误');
        }

        $authorization = new Authorization($token);

        return $this->response->item($authorization, new AuthorizationTransformer())
            ->setStatusCode(201);
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function update()
    {
        $authorization = new Authorization(Auth::refresh());

        return $this->response->item($authorization, new AuthorizationTransformer());
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function destroy()
    {
        Auth::logout();

        return $this->response->noContent();
    }
}
