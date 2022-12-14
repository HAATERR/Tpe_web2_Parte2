<?php

class TeamModel{
    function getDB() {
        $db = new PDO('mysql:host=localhost;'.'dbname=db_nba;charset=utf8', 'root', '');
        return $db;
    }

    
    function getByOrder($sort,$order){
        try{
            $db = $this->getDB();
            $query = $db->prepare("SELECT * FROM team ORDER BY $sort $order");
            $query->execute();
            $teams = $query->fetchAll(PDO::FETCH_OBJ);
            return $teams;
        }catch (\Throwable $th) {
            return false;
          }

    }

    function getPagination($off,$limit){
            
        try{
            $db = $this->getDB();
            $query = $db->prepare("SELECT * FROM team ORDER BY Team_id  LIMIT ? OFFSET ?");
            $query->bindParam(1, $limit, PDO::PARAM_INT);
            $query->bindParam(2, $off, PDO::PARAM_INT);
            $query->execute();
            $teams = $query->fetchAll(PDO::FETCH_OBJ);
            return $teams;
            }
            catch (\Throwable $th) {
                return false;
            }
        }

    function getAllTeams() {
        // 1. abro conexión a la DB
        $db = $this->getDB();
    
        // 2. ejecuto la sentencia (2 subpasos)
        $query = $db->prepare("SELECT * FROM team");
        $query->execute();
    
        // 3. obtengo los resultados
        $teams = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $teams;


    }
    
    function insert($team, $rings, $city) {
        $db = $this->getDB();
        $query = $db->prepare("INSERT INTO team ( Team, Rings, City) VALUES (?, ?, ?)");
        $query->execute([$team, $rings, $city]);

        return $db->lastInsertId();
    }

    function delete($id) {
       try{
        $db = $this->getDB();
        $query = $db->prepare('DELETE FROM team WHERE Team_id = ?');
        $query->execute([$id]);
       }
       catch(Exception $e){
            return $e;
       }
    }
    
    function teamId($id){
        $db = $this->getDB();
        $query = $db->prepare('SELECT * FROM team WHERE Team_id = ?');
        $query->execute([$id]);
        $team = $query->fetch(PDO::FETCH_OBJ);
        return $team;
    }
    
    function update($team,$rings,$city,$id) {
        $db = $this->getDB();
        $query = $db->prepare('UPDATE team SET Team = ?,Rings = ?,City = ? WHERE Team_id = ?');
        $query->execute([$team,$rings,$city,$id]);
    }

    }