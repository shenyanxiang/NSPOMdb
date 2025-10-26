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
    <link rel="stylesheet" href="assets/css/bootstrap-table.min.css">
    <link href="phoenix/public/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="phoenix/public/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="phoenix/public/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="phoenix/public/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
    <link href="assets/css/style.css" type="text/css" rel="stylesheet" id="custom-style-default">
    <style>
      .help-sidebar {
        position: -webkit-sticky;
        position: sticky;
        top: 80px;
        z-index: 1020;
        height: max-content;
      }
      .nav-link.active {
        font-weight: bold;
        color: #0d6efd !important;
        background: #f5f8ff;
      }
    </style>
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
        <div class="content container">
          <div class="d-flex">
            <!-- Sidebar Navigation -->
            <nav class="help-sidebar flex-shrink-0 mr-5 position-sticky" style="top: 80px; width: 250px;">
              <div class="card border-0 shadow-sm">
                <div class="card-body px-2 py-3">
                  <ul class="nav flex-column" id="helpNav">
                    <li class="nav-item">
                      <a class="nav-link active" href="#introduction">Introduction</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#usage">Usage</a>
                      <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                          <a class="nav-link" href="#database">Database</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#tools">Tools</a>
                          <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                              <a class="nav-link" href="#ARG-VFG-finder">ARG-VFG-finder</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#risk_management">Microbial risk management</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" href="#risk_assessment">Microbial risk assessment</a>
                            </li>
                        </li>
                      </ul>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#disclaimer">Disclaimer and assumption of risk</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#reference">References</a>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
            <!-- Main Content -->
            
            <div class="flex-grow-1">
              <div class="mx-4 px-4 mx-lg-n6 px-lg-6 bg-white pt-7 pb-5 border border-300 rounded-3">
                <div class="row align-items-center">
                  <h1 class="text-center fw-bold">NSPOMdb document</h1>
                </div>
                <section id="introduction">
                  <h3>Introduction</h3>
                  <div class="row mt-3">
                    <h4>What is an objectionable microorganism in non-sterile products?</h4>
                    <p>
                    The 2020 edition of the Chinese Pharmacopoeia points out in General Rule <1107> that the microorganisms listed for control may not comprehensively cover the microbial quality of certain drugs. 
                    Therefore, for raw materials, excipients, and certain specific preparations, other potentially harmful microorganisms may need to be examined based on the characteristics and use of the raw 
                    materials and their preparations, as well as the manufacturing process of the preparations. The United States Pharmacopeia, European Pharmacopeia, and Japanese Pharmacopeia all have similar 
                    provisions to the Chinese Pharmacopoeia’s requirement of examining “other potentially harmful microorganisms.” The term “objectionable organisms” is used in the United States Pharmacopeia, 
                    US cGMP, and Australian regulations to describe such “other potentially harmful microorganisms” in non-sterile products. The CDE of China defines objectionable microorganisms as those that, 
                    aside from pharmacopeial control organisms, can survive or proliferate in drugs, potentially causing infections or health threats in patients via specific administration routes, or compromising 
                    the nature and efficacy of the drug.
                    </p>
                  </div>
                  <div class="row">
                    <h4>About NSPOMdb</h4>
                    <p>How can we determine which microorganisms are objectionable and assess their risk? Existing pharmacopoeial standards at home and abroad lack clear technical guidance, making it difficult to 
                      eliminate the safety risks posed by potential objectionable microorganisms. Supported by the research project “Guiding Principles for the Risk Control of Objectionable Microorganisms in Non-Sterile 
                      Products” funded by the Shanghai Institute for Food and Drug Control and the Chinese Pharmacopoeia Commission, NSRiskDB was developed as a comprehensive risk analysis platform to help pharmaceutical 
                      and quality control personnel conduct thorough risk assessments of microbial risks in non-sterile products.</p>
                  </div>
                </section>
                <section id="usage">
                  <h3 class="mb-3">Usage</h3>
                  <div id="database" class="mb-5">
                    <h4>Database</h4>
                    <div>
                      <p>
                      On the <strong>"Database"</strong> page, you can navigate through the four main sections using the tabs located at the top. The database consists of the following components:
                      </p>
                      <ol>
                        <li><strong>Potentially objectionable microorganisms:</strong> A potentially objectionable microorganism is one that can survive or proliferate 
                        in non-sterile drug products or raw materials, potentially causing infections or posing health risks to patients depending on the route of 
                        administration, or adversely affecting the quality and efficacy of the product. This database compiles a list of commonly encountered potentially 
                        objectionable microorganisms based on data from pharmaceutical manufacturers, drug regulatory agencies, and historical recall events.</li>

                        <li><strong>Recall events:</strong> Recall events refer to actions taken by a firm to remove a product from the marketplace, either voluntarily 
                        or in response to a request or mandate by a regulatory authority under its legal authority. This database includes records of non-sterile product 
                        recalls related to microbial contamination, as reported by official agencies in various countries since 2012.</li>

                        <li><strong>Dosage forms:</strong> Common dosage forms of non-sterile products, including gel preparation, lotion, spray, etc</li>

                        <li><strong>Administration routes and patient population:</strong> The method by which a product is delivered (e.g., oral, topical, nasal) 
                        and the characteristics of the target patient population (e.g., adult, infants), both of which influence the assessment of 
                        microbial risk.</li>
                      </ol>
                      <div class="mt-4">
                        <h5>1. Potentially Objectionable Microorganisms</h5>
                        <img src="assets/img/help/database1.png" class="img-fluid mb-3" alt="Potentially objectionable microorganisms">
                        <p>
                          NSPOMdb features a manually curated list of 89 potentially objectionable microorganisms, compiled from various sources including non-sterile product (NSP) recall events, industry surveys, and clinical case reports.  
                          The list includes 6 genera, 1 species complex, and 82 individual species, covering 59 bacterial and 30 fungal organisms. For entries at the genus or complex level, you can click the "+" icon to expand and view the corresponding species.
                        </p>
                        <p>
                          For each microorganism, you can click the "View" button in the "Detail" column to access more information, including taxonomy, morphology, physiological and biochemical characteristics, representative sequences, and risk-related details.
                          Additionally, by clicking the bar in the "Number of Related Recall Events" column, you can jump directly to the recall events table filtered for that microorganism.
                        </p>
                        <img src="assets/img/help/ARG-VFG.png" class="img-fluid mb-3" alt="ARGs and VFGs in microorganisms">
                        <p>
                          A comprehensive dataset of 38,426 bacterial genome sequences (12,929 chromosomes and 25,497 plasmids) and 1,200 fungal genome sequences corresponding to the listed species was retrieved from the NCBI RefSeq/GenBank database.
                          These genomes were analyzed using the newly developed tool <em>ARG-VFG-finder</em> to predict the presence of putative virulence factor genes and antimicrobial resistance genes. You can click the "View" buttons in the "Virulence Factor Genes" and
                          "Antimicrobial Resistance Genes" columns to access the respective prediction results. Among the most frequent bacterial species in NSP recall events, <em>Staphylococcus aureus</em>, <em>Pseudomonas aeruginosa</em>, and <em>Cronobacter sakazakii</em> carry antibiotic resistance
                          genes from various drug classes. These findings highlight the potential for multidrug resistance among common contaminants in NSPs. Seven classes of common antifungal resistance genes were also identified among the four fungal genera listed
                          in the objectionable microorganism list. The detailed prediction results for each specific species can be viewed on the "Dataset" page.
                        </p>
                      </div>
                      <div class="mt-4">
                        <h5>2. Recall events</h5>
                        <img src="assets/img/help/database2.png" class="img-fluid mb-3" alt="Recall events">
                        <p>
                          NSPOMdb includes a total of 1,354 recall events related to microbial contamination in non-sterile products (NSPs), comprising 983 pharmaceutical items and 371 cosmetic products.  
                          The data were collected from publicly accessible websites of regulatory agencies, including the U.S. Food and Drug Administration (FDA), the European Commission,  
                          the Medicines and Healthcare products Regulatory Agency (MHRA), and the Therapeutic Goods Administration (TGA).
                        </p>
                        <p>
                          You can hover over the "..." icon to view the full product description and the reason for the recall.  
                          The link in the "Link" column will direct you to the original webpage of the recall event.
                        </p>
                      </div>
                      <div class="mt-4">
                        <h5>3. Dosage Forms</h5>
                        <img src="assets/img/help/database3.png" class="img-fluid mb-3" alt="Dosage forms">
                        <p>
                          NSPOMdb provides a list of 16 commonly used dosage forms for non-sterile products, including gels, lotions, sprays, powders, and more.  
                          This classification is based on General Rule 1107 and Guideline Principle 9211 of the Chinese Pharmacopoeia (2025 Edition).
                        </p>
                        <p>
                          You can click the bar in the "Number of Related Recall Events" column to navigate directly to the recall events table, filtered by the selected dosage form.
                        </p>
                      </div>
                      <div class="mt-4">
                        <h5>4. Administration routes and patient population</h5>
                        <img src="assets/img/help/database4.png" class="img-fluid mb-3" alt="Route and population">
                        <p>
                          Routes of administration and patient populations are critical factors in evaluating the microbial risk associated with non-sterile products.  
                          This section provides a categorized list of administration routes and target patient populations, along with their corresponding risk levels,  
                          as referenced in established <a href="decision_tree.php">risk management program</a>.
                        </p>
                      </div>
                    </div>
                  </div>
                  <div id="tools" class="mb-5">
                    <h4>Tools</h4>
                    <div id="ARG-VFG-finder" class="mt-4 mb-4">
                      <h5><li>ARG-VFG-finder</li></h5>
                      <p>
                        ARG-VFG-finder is a tool designed to predict the presence of antimicrobial resistance genes (ARGs) and virulence factor genes (VFGs) in microbial genomes.  
                        The workflow of ARG-VFG-finder is illustrated below:
                      </p>
                      <img src="assets/img/help/tool1.png" class="img-fluid mb-3" alt="ARG-VFG-finder pipeline">
                      <p>
                        You can access this tool by navigating to <strong>"Tool" → "ARG-VFG-finder"</strong> in the top menu. On the ARG-VFG-finder page, select the type of microorganism (bacteria or fungi) you wish to analyze, then upload the corresponding sequence file following the format requirements. 
                        After configuring the analysis parameters, click the <strong>"Start Run"</strong> button to begin the analysis.  
                        You may also click <strong>"Run an Example"</strong> to try a sample analysis. Example files are available via the <strong>"Download Example Files"</strong> button.
                      </p>
                    </div>
                  </div>
                  <div id="risk_management" class="mb-5">
                    <h4>Microbial Risk Management</h4>
                    <p>
                      You can access this tool by navigating to <strong>"Tool" → "Microbial Risk Management"</strong> in the top navigation menu.  
                      This decision-tree-based tool is designed to assist users in evaluating the microbial risk of non-sterile products and determining whether a specific microorganism is considered objectionable.  
                      The decision tree is developed based on Guideline Principle 9212 of the Chinese Pharmacopoeia (2025 Edition).
                    </p>
                    <p>
                      Users are guided through a series of structured questions to assess the microbial risk associated with a particular microorganism found in a non-sterile product or its raw materials.  
                      Below is an example illustrating the decision-making process:
                    </p>
                    <img src="assets/img/help/tool2.png" class="img-fluid mb-3" alt="Microbial risk management decision tree">
                    <p>
                      During use, you will be prompted to answer a sequence of questions step by step. After completing each step, click the <strong>"Next"</strong> button to proceed.  
                      If you wish to review or modify a previous answer, you can click the <strong>"Previous"</strong> button to return to an earlier step.  
                      If the result indicates <strong>"High Risk"</strong>, you will be provided with the option to view related recall events by clicking the <strong>"Show Recall Events"</strong> button.
                    </p>   
                  </div>
                  <div id="risk_assessment" class="mb-5">
                    <h4>Microbial Risk Assessment</h4>
                    <p>
                      You can access this tool by navigating to <strong>"Tool" → "Microbial Risk Assessment"</strong> in the top navigation menu.
                      This si a quantitative assessment tool based on the microbial risk calculation model proposed by Eissa, M. E. (Eissa, BJBAS, 2016). 
                      It estimates the level of microbial risk by integrating user-provided data, generating a risk score that can be used to determine 
                      whether a microorganism is objectionable. Here is an example result of the program.
                    </p>
                    <img src="assets/img/help/tool3.png" class="img-fluid mb-3" alt="Microbial risk assessment decision tree">
                    <p>
                      During use, you will be prompted to answer a series of questions. After inputing all the required data, the dashboard on the right will
                      show the calculated risk score and the corresponding risk level. To view the detailed calculation process, you can click the 
                      <strong>"View calculation formula"</strong> button.
                    </p>
                  </div>
                </section>
                <section id="disclaimer">
                  <h3 class="mb-5">Disclaimer and assumption of risk</h3>
                  <p>
                    NSPOMdb is a software platform to provide guidance on how to manage the microbial risks associated with manufacturing and storage and how 
                    to determine what isolates would be deemed an objectionable microorganism in non-sterile products that is in alignment with the microbial 
                    limits requirements for releasing these products into the marketplace.
                  </p>
                  <p>
                    This platform and its contents are provided "as is", without warranty of any kind, either express or implied, including, but not limited to, 
                    warranties of merchantability, fitness for a particular purpose, noninfringement, accuracy, completeness, or that the content is current or 
                    error-free. The user assumes the entire risk associated with the use of this platform and any decisions made based on the information provided herein.
                  </p>
                  <p>
                    In no event shall the developers, contributors, or maintainers of NSRiskDB be liable for any claim, loss, damage, or other liability, whether 
                    in an action of contract, tort, or otherwise, arising from or related to the use of this platform or reliance on any of its content. There is 
                    no obligation to update, correct, or support the platform, nor to notify users of any errors, inaccuracies, or changes.
                  </p>
                  <p>
                    Users are responsible for ensuring that any use of the information complies with applicable regulatory requirements and professional standards. 
                    Reliance on the platform is entirely at the user's own discretion and risk.
                  </p>
                </section>
                <section id="reference">
                  <h3>References</h3>
                  <div>
                    <table class="table" id="reference-table" data-search-align="left" data-classes="table table-hover">
                    </table> 
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
        var navbarTop = document.querySelector('.navbar-top');
        if (navbarTopStyle === 'darker') {
          navbarTop.classList.add('navbar-darker');
        }
      </script>
      <script>
        // Optional: Scrollspy for active navigation
        document.addEventListener('DOMContentLoaded', function () {
          if (window.bootstrap && typeof bootstrap.ScrollSpy === "function") {
            var dataSpyList = [].slice.call(document.querySelectorAll('[data-bs-spy="scroll"]'));
            dataSpyList.forEach(function (spyEl) {
              bootstrap.ScrollSpy.getOrCreateInstance(spyEl);
            });
          }
          // Activate nav-link on click
          document.querySelectorAll('#helpNav .nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
              document.querySelectorAll('#helpNav .nav-link').forEach(function (l) {
                l.classList.remove('active');
              });
              this.classList.add('active');
            });
          });
        });
      </script>
    </main>


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
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
    <script>
      $('#reference-table').bootstrapTable({
          url: 'scripts/reference_list.php',
          method: 'get',
          dataType: 'json',
          search: true,
          showHeader: false,
          columns: [
              {
                  field: 'reference_id',
                  formatter: function(value) {
                      return `<span class="text-1000">[${value || ''}]</span>`;
                  }
              },
              {
                  field: 'description',
              },
          ]
      });
    </script>

  </body>

</html>