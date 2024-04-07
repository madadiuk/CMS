<?php
  /**
   * WebPageTemplateView.php  * Sessions: PHP web application to demonstrate how databases
   * are accessed securely
   *
   *
   * @author CF Ingrams - cfi@dmu.ac.uk
   * @copyright De Montfort University
   *
   * @package petshow
   */


  class WebPageTemplateView {
    protected $page_title;
    protected $html_page_content;
    protected $html_page_output;
      /**
       * @var string
       */

      public function __construct() {
        $this->page_title = '';
        $this->html_page_content = '';
        $this->html_page_output = '';
    }
      public function __destruct(){}
     public function createWebPage()
     {
         $this->createHeadSection();
         $this->createHeader();
//         $this->createFooter();
     }

    protected function createHeadSection() {
        $css_path = CSS_PATH;
        $css_filename = 'style.css'; // Assuming you have a main stylesheet named style.css
        $css_animate_filename = 'animate.css'; // Assuming you have a main stylesheet named animate.css
        $custom_scripts = 'custom-scripts.css'; // Assuming you have a main stylesheet named custom-scripts.css
        $css_index = 'index.css'; // Assuming you have a main stylesheet named style.css
        $html_output = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
     <title>$this->page_title</title>
    <meta property="og:title" content="Main" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8" />
    <meta property="twitter:card" content="summary_large_image" />
    <link rel="stylesheet" href="{$css_path}{$css_filename}" type="text/css" />
    <link rel="stylesheet" href="{$css_path}{$css_animate_filename}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" />
    <link rel="stylesheet" href="{$css_path}{$custom_scripts}" />
    <link rel="stylesheet" href="{$css_path}{$css_index}" />
    <style>
        html { scroll-behavior: smooth; }
        /* Additional in-line CSS can be placed here */
    </style>
    <style data-tag="reset-style-sheet">
      html {  line-height: 1.15;}body {  margin: 0;}* {  box-sizing: border-box;  border-width: 0;  border-style: solid;}p,li,ul,pre,div,h1,h2,h3,h4,h5,h6,figure,blockquote,figcaption {  margin: 0;  padding: 0;}button {  background-color: transparent;}button,input,optgroup,select,textarea {  font-family: inherit;  font-size: 100%;  line-height: 1.15;  margin: 0;}button,select {  text-transform: none;}button,[type="button"],[type="reset"],[type="submit"] {  -webkit-appearance: button;}button::-moz-focus-inner,[type="button"]::-moz-focus-inner,[type="reset"]::-moz-focus-inner,[type="submit"]::-moz-focus-inner {  border-style: none;  padding: 0;}button:-moz-focus,[type="button"]:-moz-focus,[type="reset"]:-moz-focus,[type="submit"]:-moz-focus {  outline: 1px dotted ButtonText;}a {  color: inherit;  text-decoration: inherit;}input {  padding: 2px 4px;}img {  display: block;}html { scroll-behavior: smooth  }
    </style>
    <style data-tag="default-style-sheet">
      html {
        font-family: Raleway;
        font-size: 18px;
      }

      body {
        font-weight: 400;
        font-style:normal;
        text-decoration: none;
        text-transform: none;
        letter-spacing: normal;
        line-height: 1.55;
        color: var(--dl-color-gray-black);
        background-color: var(--dl-color-gray-white);

      }
    </style>
   
  </head>
  <body>
    <div>
      <div class="home-container">
HTML;

        $this->html_page_output .= $html_output ;
    }


    protected function createHeader() {
        $html_output = <<<HTML
<div data-role="Header" class="home-navbar-container">
    <div class="home-navbar">
        <div class="home-left-side">
            <img alt="image" src="https://madadi.uk/logoCrypto.png" class="home-image" />
            <div data-role="BurgerMenu" class="home-burger-menu">
                <svg viewBox="0 0 1024 1024" class="home-icon">
                    <path d="M128 256h768v86h-768v-86zM128 554v-84h768v84h-768zM128 768v-86h768v86h-768z"></path>
                </svg>
            </div>
            <div class="home-links-container">
                <a href="/" class="home-link Anchor">home</a>
                <a href="#events" class="home-link02 Anchor">events</a>
                <a href="#devices" class="home-link03 Anchor">devices</a>
             
                
            </div>
        </div>
        <div class="home-right-side">
            <button type="button" class="home-cta-btn Anchor button">login</button>
        </div>
        <div data-role="MobileMenu" class="home-mobile-menu">
            <div class="home-container1">
                <img alt="image" src="https://play.teleporthq.io/static/svg/default-img.svg" class="home-image1" />
                <div data-role="CloseMobileMenu" class="home-close-menu">
                    <svg viewBox="0 0 1024 1024" class="home-icon02">
                        <path d="M810 274l-238 238 238 238-60 60-238-238-238 238-60-60 238-238-238-238 60-60 238 238 238-238z"></path>
                    </svg>
                </div>
            </div>
            <div class="home-links-container1">
                <a href="#resources" class="home-link04 Anchor">home</a>
                <span class="home-link05 Anchor">events</span>
                <a href="#process" class="home-link06 Anchor">devices</a>
                <a href="#ourstory" class="home-link07 Anchor">Our story</a>
            </div>
        </div>
    </div>
</div>
HTML;

        $this->html_page_output .= $html_output;
    }


    protected function createFooter() {
        // Assuming you've defined JS_PATH and the JavaScript filename somewhere
        $js_path = JS_PATH;
        $js_filename = 'main.js'; // Example JavaScript filename

        $footer = <<<HTML
        <div class="home-section-separator2"></div>
        <div class="home-get-in-touch">
            <h2 class="home-text29 Section-Heading">Get in touch</h2>
            <div class="home-content-container6">
                <div class="home-locations-container">
                    <div class="home-location-1">
                        <span class="home-heading2">Leicester, UK</span>
                        <div class="home-adress">
                            <svg viewBox="0 0 1024 1024" class="home-icon36">
                                <path d="M512 0c-176.732 0-320 143.268-320 320 0 320 320 704 320 704s320-384 320-704c0-176.732-143.27-320-320-320zM512 512c-106.040 0-192-85.96-192-192s85.96-192 192-192 192 85.96 192 192-85.96 192-192 192z"></path>
                            </svg>
                            <span class="Section-Text">Address: De Montfort University</span>
                        </div>
                        <div class="home-email">
                            <svg viewBox="0 0 1024 1024" class="home-icon38">
                                <path d="M854 342v-86l-342 214-342-214v86l342 212zM854 170q34 0 59 26t25 60v512q0 34-25 60t-59 26h-684q-34 0-59-26t-25-60v-512q0-34 25-60t59-26h684z"></path>
                            </svg>
                            <span class="Section-Text">E-mail Address: Mo@Madadi.Uk, edurosa0105@gmail.com </span>
                        </div>
                        <div class="home-phone">
                            <svg viewBox="0 0 804.5714285714286 1024" class="home-icon40">
                                <path d="M804.571 708.571c0 20.571-9.143 60.571-17.714 79.429-12 28-44 46.286-69.714 60.571-33.714 18.286-68 29.143-106.286 29.143-53.143 0-101.143-21.714-149.714-39.429-34.857-12.571-68.571-28-100-47.429-97.143-60-214.286-177.143-274.286-274.286-19.429-31.429-34.857-65.143-47.429-100-17.714-48.571-39.429-96.571-39.429-149.714 0-38.286 10.857-72.571 29.143-106.286 14.286-25.714 32.571-57.714 60.571-69.714 18.857-8.571 58.857-17.714 79.429-17.714 4 0 8 0 12 1.714 12 4 24.571 32 30.286 43.429 18.286 32.571 36 65.714 54.857 97.714 9.143 14.857 26.286 33.143 26.286 50.857 0 34.857-103.429 85.714-103.429 116.571 0 15.429 14.286 35.429 22.286 49.143 57.714 104 129.714 176 233.714 233.714 13.714 8 33.714 22.286 49.143 22.286 30.857 0 81.714-103.429 116.571-103.429 17.714 0 36 17.143 50.857 26.286 32 18.857 65.143 36.571 97.714 54.857 11.429 5.714 39.429 18.286 43.429 30.286 1.714 4 1.714 8 1.714 12z"></path>
                            </svg>
                            <span class="Section-Text">0116 255 1551</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="home-section-separator3"></div>
        <div class="home-footer-container">
            <div class="home-footer">
                <div class="home-social-links">
                    <svg viewBox="0 0 950.8571428571428 1024" class="home-icon42">
                <path
                  d="M925.714 233.143c-25.143 36.571-56.571 69.143-92.571 95.429 0.571 8 0.571 16 0.571 24 0 244-185.714 525.143-525.143 525.143-104.571 0-201.714-30.286-283.429-82.857 14.857 1.714 29.143 2.286 44.571 2.286 86.286 0 165.714-29.143 229.143-78.857-81.143-1.714-149.143-54.857-172.571-128 11.429 1.714 22.857 2.857 34.857 2.857 16.571 0 33.143-2.286 48.571-6.286-84.571-17.143-148-91.429-148-181.143v-2.286c24.571 13.714 53.143 22.286 83.429 23.429-49.714-33.143-82.286-89.714-82.286-153.714 0-34.286 9.143-65.714 25.143-93.143 90.857 112 227.429 185.143 380.571 193.143-2.857-13.714-4.571-28-4.571-42.286 0-101.714 82.286-184.571 184.571-184.571 53.143 0 101.143 22.286 134.857 58.286 41.714-8 81.714-23.429 117.143-44.571-13.714 42.857-42.857 78.857-81.143 101.714 37.143-4 73.143-14.286 106.286-28.571z"
                ></path></svg
              ><svg viewBox="0 0 877.7142857142857 1024" class="home-icon44">
                <path
                  d="M713.143 73.143c90.857 0 164.571 73.714 164.571 164.571v548.571c0 90.857-73.714 164.571-164.571 164.571h-107.429v-340h113.714l17.143-132.571h-130.857v-84.571c0-38.286 10.286-64 65.714-64l69.714-0.571v-118.286c-12-1.714-53.714-5.143-101.714-5.143-101.143 0-170.857 61.714-170.857 174.857v97.714h-114.286v132.571h114.286v340h-304c-90.857 0-164.571-73.714-164.571-164.571v-548.571c0-90.857 73.714-164.571 164.571-164.571h548.571z"
                ></path></svg
              ><svg viewBox="0 0 877.7142857142857 1024" class="home-icon46">
                <path
                  d="M585.143 512c0-80.571-65.714-146.286-146.286-146.286s-146.286 65.714-146.286 146.286 65.714 146.286 146.286 146.286 146.286-65.714 146.286-146.286zM664 512c0 124.571-100.571 225.143-225.143 225.143s-225.143-100.571-225.143-225.143 100.571-225.143 225.143-225.143 225.143 100.571 225.143 225.143zM725.714 277.714c0 29.143-23.429 52.571-52.571 52.571s-52.571-23.429-52.571-52.571 23.429-52.571 52.571-52.571 52.571 23.429 52.571 52.571zM438.857 152c-64 0-201.143-5.143-258.857 17.714-20 8-34.857 17.714-50.286 33.143s-25.143 30.286-33.143 50.286c-22.857 57.714-17.714 194.857-17.714 258.857s-5.143 201.143 17.714 258.857c8 20 17.714 34.857 33.143 50.286s30.286 25.143 50.286 33.143c57.714 22.857 194.857 17.714 258.857 17.714s201.143 5.143 258.857-17.714c20-8 34.857-17.714 50.286-33.143s25.143-30.286 33.143-50.286c22.857-57.714 17.714-194.857 17.714-258.857s5.143-201.143-17.714-258.857c-8-20-17.714-34.857-33.143-50.286s-30.286-25.143-50.286-33.143c-57.714-22.857-194.857-17.714-258.857-17.714zM877.714 512c0 60.571 0.571 120.571-2.857 181.143-3.429 70.286-19.429 132.571-70.857 184s-113.714 67.429-184 70.857c-60.571 3.429-120.571 2.857-181.143 2.857s-120.571 0.571-181.143-2.857c-70.286-3.429-132.571-19.429-184-70.857s-67.429-113.714-70.857-184c-3.429-60.571-2.857-120.571-2.857-181.143s-0.571-120.571 2.857-181.143c3.429-70.286 19.429-132.571 70.857-184s113.714-67.429 184-70.857c60.571-3.429 120.571-2.857 181.143-2.857s120.571-0.571 181.143 2.857c70.286 3.429 132.571 19.429 184 70.857s67.429 113.714 70.857 184c3.429 60.571 2.857 120.571 2.857 181.143z"
                ></path>
              </svg>
                </div>
                <div class="home-copyright-container">
                    <svg viewBox="0 0 1024 1024" class="home-icon48">
                <path
                  d="M512 854q140 0 241-101t101-241-101-241-241-101-241 101-101 241 101 241 241 101zM512 86q176 0 301 125t125 301-125 301-301 125-301-125-125-301 125-301 301-125zM506 390q-80 0-80 116v12q0 116 80 116 30 0 50-17t20-43h76q0 50-44 88-42 36-102 36-80 0-122-48t-42-132v-12q0-82 40-128 48-54 124-54 66 0 104 38 42 42 42 98h-76q0-14-6-26-10-20-14-24-20-20-50-20z"
                ></path>
              </svg>
              <span class="Anchor">Copyright, De Montfort University 2024</span>
                </div>
            </div>
        </div>
    </div>
<script src="{$js_path}{$js_filename}"></script>
</div>
</body>
HTML;

        $this->html_page_output .= $footer;
    }


    protected function addJavaScriptFiles() {
        echo 'Adding JavaScript files...<br>';

        // Assuming JS_PATH and a hypothetical JS_FILE_NAME have been defined somewhere in your application settings
        $js_path = JS_PATH; // E.g., '/app/public/js/'
        $js_filenames = ['index.umd.js']; // Example array of JS filenames you want to include

        $scripts = '';
        foreach ($js_filenames as $js_filename) {
            $scripts .= "<script src=\"{$js_path}{$js_filename}\"></script>\n";
        }

        $this->html_page_output .= $scripts;
    }

    // This method needs to be implemented by subclasses to add page-specific content


    public function generateHTML() {
        echo 'Generating HTML...<br>';

        $this->addJavaScriptFiles(); // Add JS files at the end of the body
        $this->createPageContent(); // Generate the specific page content
        echo 'Generated HTML.<br>';

        return $this->html_page_output;
    }

}