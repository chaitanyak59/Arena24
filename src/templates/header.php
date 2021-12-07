<?php
//Retrieving Session Details
$isSuperAdmin = isset($_COOKIE["ID"]) ? ($_COOKIE["ID"] == -1 ? true : false) : false;
$loggedInUser = isset($_COOKIE["User"]) ? $_COOKIE["User"] : NULL;
?>
<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Arena 24</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <script>
          document.addEventListener('DOMContentLoaded', function() {
               M.AutoInit();
               // //Dropdown Exception
               // var elems = document.querySelectorAll('.dropdown-trigger');
               // var instances = M.Dropdown.init(elems, {
               //      hover: true,
               //      outDuration: 150
               // });
          });
     </script>
     <style>
          /* Stick Footer Down */
          body {
               display: flex;
               min-height: 100vh;
               flex-direction: column;
          }

          main {
               flex: 1 0 auto;
          }
          .parallax-container {
               height: 350px;
          }
          .helper-text {
               color: red !important;
          }
     </style>
</head>

<body>