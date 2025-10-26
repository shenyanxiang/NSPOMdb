<!DOCTYPE html>
<html lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>NSPOMdb</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo.png">
    <link rel="manifest" href="phoenix/public/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="phoenix/public/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="phoenix/public/vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="phoenix/public/vendors/simplebar/simplebar.min.js"></script>
    <script src="phoenix/public/assets/js/config.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="phoenix/public/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="phoenix/public/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="phoenix/public/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="phoenix/public/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="phoenix/public/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
    <link href="assets/css/style.css" type="text/css" rel="stylesheet" id="custom-style-default">
    <script>
      var phoenixIsRTL = window.config.config.phoenixIsRTL;
      if (phoenixIsRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
  </head>
  <?php
    session_start();
    require 'scripts/db-connect.php';
    $micro_query="SELECT micro_id FROM public.micro_list";
    $micro_result = pg_query($conn, $micro_query);
    $micro_num = pg_num_rows($micro_result);

    $event_query="SELECT event_id FROM public.recall_event";
    $event_result = pg_query($conn, $event_query);
    $event_num = pg_num_rows($event_result);

    $dosage_query="SELECT dosage_id FROM public.dosage_list";
    $dosage_result = pg_query($conn, $dosage_query);
    $dosage_num = pg_num_rows($dosage_result);

    $route_query="SELECT route_id FROM public.route_list";
    $route_result = pg_query($conn, $route_query);
    $route_num = pg_num_rows($route_result);

    $population_query="SELECT population_id FROM public.population_list";
    $population_result = pg_query($conn, $population_query);
    $population_num = pg_num_rows($population_result);

  ?>

  <body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container-fluid px-0">
      <div style="display: none;">
        <script type="text/javascript" id="clustrmaps" src="//clustrmaps.com/map_v2.js?d=wea__NhzJiZpeXybdHHfcCobjX2akFU9-fftwpZ2TqI"></script>
      </div>
      </div>
        <nav class="navbar navbar-vertical navbar-expand-lg">
          <script>
            var navbarStyle = window.config.config.phoenixNavbarStyle;
            if (navbarStyle && navbarStyle !== 'transparent') {
              document.querySelector('body').classList.add(`navbar-${navbarStyle}`);
            }
          </script>
        </nav>
        <?php include 'scripts/navbarTop.php'; ?>
        <script>
          var navbarVertical = document.querySelector('.navbar-vertical');
          navbarVertical.remove();
          navbarTop.removeAttribute('style');
        </script>
        <div class="content container">
          <div class="mx-2 px-4 mx-lg-n6 px-lg-6 bg-white pt-3 pb-1 border border-300 rounded-3">
            <div class="row align-items-center mb-2">
              <h1 class="text-center fw-bold">NSPOMdb</h1>
              <p class="text-center lead">Non-sterile product objectionable microorganism database</p>
            </div>
            <div class="row justify-content-between mb-6">
              <div class="col-6 col-md-6 col-xxl-3 text-center border-start-xxl border-bottom-xxl-0 border-bottom border-end border-end-md pb-4 pb-xxl-0">
                <div class="row align-items-center justify-content-between">
                  <div class="col-4"><svg t="1745843405904" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2677" style="width: 100%; height: 100%;"><path d="M512 512m-512 0a512 512 0 1 0 1024 0 512 512 0 1 0-1024 0Z" fill="#3AD0F9" p-id="2678"></path><path d="M608.8 871.2c0-3.2-3.2-6.4-8-7.2l-15.2-2.4c-4-0.8-8.8-4.8-8.8-8.8l-2.4-15.2c-0.8-4-4-8-7.2-8s-6.4 3.2-7.2 8l-2.4 15.2c-0.8 4-4.8 8.8-8.8 8.8l-15.2 2.4c-4 0.8-8 4-8 7.2s3.2 6.4 8 7.2l15.2 2.4c4 0.8 8.8 4.8 8.8 8.8l2.4 15.2c0.8 4 4 8 7.2 8s6.4-3.2 7.2-8l2.4-16.8c0.8-4 4.8-8 8.8-8.8l14.4-0.8c5.6-1.6 8.8-4 8.8-7.2zM927.2 390.4c0-3.2-3.2-6.4-8-7.2l-15.2-2.4c-4-0.8-8.8-4.8-8.8-8.8l-2.4-15.2c-0.8-4-4-8-7.2-8s-6.4 3.2-7.2 8l-2.4 15.2c-0.8 4-4.8 8.8-8.8 8.8l-15.2 2.4c-4 0.8-8 4-8 7.2s3.2 6.4 8 7.2l15.2 2.4c4 0.8 8.8 4.8 8.8 8.8l2.4 15.2c0.8 4 4 8 7.2 8s6.4-3.2 7.2-8l2.4-16.8c0.8-4 4.8-8 8.8-8.8l14.4-0.8c5.6-0.8 8.8-4 8.8-7.2zM619.2 307.2c0-3.2-3.2-6.4-8-7.2l-15.2-2.4c-4-0.8-8.8-4.8-8.8-8.8l-2.4-15.2c-0.8-4-4-8-7.2-8s-6.4 3.2-7.2 8l-2.4 15.2c-0.8 4-4.8 8.8-8.8 8.8l-15.2 2.4c-4 0.8-8 4-8 7.2s3.2 6.4 8 7.2l15.2 2.4c4 0.8 8.8 4.8 8.8 8.8l2.4 15.2c0.8 4 4 8 7.2 8s6.4-3.2 7.2-8l2.4-16.8c0.8-4 4.8-8 8.8-8.8l14.4-0.8c5.6-1.6 8.8-4 8.8-7.2zM520 560c-17.6 0-32-14.4-32-32s14.4-32 32-32 32 14.4 32 32-14.4 32-32 32z m0-48.8c-9.6 0-16.8 8-16.8 16.8 0 9.6 8 16.8 16.8 16.8 9.6 0 16.8-8 16.8-16.8 0-9.6-7.2-16.8-16.8-16.8zM160 344c-17.6 0-32-14.4-32-32s14.4-32 32-32 32 14.4 32 32-14.4 32-32 32z m0-48.8c-9.6 0-16.8 8-16.8 16.8 0 9.6 8 16.8 16.8 16.8 9.6 0 16.8-8 16.8-16.8 0-9.6-7.2-16.8-16.8-16.8z" fill="#FFFFFF" p-id="2679"></path><path d="M722.4 416c-52 0-78.4 53.6-69.6 104.8 8.8 51.2 0 148-42.4 183.2-42.4 36-24.8 123.2 42.4 125.6 67.2 2.4 132-73.6 145.6-172 13.6-98.4 31.2-241.6-76-241.6z" fill="#6AE5E1" p-id="2680"></path><path d="M784 208.8c-5.6 20-25.6 31.2-45.6 26.4l-195.2-52.8c-20-5.6-31.2-25.6-26.4-45.6 5.6-20 25.6-31.2 45.6-26.4l195.2 52.8c20 5.6 32 25.6 26.4 45.6z" fill="#FF4848" p-id="2681"></path><path d="M428.8 813.6c-16 4-32.8-4.8-36.8-20.8L368 704c-4-16 4.8-32.8 20.8-36.8s32.8 4.8 36.8 20.8l24 88.8c4.8 16-4.8 32-20.8 36.8z" fill="#EAEAEA" p-id="2682"></path><path d="M800 476c7.2 48-0.8 107.2-7.2 156-13.6 98.4-78.4 174.4-145.6 172-30.4-0.8-50.4-19.2-60-42.4 1.6 33.6 24 66.4 65.6 68 67.2 2.4 132-73.6 145.6-172 8-57.6 17.6-131.2 1.6-181.6z" fill="#4CD3CC" p-id="2683"></path><path d="M780.8 181.6c-6.4 18.4-25.6 29.6-44.8 24.8l-195.2-52.8c-10.4-2.4-18.4-9.6-22.4-18.4 0 0.8-0.8 0.8-0.8 1.6-5.6 20 6.4 40 26.4 45.6l195.2 52.8c20 5.6 40-6.4 45.6-26.4 1.6-9.6 0-19.2-4-27.2z" fill="#E8372E" p-id="2684"></path><path d="M653.6 840h-3.2c-32.8-0.8-58.4-20-68.8-51.2-11.2-32.8-3.2-68.8 20.8-88.8 40-33.6 49.6-125.6 40-176.8-5.6-33.6 1.6-66.4 20.8-88.8 14.4-17.6 34.4-26.4 57.6-26.4 28 0 50.4 8.8 66.4 27.2 43.2 48.8 28.8 154.4 19.2 224.8C792 760.8 724.8 840 653.6 840z m67.2-416c-17.6 0-33.6 7.2-44.8 20.8-16 18.4-22.4 47.2-17.6 75.2 9.6 56-0.8 154.4-45.6 192-18.4 16-25.6 44.8-16 71.2 4 12 17.6 39.2 54.4 40.8h2.4c63.2 0 123.2-72.8 136-166.4 9.6-67.2 23.2-168.8-15.2-212-12.8-14.4-30.4-21.6-53.6-21.6z" fill="#0C508E" p-id="2685"></path><path d="M416.8 784l-24-88.8c-3.2-11.2 0.8-22.4 8-29.6-4-0.8-8 0-12 0.8-16 4-25.6 20.8-20.8 36.8L392 792c4 16 20.8 25.6 36.8 20.8 4.8-1.6 9.6-4 12.8-7.2-11.2-1.6-21.6-9.6-24.8-21.6z" fill="#D4D6D6" p-id="2686"></path><path d="M746.4 248c-4 0-8-0.8-12-1.6l-196.8-56c-24-7.2-38.4-33.6-32-58.4 5.6-20.8 23.2-35.2 44-35.2 4 0 8 0.8 12 1.6l196.8 56c24 7.2 38.4 33.6 32 58.4-5.6 20.8-23.2 35.2-44 35.2zM549.6 112.8c-12.8 0-24.8 9.6-28 23.2-4 16.8 4.8 33.6 20.8 37.6l196.8 56c2.4 0.8 4.8 0.8 8 0.8 12.8 0 24.8-9.6 28-23.2 4-16.8-4.8-33.6-20.8-37.6l-196.8-56c-3.2 0-5.6-0.8-8-0.8zM419.2 824c-16 0-31.2-12-35.2-28.8l-23.2-90.4c-5.6-20.8 6.4-41.6 25.6-47.2 3.2-0.8 6.4-1.6 9.6-1.6 16 0 31.2 12 35.2 28.8l23.2 90.4c5.6 20.8-6.4 41.6-25.6 47.2-2.4 0.8-6.4 1.6-9.6 1.6z m-22.4-152c-1.6 0-4 0-5.6 0.8-11.2 3.2-17.6 16-14.4 27.2L400 790.4c3.2 12 14.4 19.2 25.6 16 11.2-3.2 17.6-16 14.4-27.2l-23.2-90.4c-2.4-9.6-11.2-16.8-20-16.8zM748 560c-15.2 0-28-12.8-28-28s12.8-28 28-28 28 12.8 28 28-12.8 28-28 28z m0-40c-6.4 0-12 5.6-12 12s5.6 12 12 12 12-5.6 12-12-5.6-12-12-12zM686.4 745.6c-2.4 0-5.6-1.6-7.2-4-2.4-4-0.8-8.8 2.4-11.2l30.4-17.6c4-2.4 8.8-0.8 11.2 2.4 2.4 4 0.8 8.8-2.4 11.2L690.4 744c-1.6 1.6-3.2 1.6-4 1.6zM716 648c-3.2 0-6.4-2.4-7.2-5.6l-8-22.4c-1.6-4 0.8-8.8 4.8-10.4 4-1.6 8.8 0.8 10.4 4.8l8 22.4c1.6 4-0.8 8.8-4.8 10.4-1.6 0.8-2.4 0.8-3.2 0.8z" fill="#0C508E" p-id="2687"></path><path d="M386.4 184.8c-96 0-208 228-80 298.4 128 69.6 89.6-84.8 104.8-125.6 15.2-40.8 71.2-172.8-24.8-172.8z" fill="#FBD000" p-id="2688"></path><path d="M329.6 462.4c-94.4-52-57.6-189.6 6.4-258.4-77.6 56-135.2 221.6-29.6 279.2 52.8 28.8 77.6 19.2 88.8-4.8-14.4 4-35.2 0.8-65.6-16z" fill="#F4B10B" p-id="2689"></path><path d="M360 512c-16 0-34.4-6.4-57.6-19.2-53.6-29.6-73.6-88.8-55.2-162.4 18.4-74.4 78.4-153.6 138.4-153.6 24 0 41.6 8 52 23.2 26.4 39.2-2.4 116.8-16 153.6l-3.2 8c-3.2 8.8-4 25.6-4 43.2-2.4 45.6-4 107.2-54.4 107.2z m25.6-319.2c-46.4 0-104 65.6-123.2 140.8-8 31.2-19.2 108 47.2 144.8 20.8 11.2 37.6 16.8 50.4 16.8 32.8 0 36.8-39.2 37.6-90.4 0.8-20 0.8-37.6 4.8-48.8l3.2-8c12-32 40-107.2 18.4-139.2-7.2-10.4-20-16-38.4-16z" fill="#0C508E" p-id="2690"></path><path d="M360 312c-13.6 0-24-10.4-24-24s10.4-24 24-24 24 10.4 24 24-10.4 24-24 24z m0-32c-4.8 0-8 3.2-8 8s3.2 8 8 8 8-3.2 8-8-3.2-8-8-8z" fill="#0C508E" p-id="2691"></path><path d="M340 412m-12 0a12 12 0 1 0 24 0 12 12 0 1 0-24 0Z" fill="#0C508E" p-id="2692"></path><path d="M432 468.8h-1.6l-28.8-5.6c-4-0.8-7.2-4.8-6.4-9.6 0.8-4 4.8-7.2 9.6-6.4l28.8 5.6c4 0.8 7.2 4.8 6.4 9.6-0.8 4-4.8 6.4-8 6.4zM220.8 418.4c-3.2 0-6.4-2.4-8-5.6-0.8-4 1.6-8.8 5.6-9.6l24-6.4c4-0.8 8.8 1.6 9.6 5.6 0.8 4-1.6 8.8-5.6 9.6l-24 6.4h-1.6zM280.8 270.4c-1.6 0-4-0.8-5.6-1.6L256 251.2c-3.2-3.2-4-8-0.8-11.2 3.2-3.2 8-4 11.2-0.8l20 17.6c3.2 3.2 4 8 0.8 11.2-1.6 1.6-4 2.4-6.4 2.4zM344.8 198.4c-3.2 0-5.6-1.6-7.2-4.8L328 173.6c-1.6-4 0-8.8 4-10.4 4-1.6 8.8 0 10.4 4l9.6 20c1.6 4 0 8.8-4 10.4-0.8 0-1.6 0.8-3.2 0.8zM610.4 706.4c-2.4 0-4.8-0.8-6.4-2.4l-16-18.4c-3.2-3.2-2.4-8 0.8-11.2 3.2-3.2 8.8-2.4 11.2 0.8l16 18.4c3.2 3.2 2.4 8-0.8 11.2-0.8 1.6-2.4 1.6-4.8 1.6zM820 708h-1.6l-24-5.6c-4-0.8-7.2-5.6-6.4-9.6 0.8-4 5.6-7.2 9.6-6.4l24 5.6c4 0.8 7.2 5.6 6.4 9.6-0.8 4-4 6.4-8 6.4zM812 570.4c-4 0-8-3.2-8-7.2 0-4.8 3.2-8 7.2-8.8l42.4-2.4c4.8 0 8 3.2 8.8 7.2 0 4.8-3.2 8-7.2 8.8l-43.2 2.4zM744 422.4c-4.8 0-8-4-8-8.8l1.6-24c0-4.8 4-8 8.8-7.2 4.8 0 8 4 7.2 8.8l-1.6 24c0 4-4 7.2-8 7.2zM628 561.6c-4 0-8-3.2-8-8s3.2-8 8-8L656 544c4 0 8 3.2 8 8s-3.2 8-8 8l-28 1.6z" fill="#0C508E" p-id="2693"></path><path d="M228.8 770.4c-3.2 0-6.4-0.8-9.6-1.6-40.8-17.6-55.2-44-59.2-63.2-7.2-32 5.6-69.6 36.8-104.8 5.6-6.4 4.8-9.6 4.8-11.2-2.4-11.2-25.6-26.4-40-32.8-12-5.6-17.6-19.2-12.8-31.2 5.6-12 19.2-17.6 31.2-12.8 9.6 4 59.2 27.2 68 66.4 3.2 12.8 2.4 32.8-15.2 53.6-20 23.2-29.6 46.4-26.4 62.4 2.4 12 13.6 21.6 31.2 29.6 12 4.8 17.6 19.2 12.8 31.2-4 8.8-12.8 14.4-21.6 14.4z" fill="#FC8BA4" p-id="2694"></path><path d="M244 614.4c-8 8.8-14.4 18.4-18.4 26.4 2.4-3.2 4.8-5.6 7.2-8.8 4.8-6.4 8.8-12 11.2-17.6zM240 752.8c-3.2 0-6.4-0.8-9.6-1.6-40.8-17.6-55.2-44-59.2-63.2-5.6-22.4 0-48 13.6-72.8-22.4 31.2-31.2 63.2-24.8 90.4 4 19.2 18.4 45.6 59.2 63.2 3.2 1.6 6.4 1.6 9.6 1.6 9.6 0 18.4-5.6 22.4-14.4 0.8-2.4 1.6-4 1.6-6.4-4 1.6-8.8 3.2-12.8 3.2zM200.8 589.6v1.6c2.4-2.4 4-4.8 6.4-8 5.6-6.4 4.8-9.6 4.8-11.2-2.4-11.2-25.6-26.4-40-32.8-10.4-4-15.2-14.4-14.4-24.8-4 2.4-7.2 6.4-9.6 11.2-5.6 12 0.8 26.4 12.8 31.2 15.2 5.6 37.6 20.8 40 32.8z" fill="#ED7090" p-id="2695"></path><path d="M224.8 778.4c-4 0-8-0.8-12-2.4-43.2-18.4-58.4-47.2-63.2-68-8-34.4 5.6-74.4 37.6-112 2.4-3.2 3.2-4.8 3.2-4.8-1.6-6.4-19.2-20-35.2-27.2-16-7.2-23.2-25.6-16.8-42.4 4.8-12 16-19.2 28.8-19.2 4 0 8.8 0.8 12 2.4 10.4 4.8 61.6 28.8 71.2 72 3.2 14.4 3.2 36.8-16.8 60-17.6 20.8-27.2 42.4-24 56 2.4 9.6 11.2 17.6 26.4 24 8 3.2 13.6 9.6 16.8 17.6 3.2 8 3.2 16.8 0 24.8-4 11.2-16 19.2-28 19.2z m-57.6-260c-6.4 0-12 4-14.4 9.6-3.2 8 0 17.6 8 20.8 12.8 5.6 40 22.4 44 38.4 1.6 5.6-0.8 11.2-6.4 18.4-28.8 33.6-40.8 68.8-34.4 97.6 4 17.6 16.8 40.8 53.6 57.6 8 3.2 17.6-0.8 20.8-8.8 1.6-4 1.6-8 0-12s-4.8-7.2-8.8-8.8c-20-8.8-32-20.8-35.2-35.2-4-19.2 5.6-44.8 27.2-69.6 15.2-18.4 16-35.2 13.6-46.4-8-36-53.6-56.8-62.4-60.8-0.8-0.8-3.2-0.8-5.6-0.8z" fill="#0C508E" p-id="2696"></path><path d="M240.8 672c-0.8 0-2.4 0-3.2-0.8l-20-9.6c-4-1.6-5.6-6.4-4-10.4 1.6-4 6.4-5.6 10.4-4l20 9.6c4 1.6 5.6 6.4 4 10.4-0.8 3.2-4 4.8-7.2 4.8zM162.4 652h-0.8l-30.4-4c-4-0.8-7.2-4.8-7.2-8.8 0.8-4 4.8-7.2 8.8-7.2l30.4 4c4 0.8 7.2 4.8 7.2 8.8-0.8 4.8-4 7.2-8 7.2zM194.4 524c-1.6 0-3.2-0.8-4.8-1.6-3.2-2.4-4.8-7.2-1.6-11.2l14.4-20.8c2.4-3.2 7.2-4.8 11.2-1.6 3.2 2.4 4.8 7.2 1.6 11.2l-14.4 20.8c-1.6 2.4-4 3.2-6.4 3.2zM194.4 792c-1.6 0-2.4 0-4-0.8-4-2.4-4.8-7.2-3.2-11.2l12-21.6c2.4-4 7.2-4.8 11.2-3.2 4 2.4 4.8 7.2 3.2 11.2l-12 21.6c-1.6 2.4-4 4-7.2 4zM282.4 757.6l-30.4-1.6c-4.8 0-8-4-7.2-8.8 0-4.8 4-8 8.8-7.2l29.6 1.6c4.8 0 8 4 7.2 8.8 0 4-4 7.2-8 7.2z" fill="#0C508E" p-id="2697"></path></svg></div>
                  <div class="col-8">
                    <span class="fs-3 fw-bold"><a href="database.php#microTable">Microorganisms</a></sp>
                    <p class="fs--1 fw-semi-bold mt-2 text-700">Potentially objectionable microorganisms, including <i>Burkholderia cepacia</i> complex (Bcc), <i>Pseudomonas aeruginosa, etc</i></p>
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-6 col-xxl-3 text-center border-start-xxl border-bottom-xxl-0 border-bottom border-end border-end-md pb-4 pb-xxl-0">
                <div class="row align-items-center justify-content-between">
                  <div class="col-4"><svg t="1745846217349" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="13218" data-spm-anchor-id="a313x.search_index.0.i2.75473a81XniWOb" style="width: 100%; height: 100%;"><path d="M915.2 224v-6.4l-17.066667-134.4c-2.133333-17.066667-17.066667-29.866667-36.266666-27.733333-17.066667 2.133333-29.866667 17.066667-27.733334 36.266666l6.4 44.8c-85.333333-66.133333-187.733333-104.533333-296.533333-104.533333-128 0-249.6 49.066667-339.2 140.8C113.066667 262.4 64 384 64 512s49.066667 249.6 140.8 339.2c93.866667 93.866667 215.466667 140.8 339.2 140.8 123.733333 0 245.333333-46.933333 339.2-140.8 12.8-12.8 12.8-32 0-44.8s-32-12.8-44.8 0c-162.133333 162.133333-426.666667 162.133333-588.8 0C170.666667 727.466667 128 622.933333 128 512s42.666667-215.466667 121.6-294.4 183.466667-121.6 294.4-121.6c100.266667 0 196.266667 36.266667 270.933333 102.4l-70.4 8.533333c-17.066667 2.133333-29.866667 17.066667-27.733333 36.266667 2.133333 17.066667 14.933333 27.733333 32 27.733333h4.266667l134.4-17.066666c14.933333-2.133333 27.733333-14.933333 27.733333-29.866667z" fill="#d81e06" p-id="13219"></path><path d="M573.866667 716.8c0 17.066667-14.933333 32-32 32s-32-14.933333-32-32-14.933333-32-32-32-32 14.933333-32 32c0 53.333333 42.666667 96 96 96s96-42.666667 96-96c0-17.066667-14.933333-32-32-32s-32 12.8-32 32zM765.866667 620.8v-64c0-36.266667-27.733333-64-64-64l-2.133334-93.866667c0-104.533333-76.8-185.6-172.8-185.6-98.133333 0-174.933333 81.066667-174.933333 183.466667V490.666667c-36.266667 0-64 29.866667-64 66.133333v64c0 17.066667 14.933333 32 32 32h416c17.066667 0 29.866667-14.933333 29.866667-32z m-64-32H349.866667v-32-2.133333h32c17.066667 0 32-14.933333 32-32v-125.866667c0-68.266667 49.066667-119.466667 110.933333-119.466667 61.866667 0 108.8 53.333333 108.8 121.6l2.133333 125.866667c0 17.066667 14.933333 32 32 32h32v32z" fill="#d81e06" p-id="13220" data-spm-anchor-id="a313x.search_index.0.i3.75473a81XniWOb" class=""></path><path d="M556.8 356.266667c-10.666667-6.4-23.466667-4.266667-34.133333 2.133333l-46.933334 36.266667c-14.933333 10.666667-17.066667 29.866667-6.4 44.8 10.666667 12.8 27.733333 17.066667 42.666667 8.533333v64c0 17.066667 14.933333 32 32 32S576 529.066667 576 512v-128c-2.133333-12.8-8.533333-23.466667-19.2-27.733333z" fill="#d81e06" p-id="13221"></path></svg></div>
                  <div class="col-8">
                    <span class="fs-3 fw-bold"><a href="database.php#recallTable">Recall events</a></sp>
                    <p class="fs--1 fw-semi-bold mt-2 text-700">Reported recall events of marketed non-sterile products associated with objectionable microorganisms.</p>
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-6 col-xxl-3 text-center border-start-xxl border-bottom-xxl-0 border-bottom border-end border-end-md pb-4 pb-xxl-0">
                <div class="row align-items-center justify-content-between">
                  <div class="col-4"><svg t="1745847269651" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="63544" id="mx_n_1745847269652" style="width: 100%; height: 100%;"><path d="M504.087273 375.761455l-162.071273 43.52a18.292364 18.292364 0 0 1-22.109091-12.70691 18.292364 18.292364 0 0 1 12.753455-22.10909l162.071272-43.52a18.292364 18.292364 0 0 1 22.109091 12.706909 17.501091 17.501091 0 0 1-12.706909 22.109091M424.401455 225.047273a156.951273 156.951273 0 0 0-156.718546 156.718545 156.951273 156.951273 0 0 0 156.718546 156.765091 156.951273 156.951273 0 0 0 156.76509-156.765091 156.951273 156.951273 0 0 0-156.76509-156.718545" fill="#00D2BF" p-id="63545"></path><path d="M510.138182 947.432727c-239.848727 0-434.967273-195.165091-434.967273-435.013818 0-239.848727 195.118545-435.013818 434.967273-435.013818 239.895273 0 435.013818 195.165091 435.013818 435.013818 0 239.848727-195.118545 435.013818-435.013818 435.013818m0-945.198545C228.864 2.234182 0 231.098182 0 512.372364 0 793.739636 228.864 1022.603636 510.138182 1022.603636c281.320727 0 510.138182-228.864 510.138182-510.138181 0-281.320727-228.817455-510.138182-510.138182-510.138182" fill="#2E3231" p-id="63546"></path><path d="M357.469091 204.288A179.246545 179.246545 0 0 0 178.548364 383.069091a179.246545 179.246545 0 0 0 178.827636 178.874182 179.246545 179.246545 0 0 0 178.874182-178.874182A179.246545 179.246545 0 0 0 357.422545 204.334545m0 40.168728a138.938182 138.938182 0 0 1 138.705455 138.705454 138.938182 138.938182 0 0 1-138.705455 138.612364A138.938182 138.938182 0 0 1 218.763636 383.115636a138.938182 138.938182 0 0 1 138.705455-138.658909" fill="#323A39" p-id="63547"></path><path d="M808.913455 719.406545l48.872727-48.872727a124.322909 124.322909 0 0 0-1.303273-174.871273 124.322909 124.322909 0 0 0-174.824727-1.349818l-48.872727 48.872728-19.456 19.456 176.826181 176.872727 18.757819-20.107637z" fill="#00D2BF" p-id="63548"></path><path d="M700.416 481.605818c-22.807273 0-43.566545 8.704-59.624727 24.762182l-39.563637 39.563636c-1.303273 1.303273-2.001455 2.653091-2.001454 4.002909 0 1.349818 0.698182 3.351273 2.048 4.00291l16.058182 16.058181c1.349818 1.396364 2.699636 2.048 4.002909 2.048 1.396364 0 3.351273-0.698182 4.049454-2.048l39.517091-39.517091c9.355636-9.355636 22.109091-14.708364 35.514182-14.708363 10.007273 0 19.409455 2.653091 27.461818 8.005818a6.050909 6.050909 0 0 0 7.354182-0.651636l16.058182-16.058182a6.050909 6.050909 0 0 0 2.048-4.701091c0-2.001455-0.698182-3.351273-2.699637-4.002909a78.382545 78.382545 0 0 0-50.26909-16.756364" fill="#323A39" p-id="63549"></path><path d="M694.365091 732.811636l-82.385455 82.385455c-1.349818 0-2.001455 0.651636-3.351272 1.303273a107.799273 107.799273 0 0 1-67.677091 23.458909 106.402909 106.402909 0 0 1-75.682909-31.464728 106.914909 106.914909 0 0 1-7.354182-143.36 5.12 5.12 0 0 0 1.349818-3.351272l82.385455-82.385455 152.715636 153.413818zM780.101818 646.981818l-58.274909 58.321455-152.715636-152.762182 58.274909-58.274909a107.613091 107.613091 0 0 1 75.031273-30.114909c28.811636 0 55.575273 11.357091 76.334545 31.464727 41.565091 41.518545 42.216727 109.847273 1.396364 151.365818z m25.460364-178.176a145.873455 145.873455 0 0 0-103.796364-42.821818c-38.167273 0-74.379636 14.708364-101.841454 41.518545l-162.117819 162.071273c-56.925091 56.971636-56.925091 150.062545 0 207.685818 27.461818 27.461818 64.325818 42.821818 103.796364 42.821819 39.563636 0 76.381091-15.36 103.842909-42.821819l162.117818-162.117818a147.828364 147.828364 0 0 0-2.001454-206.336zM437.806545 377.762909l-162.117818 43.566546a18.292364 18.292364 0 0 1-22.062545-12.753455 18.292364 18.292364 0 0 1 12.706909-22.109091l162.117818-43.52a18.292364 18.292364 0 0 1 22.109091 12.706909 18.292364 18.292364 0 0 1-12.753455 22.109091" fill="#323A39" p-id="63550"></path></svg></div>
                  <div class="col-8">
                    <span class="fs-3 fw-bold"><a href="database.php#dosageTable">Dosage forms</a></sp>
                    <p class="fs--1 fw-semi-bold mt-2 text-700">Common dosage forms of non-sterile products, including gel preparation, lotion, spray, etc</p>
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-6 col-xxl-3 text-center border-start-xxl border-bottom-xxl-0 border-bottom border-end border-end-md pb-4 pb-xxl-0">
                <div class="row align-items-center justify-content-between">
                  <div class="col-3"><svg t="1745849028376" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="69556" data-spm-anchor-id="a313x.search_index.0.i43.75473a81XniWOb" style="width: 120%; height: 120%;"><path d="M900.432 330.608c0 64.464-52.256 116.704-116.704 116.704s-116.704-52.256-116.704-116.704c0-64.464 52.256-116.704 116.704-116.704 64.464 0 116.704 52.256 116.704 116.704z" p-id="69557" fill="#1296db" data-spm-anchor-id="a313x.search_index.0.i46.75473a81XniWOb" class=""></path><path d="M52.672 100.176l0 211.664-31.648 0c-6 0-10.864-4.816-10.864-10.848l0-273.12c0-9.248 6.896-16.768 16.352-16.768l139.952 0c9.44 0 16.352 7.504 16.352 16.736l0 16.032 216.368 0c6.048 0 10.88 4.848 10.88 10.816l0 61.408-184.704 0 0-16.08c0-9.232-6.912-16.736-16.384-16.736l-139.904 0c-9.472 0-16.384 7.632-16.384 16.896z" p-id="69558" fill="#d81e06" data-spm-anchor-id="a313x.search_index.0.i44.75473a81XniWOb" class=""></path><path d="M495.136 440c0 6-4.848 10.816-10.88 10.816l-378.16 0c-6.016 0-10.864-4.816-10.864-10.832l0-273.12c0-9.248 6.896-16.768 16.352-16.768l139.92 0c9.472 0 16.384 7.504 16.384 16.736l0 16.032 216.368 0c6.032 0 10.88 4.848 10.88 10.816l0 246.32zM327.392 284.496l0-64.416-64.448 0 0 64.416-64.432 0 0 64.448 64.432 0 0 64.432 64.448 0 0-64.432 64.432 0 0-64.448-64.432 0z" p-id="69559" fill="#d81e06" data-spm-anchor-id="a313x.search_index.0.i42.75473a81XniWOb" class=""></path><path d="M899.04 477.376c64.656 0 117.072 52.304 117.072 116.96l0.24 427.728-392.704 0 0-354.576-15.904 0-72.416 108.048c-11.792 16.08-35.728 23.872-54.816 23.872l-170.016 0c-28.24 0-51.168-22.88-51.168-51.088 0-28.16 22.928-50.4 51.168-50.4l154.64 0 107.28-162.208c25.696-39.232 75.968-58.192 116.432-58.192l210.176-0.128z" p-id="69560" fill="#1296db" data-spm-anchor-id="a313x.search_index.0.i45.75473a81XniWOb" class=""></path></svg></div>
                  <div class="col-9">
                    <span class="fs-2 fw-bold"><a href="database.php#populationTable">Administration routes<br>& Patient population</a></sp>
                    <p class="fs--1 fw-semi-bold mt-2 text-700">Risk analysis factors for non-sterile products</p>
                  </div>
                </div> 
              </div>
            </div>
          </div>
          <div class="mx-4 px-4 mx-lg-n6 px-lg-6 bg-white pt-3 pb-5 border border-300 mt-5 rounded-3">
            <div class="row text-center">
              <h2 class="mb-5 text-1100">Microbial risk analysis for non-sterile products</h2>
            </div>
            <div class="row justify-content-between mb-3 align-items-stretch">
              <div class="col-4 col-xl-4 col-xxl-4 bg-50 ">
                <div class="d-flex flex-wrap mb-3 align-content-center justify-content-center">
                  <h3 class="mb-3">ARG-VFG-finder</h3>
                  <img src="assets/img/ARG-VFG-finder.png" class="img-fluid" alt="ARG-VFG-finder" style="width:100%" />
                  <a class="btn btn-outline-primary mt-3" href="ARG-VFG-finder.php">Start now<span class="fas fa-angle-right ms-2 fs--2 text-center"></span></a>
                </div>
              </div>
              <div class="col-4 col-xl-4 col-xxl-4 bg-50 ">
                <div class="d-flex flex-wrap mb-3 align-content-center justify-content-center">
                  <h3 class="mb-3">Risk management</h3>
                  <img src="assets/img/DT_overview.png" class="img-fluid" alt="Risk management" style="width:86%" />
                  <a class="btn btn-outline-primary mt-3" href="decision_tree.php">Start now<span class="fas fa-angle-right ms-2 fs--2 text-center"></span></a>
                </div>
              </div>
              <div class="col-4 col-xl-4 col-xxl-4 bg-50 ">
                <div class="d-flex flex-wrap mb-3 align-content-center justify-content-center">
                  <h3 class="mb-3">Risk assessment</h3>
                  <img src="assets/img/simulation_overview.png" class="img-fluid" alt="Risk assessment" style="width:90%" />
                  <a class="btn btn-outline-primary mt-3" href="simulation.php">Start now<span class="fas fa-angle-right ms-2 fs--2 text-center"></span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <br>
      <?php include 'scripts/footer.php'; ?>
      <script>
        var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
        var navbarTop = document.querySelector('.navbar-top');
        if (navbarTopStyle === 'darker') {
          navbarTop.classList.add('navbar-darker');
        }
      </script>
    </main>


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="phoenix/public/vendors/anchorjs/anchor.min.js"></script>
    <script src="phoenix/public/vendors/is/is.min.js"></script>
    <script src="phoenix/public/vendors/fontawesome/all.min.js"></script>
    <script src="phoenix/public/vendors/lodash/lodash.min.js"></script>
    <script src="phoenix/public/vendors/list.js/list.min.js"></script>
    <script src="phoenix/public/vendors/feather-icons/feather.min.js"></script>
    <script src="phoenix/public/vendors/dayjs/dayjs.min.js"></script>
    <script src="phoenix/public/assets/js/phoenix.js"></script>
    <script src="phoenix/public/vendors/echarts/echarts.min.js"></script>

  </body>

</html>