<?php

namespace App\Model\Manager;

use App\Model\DB;
use App\Model\Entity\User;

class UserManager
{
        /**
         *Get all data about user
         * @param array $data
         * @return User
         */
        public static function dataUser(array $data): User
    {
        $role = RoleManager::getRoleById($data['role_id']);
        return (new User())
            ->setId($data['id'])
            ->setUsername($data['username'])
            ->setEmail($data['email'])
            ->setPassword($data['password'])
            ->setRole($role)
            ;
    }


    public function getUser(int $id): ?User
    {
        $user = null;
        $stmt = DB::getPDO()->prepare("SELECT * FROM user WHERE id = :id");

        $stmt->bindParam(':id', $id);
        if($stmt->execute() && $data = $stmt->fetch()){
            $user = self::dataUser($data);
        }
        return $user;
    }

    /**
     * @return array
     */
    public static function getAllUser(): array
    {
        $user = [];
        $stmt = DB::getPDO()->query("SELECT * FROM user");

        if($stmt) {
            foreach ($stmt->fetchAll() as $data) {
                $user[] = self::dataUser($data);
            }
        }
        return $user;
    }

    /**
     * Returns a user by their mail
     * @param string $email
     * @return User|null
     */
    public static function getUserByMail(string $email): ?User
    {
        $stmt = DB::getPDO()->prepare("SELECT * FROM user WHERE email = :email ");
        $stmt->bindValue(':email', $email);

        if($stmt->execute() && $data = $stmt->fetch()) {
            return self::dataUser($data);
        }
        return null;
    }

    /**
     * @param string $username
     * @return User|null
     */
    public static function getUserByName(string $username): ?User
    {
        $stmt = DB::getPDO()->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->bindValue(':username', $username);

        if($stmt->execute() && $data = $stmt->fetch()) {
            return self::dataUser($data);
        }
        return null;
    }

    /**
     * @param User $user
     * @return bool
     */
    public static function addUser(User $user): bool
    {
        $stmt = DB::getPDO()->prepare("
            INSERT INTO user (username, email, password , role_id)
            VALUES (:username, :email, :password, :role_id) 
        ");

        $stmt->bindValue(':username', $user->getUsername());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindValue(':role_id', $user->getRole()->getId());

        $stmt = $stmt->execute();
        $user->setId(DB::getPDO()->lastInsertId());

        return $stmt;
    }

    /**
     * @param $email
     * @return bool
     */
    public static function userMailExist($email): bool
    {
        $stmt = DB::getPDO()->prepare(" SELECT count(*) as cnt FROM user WHERE email = :email");
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        return (int)$stmt->fetch()['cnt'] > 0;
    }

    /**
     * @param $username
     * @return bool
     */
    public static function usernameExist($username): bool
    {
        $stmt = DB::getPDO()->prepare(" SELECT count(*) as cnt FROM user WHERE username = :username");
        $stmt->bindValue(":username", $username);
        $stmt->execute();
        return (int)$stmt->fetch()['cnt'] > 0;
    }

    /**
     * @param $newUsername
     * @param $id
     */
    public function updateUsername($newUsername,$id)
    {
        $stmt = DB::getPDO()->prepare("
            UPDATE user SET username = :newUsername WHERE id = :id
        ");

        $stmt->bindParam(':newUsername', $newUsername);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    /**
     * @param $newEmail
     * @param $id
     */
    public function updateEmail($newEmail, $id)
    {
        $stmt = DB::getPDO()->prepare("
            UPDATE user SET email = :newEmail WHERE id = :id
        ");

        $stmt->bindParam(':newEmail', $newEmail);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    /**
     * @param $newPassword
     * @param $id
     */
    public function updatePassword($newPassword, $id)
    {
        $stmt = DB::getPDO()->prepare("
            UPDATE user SET password = :newPassword WHERE id = :id
        ");

        $stmt->bindParam(':newPassword', $newPassword);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    /**
     * @param $newRole
     * @param $newUsername
     */
    public static function updateRoleUser($newRole, $newUsername)
    {
        $stmt = DB::getPDO()->prepare("
            UPDATE user SET role_id = :newRole WHERE username = :newUsername"
        );

        $stmt->bindParam(':newRole', $newRole);
        $stmt->bindParam(':newUsername', $newUsername);

        $stmt->execute();
    }

    /**
     * Delete a user by its id
     * @param int $id
     * @return bool
     */
    public static function deleteUser(int $id): bool
    {
        $stmt = DB::getPDO()->prepare("DELETE FROM user WHERE id = :id");

        $stmt->bindParam(':id', $id);

        return $stmt->execute();

    }

    /**
     * @param $role
     * @param $id
     */
    public function updateRoleToken($role, $id)
    {
        $stmt = DB::getPDO()->prepare("UPDATE user SET role_id = :role WHERE id = :id");

        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }


}