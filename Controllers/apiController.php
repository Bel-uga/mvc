<?php
namespace Controllers;
use Classes\Controller;
use Models\UserModel;
use Models\TaskModel;

class ApiController extends Controller
{

    protected function validateEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
    }

    protected function validateName($name)
    {
        if (preg_match('/^[a-zA-Zа-яА-Я0-9]+$/ui', $name)) {
            return true;
        }
    }

    public function index()
    {
    }

    public function getPageCount()
    {
        $taskModel = new TaskModel();
        $task_count = $taskModel->getTaskCount();
        $page_count = ceil((int)$task_count['count'] / 3);
        echo json_encode(['page_count' => $page_count]);
    }

    public function getTasks()
    {
        $taskModel = new TaskModel();
        echo json_encode($taskModel->getTasks($_GET['sort'], $_GET['page']));
    }

    public function addTasks()
    {
        if (!$this->validateEmail($_GET['email'])) {
            die(json_encode(['message' => 'Укажите правильный e-mail']));
        }

        if (!$this->validateName($_GET['name'])) {
            die(json_encode(['message' => 'Имя содержит не допустимые символы. Разрешены буквы A-Z А-Я и цифры _ -']));
        }

        $taskModel = new TaskModel();

        if ($taskModel->addTask($_GET['name'], $_GET['email'], $_GET['task'])) {
            echo json_encode(['message' => 'Задание успешно сохранено!']);
        } else {
            echo json_encode(['message' => 'Не удалось сохранить задание!']);
        }
    }

    public function updateTask()
    {
        session_start();
        if ($_SESSION['user'] == "admin") {
            $taskModel = new TaskModel();

            if ($taskModel->updateTask($_GET['id'], $_GET['text'], $_GET['status'])) {
                $messages = ['message' => 'Изменения сохранены!'];
            } else {
                $messages = ['message' => 'Не удалось сохранить изменения!'];
            }
        }
        echo json_encode($messages);
    }

    public function login()
    {
        $userModel = new UserModel();
        $result = $userModel->authorization($_GET['login'], $_GET['password']);
        if (isset($result)) {
            session_start();
            $_SESSION['id'] = $result['id'];
            $_SESSION['user'] = $result['login'];
            $messages = [
                        'message' => 'Авторизован',
                        'login' => $result['login']
                        ];
        } elseif ($result == "error") {
            $messages[] = ['message' => 'Ошибка авторизации!'];
        }
        echo json_encode($messages);
    }

    public function getCurrentUser()
    {
        session_start();
        if ($_SESSION) {
            $messages = [
                        'message' => 'Авторизован',
                        'login' => $_SESSION['user']
                        ];
        } else {
            $messages = [
                        'message' => 'Авторизован',
                        'login' => 'guest'
                        ];
        }
        echo json_encode($messages);
    }

    public function logOut()
    {
        session_start();
        session_destroy();
        $messages = ['message' => 'Exit'];
        echo json_encode($messages);
    }
}
