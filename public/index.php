<?php

use App\Controller\HomeController;

require_once('../vendor/autoload.php');

// Front-controller to route requests.
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        $controller = new HomeController();
        $controller->a();
        break;
    case '/excel':
        $controller = new HomeController();
        $controller->excel();
        break;
    case '/job/a':
        // Taskname and Queuename are two of several useful Cloud Tasks headers available on the request.
        $taskName = $_SERVER['HTTP_X_APPENGINE_TASKNAME'] ?? '';
        $queueName = $_SERVER['HTTP_X_APPENGINE_QUEUENAME'] ?? '';

        try {
            handle_task(
                $queueName,
                $taskName,
                file_get_contents('php://input')
            );
        } catch (Exception $e) {
            http_response_code(400);
            exit($e->getMessage());
        }
        break;
    default:
        http_response_code(404);
        exit('Not Found');
}

function handle_task($queueName, $taskName, $body = '')
{
    if (empty($taskName)) {
        // You may use the presence of the X-Appengine-Taskname header to validate
        // the request comes from Cloud Tasks.
        throw new Exception('Bad Request - Invalid Task');
    }

    $output = sprintf('Completed task: task queue(%s), task name(%s), payload(%s)', $queueName, $taskName, $body);

    // Set a non-2xx status code to indicate a failure in task processing that should be retried.
    // For example, http_response_code(500) to indicate a server error.
    print $output;
}