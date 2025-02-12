// define the functions
function printCard() {
   var nameLine = "<strong>Name: </strong>" + this.name + "<br>";
   var emailLine = "<strong>Email: </strong>" + this.email + "<br>";
   var addressLine = "<strong>Address: </strong>" + this.address + "<br>";
   var phoneLine = "<strong>Phone: </strong>" + this.phone + "<br>";
   this.birthday = formatDate(this.birthday);
   var birthdayLine = "<strong>Birthday: </strong>" + this.birthday;
   document.getElementById("cards_display").innerHTML += nameLine + emailLine + addressLine + phoneLine + birthdayLine + "<hr><br>";
}

function formatDate(dateString) {
   if (!dateString) return; 

   var parts = dateString.split("-");
   return `${parts[1]}/${parts[2]}/${parts[0]}`;
}

function showCards(){
   sue.printCard();
   fred.printCard();
   jimbo.printCard();
}

function newCard(){
   var name = document.getElementById("name").value;
   var email = document.getElementById("email").value;
   var address = document.getElementById("address").value;
   var phone = document.getElementById("phone").value;
   var birthday = document.getElementById("birthday").value;

   var newCard = new Card(name, email, address, phone, birthday);

   newCard.printCard();
}

function Card(name,email,address,phone,birthday) {
   this.name = name;
   this.email = email;
   this.address = address;
   this.phone = phone;
   this.birthday = birthday;
   this.printCard = printCard;
}

// Create the objects
var sue = new Card("Sue Suthers", "sue@suthers.com", "123 Elm Street, Yourtown ST 99999", "555-555-9876", "2002-12-12");
var fred = new Card("Fred Fanboy", "fred@fanboy.com", "233 Oak Lane, Sometown ST 99399", "555-555-4444", "1999-03-24");
var jimbo = new Card("Jimbo Jones", "jimbo@jones.com", "233 Walnut Circle, Anotherville ST 88999", "555-555-1344", "2004-07-25");

