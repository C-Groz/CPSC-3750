<?php
header("Content-Type: application/xml; charset=UTF-8");
$states = array(
   'AL'=>array('Alabama','Montgomery'),
   'AK'=>array('Alaska','Juneau'),
   'AZ'=>array('Arizona','Phoenix'),
   'AR'=>array('Arkansas','Little Rock'),
   'CA'=>array('California','Sacramento'),
   'CO'=>array('Colorado','Denver'),
   'CT'=>array('Connecticut','Hartford'),
   'DE'=>array('Delaware','Dover'),
   'DC'=>array('District of Columbia',''),
   'FL'=>array('Florida','Tallahassee'),
   'GA'=>array('Georgia','Atlanta'),
   'HI'=>array('Hawaii','Honolulu'),
   'ID'=>array('Idaho','Boise'),
   'IL'=>array('Illinois','Springfield'),
   'IN'=>array('Indiana','Indianapolis'),
   'IA'=>array('Iowa','Des Moines'),
   'KS'=>array('Kansas','Topeka'),
   'KY'=>array('Kentucky','Frankfort'),
   'LA'=>array('Louisiana','Baton Rouge'),
   'ME'=>array('Maine','Augusta'),
   'MD'=>array('Maryland','Annapolis'),
   'MA'=>array('Massachusetts','Boston'),
   'MI'=>array('Michigan','Lansing'),
   'MN'=>array('Minnesota','St. Paul'),
   'MS'=>array('Mississippi','Jackson'),
   'MO'=>array('Missouri','Jefferson City'),
   'MT'=>array('Montana','Helena'),
   'NE'=>array('Nebraska','Lincoln'),
   'NV'=>array('Nevada','Carson City'),
   'NH'=>array('New Hampshire','Concord'),
   'NJ'=>array('New Jersey','Trenton'),
   'NM'=>array('New Mexico','Santa Fe'),
   'NY'=>array('New York','Albany'),
   'NC'=>array('North Carolina','Raleigh'),
   'ND'=>array('North Dakota','Bismarck'),
   'OH'=>array('Ohio','Columbus'),
   'OK'=>array('Oklahoma','Oklahoma City'),
   'OR'=>array('Oregon','Salem'),
   'PA'=>array('Pennsylvania','Harrisburg'),
   'RI'=>array('Rhode Island','Providence'),
   'SC'=>array('South Carolina','Columbia'),
   'SD'=>array('South Dakota','Pierre'),
   'TN'=>array('Tennessee','Nashville'),
   'TX'=>array('Texas','Austin'),
   'UT'=>array('Utah','Salt Lake City'),
   'VT'=>array('Vermont','Montpelier'),
   'VA'=>array('Virginia','Richmond'),
   'WA'=>array('Washington','Olympia'),
   'WV'=>array('West Virginia','Charleston'),
   'WI'=>array('Wisconsin','Madison'),
   'WY'=>array('Wyoming','Cheyenne'),
);

$query = isset($_GET['query']) ? $_GET['query'] : '';

echo "<?xml version=\"1.0\" ?>\n";
echo "<names>\n";
foreach ($states as $data) {
   list($name, $capital) = $data;
    if (stristr($name, $query)) {
        echo "<name>$capital</name>\n";
    }
}
echo "</names>\n";
?>
