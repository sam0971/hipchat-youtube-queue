<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\YoutubeMovie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client as GuzzleClient;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $yt = new YoutubeMovie('2Z4m4lnjxkY', 100, "Trolololo");
        $yt1 = new YoutubeMovie('mAz50pZn6Ys', 100, "Moskau");
        $yt2 = new YoutubeMovie('ykwqXuMPsoc', 100, "Narwhals");
        $yt3 = new YoutubeMovie('ZZ5LpwO-An4', 100, "heya");

        return $this->render('default/index.html.twig', ['playlist' => [$yt, $yt1, $yt2, $yt3]]);
    }

    /**
     * @Route("/ajax/load-video", name="load-more")
     * @Method("GET")
     */
    public function ajaxLoadVideoAction()
    {

        return new Response();
    }

    /**
     * @Route("/add", name="add-movie")
     * @Method("POST")
     */
    public function postAction(Request $request)
    {
        $youtubeLink = $request->get('link');
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtubeLink, $match)) {
            $video_id = $match[1];
        }

        if (!isset($video_id)) {
          return new Response('Invalid url', 422);
        }

        $client = new GuzzleClient();

        $response = $client->get(
          'http://gdata.youtube.com/feeds/api/videos/' . $video_id,
          [
            'headers' => ['Content-Type' => 'text/xml'],
            'verify' => false,
            'timeout' => 5,
          ]
        );

        $xml = $response->xml();

        $yt = new YoutubeMovie($video_id, 100,$xml->title);

        return new Response("ok \n");
    }
}