<?php
include_once 'DatabaseConnection.class.php';
include_once 'ErrorCatching.class.php';

/*
 * ContactService.class.php: Used to communication contact.php and admin portal page with backend.
 * Functions:
 *  getDBInfo($returnConn)
 *  createMiscObject($name, $isHazard, $description)
 *  readMiscObject()
 *  updateMiscObject($idMisc, $name, $isHazard, $description)
 *  deleteMiscObject($idMisc)
 */

class MiscObjectData {
    /**
     * Takes sanitized information and create a new object.
     * @param $name
     * @param $isHazard
     * @param $description
     * @return string
     */
    public function createMiscObject($name, $isHazard, $description) {
        try {
            //global $createMiscObjectQuery;
            $stmt = $this -> getDBInfo(1) -> prepare("INSERT INTO MiscObject (name, description, isHazard) VALUES (:name, :description, :isHazard)");


            $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
            $stmt -> bindParam(':isHazard', $isHazard, PDO::PARAM_STR);
            $stmt -> bindParam(':description', $description, PDO::PARAM_STR);

            $stmt -> execute();
            return $this -> getDBInfo(1) -> lastInsertId();
        } catch (PDOException $e) {
            $errorService = new ErrorCatching();
            $errorService -> logError($e);
            exit();
        }
    }

    /**
     * Retrieves the Database information needed.
     * @param $returnConn : An int that designates whether to return the DB instance
     * or the connection. 0 = instance, 1 = connection
     * @return DatabaseConnection|null|PDO : Can return the DB instance, connection,
     * or null if neither are found.
     */
    private function getDBInfo($returnConn) {
        try {
            $instance = DatabaseConnection ::getInstance();
            $conn = $instance -> getConnection();
            if ($returnConn == 0) {
                return $instance;
            } else if ($returnConn == 1) {
                return $conn;
            } else {
                return null;
            }
        } catch (Exception $e) {
            $errorService = new ErrorCatching();
            $errorService -> logError($e);
            exit();
        }
        return null;
    }

    /**
     * Retrieves all the database entries.
     * @return array
     */
    public function readMiscObject() {
        try {
            //global $getAllMiscEntriesQuery;
            return $this -> getDBInfo(0) -> returnObject("", "SELECT idTrackableObject, longitude, latitude, imageDescription, imageLocation, name, T.idTypeFilter, TF.type, M.idMisc, M.name, M.description, M.isHazard FROM MiscObject M 
JOIN TrackableObject T ON M.idMisc = T.idMisc 
JOIN TypeFilter TF ON T.idTypeFilter = TF.idTypeFilter");
        } catch (PDOException $e) {
            $errorService = new ErrorCatching();
            $errorService -> logError($e);
            exit();
        }
    }

    /**
     * Takes sanitized information and updates a object in the database.
     * @param $idMisc
     * @param $name
     * @param $isHazard
     * @param $description
     */
    public function updateMiscObject($idMisc, $name, $isHazard, $description) {
        try {
            //global $updateMiscObjectQuery;
            $stmt = $this -> getDBInfo(1) -> prepare("UPDATE MiscObject SET idMisc = :idMisc , name = :name , description = :description , isHazard = :isHazard  WHERE idMisc = :idMisc");

            $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
            $stmt -> bindParam(':isHazard', $isHazard, PDO::PARAM_STR);
            $stmt -> bindParam(':description', $description, PDO::PARAM_STR);
            $stmt -> bindParam(':idMisc', $idMisc, PDO::PARAM_STR);

            $stmt -> execute();
        } catch (PDOException $e) {
            $errorService = new ErrorCatching();
            $errorService -> logError($e);
            exit();
        }
    }

    /**
     * Deletes an object from the database
     * @param $idMisc
     */
    public function deleteMiscObject($idMisc) {
        try {
            //global $deleteMiscObjectQuery;
            $stmt = $this -> getDBInfo(1) -> prepare("DELETE FROM MiscObject WHERE idMisc = :idMisc");
            $stmt -> bindParam(':idMisc', $idMisc, PDO::PARAM_STR);
            $stmt -> execute();
        } catch (PDOException $e) {
            $errorService = new ErrorCatching();
            $errorService -> logError($e);
            exit();
        }
    }
}