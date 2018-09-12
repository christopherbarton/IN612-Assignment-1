<?php
include 'connect.inc.php';

//Establish connection to he network

try
    {
        $pdo = new PDO("mysql:host=$host;dbname=$database", $userMS, $passwordMS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');

       //echo "Connected<br/>";
    }

catch (PDOException $e)
    {
        $error = 'Connection to database failed';
        include 'error.html.php';
        exit();
    }

    // DROP tables if they exsist - only for development - Creates Table 

try
    {   
        $dropQuery = "DROP TABLE IF EXISTS medalists";
        $pdo->exec($dropQuery);

        $createQuery="CREATE TABLE medalists
        (
            medalistId INT(6) NOT NULL AUTO_INCREMENT,
            firstName      VARCHAR(20) NOT NULL,
            lastName      VARCHAR(20) NOT NULL,
            gender     VARCHAR(20) NOT NULL,
            image      VARCHAR(20) NOT NULL,
            eventId      INT(6) NOT NULL,
            medal      VARCHAR(20) NOT NULL,
            
            PRIMARY KEY(medalistId)           
        )";

        $pdo->exec($createQuery);
       //echo "Create medalists database done<br/>";

       // Create event table

       $dropQuery = "DROP TABLE IF EXISTS event";
        $pdo->exec($dropQuery);

        $createQuery="CREATE TABLE event
        (
            eventId INT(6) NOT NULL AUTO_INCREMENT,
            sport      VARCHAR(50) NOT NULL,
            event      VARCHAR(50) NOT NULL,
            PRIMARY KEY(eventId)           
        )";

        $pdo->exec($createQuery);
       //echo "Create sport database done<br/>";

    }
catch (PDOException $e)
    {
        $error='Creating the table failed';
        include 'error.html.php';
        exit();

    }

//Reading csv file and INSERTing data into table

try
    {   
        $count=1;
   
        //Insert medalist Data usig a prepared table
        $insertQuery = "INSERT into medalists(firstName,lastName,gender,image,medal,eventId) VALUES(:firstName,:lastName,:gender,:image,:medal,:eventId)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->bindParam(':firstName',$firstName);
        $stmt->bindParam(':lastName',$lastName);
        $stmt->bindParam(':gender',$gender);
        $stmt->bindParam(':image',$image);
        $stmt->bindParam(':medal',$medal);
        $stmt->bindParam(':eventId',$eventId);

        $file = fopen("medalists.csv","r");
        
        while(! feof($file))
            {  
            $myArray= fgetcsv($file);
            $medal=$myArray[0];
            $firstName=$myArray[1];
            $lastName= $myArray[2];
            $gender= $myArray[3];
            $image= $myArray[6];
            $eventId=$count;
            $stmt->execute();
           // echo '<pre>'; print_r($myArray); echo '</pre>';
            //echo $eventId;
            $count++;
            }
        fclose($file);

        //echo "Create medalists database done<br/>";

        // Insert sport data using prepared tables
        $insertQuery2 = "INSERT into event(sport,event) VALUES(:sport,:event)";
        $stmt2 = $pdo->prepare($insertQuery2);
        $stmt2->bindParam(':sport',$sport);
        $stmt2->bindParam(':event',$event);

        
        $file1 = fopen("medalists.csv","r");
        $count=1;
        while(! feof($file1))
            {  
            $myArray= fgetcsv($file1);
            $sport= $myArray[4];
            $event= $myArray[5];
            $stmt2->execute();
            //do something with the data
            }
        fclose($file1);

    //echo "Create event database done<br/>";

    }
catch (PDOException $e)
    {
        $error='Creating the table failed';
        include 'error.html.php';
        exit();

    }

    


?>