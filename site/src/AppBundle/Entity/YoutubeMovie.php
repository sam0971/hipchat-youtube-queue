<?php

namespace AppBundle\Entity;

class YoutubeMovie
{
    private $id;

    private $videoId;
    private $postedTime;
    private $length;
    private $title;
    private $requestname;
    private $startedTime;
    private $skipped = false;
    private $played = false;

    private $imageLocation = 'images/youtube/';

    public function __construct($videoId, $length, $title, $requestname = NULL)
    {
        $this->videoId = $videoId;
        $this->length = $length;
        $this->title = $title;
        $this->requestname = $requestname;

        $this->postedTime = new \DateTime();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function skipVideo()
    {
        $this->skipped = true;
    }

    public function isPlayed()
    {
        return $this->played;
    }

    public function setPlayed()
    {
        $this->played = true;
    }

    public function startPlaying()
    {
        if (is_null($this->startedTime)) {
            $this->startedTime = new \DateTime();
        }
    }

    /**
     * @return \DateTime|null
     */
    public function getStartedTime()
    {
        return $this->startedTime;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDuration()
    {
        return $this->length;
    }

    public function getYoutubeKey()
    {
        return $this->videoId;
    }

    public function getVideo()
    {
      return "https://youtu.be/" . $this->videoId;
    }

    public function getImage()
    {
      return '/'.$this->imageLocation . $this->videoId . '.jpg';
    }

    public function getIframe()
    {
      return '<iframe width="800" height="400" src="https://www.youtube.com/embed/'.$this->videoId.'?autoplay=0x&controls=0&showinfo=0&disablekb=1&modestbranding=1" frameborder="0" allowfullscreen></iframe>';
    }

    public function getRequestName()
    {
      return $this->requestname;
    }

    public function getDataForJson()
    {
        return array(
            'iframe' => $this->getIframe(),
            'title' => $this->getTitle(),
            'requestname' => $this->getRequestName(),
            'duration' => $this->getDuration(),
            'id' => $this->getId(),
            'youtubekey' => $this->getYoutubeKey(),
            'image' => $this->getImage(),
        );
    }
}
