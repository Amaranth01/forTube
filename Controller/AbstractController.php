<?php

namespace App\Controller;

use App\Model\Entity\User;

abstract class AbstractController
{
    abstract public function index();

    /**
     * @param string $template
     * @param array $data
     * @return void
     */
    public function render(string $template, array $data = [])
    {
        ob_start();
        require __DIR__ . '/../View/' . $template . '.html.php';
        $html = ob_get_clean();
        require __DIR__ . '/../View/base.html.php';
        exit;
    }

    public function clean(string $data): string {
        $data = trim($data);
        $data = strip_tags($data);
        $data = htmlentities($data);

        return $data;
    }

    /**
     * Checks if the form has been submitted
     * @return bool
     */
    public function formSubmitted(): bool
    {
        return isset($_POST['submit']);
    }

    /**
     * Get field data
     * @param string $field
     * @param null $default
     * @return mixed|string
     */
    public function getFormField(string $field, $default = null)
    {
        if(!isset($_POST[$field])) {
            return (null === $default) ? '' : $default;
        }
        return $_POST[$field];
    }

    /**
     * Returns a logged-in user, or null if not logged in.
     * @return User|null
     */
    public function getConnectedUser(): ?User
    {
        if(!self::userConnected()) {
            return null;
        }
        return ($_SESSION['user']);
    }

    /**
     * Checks if an admin is already logged in
     * @return bool
     */
    public static function adminConnected(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user']->getRole()->getRoleName() === 'admin';
    }

    /**
     * Checks if a user is already logged in
     * @return bool
     */
    public static function userConnected(): bool
    {
        return isset($_SESSION['user']) && null !== ($_SESSION['user'])->getId();
    }
}