<?php
namespace App\Extensions\ExtensionTest\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
class GraphQLController extends BaseController
{
    public function handle(Request $request)
    {
        $params=$request->input();
        $requestString = isset($params['query']) ? $params['query'] : null;
        $operationName = isset($params['operation']) ? $params['operation'] : null;
        $variableValues = isset($params['variables']) ? $params['variables'] : null;
        $result=app()['GraphQLHandler']->execute($requestString,$variableValues,$operationName,$params);
        return response()->json(['items' => $result['data']['articles']]);
    }

}
