<?php

include __DIR__ . '/functions.php';

display_header();
display_hero();
set_config_inc();
set_send_email();

require(MYSQL);

$client_query = "SELECT COUNT(*) as client_count FROM clients"; // Count the number of clients
$client_result = $dbc->query($client_query);

// Fetch the result
$client_row = $client_result->fetch_assoc();
$client_count = $client_row['client_count'];


// Count the number of clients with status "Granted"
$granted_count_query = "SELECT COUNT(*) as granted_count FROM clients WHERE status = 'Grant'";
$granted_count_result = $dbc->query($granted_count_query);
$granted_row = $granted_count_result->fetch_assoc();
$granted_count = $granted_row['granted_count'];

// Count the number of clients with status "Denied"
$denied_count_query = "SELECT COUNT(*) as denied_count FROM clients WHERE status = 'Denied'";
$denied_count_result = $dbc->query($denied_count_query);
$denied_row = $denied_count_result->fetch_assoc();
$denied_count = $denied_row['denied_count'];




// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Minimal form validation:
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['message'])) {

        // Prepare SQL statement to insert data into the database table:
        $stmt = $dbc->prepare("INSERT INTO email_messages (name, email, subject, message, date_received) VALUES (?, ?, ?, ?, NOW())");

        // Bind parameters and execute the statement:
        $stmt->bind_param("ssss", $_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']);
        $stmt->execute();

        // Close statement and database connection:
        $stmt->close();
        $dbc->close();


        // Create the body:
        $body = "Sender Name: {$_POST['name']}, <br />Email From: {$_POST['email']}, <br /> Message: {$_POST['message']}";

        // Make it no longer than 100 characters long:
        $body = wordwrap($body, 100);

        // Send the email:
        send_email('montesarose@gmail.com', $_POST['subject'], $body, "From: {$_POST['email']}");

        // Print a message:
        //echo '<p><em>Thank you for contacting me. I will reply some day.</em></p>';
        successButtomMessage('Message successfully sent!');

        // Clear $_POST (so that the form's not sticky):
        $_POST = [];
    } else {
        echo '<p style="font-weight: bold; color: #C00">Please fill out the form completely.</p>';
    }
} // End of main isset() IF.

?>

<main id="main">

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
        <div class="container">

            <div class="section-title">
                <h2>About Us</h2>
                <p>Mandate/Goals</p>
            </div>

            <div class="row content">
                <div class="col-lg-6">
                    <p>
                        The Parole And Probation And Probation Administration is mandated to conserve and/or redeem
                        convicted offenders and prisoners who are under the probation or parole system.
                    </p>
                    <ul>
                        <li><i class="ri-check-double-line"></i> To administer the Parole and probation system</li>
                        <li><i class="ri-check-double-line"></i> To exercise supervision over probationers, parolees,
                            and pardonees</li>
                        <li><i class="ri-check-double-line"></i> To promote the correction and rehabilation of criminal
                            offenders</li>
                    </ul>
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0">
                    <p>
                        To Promote the reformation of criminal offenders and reduce the incidence of recidivism. Provide
                        a cheaper alternative to the institutional confinement of
                        first-time offenders who are likely to respond to individualized, and community-based treatment
                        programs.
                    </p>
                    <a href="about_us.php" class="btn-learn-more">Learn More</a>
                </div>
            </div>

        </div>
    </section><!-- End About Us Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
        <div class="container">

            <div class="section-title">
                <h2>Services</h2>
                <p>Here's the list of services</p>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bxs-file-pdf"></i></div>
                        <h4><a href="assets/pdf_dl/Court-Referrals.pdf">Investigation of Court Referrals</a></h4>
                        <p>To provide the courts with relevant information and judicious recommendations for the
                            selection of offenders to be placed on probation.</p>
                        <br />
                        <a href="assets/pdf_dl/Court-Referrals.pdf"><b>Click to download the pdf copy.</b></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bxs-file-pdf"></i></div>
                        <h4><a href="assets/pdf_dl/Corrections.pdf">Correction And Rehabilitation of Penitent
                                Offenders</a></h4>
                        <p>To effect the rehabilitation and reintegration of probationers, parolees, pardonees, and
                            first-time minor drug offenders as productive, law-abiding and socially responsible members
                            of the community through</p>
                        <br />
                        <a href="assets/pdf_dl/Corrections.pdf"><b>Click to download the pdf copy.</b></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
                    <div class="icon-box">
                        <div class="icon"><i class="bx bxs-file-pdf"></i></div>
                        <h4><a href="assets/pdf_dl/Supervision-ROR.pdf">Role of the Probation Officer</a></h4>
                        <p>To monitor and evaluate the activities of the person released on recognizance</p>
                        <br />
                        <a href="assets/pdf_dl/Corrections.pdf"><b>Click to download the pdf copy.</b></a>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Services Section -->

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
        <div class="container">

            <div class="row">
                <div class="col-lg-9 text-center text-lg-start">
                    <h3>Want to apply for probation?</h3>
                    <p> Create an account now to start applying for probation</p>
                </div>
                <div class="col-lg-3 cta-btn-container text-center">
                    <a class="cta-btn align-middle" href="register_v3.php">Sign up</a>
                </div>
            </div>

        </div>
    </section><!-- End Cta Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container">

            <div class="row">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="icon-box mt-5 mt-lg-0">
                        <i class="bx bx-user"></i>
                        <h4>Aries M. Navarro</h4>
                        <p>Chief Probation and Parole Officer</p>
                    </div>
                    <div class="icon-box mt-5">
                        <i class="bx bx-user"></i>
                        <h4>Gerald R. de Mesa</h4>
                        <p>Senior Probation and Parole Officer</p>
                    </div>
                    <div class="icon-box mt-5">
                        <i class="bx bx-user"></i>
                        <h4>Rossville “Aeron” B. Violanta-Falcon</h4>
                        <p>Probation and Parole Officer I</p>
                    </div>
                    <div class="icon-box mt-5">
                        <i class="bx bx-user"></i>
                        <h4>Francis Homer J. Balaaldia</h4>
                        <p> Probation and Parole Officer I</p>
                    </div>
                    <div class="icon-box mt-5">
                        <i class="bx bx-user"></i>
                        <h4>Alden Richard</h4>
                        <p> Administrative Aide IV</p>
                    </div>
                </div>
                <div class="image col-lg-6 order-1 order-lg-2"
                    style='background-image: url("assets/img/features.jpg");'></div>
            </div>

        </div>
    </section><!-- End Features Section -->



    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
        <div class="container">

            <div class="text-center title">
                <h3>Areas of Jurisdiction</h3>
                <p>Kalayaan, Lumban, Pagsanjan, Pila, Cavinti, Luisiana, Sta. Cruz, Liliw, Victoria, Magdalena,
                    Majayjay, Paete, Pakil, Pangil, Siniloan, Famy, Mabitac, Sta. Maria</p>
            </div>

            <div class="row counters position-relative">

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="<?= $client_count ?>"
                        data-purecounter-duration="1" class="purecounter"></span>
                    <p>Clients</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="<?= $granted_count ?>"
                        data-purecounter-duration="1" class="purecounter"></span>
                    <p>Granted</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="<?= $denied_count ?>"
                        data-purecounter-duration="1" class="purecounter"></span>
                    <p>Denied</p>
                </div>

                <div class="col-lg-3 col-6 text-center">
                    <span data-purecounter-start="0" data-purecounter-end="5" data-purecounter-duration="1"
                        class="purecounter"></span>
                    <p>Probation Officers</p>
                </div>

            </div>
        </div>

    </section><!-- End Counts Section -->


    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
        <div class="container">

            <div class="section-title">
                <h2>Courts Served</h2>
                <p>Regional Trial Court(RTC), Municipal Trial Court(MTC), Municipal Circuit Trial Court</p>
            </div>

            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <ul id="portfolio-flters">
                        <li data-filter="*" class="filter-active">All</li>
                        <li data-filter=".filter-app">RTC</li>
                        <li data-filter=".filter-card">MTC</li>
                        <li data-filter=".filter-web">MCTC</li>
                    </ul>
                </div>
            </div>

            <div class="row portfolio-container">

                <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                    <img src="assets/img/portfolio/RTC.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Brach 6</h4>
                        <p> Sta.Cruz(Family Court)</p>
                        <a href="assets/img/portfolio/RTC.jpg" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="RTC Branch 6 - Sta.Cruz(Family Court)"><i
                                class="bx bx-plus"></i></a>
                        <!-- <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a> -->
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <img src="assets/img/portfolio/MCTC_2.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Branch 2<sup>nd</sup></h4>
                        <p>Magdalena, Liliw, Majayjay</p>
                        <a href="assets/img/portfolio/MCTC_2.jpg" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="2nd MCTC - Magdalena, Liliw, Majayjay"><i
                                class="bx bx-plus"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                    <img src="assets/img/portfolio/RTC.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Branch 26, to 28, 91, 176</h4>
                        <p>Sta.Cruz</p>
                        <a href="assets/img/portfolio/RTC.jpg" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="RTC Brach 26, 28, 91, 176 - Sta.Cruz"><i
                                class="bx bx-plus"></i></a>
                        <!-- <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a> -->
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                    <img src="assets/img/portfolio/MTC.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>-</h4>
                        <p>Pagsanjan, Pila, Sta.Cruz, Victoria</p>
                        <a href="assets/img/portfolio/MTC.jpg" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link"
                            title="1st MTC - Pagsanjan, Sta.Cruz, Pila, Victoria"><i class="bx bx-plus"></i></a>
                        <!-- <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a> -->
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <img src="assets/img/portfolio/MCTC_1.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Branch 1<sup>st</sup></h4>
                        <p>Luisiana, Cavinti</p>
                        <a href="assets/img/portfolio/MCTC_1.jpg" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="1st MCTC - Luisiana, Cavinti"><i
                                class="bx bx-plus"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                    <img src="assets/img/portfolio/RTC.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Branch 33, and 166</h4>
                        <p>Siniloan</p>
                        <a href="assets/img/portfolio/RTC.jpg" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="RTC Branch 33 and 166 - Siniloan"><i
                                class="bx bx-plus"></i></a>
                        <!-- <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a> -->
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <img src="assets/img/portfolio/MCTC_7.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Branch 5<sup>th</sup></h4>
                        <p>Paete, Pakil, Pangil</p>
                        <a href="assets/img/portfolio/MCTC_7.jpg" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="MCTC 5th Branch - Paete, Pakil, Pangil"><i
                                class="bx bx-plus"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <img src="assets/img/portfolio/MCTC_4.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Branch 4<sup>th</sup></h4>
                        <p>Lumban, Kalayan</p>
                        <a href="assets/img/portfolio/MCTC_4.jpg" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="MCTC 4th Branch - Lumban, Kalayaan"><i
                                class="bx bx-plus"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <img src="assets/img/portfolio/MCTC_7.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Branch 6<sup>th</sup></h4>
                        <p>Siniloan, Famy</p>
                        <a href="assets/img/portfolio/MCTC_7.jpg" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="MCTC 6th Branch - Siniloan, Famy"><i
                                class="bx bx-plus"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                    <img src="assets/img/portfolio/MCTC_7.jpg" class="img-fluid" alt="">
                    <div class="portfolio-info">
                        <h4>Branch 7<sup>th</sup></h4>
                        <p>Sta.Maria, Mabitac</p>
                        <a href="assets/img/portfolio/MCTC_7.jpg" data-gallery="portfolioGallery"
                            class="portfolio-lightbox preview-link" title="MCTC 7th Branch - Sta.Maria, Mabitac"><i
                                class="bx bx-plus"></i></a>
                    </div>
                </div>

            </div>

        </div>
    </section><!-- End Portfolio Section -->




    <!-- ======= Faq Section ======= -->
    <section id="faq" class="faq">
        <div class="container-fluid">
            <div class="row">

                <!-- Left side: FAQ + Assistant -->
                <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">

                    <!-- FAQ Header -->
                    <div class="content">
                        <h3>Frequently Asked <strong>Questions</strong></h3>
                    </div>

                    <!-- Accordion FAQ List -->
                    <div class="accordion-list">
                        <ul>
                            <li>
                                <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1">What is
                                    Probation?
                                    <i class="bx bx-chevron-down icon-show"></i><i
                                        class="bx bx-chevron-up icon-close"></i></a>
                                <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                                    <p>Probation is a privilege granted by the court to a person convicted of a criminal
                                        offense to remain in the community instead of actually going to prison/jail.</p>
                                </div>
                            </li>

                            <li>
                                <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2" class="collapsed">What
                                    are the advantages of probation?
                                    <i class="bx bx-chevron-down icon-show"></i><i
                                        class="bx bx-chevron-up icon-close"></i></a>
                                <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                                    <p>The government spends much less when an offender is released on probation than
                                        that offender be placed behind bars (jails/prisons).</p>
                                    <p>The offender and the offender's family are spared the embarrassment and dishonor
                                        of imprisonment.</p>
                                </div>
                            </li>

                            <li>
                                <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3" class="collapsed">Who
                                    can apply for Probation?
                                    <i class="bx bx-chevron-down icon-show"></i><i
                                        class="bx bx-chevron-up icon-close"></i></a>
                                <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                                    <p>Any sentenced offender, not disqualified, can apply for probation before serving
                                        their prison/jail sentence.</p>
                                </div>
                            </li>

                            <a href="assets/content_uploads/FAQ_Probation.pdf" class="btn-learn-more">Read More</a>
                        </ul>
                    </div>

                    <!-- Assistant Section -->
                    <div class="content mt-1">
                        <span class="me-2" style="font-size: 4rem;">🤖</span>
                        <h3>Ask our <strong>LPPO Assistant</strong></h3>
                        <p>Type a question about probation and get an instant answer.</p>
                    </div>
                    <!-- Move the typing indicator BELOW the chatLog and ABOVE the input/button -->
                    <div class="chatbox border rounded p-3 bg-light mb-5">
                        <div id="chatLog" style="height: 150px; overflow-y: auto; margin-bottom: 20px;"></div>
                        <div id="typingIndicator" style="display:none; color: #888; margin-bottom: 10px;">
                            Assistant is typing<span id="dots">.</span>
                        </div>
                        <input type="text" id="userInput" class="form-control mb-2"
                            placeholder="Type your question here...">
                        <button class="btn btn-danger w-100" onclick="chat()">Ask</button>
                    </div>
                </div>

                <!-- Right side: Image -->
                <div class="col-lg-5 d-none d-lg-block order-1 order-lg-2"
                    style="background: url('assets/img/faq.jpg') center center / cover no-repeat; min-height: 400px; border-radius: 10px;">
                </div>

            </div>
        </div>


        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container">

                <div class="section-title">
                    <h2>Contact Us</h2>
                    <p>How to Reach Us?</p>
                </div>
            </div>

            <div>
                <iframe style="border:0; width: 100%; height: 350px;"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d966.6527851837013!2d121.4168733155741!3d14.27588558604298!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397e314863f1371%3A0xd0a9f7ebc13e9227!2sSan%20Luis%20Building!5e0!3m2!1sen!2sph!4v1696666355570!5m2!1sen!2sph"
                    frameborder="0" allowfullscreen></iframe>
            </div>

            <div class="container">

                <div class="row mt-5">

                    <div class="col-lg-4">
                        <div class="info">
                            <div class="address">
                                <i class="ri-map-pin-line"></i>
                                <h4>Location:</h4>
                                <p>F.T. San Luis Bldg., Provincial Capitol Compound, 4009 Sta. Cruz, Laguna</p>
                            </div>

                            <div class="email">
                                <i class="ri-mail-line"></i>
                                <h4>Email:</h4>
                                <p>Lagunappo2015@gmail.com</p>
                                <p>montesarose@gmail.com</p>
                            </div>

                            <div class="phone">
                                <i class="ri-phone-line"></i>
                                <h4>Call:</h4>
                                <p>(049)501-1902</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-8 mt-5 mt-lg-0">

                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control" id="name"
                                        placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Your Email" required>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="subject" id="subject"
                                    placeholder="Subject" required>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message"
                                    required></textarea>
                            </div>
                            <!-- <div class="my-3">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div>
                </div> -->
                            <div class="text-center"><button type="submit" name="submit" class="btn btn-success">Send
                                    Message</button></div>
                            <!-- <div class="text-center"><input type="submit" name="submit"></div> -->
                        </form>

                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

</main><!-- End #main -->
<script>
    function chat(inputValue = null) {
        const inputElement = document.getElementById("userInput");
        const chatLog = document.getElementById("chatLog");
        const typingIndicator = document.getElementById("typingIndicator");

        // Get user input
        let input = inputValue !== null ? inputValue.toLowerCase().trim() : inputElement.value.toLowerCase().trim();
        if (!input) return;

        // Default reply
        let reply = "Pasensya, hindi ko alam ang sagot doon. / Sorry, I don’t know the answer to that.";

        // Bot logic
        if (
            input === "hi" || input === "hello" || input === "hey" ||
            input === "kamusta" || input === "kumusta"
        ) {
            reply = "Kamusta! Paano kita matutulungan? / Hello! How can I help you?";
        }
        else if (
            input === "salamat" || input === "maraming salamat" ||
            input === "thank you" || input === "thanks"
        ) {
            reply = "Walang anuman! Nandito lang ako para tumulong. / You're welcome! I'm here to help.";
        }
        else if (
            input.includes("ano ang probation") ||
            input.includes("ano ang ibig sabihin ng probation") ||
            input.includes("what is probation") ||
            (input.includes("probation") && !input.includes("benefits") && !input.includes("advantages") && !input.includes("benepisyo") && !input.includes("bentahe"))
        ) {
            reply = "Probation ay pribilehiyo na ibinibigay ng korte sa isang taong nahatulan para manatili sa komunidad sa halip na makulong. / Probation is a privilege granted by the court allowing a convicted person to remain in the community instead of going to jail.";
        }
        else if (
            input.includes("ano ang benepisyo") ||
            input.includes("ano ang bentahe") ||
            input.includes("mga benepisyo") ||
            input.includes("advantages") ||
            input.includes("benefits")
        ) {
            reply = "Nakakatipid ang gobyerno at naiiwasan ng may sala at pamilya niya ang kahihiyan ng pagkakakulong. / It saves government resources and spares the offender and their family from the dishonor of imprisonment.";
        }
        else if (
            input.includes("sino ang pwedeng mag-apply") ||
            input.includes("sino pwedeng mag-apply") ||
            input.includes("sino ang kwalipikado") ||
            input.includes("who can apply")
        ) {
            reply = "Sinumang nahatulan ngunit hindi disqualified ay maaaring mag-apply ng probation bago magsilbi ng sentensya. / Any sentenced offender who is not disqualified may apply for probation before serving their sentence.";
        }
        else if (
            input.includes("gaano katagal") ||
            input.includes("tagal") ||
            input.includes("how long") ||
            input.includes("duration")
        ) {
            reply = "Ang tagal ng probation ay nag-iiba depende sa desisyon ng korte. / The length of probation varies depending on the court's decision.";
        }
        else if (
            input.includes("ano mangyayari") ||
            input.includes("parusa") ||
            input.includes("violation") ||
            input.includes("kapag nilabag") ||
            input.includes("what happens if") ||
            input.includes("violation")
        ) {
            reply = "Kapag nilabag ang probation, maaaring bawiin ng korte ito at ipataw ang orihinal na sentensya. / If probation is violated, the court may revoke it and impose the original sentence.";
        }
        else if (
            input.includes("saan basahin") ||
            input.includes("saan ako makakabasa") ||
            input.includes("pdf") ||
            input.includes("read more") ||
            input.includes("more")
        ) {
            reply = `Maaari kang magbasa pa sa pamamagitan ng <a href="assets/content_uploads/FAQ_Probation.pdf" target="_blank" rel="noopener noreferrer">pag-click dito</a>. / You can read more by <a href="assets/content_uploads/FAQ_Probation.pdf" target="_blank" rel="noopener noreferrer">clicking here</a>.`;
        }

        // Show user's message
        chatLog.innerHTML += `<div><strong>Ikaw:</strong> ${inputValue !== null ? inputValue : inputElement.value}</div>`;

        // Show typing indicator
        typingIndicator.style.display = "block";

        // Animate dots
        if (!window.typingDotsInterval) {
            const dots = document.getElementById("dots");
            let dotCount = 1;
            window.typingDotsInterval = setInterval(() => {
                dotCount = (dotCount % 3) + 1;
                dots.textContent = '.'.repeat(dotCount);
            }, 400);
        }


        // Simulate typing delay
        setTimeout(() => {
            chatLog.innerHTML += `<div><strong>Assistant:</strong> ${reply}</div><hr>`;
            inputElement.value = "";
            chatLog.scrollTop = chatLog.scrollHeight;
            typingIndicator.style.display = "none";
            clearInterval(window.typingDotsInterval);
            window.typingDotsInterval = null;
            document.getElementById("dots").textContent = '.';
        }, 1000);
    }



    // Add sample question buttons after DOM loads
    document.addEventListener("DOMContentLoaded", () => {
        const sampleQuestions = [
            "Ano ang probation?",
            "What is probation?",
            "Ano ang mga benepisyo ng probation?",
            "What are the benefits of probation?",
            "Sino ang pwedeng mag-apply ng probation?",
            "Who can apply for probation?",
            "Gaano katagal ang probation?",
            "How long is probation?",
            "Ano ang mangyayari kapag nilabag ang probation?",
            "What happens if probation is violated?",
            "Saan ako makakabasa ng PDF?",
            "Where can I read more?",
        ];

        const container = document.createElement("div");
        container.style.marginTop = "15px";
        container.style.display = "flex";
        container.style.flexWrap = "wrap";
        container.style.gap = "10px";

        sampleQuestions.forEach(q => {
            const btn = document.createElement("button");
            btn.className = "btn btn-outline-secondary btn-sm";
            btn.textContent = q;
            btn.style.cursor = "pointer";
            btn.onclick = () => chat(q);
            container.appendChild(btn);
        });

        document.querySelector(".chatbox").appendChild(container);
    });
</script>


<?php display_footer(); ?>