<?php
include '../../data/MiscObjectData.class.php';
include '../../models/MiscObject.class.php';
include 'TrackableObjectService.class.php';
/**
 */

class MiscObjectService extends TrackableObjectService {
    public function __construct(){
    }

    public function getAllMiscObjectEntries() {
        $miscObjectDataClass = new MiscObjectData();
        $allMiscObjectDataObjects =  $miscObjectDataClass -> readMiscObject();
        $allMiscObject = array();

        foreach ($allMiscObjectDataObjects as $miscObjectArray) {
            $miscObject = new MiscObject($miscObjectArray['idMisc'], $miscObjectArray['name'], $miscObjectArray['isHazard'], $miscObjectArray['description'],
                $miscObjectArray['idTrackableObject'], $miscObjectArray['longitude'], $miscObjectArray['latitude'], $miscObjectArray['hint'], $miscObjectArray['imageDescription'], $miscObjectArray['imageLocation'], $miscObjectArray['idTypeFilter'], $miscObjectArray['$type']);

            array_push($allMiscObject, $miscObject);
        }
        return $allMiscObjectDataObjects;
    }

    public function createMiscObjectEntry($name, $isHazard, $description, $longitude, $latitude, $hint, $imageDescription, $imageLocation, $idTypeFilter) {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $isHazard = filter_var($isHazard, FILTER_SANITIZE_STRING);
        $description = filter_var($description, FILTER_SANITIZE_STRING);

        //create Trackable Object
        $lastInsertIdTrackableObject = $this -> createTrackableObjectEntry($longitude, $latitude, $hint, $imageDescription, $imageLocation, $idTypeFilter);

        //create MiscObject Object
        $miscObjectDataClass = new MiscObjectData();
        $lastInsertIdMiscObject =  $miscObjectDataClass -> createMiscObject($name, $isHazard, $description);

        //Update Trackable Object to know MiscObject Object
        $this -> updateObjectEntryID("Misc", $lastInsertIdMiscObject, $lastInsertIdTrackableObject);
    }

    public function updateMiscObjectEntry($idTrackableObject, $idMiscObject, $name, $isHazard, $description, $longitude, $latitude, $hint, $imageDescription, $imageLocation, $idTypeFilter) {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $isHazard = filter_var($isHazard, FILTER_SANITIZE_STRING);
        $description = filter_var($description, FILTER_SANITIZE_STRING);

        $this ->updateTrackableObjectEntry($idTrackableObject, $longitude, $latitude, $hint, $imageDescription, $imageLocation, $idTypeFilter);

        $miscObjectDataClass = new MiscObjectData();
        $miscObjectDataClass -> updateMiscObject($idMiscObject, $name, $isHazard, $description);
    }

    public function deleteMiscObjectEntry($idMiscObject) {
        $idMiscObject = filter_var($idMiscObject, FILTER_SANITIZE_NUMBER_INT);
        if (empty($idMiscObject) || $idMiscObject == "") {
            return;
        } else {
            $miscObjectDataClass = new MiscObjectData();
            $miscObjectDataClass -> deleteMiscObject($idMiscObject);
        }

    }
}