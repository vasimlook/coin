<!DOCTYPE html>
<html lang="en" class="js">

<head>
  <base href="../">
  <meta charset="utf-8">
  <meta name="author" content="Softnio">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="A powerful color game for make big profit">
  <!-- Fav Icon  -->
  <link rel="shortcut icon" href="<?php echo ASSETS_DIR_LINK; ?>template/images/favicon.png">
  <!-- Page Title  -->
  <title><?php echo $title; ?></title>
  <!-- StyleSheets  -->
  <link rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/dashlite.css">
  <link id="skin-default" rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/theme.css">
  <link rel="stylesheet" href="<?php echo ASSETS_DIR_LINK; ?>common/common.css">
  <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_DIR_LINK; ?>template/assets/css/libs/bootstrap-icons.css">

  <!-- datatable start css  -->
  <link href="<?php echo ASSETS_DIR_LINK; ?>central/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo ASSETS_DIR_LINK; ?>central/datatable/responsive.dataTables.min.css" rel="stylesheet" type="text/css">
<style>
.img-box {
    position: relative;
    display: inline-block;
    margin: 10px;
}

.img-box img {
    border-radius: 6px;
}

.view-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 8px 16px;
    background: rgba(0,0,0,0.7);
    color: #fff;
    border: none;
    border-radius: 4px;
    display: none;
    cursor: pointer;
}

.img-box:hover .view-btn {
    display: block;
}

.img-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    padding-top: 80px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    text-align: center;
}

.img-modal-content {
    max-width: 90%;
    max-height: 80%;
    border-radius: 8px;
}

.img-modal-close {
    position: absolute;
    top: 20px;
    right: 35px;
    font-size: 40px;
    font-weight: bold;
    color: white;
    cursor: pointer;
}
</style>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar">
  <div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main" style="background: radial-gradient(circle at top, #3a0ca3, #0b061a);">