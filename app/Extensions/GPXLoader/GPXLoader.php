<?php

namespace App\Extensions\GPXLoader;
/**
 * This library loads and parse gpx file
 *
 */
class GPXLoader implements \Iterator
{
    /**
     * @var string
     */
    private $trackName;
    /**
     * @var int
     */
    private $position;
    /**
     * @var Point[]
     */
    private $points = [];
    /**
     * @var float
     */
    private $speedTrack;

    public function __construct($file)
    {
        $this->position = 0;
        $this->parseGPXFile($file);
    }

    /**
     * @return string
     */
    public function getTrackName()
    {
        return $this->trackName;
    }

    /**
     * @return Point[]
     */
    public function getPoints()
    {
        return $this->points;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return Point
     */
    public function current()
    {
        return $this->points[$this->position];
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->points[$this->position]);
    }

    /**
     * @return float
     */
    public function getSpeedTrack()
    {
        return $this->speedTrack;
    }

    private function parseGPXFile($file)
    {
        if (file_exists($file)) {
            $gpx = simplexml_load_file($file);

            // save name

            if (!is_null($gpx->trk->name)) {
                $this->trackName = (string)$gpx->trk->name;

            }
            if(!is_null($gpx->metadata->speed)){
                $this->speedTrack = (floatval($gpx->metadata->speed));
            }
            // push points to array
            foreach ($gpx->trk->trkseg->children() as $trkpt) {

                $this->points[] = new Point(floatval($trkpt['lat']), floatval($trkpt['lon']), $trkpt->time,floatval ($trkpt->speed));
            }
        } else {
            throw new \Exception('The file does not exist.');
        }
    }
}