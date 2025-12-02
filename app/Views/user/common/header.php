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
    .emoji-zoom {
      font-size: 30px;
      display: inline-block;
      animation: zoomPulse 1.5s ease-in-out infinite;
    }

    @keyframes zoomPulse {

      0%,
      100% {
        transform: scale(1);
      }

      50% {
        transform: scale(1.3);
      }
    }

    .sticky-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background-color: #3f33ff;
      color: white;
      font-size: 24px;
      border: none;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
      cursor: pointer;
      z-index: 999;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .pay-icons {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    .pay-icon {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 12px;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      text-decoration: none;
      color: #111827;
      background: #fff;
      pointer-events: none;
    }

    .pay-icon img,
    .pay-icon svg {
      width: 24px;
      height: 24px;
      display: block
    }

    .pay-icon span {
      font: 600 14px/1.2 system-ui, -apple-system, Segoe UI, Roboto, sans-serif
    }
    .disabled {
        pointer-events: none;
        opacity: 0.6;
        cursor: not-allowed;
    }
  </style>
  <style>
    .blink-bg {      
      display: inline-block;
      animation: blink-bg 2s infinite;
    }
    @keyframes blink-bg {
      0%,100% { background: darkmagenta; }
      50%     { background: darkred; }
    }
    @media (prefers-reduced-motion: reduce) {
      .blink-bg { animation: none; background: darkred; } /* keep visible but not animated */
    }
</style>
</head>

<body class="nk-body bg-lighter npc-default has-sidebar">
  <div class="nk-app-root">
    <!-- main @s -->
    <div class="nk-main">