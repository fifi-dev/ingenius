<?php
/**
 * Template Name: Home
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package fideline-theme
 */
get_header();
?>
<section class="section1">
    <div class="div_left">
        <h1>A unique learning and networking experience</h1>
        <p>The International University of Monaco (Licensed &recognized by the Government of the Principality of Monaco and Accredited by AMBA & AACSB) offers outstanding teaching in its small, connected, stimulating, cross-cultural environment fostering an entrepreneurial spirit, collaborative work, experiential learning and mutual understanding among students, faculty and staff.
    </p>
    </div>
    <div class="form">
    <?php
 echo do_shortcode("[welcome-form]"); ?>
    </div>
</section>

<!-- Nos programmes -->
<section class="section2">
    <h1>Nos programmes</h1>
    <div class="cards">
        <!-- bachelor -->
        <div class="card">
            <div class="card_img">
            <img src="./wp-content/themes/fideline-theme/sass/img/bachelor.png" height="100%" width="100%">
            </div>
            <div class="card_body">
                <h3>Bachelor</h3>
                <p>(BBA)</p>
            </div>
        </div>
        <!-- Mcs in Finance -->
        <div class="card">
            <div class="card_img">
            <img src="./wp-content/themes/fideline-theme/sass/img/finance.png" height="100%" width="100%">
            </div>
            <div class="card_body">
                <h2>Mcs in Finance</h2>
            </div>
        </div>
        <!-- Mcs in Lucury Management -->
        <div class="card">
            <div class="card_img">
            <img src="./wp-content/themes/fideline-theme/sass/img/luxury_management.png" height="100%" width="100%">
            </div>
            <div class="card_body">
                <h2>Mcs in Lucury Management</h2>
            </div>
        </div>
        <!-- Mcs in Marketing for Lucury Goods & Services -->
        <div class="card">
            <div class="card_img">
            <img src="./wp-content/themes/fideline-theme/sass/img/marketing.png" height="100%" width="100%">
            </div>
            <div class="card_body">
                <h2>Mcs in Marketing for Lucury Goods & Services</h2>
            </div>
        </div>
        <!-- Mcs in International Management -->
        <div class="card">
            <div class="card_img">
            <img src="./wp-content/themes/fideline-theme/sass/img/international_management.png" height="100%" width="100%">
            </div>
            <div class="card_body">
                <h2>Mcs in International Management</h2>
            </div>
        </div>
        <!-- Mcs in Sport Business Management -->
        <div class="card">
            <div class="card_img">
            <img src="./wp-content/themes/fideline-theme/sass/img/sport.png" height="100%" width="100%">
            </div>
            <div class="card_body">
                <h2>Mcs in Sport Business Management</h2>
            </div>
        </div>
        <!-- MBA -->
        <div class="card">
            <div class="card_img">
            <img src="./wp-content/themes/fideline-theme/sass/img/mba.png" height="100%" width="100%">
            </div>
            <div class="card_body">
                <h2>MBA</h2>
            </div>
        </div>
        <!-- DBA -->
        <div class="card">
            <div class="card_img">
            <img src="./wp-content/themes/fideline-theme/sass/img/dba.png" height="100%" width="100%">
            </div>
            <div class="card_body">
                <h2>DBA</h2>
            </div>
        </div>

    </div>
    <div class="btn">
    <button class="btn">DISCOVER ALL PROGRAMS</button>
    </div>
</section>

<!-- Pourquoi choisir IUM -->

<section class="section3">
    <h1> Pourquoi choisir IUM ?</h1>
    <div class="flex">
        <div class="lDiv">
        <img src="./wp-content/themes/fideline-theme/sass/img/video.png" height="100%" width="100%" alt="aperçu vidéo">
        </div>
        <div class="rDiv">
            <div class="block">
                <div class="picto">
                    <img src="./wp-content/themes/fideline-theme/sass/img/picto.png" alt="pictogramme">
                </div>
                <div>
                    <h3>Multi-cultural environment</h3>
                    <p>70+ different nationalities represented in the student body and in the faculty. This multicultural setting nurtures a constant exchange of knowledge and viewpoints enhancing the overall academic experience.</p>
                </div>
            </div>
            <!-- Monaco Experience -->
            <div class="block">
                <div class="picto">
                    <img src="./wp-content/themes/fideline-theme/sass/img/picto.png" alt="pictogramme">
                </div>
                <div>
                    <h3>Monaco Experience</h3>
                    <p>Monaco is a unique economic model, the country offers an unparalleled gateway to successful companies that work right on IUM doorstep.</p>
                </div>
            </div>
            <!-- Entrepreneurial mindset -->
            <div class="block">
                <div class="picto">
                    <img src="./wp-content/themes/fideline-theme/sass/img/picto.png" alt="pictogramme">
                </div>
                <div>
                    <h3>Entrepreneurial mindset </h3>
                    <p>At IUM we help students to develop an entrepreneurial mindset and the creative leadership skills to excel both in the startup and the enterprise environments.</p>
                </div>
            </div>
            <!-- Individual support-->
            <div class="block">
                <div class="picto">
                    <img src="./wp-content/themes/fideline-theme/sass/img/picto.png" alt="pictogramme">
                </div>
                <div>
                    <h3>Individual support </h3>
                    <p>Professors, professional advisors, and alumni are there to ensure that all students have the same opportunities to fulfil their potential.</p>
                </div>
            </div>
            <!-- Our faculty is composed of -->
            <div class="block">
                <div class="picto">
                    <img src="./wp-content/themes/fideline-theme/sass/img/picto.png" alt="pictogramme">
                </div>
                <div>
                    <h3>Our faculty is composed of : </h3>
                    <p>• Permanent, affiliate and visiting professors from some of the top international business schools. <br>
• Professionals and entrepreneurs sharing their own stories and experiences.</p>
                </div>
            </div>
        </div>
        
    </div>
    <div class="btn">
    <button class="btn">Apply</button>
    </div>
</section>

<!--Accréditations -->
<section class="section4">
    <h1>Accreditations</h1>
    <div class="flex">
        <div class="left">
        <img src="./wp-content/themes/fideline-theme/sass/img/amba.png" alt="AMBA">
        </div>
        <div class="right">
        <img src="./wp-content/themes/fideline-theme/sass/img/aacsb.png" alt="ACCSB">
        </div>
    </div>
</section>
