<?php
/**
 * Created by PhpStorm.
 * User: antarus66
 * Date: 6/27/15
 * Time: 4:38 PM
 */

namespace antarus66\BAHomework3\Models\Recipe\Repositories;


use antarus66\BAHomework3\Exceptions\RepositoryException;

class MySQLiRecipesRepository extends AbstractRecipesRepository {
    private $mysqli;

    public function __construct($config) {
        $this->mysqli = new \mysqli(
            $config->getSetting('host'),
            $config->getSetting('username'),
            $config->getSetting('password'),
            $config->getSetting('dbname')
        );

        if ($this->mysqli->connect_errno) {
            throw new RepositoryException('Cannot connect with MySQL! '
                . '(' . $this->mysqli->connect_errno . ')'
                . $this->mysqli->connect_error);
        }

        $sql = 'CREATE TABLE IF NOT EXISTS `recipe` ('
            . '`id` INT(11) NOT NULL AUTO_INCREMENT,'
            . '`name` VARCHAR(255) NOT NULL UNIQUE,'
            . '`serialized` BLOB NOT NULL,'
            . 'PRIMARY KEY (`id`)'
            . ');';

        if (!$this->mysqli->query($sql)) {
            throw new RepositoryException('Cannot create table for recipes');
        }
    }

    public function getRecipe($recipe_name) {
        $sql = 'SELECT `serialized` FROM `recipe` WHERE `name` = ?;';
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('s', $recipe_name);
        $ex = $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_row()) {
            return unserialize($row[0]);
        } else {
            throw new RepositoryException('No such recipe!');
        }
    }

    public function addRecipe($recipe) {
        $sql = 'INSERT INTO `recipe` (`name`, `serialized`) VALUES (?, ?);';
        $stmt = $this->mysqli->prepare($sql);

        $recipe_name = $recipe->getName();
        $serialized = serialize($recipe);

        $stmt->bind_param('ss', $recipe_name, $serialized);

        if (!$stmt->execute()) {
            throw new RepositoryException('Cannot save recipe $recipe_name.'
                . 'It\'s already exists.');
        }
    }

    public function getRecipesNames() {
        $sql = 'SELECT `name` FROM `recipe`;';
        $res = $this->mysqli->query($sql);
        $names = [];

        while ($row = $res->fetch_row()) {
            $names[] = $row[0];
        }

        return $names;
    }
}