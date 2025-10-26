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
    <link href="phoenix/public/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="phoenix/public/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="phoenix/public/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="phoenix/public/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
    <link href="assets/css/bootstrap-table.min.css" rel="stylesheet">
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
    $micro_id = $_GET['id'];
    function filter_sql($str){ 
        $keywords = array(
            'SELECT', 'INSERT', 'UPDATE', 'DELETE', 'CREATE', 'DROP', 'ALTER', 'GRANT', 'REVOKE', 'TRUNCATE', 'CAST', 'DECLARE', '%20%', '=', '%3E%', '%3C%', '--', '+', '|', "%27", 'VERSION', 'SLEEP'
        );
        // 循环直到输入字符串不再包含任何关键字
        while (true) {
          // 初始化一个标志，用于检查是否删除了任何关键字
          $removed = false;
          // 循环遍历关键字数组
          foreach ($keywords as $keyword) {
              // 使用大小写不敏感的替换来删除关键字
              $input_lower = strtolower($str);
              $keyword_lower = strtolower($keyword);
              $position = strpos($input_lower, $keyword_lower);
              // 如果找到关键字，则从输入字符串中删除它
              if ($position !== false) {
                  $str = substr_replace($str, '', $position, strlen($keyword));
                  // 设置标志为 true，表示删除了关键字
                  $removed = true;
              }
          }
          // 如果没有删除任何关键字，则跳出循环
          if (!$removed) {
              break;
          }
        }
        return $str;
    }
    $micro_id = filter_sql($micro_id);
    $sql = "SELECT * FROM public.micro_list WHERE micro_id = '$micro_id'";
    $result = pg_query($conn, $sql);
    $row = pg_fetch_assoc($result);
    $micro_name = $row['micro_name'];
    $micro_classification = $row['classification'];

    $taxonomy_sql = "SELECT * FROM public.micro_taxonomy WHERE micro_id = '$micro_id'";
    $taxonomy_result = pg_query($conn, $taxonomy_sql);
    $taxonomy_row = pg_fetch_assoc($taxonomy_result);

    $morphology_sql = "SELECT * FROM public.micro_morphology WHERE micro_id = '$micro_id'";
    $morphology_result = pg_query($conn, $morphology_sql);
    $morphology_row = pg_fetch_assoc($morphology_result);

    if ($micro_classification == 'Bacteria'){
      $physiology_sql = "SELECT * FROM public.micro_physiology WHERE micro_id = '$micro_id'";
      $physiology_result = pg_query($conn, $physiology_sql);
      $physiology_row = pg_fetch_assoc($physiology_result);

      $biochemistry_sql = "SELECT * FROM public.micro_biochemistry WHERE micro_id = '$micro_id'";
      $biochemistry_result = pg_query($conn, $biochemistry_sql);
      $biochemistry_row = pg_fetch_assoc($biochemistry_result);
    }elseif ($micro_classification == 'Fungi'){
      $fungi_info_sql = "SELECT * FROM public.fungi_info WHERE micro_id = '$micro_id'";
      $fungi_info_result = pg_query($conn, $fungi_info_sql);
      $fungi_info_row = pg_fetch_assoc($fungi_info_result);
    }
    
    $seq_sql = "SELECT * FROM public.micro_seq WHERE micro_id = '$micro_id'";
    $seq_result = pg_query($conn, $seq_sql);
    $seq_row = pg_fetch_assoc($seq_result);

    $biosafety_sql = "SELECT * FROM public.micro_biosafety WHERE micro_id = '$micro_id'";
    $biosafety_result = pg_query($conn, $biosafety_sql);

    $micro_name_array = explode(" ", $micro_name);
    $micro_name_array_length = count($micro_name_array);
    if ($micro_name_array[$micro_name_array_length-1] == 'complex' || $micro_name_array[$micro_name_array_length-1] == 'spp.') {
      unset($micro_name_array[$micro_name_array_length-1]);
    }
    $micro_name_new = implode(" ", $micro_name_array);
    $event_sql = "SELECT * FROM public.recall_event WHERE micro ILIKE '%$micro_name_new%'";
    $event_result = pg_query($conn, $event_sql);
    $event_count = pg_num_rows($event_result);

    $ref_sql = "SELECT * FROM public.micro_ref WHERE micro_id = '$micro_id'";
    $ref_result = pg_query($conn, $ref_sql);

    $question_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
    </svg>';
  ?>

  <body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container-fluid px-0">
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
        <?php if ($micro_classification == 'Bacteria'): ?>
          <div class="content">
            <h3 class="mb-2 lh-sm">Detailed information of <i><?php echo $micro_name;?></i></h3>
            <div class="mt-4">
              <div class="row g-4">
                <div class="col-12 col-xl-2">
                  <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between pb-3">
                      <div class="position-sticky" style="top: 80px;">
                        <ul class="nav nav-vertical flex-column nav-pills">
                          <li class="nav-item"> <a class="nav-link" href="#taxonomy"><strong>Taxonomy</strong></a></li>
                          <li class="nav-item"> <a class="nav-link" href="#morphology"><strong>Morphology</strong></a></li>
                          <li class="nav-item"> <a class="nav-link" href="#physiology"><strong>Physiology</strong></a></li>
                          <li class="nav-item"> <a class="nav-link" href="#biochemistry"><strong>Biochemistry</strong></a></li>
                          <li class="nav-item"> <a class="nav-link" href="#sequence_information"><strong>Sequence information</strong></a></li>
                          <li class="nav-item"> <a class="nav-link" href="#risk_information"><strong>Risk information</strong></a></li>
                          <li class="nav-item"> <a class="nav-link" href="#reference"><strong>Reference</strong></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-xl-10 order-1 order-xl-0">
                  <?php
                  if ($taxonomy_row['note'] != NULL){
                    echo '<strong>Note:</strong> '.$taxonomy_row['note'].'<br>';
                  }
                  if ($micro_name=='Burkholderia cepacia complex'){
                    echo '<a class="btn btn-phoenix-secondary mt-2" data-toggle="collapse" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">The 24 species that currently comprise the <i>Burkholderia cepacia</i> complex (and the year of each species description in the literature) are the following:</a>';
                    echo '<div class="collapse" id="collapseExample">
                            <div class="border p-3 rounded"><i>B. alpina</i> (2017), <i>B. ambifaria</i> (2001), <i>B. anthina</i> (2002), <i>B. arboris</i> (2008), <i>B. catarinensis</i> (2017), <i>B. cenocepacia</i> (2003), <i>B. cepacia</i> (1950), <i>B. contaminans</i> (2009), <i>B. diffusa</i> (2008), <i>B. dolosa</i> (2004), <i>B. lata</i> (2009), <i>B. latens</i> (2008), <i>B. metallica</i> (2008), <i>B. multivorans</i> (1997), <i>B. pseudomultivorans</i> (2013), <i>B. paludis</i> (2016), <i>B. puraquae</i> (2018), <i>B. pyrrocinia</i> (2002), <i>B. seminalis</i> (2008), <i>B. stabilis</i> (2000), <i>B. stagnalis</i> (2015), <i>B. territorii</i> (2015), <i>B. ubonensis</i> (2000), and <i>B. vietnamiensis</i> (1995).</div>
                          </div>';
                  }
                  ?>
                  <!-- Taxonomy -->
                  <div class="card custom-shadow my-2" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="taxonomy">Taxonomy</h3><hr>
                        <table class="table table-sm table-white-borders"
                                          style="font-size:16px; border-color: #FFFFFF"					
                                          data-toggle="table" 
                                          data-pagination="false"
                                          data-search="false"
                                          data-show-refresh="false"
                                          data-show-fullscreen="false"
                                          data-show-columns="false"
                                          data-show-export="false"
                                          data-click-to-select="false"
                                          data-mobile-responsive="true">
                          <tbody>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Phylum</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['phylum']?></i></td>
                            </tr>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Class</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['class']?></i></td>
                            </tr>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Order</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['order']?></i></td>
                            </tr>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Family</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['family']?></i></td>
                            </tr>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Genus</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['genus']?></i></td>
                            </tr>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Species</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['species']?></i></td>
                            </tr>
                            <?php
                                if ($taxonomy_row['synonym'] != NULL){
                                  echo "<tr>
                                  <td align='right' width='30%' style='border-right: 3px solid #F08080;'>&nbsp;&nbsp;</strong>&nbsp;</td>
                                  <td width='70%'></td>
                                  </tr>";
                                  $synonym = $taxonomy_row['synonym'];
                                  $synonym_array = explode('/', $synonym);
                                  foreach ($synonym_array as $key => $value) {
                                  echo "<tr>";
                                  echo "<td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Synonym</strong>&nbsp;</td>";
                                  echo "<td width='70%'>&nbsp;<i>$value</i></td>";
                                  echo "</tr>";
                                  }
                                }
                            ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div><br><br>
                  <!-- Morphology -->
                  <div class="card custom-shadow my-0" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="morphology">Morphology</h3><hr>
                        <table class="table table-sm table-white-borders"
                                          style="font-size:16px; border-color: #FFFFFF"					
                                          data-toggle="table" 
                                          data-pagination="false"
                                          data-search="false"
                                          data-show-refresh="false"
                                          data-show-fullscreen="false"
                                          data-show-columns="false"
                                          data-show-export="false"
                                          data-click-to-select="false"
                                          data-mobile-responsive="true">
                          <tbody>
                          <tr>
                              <td align='right' width='12%' style='border-right: 3px solid #F08080;'><strong>Gram strain</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo$morphology_row['gram_strain']?></td>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Flagellum arrangement</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo$morphology_row['flagellum_arrangement']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='12%' style='border-right: 3px solid #F08080;'><strong>Cell shape</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo$morphology_row['cell_shape']?></td>                            
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Modility</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo$morphology_row['modility']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='12%' style='border-right: 3px solid #F08080;'><strong>Cell length</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo$morphology_row['cell_length']?></td>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Type of hemolysis</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo$morphology_row['type_of_hemolysis']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='12%' style='border-right: 3px solid #F08080;'><strong>Odor</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo$morphology_row['odor']?></td>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Pigment production</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo$morphology_row['pigment_production']?></td>
                              </tr>
                              <?php
                                if ($morphology_row['image'] != 0) {
                                  echo '<tr>
                                          <td align="right" width="12%" style="border-right: 3px solid #F08080;"><strong>Colony image (Pros)&nbsp;&nbsp;<a href="" role="button" data-bs-toggle="popover" data-bs-trigger="hover" title="Colony image" data-bs-content="This microorganism was cultured on Tryptic Soy Agar (TSA) (Chinese Pharmacopoeia 2025 Edition) at 37°C">'.$question_icon.'</a></strong>&nbsp;</td>
                                          <td width="34%">
                                          <img class="card-img-top" src="assets/colony_img/' . str_replace(' ', '_', $micro_name_new) . '_pros1.png" style="width:50%" /></td>
                                          <td align="right" width="12%" style="border-right: 3px solid #F08080;"><strong>Colony image (Cons)&nbsp;&nbsp;<a href="" role="button" data-bs-toggle="popover" data-bs-trigger="hover" title="Colony image" data-bs-content="This microorganism was cultured on Tryptic Soy Agar (TSA) (Chinese Pharmacopoeia 2025 Edition) at 37°C">'.$question_icon.'</a></strong>&nbsp;</td>
                                          <td width="34%">
                                          <img class="card-img-top" src="assets/colony_img/' . str_replace(' ', '_', $micro_name_new) . '_cons1.png" style="width:50%" />
                                          </td>
                                        </tr>';
                                }
                              ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div><br><br>
                  <!-- Physiology -->
                  <div class="card custom-shadow my-0" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="physiology">Physiology</h3><hr>
                        <table class="table table-sm table-white-borders"
                                          style="font-size:16px; border-color: #FFFFFF"					
                                          data-toggle="table" 
                                          data-pagination="false"
                                          data-search="false"
                                          data-show-refresh="false"
                                          data-show-fullscreen="false"
                                          data-show-columns="false"
                                          data-show-export="false"
                                          data-click-to-select="false"
                                          data-mobile-responsive="true">
                          <tbody>
                              <tr>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Oxygen tolerance</strong>&nbsp;</td>
                              <td width='30%'>&nbsp;<?php echo$physiology_row['oxygen_tolerance']?></td>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Growth temperature</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo$physiology_row['growth_temperature']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Ability of spore formation</strong>&nbsp;</td>
                              <td width='30%'>&nbsp;<?php echo$physiology_row['ability_of_spore_formation']?></td>                            
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Growth PH</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo$physiology_row['growth_ph']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Growth water activity</strong>&nbsp;</td>
                              <td width='30%'>&nbsp;<?php echo$physiology_row['growth_water_activity']?></td>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Growth salt concentration</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo$physiology_row['growth_salt_concentration']?></td>
                              </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div><br><br>
                  <!-- Biochemistry -->
                  <div class="card custom-shadow my-0" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="biochemistry">Biochemistry</h3><hr>
                        <table class="table table-sm table-white-borders"
                                          style="font-size:16px; border-color: #FFFFFF"					
                                          data-toggle="table" 
                                          data-pagination="false"
                                          data-search="false"
                                          data-show-refresh="false"
                                          data-show-fullscreen="false"
                                          data-show-columns="false"
                                          data-show-export="false"
                                          data-click-to-select="false"
                                          data-mobile-responsive="true">
                          <tbody>
                              <tr>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Catalase</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['catalase_reaction']?></td>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Oxidase</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['oxidase_reaction']?></td>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>V-P test</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['voges_proskauer_test']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Methylred test</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['methylred_test']?></td>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Indole test</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['indole_test']?></td>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Citrate test</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['citrate_test']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Nitrate reduction</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['nitrate_reduction']?></td>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Glucose fermentation</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['glucose_fermentation']?></td>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Arginine dihydrolase</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['arginine_dihydrolase']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Urease</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['urease']?></td>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Esculin hydrolysis</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['esculin_hydrolysis']?></td>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>β-galactosidase</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['beta-galactosidase']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Esterase (C4)</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['esterase_c4']?></td>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Esterase (C8)</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['esterase_c8']?></td>
                              <td align='right' width='15%' style='border-right: 3px solid #F08080;'><strong>Lipase (C14)</strong>&nbsp;</td>
                              <td width='15%'>&nbsp;<?php echo$biochemistry_row['lipase_c14']?></td>
                              </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div><br><br>
                  <!-- Sequence information -->
                  <div class="card custom-shadow my-0" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="sequence_information">Sequence information</h3><hr>
                        <?php
                          echo "<h4 class='text-900 mb-0'><span class='fs-2 uil uil-dna'></span>&nbsp;&nbsp;16S rRNA gene sequence</h4><br>";
                          echo "<p><a href='download/".$seq_row['seq_file']."' target='_blank'><span class='uil fs-0 me-2 uil-arrow-circle-down'></span>Download</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <strong>Length:</strong> ".$seq_row['length']." nt</p>";
                          echo "<div class='form-box' style='border: 0; font-size: 14px; font-family: Courier; background-color: #9BD2ED'>";
                          echo ">".$seq_row['record_id']."";
                          echo "<br>";
                          echo $seq_row['record_seq'];
                          echo "</div>";
                          echo "<br>";
                          echo "<h4 class='text-900 mb-0'><span class='fs-2 uil uil-dna'></span>&nbsp;&nbsp;Genome sequences</h4><br>";
                          echo "<h5>Number of available genomes/segments in <a href='https://www.bv-brc.org/view/Taxonomy/".$seq_row['link_id']."' target='_blank'>BV-BRC</a>: &nbsp;&nbsp;<span class='badge badge-phoenix badge-phoenix-primary'>".$seq_row['genome_num']."</span></h5>";
                        ?>
                      </div>
                    </div>
                  </div><br><br>
                  <!-- Risk information -->
                  <div class="card custom-shadow my-0" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="risk_information">Risk information</h3><hr>
                        <h4 class="text-900 mb-0"><span class="fs-2 uil uil-capsule"></span>&nbsp;&nbsp;Biosafety level</h4><br>
                        <table class="table table-sm table-striped"
                                          style="font-size:16px;"					
                                          data-toggle="table" 
                                          data-pagination="false"
                                          data-search="false"
                                          data-show-refresh="false"
                                          data-show-fullscreen="false"
                                          data-show-columns="false"
                                          data-show-export="false"
                                          data-click-to-select="false"
                                          data-mobile-responsive="true">
                        <thead>
                          <tr>
                            <th class="sort border-top">Guideline</th>
                            <th class="sort border-top">Risk group</th>
                            <th class="sort border-top">description</th>
                          </tr>
                        </thead>
                          <tbody>
                          <?php
                            while ($row = pg_fetch_assoc($biosafety_result)) {
                              echo "<tr>";
                              echo "<td align='left' width='30%'>".$row['guideline']."</td>";
                              echo "<td align='left' width='10%'>".$row['risk_group']."</td>";
                              echo "<td align='left' width='60%'>".$row['description']."</td>";
                              echo "</tr>";
                            }
                          ?>
                          </tbody>
                        </table>
                        <br>
                        <h4 class="text-900 mb-0"><span class="fs-2 uil uil-refresh"></span>&nbsp;&nbsp;Related recall events&nbsp;&nbsp;<span class='badge badge-phoenix badge-phoenix-primary'><?php echo $event_count?></span></h4><br>
                        <div id="event_table" data-list='{"valueNames":["product_description","dosage_form","country","product_category","date","link"],"page":5,"pagination":true}'>
                          <div class="table-responsive">
                            <table class="table table-sm table-striped"
                                              style="font-size:16px; table-layout:fixed;">
                            <thead>
                              <tr>
                                <th class="sort border-top" data-sort="product_category" width="20%">Product category</th>
                                <th class="sort border-top" data-sort="dosage_form" width="20%">Dosage form</th>
                                <th class="border-top ps-3" width="30%">Product description</th>
                                <th class="sort border-top" data-sort="country" width="10%">Country</th>
                                <th class="sort border-top" data-sort="date" width="10%">Date</th>
                                <th class="border-top" width="10%">Link</th>
                              </tr>
                            </thead>
                              <tbody class="list">
                              <?php
                                while ($row = pg_fetch_assoc($event_result)) {
                                  echo "<tr>";
                                  echo "<td class='product_category' align='left' >".$row['product_category']."</td>";
                                  echo "<td class='dosage_form' align='left' >".$row['dosage_form']."</td>";
                                  echo "<td class='product_description' title='".$row['product_description']."' align='left' style='overflow:hidden; text-overflow:ellipsis; white-space: nowrap;'>".$row['product_description']."</td>";
                                  echo "<td class='country' align='left' >".$row['country']."</td>";
                                  echo "<td class='date' align='left' >".$row['date']."</td>";
                                  echo "<td class='link' align='left' ><a href='".$row['link']."' target='_blank'>Link</a></td>";
                                  echo "</tr>";
                                }
                              ?>
                              </tbody>
                            </table>
                          </div>
                          <div class="d-flex justify-content-center mt-3">
                            <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                            <ul class="mb-0 pagination"></ul>
                            <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div><br><br>
                  <!-- Reference -->
                  <div class="card custom-shadow my-0" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="reference">Reference</h3><hr>
                        <list>
                          <?php
                            while ($row = pg_fetch_assoc($ref_result)) {
                              echo "<li>".$row['description']."</a></li>";
                            }
                          ?>
                        </list>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="content">
            <h3 class="mb-2 lh-sm">Detailed information of <i><?php echo $micro_name;?></i></h3>
            <div class="mt-4">
              <div class="row g-4">
                <div class="col-12 col-xl-2">
                  <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between pb-3">
                      <div class="position-sticky" style="top: 80px;">
                        <ul class="nav nav-vertical flex-column nav-pills">
                          <li class="nav-item"> <a class="nav-link" href="#taxonomy"><strong>Taxonomy</strong></a></li>
                          <li class="nav-item"> <a class="nav-link" href="#morphology"><strong>Morphology</strong></a></li>
                          <li class="nav-item"> <a class="nav-link" href="#physiology"><strong>Physiology</strong></a></li>
                          <li class="nav-item"> <a class="nav-link" href="#sequence_information"><strong>Sequence information</strong></a></li>
                          <li class="nav-item"> <a class="nav-link" href="#risk_information"><strong>Risk information</strong></a></li>
                          <li class="nav-item"> <a class="nav-link" href="#reference"><strong>Reference</strong></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-xl-10 order-1 order-xl-0">
                  <?php
                  #print note
                  ?>
                  <!-- Taxonomy -->
                  <div class="card custom-shadow my-2" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="taxonomy">Taxonomy</h3><hr>
                        <table class="table table-sm table-white-borders"
                                          style="font-size:16px; border-color: #FFFFFF"					
                                          data-toggle="table" 
                                          data-pagination="false"
                                          data-search="false"
                                          data-show-refresh="false"
                                          data-show-fullscreen="false"
                                          data-show-columns="false"
                                          data-show-export="false"
                                          data-click-to-select="false"
                                          data-mobile-responsive="true">
                          <tbody>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Phylum</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['phylum']?></i></td>
                            </tr>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Class</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['class']?></i></td>
                            </tr>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Order</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['order']?></i></td>
                            </tr>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Family</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['family']?></i></td>
                            </tr>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Genus</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['genus']?></i></td>
                            </tr>
                            <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Species</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<i><?php echo $taxonomy_row['species']?></i></td>
                            </tr>
                              <?php
                                  if ($taxonomy_row['synonym'] != NULL){
                                    echo"<tr>
                                      <td align='right' width='30%' style='border-right: 3px solid #F08080;'>&nbsp;&nbsp;</strong>&nbsp;</td>
                                      <td width='70%'></td>
                                    </tr>";
                                    $synonym = $taxonomy_row['synonym'];
                                    $synonym_array = explode('/', $synonym);
                                    foreach ($synonym_array as $key => $value) {
                                    echo "<tr>";
                                    echo "<td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Synonym</strong>&nbsp;</td>";
                                    echo "<td width='70%'>&nbsp;<i>$value</i></td>";
                                    echo "</tr>";
                                    }
                                  }
                              ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div><br><br>
                  <!-- Morphology -->
                  <div class="card custom-shadow my-0" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="morphology">Morphology</h3><hr>
                        <table class="table table-sm table-white-borders"
                                          style="font-size:16px; border-color: #FFFFFF"					
                                          data-toggle="table" 
                                          data-pagination="false"
                                          data-search="false"
                                          data-show-refresh="false"
                                          data-show-fullscreen="false"
                                          data-show-columns="false"
                                          data-show-export="false"
                                          data-click-to-select="false"
                                          data-mobile-responsive="true">
                          <tbody>
                              <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Growth form</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<?php echo $fungi_info_row['growth_form']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Fruitbody type</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<?php echo $fungi_info_row['fruitbody_type']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='30%' style='border-right: 3px solid #F08080;'><strong>Hymenium type</strong>&nbsp;</td>
                              <td width='70%'>&nbsp;<?php echo $fungi_info_row['hymenium_type']?></td>
                              </tr>
                              <?php
                                if ($morphology_row['image'] != 0) {
                                  echo '<tr>
                                          <td align="right" width="30%" style="border-right: 3px solid #F08080;"><strong>Colony image (Pros and Cons)&nbsp;&nbsp;<a href="" role="button" data-toggle="popover" data-trigger="hover" title="Colony image" data-content="This microorganism was cultured on Tryptic Soy Agar (TSA) (Chinese Pharmacopoeia 2025 Edition) at 37°C">'.$question_icon.'</a></strong>&nbsp;</td>
                                          <td width="70%">
                                          <img class="card-img-top" src="assets/colony_img/' . str_replace(' ', '_', $micro_name_new) . '_pros1.png" style="width:25%" />
                                          <img class="card-img-top" src="assets/colony_img/' . str_replace(' ', '_', $micro_name_new) . '_cons1.png" style="width:25%" /></td>
                                        </tr>';
                                }
                              ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div><br><br>
                  <!-- Physiology -->
                  <div class="card custom-shadow my-0" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="physiology">Physiology</h3><hr>
                        <table class="table table-sm table-white-borders"
                                          style="font-size:16px; border-color: #FFFFFF"					
                                          data-toggle="table" 
                                          data-pagination="false"
                                          data-search="false"
                                          data-show-refresh="false"
                                          data-show-fullscreen="false"
                                          data-show-columns="false"
                                          data-show-export="false"
                                          data-click-to-select="false"
                                          data-mobile-responsive="true">
                          <tbody>
                              <tr>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Primary lifestyle</strong>&nbsp;</td>
                              <td width='30%'>&nbsp;<?php echo $fungi_info_row['primary_lifestyle']?></td>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Secondary lifestyle</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo $fungi_info_row['secondary_lifestyle']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Endophytic interaction capability</strong>&nbsp;</td>
                              <td width='30%'>&nbsp;<?php echo $fungi_info_row['endophytic_interaction_capability']?></td>                            
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Plant pathogenic capacity</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo $fungi_info_row['plant_pathogenic_capacity']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Growth water activity</strong>&nbsp;</td>
                              <td width='30%'>&nbsp;<?php echo $fungi_info_row['decay_substrate']?></td>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Growth salt concentration</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo $fungi_info_row['decay_type']?></td>
                              </tr>
                              <tr>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Aquatic habitat</strong>&nbsp;</td>
                              <td width='30%'>&nbsp;<?php echo $fungi_info_row['aquatic_habitat']?></td>
                              <td align='right' width='16%' style='border-right: 3px solid #F08080;'><strong>Animal biotrophic capacity</strong>&nbsp;</td>
                              <td width='34%'>&nbsp;<?php echo $fungi_info_row['animal_biotrophic_capacity']?></td>
                              </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div><br><br>
                  <!-- Sequence information -->
                  <div class="card custom-shadow my-0" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="sequence_information">Sequence information</h3><hr>
                        <?php
                          echo "<h4 class='text-900 mb-0'><span class='fs-2 uil uil-dna'></span>&nbsp;&nbsp;18S rRNA gene sequence</h4><br>";
                          echo "<p><a href='download/".$seq_row['seq_file']."' target='_blank'><span class='uil fs-0 me-2 uil-arrow-circle-down'></span>Download</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <strong>Length:</strong> ".$seq_row['length']." nt</p>";
                          echo "<div class='form-box' style='border: 0; font-size: 14px; font-family: Courier; background-color: #9BD2ED'>";
                          echo ">".$seq_row['record_id']."";
                          echo "<br>";
                          echo $seq_row['record_seq'];
                          echo "</div>";
                          echo "<br>";
                          echo "<h4 class='text-900 mb-0'><span class='fs-2 uil uil-dna'></span>&nbsp;&nbsp;Genome sequences</h4><br>";
                          echo "<h5>Number of available genomes in <a href='https://www.ncbi.nlm.nih.gov/datasets/taxonomy/".$seq_row['link_id']."' target='_blank'>NCBI</a>: &nbsp;&nbsp;<span class='badge badge-phoenix badge-phoenix-primary'>".$seq_row['genome_num']."</span></h5>";
                        ?>
                      </div>
                    </div>
                  </div><br><br>
                  <!-- Risk information -->
                  <div class="card custom-shadow my-0" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="risk_information">Risk information</h3><hr>
                        <h4 class="text-900 mb-0"><span class="fs-2 uil uil-capsule"></span>&nbsp;&nbsp;Biosafety level</h4><br>
                        <table class="table table-sm table-striped"
                                          style="font-size:16px;"					
                                          data-toggle="table" 
                                          data-pagination="false"
                                          data-search="false"
                                          data-show-refresh="false"
                                          data-show-fullscreen="false"
                                          data-show-columns="false"
                                          data-show-export="false"
                                          data-click-to-select="false"
                                          data-mobile-responsive="true">
                        <thead>
                          <tr>
                            <th class="sort border-top">Guideline</th>
                            <th class="sort border-top">Risk group</th>
                            <th class="sort border-top">description</th>
                          </tr>
                        </thead>
                          <tbody>
                          <?php
                            while ($row = pg_fetch_assoc($biosafety_result)) {
                              echo "<tr>";
                              echo "<td align='left' width='30%'>".$row['guideline']."</td>";
                              echo "<td align='left' width='10%'>".$row['risk_group']."</td>";
                              echo "<td align='left' width='60%'>".$row['description']."</td>";
                              echo "</tr>";
                            }
                          ?>
                          </tbody>
                        </table>
                        <br>
                        <h4 class="text-900 mb-0"><span class="fs-2 uil uil-refresh"></span>&nbsp;&nbsp;Related recall events&nbsp;&nbsp;<span class='badge badge-phoenix badge-phoenix-primary'><?php echo $event_count?></span></h4><br>
                        <div id="event_table" data-list='{"valueNames":["product_description","dosage_form","country","product_category","date","link"],"page":5,"pagination":true}'>
                          <div class="table-responsive">
                            <table class="table table-sm table-striped"
                                              style="font-size:16px; table-layout:fixed;">
                            <thead>
                              <tr>
                                <th class="sort border-top" data-sort="product_category" width="20%">Product category</th>
                                <th class="sort border-top" data-sort="dosage_form" width="20%">Dosage form</th>
                                <th class="border-top ps-3" width="30%">Product description</th>
                                <th class="sort border-top" data-sort="country" width="10%">Country</th>
                                <th class="sort border-top" data-sort="date" width="10%">Date</th>
                                <th class="border-top" width="10%">Link</th>
                              </tr>
                            </thead>
                              <tbody class="list">
                              <?php
                                while ($row = pg_fetch_assoc($event_result)) {
                                  echo "<tr>";
                                  echo "<td class='product_category' align='left' >".$row['product_category']."</td>";
                                  echo "<td class='dosage_form' align='left' >".$row['dosage_form']."</td>";
                                  echo "<td class='product_description' title='".$row['product_description']."' align='left' style='overflow:hidden; text-overflow:ellipsis; white-space: nowrap;'>".$row['product_description']."</td>";
                                  echo "<td class='country' align='left' >".$row['country']."</td>";
                                  echo "<td class='date' align='left' >".$row['date']."</td>";
                                  echo "<td class='link' align='left' ><a href='".$row['link']."' target='_blank'>Link</a></td>";
                                  echo "</tr>";
                                }
                              ?>
                              </tbody>
                            </table>
                          </div>
                          <div class="d-flex justify-content-center mt-3">
                            <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                            <ul class="mb-0 pagination"></ul>
                            <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div><br><br>
                  <!-- Reference -->
                  <div class="card custom-shadow my-0" data-component-card="data-component-card">
                    <div class="card-body p-0">                                
                      <div class="p-4 code-to-copy">
                        <h3 class="text-900 mb-0" data-anchor="data-anchor" id="reference">Reference</h3><hr>
                        <list>
                          <?php
                            while ($row = pg_fetch_assoc($ref_result)) {
                              echo "<li>".$row['description']."</a></li>";
                            }
                          ?>
                        </list>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
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
    <script src="assets/jquery-3.6.0.min.js"></script>
    <script src="phoenix/public/vendors/popper/popper.min.js"></script>
    <script src="phoenix/public/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-table.min.js"></script>
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