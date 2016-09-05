<?php
namespace App\Extensions\ExtensionTest\Controllers;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Lullabot\AMP\AMP;
use Lullabot\AMP\Validate\Scope;

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

    public function ampList(Request $request)
    {
        $rootSrc = str_replace('http://', '', $request->root());
        return view()->make('amplist', ['rootSrc' => $rootSrc]);
    }

    public function ampList2(Request $request)
    {
        $params=$request->input();
        $requestString = "{articles(limit:80 orderBy:\"date\"){diffbotUri date pageUrl title html author tags{label uri rdfTypes} images{url} videos{url}}}";
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
        $amp = new AMP();
        $amp->loadHtml($result['data']['article']['html']);
        $result['data']['article']['html'] = $amp->convertToAmpHtml();
        return view()->make('ampdetail', $result['data']['article']);
    }



}
