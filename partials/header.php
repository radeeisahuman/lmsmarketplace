<?php
session_start();
include 'config.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LMS Marketplace by Ascended</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">Ascended</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active"  href="courses.php">Courses</a>
        </li>
        <?php if (isset($_SESSION['username'])) {
          echo '<li class="nav-item ">';
          echo '<a class="nav-link active" href="dashboard.php">Dashboard</a>';
          echo '</li>';
          echo '<li class="nav-item ">';
          echo '<a class="nav-link active" href="logout.php">Logout</a>';
          echo '</li>';
          } else{
          echo '<li class="nav-item ">';
          echo '<a class="nav-link active" href="login.php">Login</a>';
          echo '</li>';
          echo '<li class="nav-item ">';
          echo '<a  class="btn btn-light btn-md " href="registration.php" >Sign Up</a>';
          echo '</li>';
          }?>   
        </ul>
      </div>
    </div>
  </nav>
  
