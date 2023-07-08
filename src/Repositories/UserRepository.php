<?php

namespace src\Repositories;

require_once 'Repository.php';
require_once __DIR__ . '/../Models/User.php';

use src\Models\User;

class UserRepository extends Repository {

	/**
	 * @param string $id
	 * @return User|false
	 */
	public function getUserById(string $id): User|false {
		$sqlStatement = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
		$sqlStatement->execute([$id]);
		$resultSet = $sqlStatement->fetch();
		return $resultSet === false ? false : new User($resultSet);
	}

	/**
	 * @param string $email
	 * @return User|false
	 */
	public function getUserByEmail(string $email): User|false {
		$sqlStatement = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
		$sqlStatement->execute([$email]);
		$resultSet = $sqlStatement->fetch();
		return $resultSet === false ? false : new User($resultSet);	
	}

	/**
	 * @param string $passwordDigest
	 * @param string $email
	 * @param string $name
	 * @return User|false
	 */
	public function saveUser(string $name, string $email, string $passwordDigest): User|false {
		$sqlStatement = $this->pdo->prepare("INSERT INTO users (name, email, password_digest) VALUES (?, ?, ?);");
		$saved = $sqlStatement->execute([$name, $email, $passwordDigest]);
		if ($saved) {
			$id = $this->pdo->lastInsertId();
			$sqlStatement = "SELECT * FROM users where id = $id";
			$result = $this->pdo->query($sqlStatement);
			return new User($result->fetch());
		}
		return false;
	}

	/**
	 * @param int $id
	 * @param string $name
	 * @param string|null $profilePicture
	 * @return bool
	 */
	public function updateUser(int $id, string $name, string $profilePicture = null): bool {
		$sql = isset($profilePicture) ? 'profile_picture=?' : '';
		$sqlStatement = $this->pdo->prepare("UPDATE users SET name=?, $sql WHERE id=?");
		$saved = $sqlStatement->execute([$name, $profilePicture, $id]);
		return $saved;
	}
}
