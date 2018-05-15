<?php

namespace App\Extensions\GPXLoader;

class Point
{
    /**
     * @var float
     */
    private $latitude;
    /**
     * @var float
     */
    private $longitude;
    /**
     * @var time
     */
    private $time;
    /**
     * @var float
     */
    private $speedTrack;


    public function __construct($latitude, $longitude, $time, $speedTrack)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->time = $time;
        $this->speedTrack = $speedTrack;

    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @param $time
     */
    public function setTime($time)
    {
        $this->longitude = $time;
    }

    /**
     * @return time
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param $speedTrack
     */
    public function setSpeedTrack(float $speedTrack)
    {
        $this->speedTrack = $speedTrack;
    }

    /**
     * @return float
     */
    public function getSpeedTrack()
    {
       return  $this->speedTrack;
    }

}