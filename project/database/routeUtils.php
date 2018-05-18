<?php

include_once '../database/createConnection.php';
include_once '../constants/routeConstants.php';

//DEBUGGING
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

function getRouteInfoForMapAPI__FAKE($routeID) {

    //TODO: Might be totally different
    return array(
        'latStart' => '42',
        'lngStart' => '42',
        'latEnd' => '43',
        'lngEnd' => '43'
    );
}

function getRouteInfoForMapAPI($routeID) {

    //TODO: Look to DB and return some data
}

function getRouteShortDescription__FAKE($routeID) {

    return array(
        'name' => 'Za mesiac na mesiac',
        'totalDistance' => 384000
    );
}

function getRouteShortDescription($routeID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT name, distance FROM w2final.Route WHERE id = ?");
    $stmn->bind_param("i", $routeID);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();

    return array(
        'name' => $row['name'],
        'totalDistance' => $row['distance']
    );
}

function getRouteFullDescription__FAKE($routeID) {

    return array(
        'name' => 'Toto je dlhe ako hmmm... ( ͡° ͜ʖ ͡°)',
        'totalDistance' => 21,
        'activeContributorsCount' => 3,
        'routeMode' => PRIVATE_MODE
    );
}

function getRouteFullDescription($routeID) {

    $shortInfo = getRouteShortDescription($routeID);
    $activeContributorsCount = countActiveContributors($routeID);
    $routeMode = getRouteMode($routeID);

    return array(
        'name' => $shortInfo['name'],
        'totalDistance' => $shortInfo['distance'],
        'activeContributorsCount' => $activeContributorsCount,
        'routeMode' => $routeMode
    );
}

function getRouteContributors__FAKE($routeId) {

    return array(
        'first@one.sk' => 100,
        'second@two.sk' => 50,
        'last @lats.sk' => 10
    );
}

function getRouteContributors($routeId) {

    //TODO: Look in DB and onstruct array of users and their km

}

function countActiveContributors($routeID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT COUNT(*) AS 'activeUsers' FROM w2final.Route
                                    JOIN w2final.User ON Route.id = User.activeRoute_fk
                                  WHERE Route.id = ?;");
    $stmn->bind_param("i", $routeID);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    $row = $result->fetch_assoc();

    return $row['activeUsers'];
}

function getRouteMode__FAKE($routeID) {
    return PRIVATE_MODE;
}

function getRouteMode($routeID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT mode_fk AS 'mode' FROM w2final.Route WHERE id = ?");
    $stmn->bind_param("i",$routeID);
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    if(mysqli_num_rows($result) === 0) {
        return null;
    }

    $row = $result->fetch_assoc();
    return $row['mode'];
}

function saveRoute($createdByUserID, $name, $totalDistance, $mode,
                   $startLatiude, $startLongitude,
                   $endLatitude, $endLongitude) {

    $conn = createConnectionFromConfigFileCredentials();

    $sql = "INSERT INTO w2final.Route (id, user_fk, name, distance, mode_fk, startLatitude, startLongitude, endLatitude, endLongitude)
            VALUES (NULL, '$createdByUserID', '$name', '$totalDistance', '$mode', '$startLatiude', '$startLongitude', '$endLatitude', '$endLongitude')";
    $conn->query($sql);

    $conn->close();
}

function saveRoute_FAKE($userId, $name ,$distance, $mode,
                        $startLatitude, $startLongitude, $endLatitude, $endLongitude)
{

}

function calculateRouteRemainingAndDoneDistance__FAKE($routeID) {
    return array(
        'totalDistance' => 300,
        'done' => 120,
        'remaining' => 180
    );
}

/**
 *  Returns array with totalDistance, done and remaining units
 *  on route given routeID.
 *
 * @param $routeID
 * @return array
 */
function calculateRouteRemainingAndDoneDistance($routeID) {

    $conn = createConnectionFromConfigFileCredentials();
    //COALESCE --> When resul of SUM is NULL, replace it with 0
    $stmn = $conn->prepare("SELECT X.done AS 'done', Route.distance AS 'total' FROM
                                        (SELECT COALESCE(SUM(Run.distance),0) AS 'done', Route.id AS  'id'
                                         FROM w2final.Run
                                            RIGHT JOIN w2final.Route ON Run.route_fk = Route.id
                                         WHERE Run.route_fk = $routeID
                                          ) AS X
                                            JOIN w2final.Route ON X.id = Route.id
                                      ");
    $stmn->execute();

    $result = $stmn->get_result();
    $row = $result->fetch_assoc();

    $stmn->close();
    $conn->close();

    return array(
        'totalDistance' => $row['total'],
        'done' => $row['done'],
        'remaining' => $row['total'] - $row['done']
    );
}

function get_N_lastRuns__FAKE($routeID, $N = 5) {

    return array(
        array(
            'userID' => 1,
            'distance' => 10,
            'date' => "2018-12-30",
            'endAtTime' => "15:00:00"

        ),
        array(
            'userID' => 1,
            'distance' => 12,
            'date' => "2018-12-30",
            'endAtTime' => "9:30:00"
        ),
        array(
            'userID' => 2,
            'distance' => 5,
            'date' => "2018-12-28",
            'endAtTime' => "18:00:00"
        )
    );
}

/**
 * Returns array, where on first position is most new run
 *
 * Size of array is N or less, where N is 5 as default value
 *
 * @param $routeID
 * @param int $N
 * @return array
 */
function get_N_lastRuns($routeID, $N = 5) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT distance, date, endAtTime, user_fk AS 'userID' 
                                    FROM w2final.Run
                                    WHERE route_fk = ?
                                    ORDER BY date DESC, endAtTime DESC
                                    LIMIT ?");
    $stmn->bind_param("ii", $routeID, $N);
    $stmn->execute();

    $result = $stmn->get_result();

    $res_arr = new ArrayObject();

    foreach ($result as $row) {

        $res = array(
            'userID' => $row['userID'],
            'distance' => $row['distance'],
            'date' => $row['date'],
            'endAtTime' => $row['endAtTime']
        );

        $res_arr->append($res);
    }

    return $res_arr->getArrayCopy();
}

function get_N_topContributorsToRouteID__FAKE($routeID, $N = 5) {
    return array(
        array(
            'userID' => 1,
            'distance' => 150,
        ),
        array(
            'userID' => 2,
            'distance' => 80,
        )
    );
}

/**
 * Returns array of users that contributed most units to
 * route with given routeID. First in array is biggest contributor.
 *
 * Size of array is N or less, where N is 5 as default value
 *
 * @param $routeID
 * @param int $N
 * @return array
 */
function get_N_topContributorsToRouteID($routeID, $N = 5) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT SUM(distance) AS 'totalContribution', user_fk AS 'userID'
                                    FROM w2final.Run
                                    WHERE route_fk = ?
                                    GROUP BY user_fk DESC
                                    LIMIT ?");
    $stmn->bind_param("ii", $routeID, $N);
    $stmn->execute();

    $result = $stmn->get_result();

    $res_arr = new ArrayObject();

    foreach ($result as $row) {

        $res = array(
            'userID' => $row['userID'],
            'distance' => $row['totalContribution'],
        );

        $res_arr->append($res);
    }

    return $res_arr->getArrayCopy();
}

function getAllRoutesWithModeVisibleForUserID__FAKE($mode, $userID = null) {

    switch ($mode) {
        case PRIVATE_MODE:
        case PUBLIC_MODE:
            return array(
                array(
                    'distanceData' => array(
                        'totalDistance' => 300,
                        'done' => 120,
                        'remaining' => 180),
                    'name' => 'route1',
                    'isActiveForUser' => true,
                    'routeID' => 1
                ),
                array(
                    'distanceData' => array(
                        'totalDistance' => 1000,
                        'done' => 0,
                        'remaining' => 1000),
                    'name' => 'route2',
                    'isActiveForUser' => false,
                    'routeID' => 1
                ),
                array(
                    'distanceData' => array(
                        'totalDistance' => 100,
                        'done' => 23,
                        'remaining' => 77),
                    'name' => 'route3',
                    'isActiveForUser' => false,
                    'routeID' => 1
                )
            );
            break;
        case TEAM_MODE:
            array(
                array(
                    'distanceData' => array(
                        'totalDistance' => 1500,
                        'done' => 500,
                        'remaining' => 1000),
                    'name' => 'route1',
                    'isActiveForUser' => true,
                    'isUserInTeam' => true,
                    'routeID' => 1
                ),
                array(
                    'distanceData' => array(
                        'totalDistance' => 1000,
                        'done' => 250,
                        'remaining' => 750),
                    'name' => 'route2',
                    'isActiveForUser' => false,
                    'isUserInTeam' => false,
                    'routeID' => 1
                ),
                array(
                    'distanceData' => array(
                        'totalDistance' => 200,
                        'done' => 120,
                        'remaining' => 80),
                    'name' => 'route3',
                    'isActiveForUser' => false,
                    'isUserInTeam' => true,
                    'routeID' => 1
                )
            );
        default:
    }

    return null;
}

/**
 *  Gets all routes based on common USER visibility rules:
 *      PRIVATE - only for user that created them
 *      PUBLIC  - get every route
 *      TEAM - not yet implemented
 *
 *  This function is not supposed to get data for admin!
 *
 * @param $mode
 * @param $userID
 * @return array|null
 */
function getAllRoutesWithModeVisibleForUserID($mode, $userID) {

    $result = null;
    switch ($mode) {
        case PRIVATE_MODE:
            $result = selectPrivateRoutes($userID);
            break;
        case PUBLIC_MODE:
            $result = selectPublicRoutes($userID);
            break;
        case TEAM_MODE:
            $result = selectTeamRoutes($userID);
            break;
        default:
    }

    return $result;
}

function selectPrivateRoutes($userID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT Route.id AS 'routeID', activeRoute_fk AS 'usersActiveRouteID', Route.name AS 'routeName'
                                   FROM w2final.Route
                                      JOIN w2final.User ON Route.user_fk = User.id
                                   WHERE user_fk = ? AND mode_fk = 1");
    $stmn->bind_param("i", $userID);
    $stmn->execute();


    $result = $stmn->get_result();

    $stmn->close();
    $conn->close();

    $res_arr = new ArrayObject();

    foreach ($result as $row) {

        $routeID = $row['routeID'];
        $isActiveRoute = $routeID === $row['usersActiveRouteID'];
        $routeInfo = calculateRouteRemainingAndDoneDistance($routeID);

        $res = array(
            'distanceData' => $routeInfo,
            'name' => $row['routeName'],
            'isActiveForUser' => $isActiveRoute
        );

        $res_arr->append($res);
    }

    return $res_arr->getArrayCopy();
}

function selectPublicRoutes($userID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT Route.id AS 'routeID', Route.name AS 'routeName', X.activeRoute_fk AS 'usersActiveRouteID' FROM
                                      (SELECT id , activeRoute_fk
                                       FROM w2final.User
                                       WHERE id = $userID
                                       ) AS X
                                   JOIN w2final.Route
                                   WHERE mode_fk = 2;");
    $stmn->execute();
    $result = $stmn->get_result();

    $stmn->close();
    $conn->close();

    $res_arr = new ArrayObject();

    foreach ($result as $row) {

        $routeID = $row['routeID'];
        $isActiveRoute = $routeID === $row['usersActiveRouteID'];
        $routeInfo = calculateRouteRemainingAndDoneDistance($routeID);

        $res = array(
            'distanceData' => $routeInfo,
            'name' => $row['routeName'],
            'isActiveForUser' => $isActiveRoute
        );

        $res_arr->append($res);
    }

    return $res_arr->getArrayCopy();
}

function selectTeamRoutes($userID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT canParticipateTo AS 'canChoose', Route.id AS 'routeID', activeRoute_fk AS 'isActiveRoute' , Route.name FROM (
                                        SELECT Route.id AS 'canParticipateTo' FROM w2final.Route
                                          JOIN w2final.TeamRoutes ON Route.id = TeamRoutes.route_fk
                                          JOIN w2final.Team ON TeamRoutes.team_fk = Team.id
                                          JOIN (SELECT team_fk AS 'userInTeam' FROM w2final.TeamMembers
                                        WHERE user_fk = $userID
                                        ) AS USER_IN_TEAMS
                                    WHERE userInTeam = Team.id
                                  ) AS CAN_PARTICIPATE_IN
                                    RIGHT JOIN w2final.Route ON canParticipateTo = Route.id
                                    LEFT JOIN w2final.User ON Route.id = User.activeRoute_fk
                                    WHERE mode_fk = 3");
    $stmn->execute();

    $result = $stmn->get_result();
    $stmn->close();
    $conn->close();

    $res_arr = new ArrayObject();
    foreach ($result as $row) {

        $routeID = $row['routeID'];
        $canUserParticipate = $row['canChoose'] !== null;
        $isActiveForUser = $row['isActiveRoute'] !== null;
        $routeName = $row['name'];
        $routeInfo = calculateRouteRemainingAndDoneDistance($routeID);

        $res = array(
            'distanceData' => $routeInfo,
            'name' => $routeName,
            'isActiveForUser' => $isActiveForUser,
            'isUserInTeam' => $canUserParticipate
        );

        $res_arr->append($res);
    }

    return $res_arr->getArrayCopy();
}


function getAllRoutesWithMode__FAKE($mode) {

    return array(
        array(
            'distanceData' => array(
                'totalDistance' => 300,
                'done' => 120,
                'remaining' => 180),
            'name' => 'route1',
            'createdByUserID' => 3
        ),
        array(
            'distanceData' => array(
                'totalDistance' => 1000,
                'done' => 0,
                'remaining' => 1000),
            'name' => 'route2',
            'createdByUserID' => 5
        ),
        array(
            'distanceData' => array(
                'totalDistance' => 100,
                'done' => 23,
                'remaining' => 77),
            'name' => 'route3',
            'createdByUserID' => 9
        )
    );

}


/**
 *  This function DOES NOT take visibility into account, and should only be called
 *  if we are sure user is admin. It returns array with info + who created that route.
 *
 * @param $mode
 * @return array
 */
function getAllRoutesWithMode($mode) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id AS 'routeID', Route.name AS 'routeName' , user_fk AS 'createdByUserID'
                                    FROM w2final.Route
                                    WHERE mode_fk = ?;");
    $stmn->bind_param("i", $mode);
    $stmn->execute();

    $result = $stmn->get_result();

    $stmn->close();
    $conn->close();

    $res_arr = new ArrayObject();

    foreach ($result as $row) {
        $routeID = $row['routeID'];
        $createdByUserID = $row['createdByUserID'];
        $routeInfo = calculateRouteRemainingAndDoneDistance($routeID);

        $res = array(
            'distanceData' => $routeInfo,
            'name' => $row['routeName'],
            'createdByUserID' => $createdByUserID
        );

        $res_arr->append($res);
    }

    return $res_arr->getArrayCopy();
}

function isRouteVisibleForUserID($routeID, $userID) {

    $routeMode = getRouteMode($routeID);

    switch($routeMode) {
        case PRIVATE_MODE:
            return isUserCreatorOfPrivateRoute($userID, $routeID);
        case PUBLIC_MODE:
        case TEAM_MODE:
            return true;
        default:
            return false;
    }
}

function isUserCreatorOfPrivateRoute($userID, $routeID) {

    $conn = createConnectionFromConfigFileCredentials();
    $stmn = $conn->prepare("SELECT id FROM w2final.Route
                                    WHERE id = ? AND user_fk = ? AND mode_fk = 1");
    $stmn->bind_param("ii",$routeID,$userID);
    $stmn->execute();

    $result = $stmn->get_result();

    return mysqli_num_rows($result) === 0 ? false : true;
}



