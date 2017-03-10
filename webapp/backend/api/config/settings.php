<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
		'serverLogPath' => getenv('LOG_SERVER_PATH', true) ? getenv('LOG_SERVER_PATH') : __DIR__.'/../../../../example/log/',
		'maxFileSize' => getenv('MAX_FILE_SIZE', true) ? getenv('MAX_FILE_SIZE') : 4096,
    ],
];
