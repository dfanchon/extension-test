<?php

//test adding alambic configs
$currentPaths=config("alambicConfigPaths");
$currentPaths[]=realpath(__DIR__.'/alambicConfig/');
config(["alambicConfigPaths"=>$currentPaths]);

//test provider integration
$app->register(App\Extensions\ExtensionTest\Providers\ExtensionProvider::class);