<!DOCTYPE html>
<html class="no-js">

  <head>
    <meta charset="utf-8">
    <script data-require="jquery@*" data-semver="2.0.3" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.1.1" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="./js/sidebar.js"></script>
    <script src="./js/background-mode.js"></script>
    <link data-require="bootstrap-css@3.1.1" data-semver="3.1.1" rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/sidebar.css" />
  </head>

  <body>
    <div class="contents-wrap">
    <!-- Top navbar -->
    <div class="navbar navbar-static navbar-default navbar-fixed-top" style="height: 51px;">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle toggle-left hidden-md hidden-lg" data-toggle="sidebar" data-target=".sidebar-left">
            <i class="fas fa-bookmark" style="color: dimgray; margin: 0 5px;"></i>
          </button>
          <span class="navbar-brand"><a href="/">Have it</a></span>
        </div>
        <button type="button" class="navbar-toggle toggle-right" data-toggle="sidebar" data-target=".sidebar-right">
          <i class="fas fa-dolly-flatbed" style="color: dimgray; margin: 0 2px;"></i>
        </button>
      </div>
    </div>
    <!-- "((" (leftside)(example)(rightside) )) -->
    <div class="container-fluid">
      <div class="row">