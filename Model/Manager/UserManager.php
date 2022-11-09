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
            ->setToken($data['token'])
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
}