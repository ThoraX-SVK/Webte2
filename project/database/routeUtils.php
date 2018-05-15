<?php

include_once '../database/createConnection.php';


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

    //TODO: Look to DB and construct short description
}

function getRouteFullDescription__FAKE($routeID) {

    return array(
        'name' => 'Za mesiac na mesiac',
        'totalDistance' => 384000,
        'more info' => 'This is full description btw!'
    );
}

function getRouteFullDescription($routeID) {

    //TODO: Look to DB and construct full description
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

function saveRoute($creatingUserID, $totalDistance, $mode) {

    $conn = createConnectionFromConfigFileCredentials();

    $stmn = $conn->prepare("INSERT w2final.Route VALUES (DEFAULT, ?, ?, ?)");
    $stmn->bind_param('iii',$creatingUserID,$totalDistance, $mode);
    $stmn->execute();

    $stmn->close();
    $conn->close();
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
    $stmn = $conn->prepare("SELECT COALESCE(SUM(Run.distance),0) AS 'done', Run.distance AS 'total'
                                    FROM w2final.Run
                                      RIGHT JOIN w2final.Route ON Run.route_fk = Route.id
                                      GROUP BY Route.id
                                      HAVING Route.id = ?");

    $stmn->bind_param("i",$routeID);
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

function getAllRoutesWithMode__FAKE($mode, $userID = null) {

    return array(
        array(
            'distanceData' => array(
                'totalDistance' => 300,
                'done' => 120,
                'remaining' => 180),
            'name' => 'route1',
            'isActiveForUser' => true
        ),
        array(
            'distanceData' => array(
                'totalDistance' => 1000,
                'done' => 0,
                'remaining' => 1000),
            'name' => 'route2',
            'isActiveForUser' => false
        ),
        array(
            'distanceData' => array(
                'totalDistance' => 100,
                'done' => 23,
                'remaining' => 77),
            'name' => 'route3',
            'isActiveForUser' => false
        )
    );
}


