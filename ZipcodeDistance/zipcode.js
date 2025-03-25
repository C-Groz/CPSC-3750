
let zip1 = document.getElementById("zip1");
let zip2 = document.getElementById("zip2");
let hideIntermediate = document.getElementById("hide-info");
let outputDiv = document.getElementById("output");

let zipCodeData = {};

window.onload = function(){
    fetch('getZipInfo.php')
    .then(response => response.json())
    .then(data => {
        zipCodeData = data; 
    })
    .catch(error => console.error('Error:', error));
}


function submit(){
    var code1 = zip1.value;
    var code2 = zip2.value;
    var lat1 = zipCodeData[code1].latitude;
    var lat2 = zipCodeData[code2].latitude;
    var long1 = zipCodeData[code1].longitude;
    var long2 = zipCodeData[code2].longitude;


    if(zipCodeData[code1] && zipCodeData[code2]){
        if(!hideIntermediate.checked){
            var distance = geolib.getDistance(
                { latitude: lat1, longitude: long1 },
                { latitude: lat2, longitude: long2 }
            );

            distance = geolib.convertDistance(distance, 'mi');
            
            outputDiv.innerText = "Zipcode 1 Coordinates: " + lat1 + " " + long1 + "\n";
            outputDiv.innerText += "Zipcode 2 Coordinates: " + lat2 + " " + long2 + "\n";
            outputDiv.innerText += "Distance: " + distance + " miles";
        }
        else{
            var distance = geolib.getDistance(
                { latitude: lat1, longitude: long1 },
                { latitude: lat2, longitude: long2 }
            );

            distance = geolib.convertDistance(distance, 'mi');
            outputDiv.innerText = "Distance: " + distance + " miles";
        }

    }
    else{
        outputDiv.innerText = "1 or more zipcodes invalid, try again";
    }
}