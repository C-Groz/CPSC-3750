<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    echo "<h2>Form Responses</h2>";
    echo "<p>Text Input: " . htmlspecialchars($_POST['text'] ?? '') . "</p>";
    echo "<p>Text Area Input: " . htmlspecialchars($_POST['textarea'] ?? '') . "</p>";
    echo "<p>Password Input : " . htmlspecialchars($_POST['password'] ?? '') . "</p>";
    
    echo "<p>Check Boxes Input: </p>";
    foreach(["checkbox1", "checkbox2", "checkbox3"] as $checkbox){
        if(isset($_POST[$checkbox])) {
            echo "<p>" . htmlspecialchars($checkbox) . " checked</p>";
        }
    }
    
    echo "<p>Radio Input: " . htmlspecialchars($_POST['radio'] ?? 'Off') . "</p>";
    echo "<p>Selection List Input: " . htmlspecialchars($_POST['select'] ?? '') . "</p>";
    echo "<p>URL Input: " . htmlspecialchars($_POST['url'] ?? '') . "</p>";
    
    if(!empty($_FILES["file"]["name"])){
        echo "<p>File Uploaded: " . htmlspecialchars($_FILES["file"]["name"]) . "</p>";
    }

    echo "<a href='forms.html'>Back</a>";
}
?>