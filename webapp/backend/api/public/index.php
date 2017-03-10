<?php
#use \Psr\Http\Message\ServerRequestInterface as Request;
#use \Psr\Http\Message\ResponseInterface as Response;
#TODO: Create class that handles the file

require '../vendor/autoload.php';

// Run app
$app = (new rpebenito\LogViewerAPI\App(__DIR__.'/../'))->get();
$app->run();

//$corsOptions = array(
//    "origin" => "*",
//    "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
//    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
//);
//
//$cors = new \CorsSlim\CorsSlim($corsOptions);
//
//$app = new \Slim\App;
//$app->add($cors);

//$app->get('/log', function ($request, $response, $args) {
//    #Hardcode the path for now
//    $path = '/home/gsc/Projects/case-study-property-guru/example/log/';
//    $uri = $request->getUri();
//    $query = $uri->getQuery();
//    $h = $request->getQueryParam('file');
//    if ($h === null) {
//        error_log('empty!!!');
//        return $response->withStatus(400)->write('Bad Request!');
//    }
//    $full_path_log = $path . $h;
//    $f = new FileChecker($full_path_log);
//
//    switch ($full_path_log) {
//        case (!$f->fileExists()):
//            return $response->withStatus(404)->withJson(array('detail' => 'File not found!'));
//        case ($f->isFileBlank()):
//            return $response->withStatus(422)->withJson('File is blank!');
//        case ($f->getMimeType() != 'text/plain');
//            error_log(mime_content_type ( $full_path_log ));
//            return $response->withStatus(422)->withJson('File cant read!');
//        case ($f->fileLimitExceeded()):
//            return $response->withStatus(422)->withJson('File too large!');
//    }
//
//    
//    error_log(filesize($full_path_log));
//    error_log( $h );
//    $res_data = file($full_path_log, FILE_IGNORE_NEW_LINES);
//    $json = json_encode($res_data);
//
//    return $response->withStatus(200)
//        ->withHeader('Content-type', 'application/json')
//        ->write($json);
//});
//$app->run();
