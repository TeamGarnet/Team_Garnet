<?php
include_once 'DatabaseConnection.class.php';
include_once 'ErrorCatching.class.php';

/*
 * ContactService.class.php: Used to communication contact.php and admin portal page with backend.
 * Functions:
 *  getAllContactEntries()
 *  formatContactInfo($pinObjectsArray)
 *  createContactEntry($pin, $markerName)
 *  updateContactEntry()
 *  deleteContactEntry($idContact)
 *  getAllEntriesAsRows()
 */

class HistoricFilterData {
    /**
     * Takes sanitized information and create a new object.
     * @param $historicFilterName
     * @param $dateStart
     * @param $description
     * @param $dateEnd
     * @param $buttonColor
     */
    public function createHistoricFilter($historicFilterName, $dateStart, $description, $dateEnd, $buttonColor) {
        try {
            //global $createHistoricFilterQuery;
            $stmt = $this -> getDBInfo(1) -> prepare("INSERT INTO HistoricFilter (historicFilterName, description, dateStart, dateEnd, buttonColor) VALUES (:historicFilterName, :description, :dateStart, :dateEnd, COALESCE(:buttonColor, DEFAULT(buttonColor)))");


            $stmt -> bindParam(':historicFilterName', $historicFilterName, PDO::PARAM_STR);
            $stmt -> bindParam(':dateStart', $dateStart, PDO::PARAM_STR);
            $stmt -> bindParam(':description', $description, PDO::PARAM_STR);
            $stmt -> bindParam(':dateEnd', $dateEnd, PDO::PARAM_STR);
            if ($buttonColor == "" || empty($buttonColor)) {
                $buttonColor = null;
                $stmt -> bindParam(':buttonColor', $buttonColor, PDO::PARAM_STR);
            } else {
                $stmt -> bindParam(':buttonColor', $buttonColor, PDO::PARAM_STR);
            }

            $stmt -> execute();
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
    public function readHistoricFilter() {
        try {
            //global $getAllHistoricFilterEntriesQuery;
            return $this -> getDBInfo(0) -> returnObject("", "SELECT idHistoricFilter, dateStart, description, historicFilterName, dateEnd, buttonColor FROM HistoricFilter");
        } catch (PDOException $e) {
            $errorService = new ErrorCatching();
            $errorService -> logError($e);
            exit();
        }
    }

    /**
     * Takes sanitized information and updates a object in the database.
     * @param $idHistoricFilter
     * @param $historicFilterName
     * @param $dateStart
     * @param $description
     * @param $dateEnd
     * @param $buttonColor
     */
    public function updateHistoricFilter($idHistoricFilter, $historicFilterName, $dateStart, $description, $dateEnd, $buttonColor) {
        try {
            //global $updateHistoricFilterQuery;
            $stmt = $this -> getDBInfo(1) -> prepare("UPDATE HistoricFilter SET idHistoricFilter = :idHistoricFilter , historicFilterName = :historicFilterName , description = :description , dateStart = :dateStart, dateEnd =:dateEnd, buttonColor = COALESCE(:buttonColor, DEFAULT(buttonColor)) WHERE idHistoricFilter = :idHistoricFilter");

            $stmt -> bindParam(':idHistoricFilter', $idHistoricFilter, PDO::PARAM_STR);
            $stmt -> bindParam(':historicFilterName', $historicFilterName, PDO::PARAM_STR);
            $stmt -> bindParam(':dateStart', $dateStart, PDO::PARAM_STR);
            $stmt -> bindParam(':description', $description, PDO::PARAM_STR);
            $stmt -> bindParam(':dateEnd', $dateEnd, PDO::PARAM_STR);

            if ($buttonColor == "" || empty($buttonColor)) {
                $buttonColor = null;
                $stmt -> bindParam(':buttonColor', $buttonColor, PDO::PARAM_STR);
            } else {
                $stmt -> bindParam(':buttonColor', $buttonColor, PDO::PARAM_STR);
            }

            $stmt -> execute();
        } catch (PDOException $e) {
            $errorService = new ErrorCatching();
            $errorService -> logError($e);
            exit();
        }
    }

    /**
     * Deletes an object from the database
     * @param $idHistoricFilter
     */
    public function deleteHistoricFilter($idHistoricFilter) {
        try {
            //global $deleteHistoricFilterQuery;
            //TODO: will need to call the event first
            $stmt = $this -> getDBInfo(1) -> prepare("DELETE FROM HistoricFilter WHERE idHistoricFilter = :idHistoricFilter");
            $stmt -> bindParam(':idHistoricFilter', $idHistoricFilter, PDO::PARAM_STR);
            $stmt -> execute();
        } catch (PDOException $e) {
            $errorService = new ErrorCatching();
            $errorService -> logError($e);
            exit();
        }
    }

    /**
     * Selects all Grave IDs for Historic Filters. Used to prevent deletion of a historic filter that is in use.
     * @param $idTypeFilter
     * @return int
     */
    public function checkForInUseHistoricFilters($idTypeFilter) {
        try {
            //global $deleteEventQuery;
            $stmt = $this -> getDBInfo(1) -> prepare("SELECT idGrave FROM Grave WHERE idHistoricFilter = :idHistoricFilter");
            $stmt -> bindParam(':idHistoricFilter', $idTypeFilter, PDO::PARAM_STR);
            $stmt -> execute();
            $count = $stmt -> rowCount();
            return $count;
        } catch (PDOException $e) {
            $errorService = new ErrorCatching();
            $errorService -> logError($e);
            exit();
        }
    }
}