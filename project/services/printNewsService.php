<?php

include_once "../database/newsUtils.php";

define("NEWS_PER_PAGE", 5);

function printNewsByPage($page, $newsPerPage = null) {

    if ($newsPerPage == null) {
        $newsPerPage = NEWS_PER_PAGE;
    }

    $allNews = getAllNews();
    if ($allNews === null) {
        return array();
    }

    $newsForGivenPage = getNewsForGivenPage($allNews, $page, $newsPerPage);
    $formattedNews = array();

    foreach ($newsForGivenPage as $news) {
        array_push($formattedNews, constructNews($news));
    }

    return $formattedNews;

}

function getNewsForGivenPage($allNews, $page, $newsPerPage) {
    $startingIndex = $newsPerPage * ($page - 1);

    $newsToShow = array_slice($allNews, $startingIndex, $newsPerPage);

    return $newsToShow;
}

function constructNews($news) {
    $string = "";

    $string .= '<h2 class="newsHeader">';
    $string .= $news["header"];
    $string .= '</h2>';

    $string .= '<hr>';

    $string .= '<p class="newsText">';
    $string .= $news["content"];
    $string .= '</p>';

    $string .= '<p class="newsDate">';
    $string .= $news["added"];
    $string .= '</p>';

    $string .= "<br/><br/>\n";

    return $string;

}

