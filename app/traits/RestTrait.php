<?php
/**
 * Created by PhpStorm.
 * User: hambi
 * Date: 4/18/2018
 * Time: 9:46 PM
 */

namespace App\Traits;

use Illuminate\Http\Request;

trait RestTrait
{

    /**
     * Determines if request is an api call.
     *
     * If the request URI contains '/api/v'.
     *
     * @param Request $request
     * @return bool
     */
    protected function isApiCall(Request $request)
    {

        return strpos($request->getUri(), '/api/') !== false;
    }

}