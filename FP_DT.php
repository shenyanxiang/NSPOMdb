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
    <link href="phoenix/public/vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
    <link href="phoenix/public/vendors/dropzone/dropzone.min.css" rel="stylesheet">
    <link href="phoenix/public/vendors/prism/prism-okaidia.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link href="phoenix/public/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="phoenix/public/assets/css/theme-rtl.min.css" type="text/css" rel="stylesheet" id="style-rtl">
    <link href="phoenix/public/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="phoenix/public/assets/css/user-rtl.min.css" type="text/css" rel="stylesheet" id="user-style-rtl">
    <link href="phoenix/public/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
    <link href="phoenix/public/vendors/choices/choices.min.css" rel="stylesheet" />
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
          <div class="row">
            <div class="col-12 col-xxl-10 offset-xxl-1">
                <div class="card-header p-4 border-bottom border-300 bg-soft">
                  <div class="row g-3 justify-content-between align-items-center">
                    <div class="col-12 col-md">
                        <h4 class="text-900 mb-0" data-anchor="data-anchor">Decision tree for finished product</h4>
                    </div>
                  </div>
                </div>
              <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
                <div class="card-header bg-100 pt-3 pb-2 border-bottom-0">
                    <ul class="nav justify-content-between nav-wizard">
                        <li class="nav-item"><a class="nav-link active fw-semi-bold disabled" href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1">
                            <div class="text-center d-inline-block"><span class="d-none d-md-block fs--1">Step1</span><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-1"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Microbial<br>species</span></div>
                            </a></li>
                        <li class="nav-item"><a class="nav-link fw-semi-bold disabled" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="2">
                            <div class="text-center d-inline-block"><span class="d-none d-md-block fs--1">Step2</span><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-2"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Microbial<br>count</span></div>
                            </a></li>
                        <li class="nav-item"><a class="nav-link fw-semi-bold disabled" href="#bootstrap-wizard-tab3" data-bs-toggle="tab" data-wizard-step="3">
                            <div class="text-center d-inline-block"><span class="d-none d-md-block fs--1">Step3</span><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-3"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Challenge<br>test</span></div>
                            </a></li>
                        <li class="nav-item"><a class="nav-link fw-semi-bold disabled" href="#bootstrap-wizard-tab4" data-bs-toggle="tab" data-wizard-step="4">
                            <div class="text-center d-inline-block"><span class="d-none d-md-block fs--1">Step4</span><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-4"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Administration<br>route</span></div>
                            </a></li>
                        <li class="nav-item"><a class="nav-link fw-semi-bold disabled" href="#bootstrap-wizard-tab5" data-bs-toggle="tab" data-wizard-step="5">
                            <div class="text-center d-inline-block"><span class="d-none d-md-block fs--1">Step5</span><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-5"></span></span></span><span class="d-none d-md-block mt-1 fs--1">Patient<br>population</span></div>
                            </a></li>
                        <li class="nav-item"><a class="nav-link fw-semi-bold disabled" href="#bootstrap-wizard-tab6" data-bs-toggle="tab" data-wizard-step="6">
                            <div class="text-center d-inline-block"><span class="d-none d-md-block fs--1">Result</span><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-check"></span></span></span>
                              <span class="d-none d-md-block mt-1 fs--1">&nbsp;<br>&nbsp;</span>
                            </div>
                          </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body pt-4 pb-0">
                  <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1" id="bootstrap-wizard-tab1">
                        <form class="needs-validation" id="wizardForm1" novalidate="novalidate" data-wizard-form="1" required="required">
                            <div class="mb-5">
                            <label for="step1-1">Please input or select the microorganism detected from your product:</label>
                            <select class="form-select" name="microSpecies" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true,"shouldSort": false}' required="required">
                              <option value="">Select microorganism...</option>
                              <?php
                                $query = "SELECT micro_name FROM public.micro_risk_list";
                                $result = pg_query($conn, $query);
                                while ($row = pg_fetch_row($result)){
                                  echo '<option>'.$row[0].'</option>';
                                }
                              ?>
                              <option value="Other">Other species</option>
                            </select>
                            </div>
                            <div class="mb-2">
                            <label for="step1-2">Does the microorganism damage the properties and efficacy of the product?</label>
                            <select class="form-select" name="damage" required="required">
                              <option value="">Select one option ...</option>
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                            </select>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab2" id="bootstrap-wizard-tab2">
                    <form class="needs-validation" id="wizardForm2" novalidate="novalidate" data-wizard-form="2" required="required">
                      <div class="mb-4">
                        <label for="step2-1">Please select the microbial limit threshold applied in your analysis (in CFU/g or CFU/ml).</label>
                        <select class="form-select" name="threshold" required="required">
                          <option value="">Select one option ...</option>
                          <option value="10">10</option>
                          <option value="100">100</option>
                          <option value="1000">1000</option>
                        </select>
                      </div>
                      <div class="mb-2">
                        <label for="step2">Please enter the quantity of microbial contamination (in CFU/g or CFU/ml): </label>
                        <input class="form-control" type="number" name="quantity" placeholder="e.g. 100" required="required"/>
                      </div>
                    </form>
                    </div>
                    <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab3" id="bootstrap-wizard-tab3">
                    <form class="needs-validation" id="wizardForm3" novalidate="novalidate" data-wizard-form="3" required="required">
                      <div class="mb-2">
                        <label for="step3">Is there scientific evidence (e.g. challenge test) that the product can effectively inhibit the survival and proliferation of the microorganism?</label>
                        <select class="form-select" name="flag3" required="required">
                          <option value="">Select one option ...</option>
                          <option value="1">Yes</option>
                          <option value="0">No</option>
                        </select>
                      </div>
                    </form>
                    </div>
                    <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab4" id="bootstrap-wizard-tab4">
                    <form class="needs-validation" id="wizardForm4" novalidate="novalidate" data-wizard-form="4" required="required">
                      <div class="mb-2">
                        <label for="step4">Please select the administration route(s) of your product:</label>
                        <select class="form-select" name="route[]" data-choices="data-choices" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true,"shouldSort": false}' required="required">
                          <option value="">Select administration route(s)...</option>
                          <?php
                            $query = "SELECT route FROM public.route_list";
                            $result = pg_query($conn, $query);
                            while ($row = pg_fetch_row($result)){
                              echo '<option>'.$row[0].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </form>
                    </div>
                    <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab5" id="bootstrap-wizard-tab5">
                    <form class="needs-validation" id="wizardForm5" novalidate="novalidate" data-wizard-form="5" required="required">
                      <div class="mb-2">
                        <label for="step5">Please select the target population(s) of your product:</label>
                        <select class="form-select" name="population[]" data-choices="data-choices" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true,"shouldSort":false}' required="required">
                          <option value="">Select target population(s)...</option>
                          <?php
                            $query = "SELECT population FROM public.population_list";
                            $result = pg_query($conn, $query);
                            while ($row = pg_fetch_row($result)){
                              echo '<option>'.$row[0].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </form>
                    </div>
                    <div class="tab-pane" role="tabpanel" aria-labelledby="bootstrap-wizard-tab6" id="bootstrap-wizard-tab6">
                      <div class="row flex-center pb-4 pt-4 gx-3 gy-4">
                        <div class="col-18 col-sm-auto">
                          <div id="result-tab-content"></div>
                        </div>
                      </div>
                      <div class="d-flex pager wizard list-inline mb-5">
                        <div id="related-recall"></div>
                        <div class="flex-1 text-end">
                          <button class="btn btn-primary px-6" onclick="location.reload()">Start Over</button>
                        </div>
                      </div>
                      <div class="collapse" id="collapseTable">
                        <div id="related-recall-table"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer border-top-0" data-wizard-footer="data-wizard-footer">
                <div class="d-flex pager wizard list-inline mb-0">
                    <button class="btn btn-link ps-0 d-none wizard-prev" type="button" data-wizard-prev-btn="data-wizard-prev-btn"><svg class="svg-inline--fa fa-chevron-left me-1" data-fa-transform="shrink-3" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;"><g transform="translate(160 256)"><g transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)"><path fill="currentColor" d="M224 480c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25l192-192c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25L77.25 256l169.4 169.4c12.5 12.5 12.5 32.75 0 45.25C240.4 476.9 232.2 480 224 480z" transform="translate(-160 -256)"></path></g></g></svg><!-- <span class="fas fa-chevron-left me-1" data-fa-transform="shrink-3"></span> Font Awesome fontawesome.com -->Previous</button>
                    <div class="flex-1 text-end">
                    <button class="btn btn-primary px-6 px-sm-6 wizard-next" type="submit" data-wizard-next-btn="data-wizard-next-btn">Next<svg class="svg-inline--fa fa-chevron-right ms-1" data-fa-transform="shrink-3" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="" style="transform-origin: 0.3125em 0.5em;"><g transform="translate(160 256)"><g transform="translate(0, 0)  scale(0.8125, 0.8125)  rotate(0 0 0)"><path fill="currentColor" d="M96 480c-8.188 0-16.38-3.125-22.62-9.375c-12.5-12.5-12.5-32.75 0-45.25L242.8 256L73.38 86.63c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0l192 192c12.5 12.5 12.5 32.75 0 45.25l-192 192C112.4 476.9 104.2 480 96 480z" transform="translate(-160 -256)"></path></g></g></svg><!-- <span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"> </span> Font Awesome fontawesome.com --></button>
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-xxl-10 offset-xxl-1">
              <p>
                <a class="btn btn-phoenix-secondary mt-2" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Decision tree, referenced from Guideline Principle 9212, Chinese Pharmacopoeia (2025)</a>
              </p>
              <div class="collapse show" id="collapseExample">
                <img src="assets/img/FP_DT.png" class="img-fluid" alt="Decision tree for finished product">
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        pg_close($conn);
      ?>
      <script>
        var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
        var navbarTop = document.querySelector('.navbar-top');
        if (navbarTopStyle === 'darker') {
          navbarTop.classList.add('navbar-darker');
        }

        const goToStep = (stepNumber) => {
          document.querySelector(".tab-pane.active").classList.remove("active");
          document.querySelector(`#bootstrap-wizard-tab${stepNumber}`).classList.add("active");
          
          document.querySelector(".nav-link.active").classList.remove("active");
          document.querySelector(`[data-wizard-step="${stepNumber}"]`).classList.add("active");

          const prevButton = document.querySelector(".wizard-prev");
          const nextButton = document.querySelector(".wizard-next");
          
          if (stepNumber === 6) {
            prevButton.classList.add("d-none");
            nextButton.classList.add("d-none");
          } else {
            prevButton.classList.remove("d-none");
            nextButton.classList.remove("d-none");
          }
        };

        const getRecallEvents = (microbe) => {
          const formData = new FormData();
          formData.append('microbe', microbe);

          fetch('scripts/list-recall.php', {
            method: 'POST',
            body: formData,
          })
          .then(response => response.text())
          .then(data => {
            document.getElementById('related-recall-table').innerHTML = data;
            // 重新初始化 List.js
            const recallTableElement = document.getElementById('recallTable');
            if (recallTableElement) {
                const listConfig = JSON.parse(recallTableElement.getAttribute('data-list'));
                new List(recallTableElement, listConfig);
            }
          })
          .catch(error => {
            console.error('Error:', error);
          });
        };

        document.querySelector('[data-wizard-next-btn="data-wizard-next-btn"]').addEventListener('click', function(e) {
            e.preventDefault(); 

            const currentStepForm = document.querySelector('.tab-pane.active form');
            if (!currentStepForm.checkValidity()) {
                return;
            }
            const formData = new FormData(currentStepForm); 
            const currentStep = document.querySelector('.tab-pane.active form').getAttribute('data-wizard-form');
            formData.append('step', currentStep);

            fetch('scripts/finished_product_DT.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.continue) {
                    const nextStep = document.querySelector('.nav-wizard .nav-item.active');
                    if (nextStep) {
                        nextStep.querySelector('a').click();
                    }
                } else {
                    const resultTabContent = document.getElementById('result-tab-content');
                    const relatedRecall = document.getElementById('related-recall');
                    if (data.message === 'objectionable') {
                      resultTabContent.innerHTML = `
                        <div class="alert alert-outline-info d-flex align-items-center justify-content-center text-center" role="alert">
                          <span class="fas fa-info-circle text-info fs-2 me-3"></span>
                          <h4 class="alert-heading mb-0 fw-bold">Analysis Complete!</h4>
                        </div>
                        <div class="alert alert-outline-warning d-flex align-items-center mt-3" role="alert">
                          <span class="fas fa-times-circle text-warning fs-3 me-3"></span>
                          <h4 class="alert-heading">High risk: This microorganism could potentially be objectionable for the product.</h4>
                        </div>
                      `;
                      relatedRecall.innerHTML = `
                        <button class="btn btn-phoenix-secondary rounded-pill shadow-sm mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTable" aria-expanded="false" aria-controls="collapseTable">
                          <i class="fas fa-list"></i> Show recall events involved in <i>${data.microbe}</i>
                        </button>
                      `;
                      getRecallEvents(data.microbe);
                    } else {
                      resultTabContent.innerHTML = `
                        <div class="alert alert-outline-info d-flex align-items-center justify-content-center text-center" role="alert">
                          <span class="fas fa-info-circle text-info fs-2 me-3"></span>
                          <h4 class="alert-heading mb-0 fw-bold">Analysis Complete!</h4>
                        </div>
                        <div class="alert alert-outline-success d-flex align-items-center mt-3" role="alert">
                          <span class="fas fa-check-circle text-success fs-3 me-3"></span>
                          <h4 class="alert-heading">Based on a comprehensive evaluation of historical data, this microorganism can be classified as low risk for your product.</h4>
                        </div>
                      `;
                    }
                    goToStep(6);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
      </script>
    </main>


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap-table.min.js"></script>
    <script src="phoenix/public/vendors/popper/popper.min.js"></script>
    <script src="phoenix/public/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="phoenix/public/vendors/anchorjs/anchor.min.js"></script>
    <script src="phoenix/public/vendors/is/is.min.js"></script>
    <script src="phoenix/public/vendors/fontawesome/all.min.js"></script>
    <script src="phoenix/public/vendors/lodash/lodash.min.js"></script>
    <script src="phoenix/public/vendors/list.js/list.min.js"></script>
    <script src="phoenix/public/vendors/feather-icons/feather.min.js"></script>
    <script src="phoenix/public/vendors/dayjs/dayjs.min.js"></script>
    <script src="phoenix/public/vendors/dropzone/dropzone.min.js"></script>
    <script src="phoenix/public/vendors/prism/prism.js"></script>
    <script src="phoenix/public/vendors/choices/choices.min.js"></script>
    <script src="phoenix/public/assets/js/phoenix.js"></script>

  </body>

</html>