<?php

namespace src\Repositories;

require_once 'Repository.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../../vendor/hybridauth/hybridauth/src/autoload.php';

use Hybridauth\User\Profile;
use src\Models\User;

class UserRepository extends Repository {

	/**
	 * @param string $id
	 * @return User|false
	 */
	public function getUserById(string $id): User|false
    {
        $query = $this->pdo->prepare(
            "SELECT * 
                   FROM users 
                   WHERE id = ?");
        $query->execute([$id]);
        $result = $query->fetch();
        return $result ? new User($result): false;
	}

	/**
	 * @param string $email
	 * @return User|false
	 */
	public function getUserByEmail(string $email): User|false {
        $query = $this->pdo->prepare(
            "SELECT * 
                   FROM users 
                   WHERE email = ?");
        $query->execute([$email]);
        $result = $query->fetch();
        return $result ? new User($result): false;
	}

    public function getUserByGithubId(string $identifier): User|false
    {
        $query = $this->pdo->prepare(
            "SELECT * 
                   FROM users 
                   WHERE github_identifier = ?");
        $query->execute([$identifier]);
        $result = $query->fetch();
        return $result ? new User($result): false;
    }

	/**
	 * @param string $passwordDigest
	 * @param string $email
	 * @param string $name
	 * @return User|false
	 */
	public function saveUser(string $name, string $email, string $passwordDigest): User|false
    {
        $query = $this->pdo->prepare(
            "INSERT INTO users (name, email, password_digest) 
                   VALUES (?, ?, ?);");
        if ($query->execute([$name, $email, $passwordDigest]))
        {
            $id = $this->pdo->lastInsertId();
            $query = "SELECT * 
                      FROM users 
                      where id = $id";
            $result = $this->pdo->query($query);
            return new User($result->fetch());
        }

        return false;
	}

    public function saveUserGithub(Profile $githubProfile): User|false
    {
        $name = $githubProfile->displayName;
        $email = $githubProfile->email;
        $identifier = $githubProfile->identifier;

        if ($user = $this->getUserByEmail($email))
        {
            $this->updateGithubId($user->id, $identifier);
            return $this->getUserByGithubId($identifier);
        }

        $query = $this->pdo->prepare(
            "INSERT INTO users (name, email, github_identifier) 
                   VALUES (?, ?, ?);");
        if ($query->execute([$name, $email, $identifier]))
        {
            $id = $this->pdo->lastInsertId();
            $query = "SELECT * 
                      FROM users 
                      where id = $id";
            $result = $this->pdo->query($query);
            return new User($result->fetch());
        }

        return false;
    }

    private function updateGithubId(int $id, string $identifier): void
    {
        $query = $this->pdo->prepare(
            "UPDATE users
                   SET github_identifier = ?
                   WHERE id = ?;");
        $query->execute([$identifier, $id]);
    }

	/**
	 * @param int $id
	 * @param string $name
	 * @param string|null $profilePicture
	 * @return bool
	 */
	public function updateUser(int $id, string $name, string $profilePicture = null): bool
    {
        $setPicture = isset($profilePicture) ? "profile_picture=?" : "";
        $query = $this->pdo->prepare(
            "UPDATE users 
                   SET name=?, $setPicture 
                   WHERE id=?");
        return $query->execute([$name, $profilePicture, $id]);
	}
}
