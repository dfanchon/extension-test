<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
Blade::setEscapedContentTags('[[', ']]');
Blade::setContentTags('[[[', ']]]');
//test adding alambic configs
$currentPaths=config("alambicConfigPaths");
$currentPaths[]=realpath(__DIR__.'/alambicConfig/');
config(["alambicConfigPaths"=>$currentPaths]);

//test provider integration
$app->register(App\Extensions\ExtensionTest\Providers\ExtensionProvider::class);
view()->addLocation(realpath(__DIR__.'/views'));

$app->get('/news1', function (Request $request) {
    $params=$request->input();
    $requestString = "{articles{date title html author tags{label uri rdfTypes} images{url} videos{url}}}";
    $operationName = isset($params['operation']) ? $params['operation'] : null;
    $variableValues = isset($params['variables']) ? $params['variables'] : null;
    $result=app()['GraphQLHandler']->execute($requestString,$variableValues,$operationName,$params);
    return view()->make('welcome',$result['data']);

});

$app->get('/news2', 'App\Extensions\ExtensionTest\Controllers\NewsController@index');
$app->get('/list', 'App\Extensions\ExtensionTest\Controllers\NewsController@ampList');
$app->get('/list2', 'App\Extensions\ExtensionTest\Controllers\NewsController@ampList2');
$app->get('/detail', 'App\Extensions\ExtensionTest\Controllers\NewsController@ampDetail');
$app->get('/api/news', 'App\Extensions\ExtensionTest\Controllers\GraphQLController@handle');
