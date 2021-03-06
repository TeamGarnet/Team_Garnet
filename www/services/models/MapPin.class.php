<?php


/**
 * MapPin.class.pin: Handles objects that hold Google Maps marker information.
 */
class MapPin {

    private $idTrackableObject;

    private $latitude;

    private $longitude;

    private $imageDescription;

    private $imageLocation;

    private $name;

    private $filterType;

    private $pinDesign;

    private $idHistoricFilter;


    /**
     * MapPin constructor. The following params are fields in the Database that
     * Google Map markers use.
     * @param $idTrackableObject
     * @param $latitude
     * @param $longitude
     * @param $imageDescription
     * @param $imageLocation
     * @param $name
     * @param $filterType
     * @param $pinDesign : a url to the marker design to be used for the pin
     * @param $idHistoricFilter
     */
    public function __construct($idTrackableObject, $latitude, $longitude, $imageDescription, $imageLocation, $name, $filterType, $pinDesign, $idHistoricFilter) {
        $this -> setIdTrackableObject($idTrackableObject);
        $this -> setLatitude($latitude);
        $this -> setLongitude($longitude);
        $this -> setImageDescription($imageDescription);
        $this -> setImageLocation($imageLocation);
        $this -> setName($name);
        $this -> setFilterType($filterType);
        $this -> setPinDesign($pinDesign);
        $this -> setIdHistoricFilter($idHistoricFilter);
    }


    /**
     * @return int : the ID stored in the DB of the trackable object
     */
    public function getIdTrackableObject() {
        return $this -> idTrackableObject;
    }

    public function setIdTrackableObject($idTrackableObject) {
        $this -> idTrackableObject = $idTrackableObject;
    }


    /**
     * @return string: string of the longitude
     */
    public function getLongitude() {
        return $this -> longitude;
    }

    public function setLongitude($longitude) {
        $this -> longitude = $longitude;
    }


    /**
     * @return string: string of the name
     */
    public function getName() {
        return $this -> name;
    }

    public function setName($name) {
        $this -> name = $name;
    }

    public function getLatitude() {
        return $this -> latitude;
    }

    /**
     * @param string : the object's latitude
     */
    public function setLatitude($latitude) {
        $this -> latitude = $latitude;
    }

    /**
     * @return string : the object's image alt text
     */
    public function getImageDescription() {
        return $this -> imageDescription;
    }

    public function setImageDescription($imageDescription) {
        $this -> imageDescription = $imageDescription;
    }


    /**
     * @return string : a url to the location of the object image
     */
    public function getImageLocation() {
        return $this -> imageLocation;
    }

    public function setImageLocation($imageLocation) {
        $this -> imageLocation = $imageLocation;
    }


    /**
     * @return string :  the type of object in the database
     */
    public function getFilterType() {
        return $this -> filterType;
    }

    public function setFilterType($filterType) {
        $this -> filterType = $filterType;
    }


    /**
     * @return mixed
     */
    public function getIdHistoricFilter() {
        return $this -> idHistoricFilter;
    }

    public function setIdHistoricFilter($idHistoricFilter) {
        $this -> idHistoricFilter = $idHistoricFilter;
    }

    /**
     * @return string: the url to be used for the marker design
     */
    public function getPinDesign() {
        return $this -> pinDesign;
    }

    public function setPinDesign($pinDesign) {
        $this -> pinDesign = $pinDesign;
    }
}