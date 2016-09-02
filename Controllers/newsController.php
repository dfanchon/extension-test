<?php
namespace App\Extensions\ExtensionTest\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
class NewsController extends BaseController
{
    public function index(Request $request)
    {
        $params=$request->input();
        $requestString = "{articles(limit=50){date title html author tags{label uri rdfTypes} images{url} videos{url}}}";
        $operationName = isset($params['operation']) ? $params['operation'] : null;
        $variableValues = isset($params['variables']) ? $params['variables'] : null;
        $result=app()['GraphQLHandler']->execute($requestString,$variableValues,$operationName,$params);
        return view()->make('welcome',$result['data']);
    }

    public function ampList()
    {
        return view()->make('amplist');
    }

    public function ampList2(Request $request)
    {
        $params=$request->input();
        $requestString = "{articles(limit:50 orderBy:\"date\"){diffbotUri date pageUrl title html author tags{label uri rdfTypes} images{url} videos{url}}}";
        $operationName = isset($params['operation']) ? $params['operation'] : null;
        $variableValues = isset($params['variables']) ? $params['variables'] : null;
        $result=app()['GraphQLHandler']->execute($requestString,$variableValues,$operationName,$params);
        return view()->make('amplist2', $result['data']);
    }

    public function ampDetail(Request $request)
    {
        $params=$request->input();
        $requestString = "{article(diffbotUri:\"".$params['id']."\"){date pageUrl title html author tags{label uri rdfTypes} images{url} videos{url}}}";
        $operationName = isset($params['operation']) ? $params['operation'] : null;
        $variableValues = isset($params['variables']) ? $params['variables'] : null;
        $result=app()['GraphQLHandler']->execute($requestString,$variableValues,$operationName,$params);
        $html = $result['data']['article']['html'];
        $html = str_replace('<img', '<amp-img layout="fixed"', $html);
        $result['data']['article']['html'] = $html;
        return view()->make('ampdetail', $result['data']['article']);
    }



}
