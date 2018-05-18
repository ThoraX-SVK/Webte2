<?php

include_once "../database/userUtils.php";


function isUserSubscribed($userID) {

    if ($userID === null) {
        return false;
    }

    return isUserSignedToNewsfilter($userID);
}

function getUserSubscriptionOptions($userID) {

    $isSubscribed = isUserSubscribed($userID);

    if (!$isSubscribed) {
        return '<a href="../controller/subscribeToNewsletterController.php?userID=' . $userID . '">Subscribe</a>';
    } else {
        return '<a href="../controller/unsubscribeFromNewsletterController.php?userID=' . $userID . '">Unsubscribe</a>';
    }

}