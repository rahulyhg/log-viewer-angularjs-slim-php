<?php
namespace rpebenito\LogViewerAPI;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require('../vendor/autoload.php');

class App {

	/**
     * Stores an instance of the Slim application.
     *
     * @var \Slim\App
     */
    private $app;

	public function __construct() {
        //Ensure FileChecker class is imported
        require __DIR__.'/../lib/FileChecker.php';
        
        //Add config settings
        $settings = require __DIR__.'/../config/settings.php';
        $app = new \Slim\App($settings);

        $corsOptions = array(
                "origin" => "*",
                "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
                "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
        );  

        $cors = new \CorsSlim\CorsSlim($corsOptions);
        $app->add($cors);

		$app->get('/log', function ($request, $response, $args) {
            //Get query param file
            $uri = $request->getUri();
            $query = $uri->getQuery();
            $h = $request->getQueryParam('file');

            //Return 400 Bad Request if file queryParam doesn't exists
            if ($h === null) {
                return $response->withStatus(400)->withJson(array('detail' => 'Bad Request!'));
            }

            //Get the full path and initialize the FileChecker class.
            $full_path_log = $this->get('settings')['serverLogPath'] . $h;
            $f = new FileChecker($full_path_log, $this->get('settings')['maxFileSize']);

            //Handle errors
            switch ($full_path_log) {
                case (!$f->fileExists()):
                    return $response->withStatus(404)->withJson(array('detail' => 'File not found!'));
                case ($f->isFileBlank()):
                    return $response->withStatus(422)->withJson(array('detail' => 'File is blank!'));
                case ($f->getMimeType() != 'text/plain');
                    return $response->withStatus(422)->withJson(array('detail' => 'File cant read!'));
                case ($f->fileLimitExceeded()):
                    return $response->withStatus(422)->withJson(array('detail' => 'File too large!'));
            }

            //Convert file content into JSON array
            $res_data = file($full_path_log, FILE_IGNORE_NEW_LINES);
            $json = json_encode($res_data);

            return $response->withStatus(200)
                ->withHeader('Content-type', 'application/json')
                ->write($json);
		});
		

		$this->app = $app;
    }


    /**
     * Get an instance of the application.
     *
     * @return \Slim\App
     */
    public function get() {
        return $this->app;
    }


}

?>
