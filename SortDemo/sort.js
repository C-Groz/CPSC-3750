// initialize the counter and the array
var numbernames=0;
var names = new Array();
function SortNames() {
   // Get the name from the text field
   thename=document.theform.newname.value;

   // Convert names to upercase
   let splits = thename.split(" ");
   let upName = "";
   for(let i = 0; i < splits.length; i++){
      upName += splits[i].charAt(0).toUpperCase() + splits[i].slice(1).toLowerCase() + " ";
   }

   // Add the uppercase name to the array
   names[numbernames]=upName;

   // Increment the counter
   numbernames++;

   // Sort the array
   names.sort();

   // Add numbers to names
   let numberedNames = names.map((name, index) => {
      return `${index + 1}. ${name}`;
   });

   document.theform.sorted.value=numberedNames.join("\n");
}

// Ensure DOM is finished loading before detecting enter keystroke
document.addEventListener("DOMContentLoaded", function() {
   let enterPress = document.getElementById("newname");
   let addButton = document.getElementById("addname");

   enterPress.addEventListener("keypress", function(event){
      if(event.key === "Enter"){
         event.preventDefault();
         addButton.click();
      }
   })
});