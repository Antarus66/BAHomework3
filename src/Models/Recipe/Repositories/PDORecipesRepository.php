<?php
/**
 * Created by PhpStorm.
 * User: antarus66
 * Date: 6/25/15
 * Time: 8:30 PM
 */

namespace antarus66\BAHomework3\Models\Recipe\Repositories;


use antarus66\BAHomework3\Exceptions\RepositoryException;

class PDORecipesRepository extends AbstractRecipesRepository{
    private $pdo;

    public function __construct($config)
    {
        try {
            $this->pdo = new \PDO(
                sprintf(
                    '%s:host=%s;dbname=%s;port=%i',
                    $config->getSetting('dbtype'),
                    $config->getSetting('host'),
                    $config->getSetting('dbname'),
                    $config->getSetting('port')
                ),
                $config->getSetting('username'),
                $config->getSetting('password')

            );

            $sql = 'CREATE TABLE IF NOT EXISTS `recipe` ('
                 . '`id` INT(11) NOT NULL AUTO_INCREMENT,'
                 . '`name` VARCHAR(255) NOT NULL UNIQUE,'
                 . '`serialized` BLOB NOT NULL,'
                 . 'PRIMARY KEY (`id`)'
                 . ');';

            $q = $this->pdo->query($sql);
            if ($q === false) throw new \PDOException('Cannot create table recipe!');

        } catch (\PDOException $e) {
            throw new RepositoryException('Cannot initialize repository! '
                . $e->getMessage(), null, $e);
        }
    }

    public function getRecipe($recipe_name)
    {
        $sql = 'SELECT * FROM `recipe` WHERE `name` = :recipe_name;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':recipe_name', $recipe_name);
        $statement->execute();

        $serialized = $statement->fetchColumn(2);
        if ($serialized !== false) {
            return unserialize($serialized);
        } else {
            throw new RepositoryException('No such recipe!');
        }
    }

    public function addRecipe($recipe)
    {
        $recipe_name = $recipe->getName();
        $serialized = serialize($recipe);

        $sql = 'INSERT INTO `recipe` (`name`, `serialized`) VALUES (:name, :serialized);';
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':name', $recipe_name);
        $statement->bindParam(':serialized', $serialized);
        if (!$statement->execute()) {
            throw new RepositoryException("Cannot save recipe $recipe_name. It's already exists.");
        }
    }

    public function getRecipesNames()
    {
        $sql = 'SELECT `name` FROM `recipe`;';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}