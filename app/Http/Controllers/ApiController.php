<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class ApiController
 *
 * @package App\Http\Controllers
 *
 * @SWG\Swagger(
 *     basePath="",
 *     host="rotatourapi.herokuapp.com",
 *     schemes={"https"},
 *     @SWG\Info(
 *         version="1.0",
 *         title="RotaTour API",
*          description="Documentation created using Swagger.",
 *         @SWG\Contact(name="Saulo Gomes", url="https://github.com/saulobr88")
 *     ),
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     ),
 *    @SWG\Definition(
 *         definition="Timestamps",
 *         @SWG\Property(
 *             property="created_at",
 *             type="string",
 *             format="date-time",
 *              description="Creation date",
 *              example="2017-03-01 00:00:00"
 *         ),
 *         @SWG\Property(
 *              property="updated_at",
 *              type="string",
 *              format="date-time",
 *              description="Last updated",
 *              example="2017-03-01 00:00:00"
 *         )
 *    )
 * )
 */
class ApiController extends Controller
{
    //
}
