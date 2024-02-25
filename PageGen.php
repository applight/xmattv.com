<?php
require_once("./FormBuilder.php");
require_once("./FileUserManagement.php");

session_start();

class PageGen {

    private static $DEBUG = true;

    private static $instance = null;
    public static function title($title) { 
        if ( self::$instance == null ) self::$instance = new PageGen($title);
        return self::$instance; 
    }
    public static function get() {
        if ( self::$instance == null ) self::$instance = new PageGen(" . . . ");
        return self::$instance;
    }

    private $title;
    private $navElements = [];

    private function __construct($title) {
        $this->title = $title;
    }

    /**
     * Content can be a function or a string literal, a string literal is simply echo'ed
     * a function, however, is called, with (if supplied) the arguments in array $arguments
     * content must return a string
     */
    public function contentWrap( $content, $arguments=[] ) {
        $pageString = $this->html() . $this->head() 
            . "<body class=\"is-preload\">" . $this->header() 
            . $this->nav() . $this->banner();

        // insert page content either as string literal or result of calling $content()
        switch ( gettype($content) ) {
            case "string":
                $pageString .= $content;
                break;

            case "object":
                if ( get_class($content) == "Closure" ) {
                    $pageString .= ( gettype($arguments) == "array" && $arguments != [] ? $content(...$arguments) : $content() ); 
                } 
                break;

            default:
                break;
        }

        return $pageString . $this->footer() . $this->tailscripts() . $this->closing();
    }

    public function page( $middle, $args=[] ) {
        return $this->html() . $this->head() 
        . "<body class=\"is-preload\">" . $this->header() . $this->nav() . $this->banner() 
        . $this->$middle(...$args) 
        . $this->footer() . $this->tailscripts() . $this->closing();
    }

    public function html() {
        return <<<EOF
        <!DOCTYPE html>
        <html>
        EOF;
    }

    public function closing() {
        return "</body></html>";
    }

    public function head($morecss=null) {
        return  '<head><title>' . $this->title . '</title>'
            . '<meta charset="utf-8" />'
            . '<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />'
            . '<meta name="description" content="" />'
            . '<meta name="keywords" content="" />'
            . '<link rel="stylesheet" href="assets/css/main.css" />'
            . '<link rel="stylesheet" href="assets/css/messages.css" />'
            .  ($morecss != null ? '<link rel="stylesheet" href="assets/css/'.$morecss.'" />' : '')
            . '</head>';
    }

    public function header() {
        return '<header id="header">'
        .'<a class="logo" href="index.php">' . $this->title . '</a>'
        .'<nav><a href="#menu">Menu</a></nav></header>';
    }

    public function nav( $items=[] ) {
        $items != []  ?? $this->navElements = $items;
          
        if ( $items == [] ) {
            return "<nav id=\"menu\">" 
            ."<ul class=\"links\">" 
            ."<li><a href=\"index.php\">Home</a></li>"
            ."<li><a href=\"resume.php\">Resume</a></li>" 
            ."<li><a href=\"blog.php\">Blog</a></li>" 
            ."<li><a href=\"sms.php\">Two way messaging</a></li>" 
            ."<li><a href=\"assistant.php\">Twilio Assistant</a></li>" 
            ."<li><a href=\"" 
            . ( isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] ? "logout.php\">Log Out</a></li>" : "login.php\">Log In</a></li><li><a href=\"register.php\">Register</a></li>")
            ."</ul></nav>";
        } elseif ( gettype($items) == "array" ) {
            $ul = "<ul class=\"links\">";
            foreach($items as $text => $uri ) {
                $li = "<li><a href=\"{$uri}\">{$text}</a></li>";
                $ul .= $li;
            }
            
            $ul .= "</ul>";
            return "<nav id=\"menu\">" . $ul . "</nav>";
        } elseif ( gettype($items) == "object" ) {
            //TODO:
            // build the nav bar based on a well formed objects 'instructions'
        } else {
            return "<nav id=\"menu\"><ul class=\"links\"><li>Broken nav</li></ul></nav>";
        }
    }

    public function banner() {
        return <<<EOF
        <section id="banner" style="background-image: url('./images/banner.jpg');">
            <div class="inner">
            <h1>Life Philosophy</h1>
            <p>"Live a good life. <br />If there are gods and they are just, then they will not care how devout you have been, but will welcome you based on the virtues you have lived by. If there are gods, but unjust, then you should not want to worship them. If there are no gods, then you will be gone, but will have lived a noble life that will live on in the memories of your loved ones." <br /> --Marcus Aurelius
                <p>
            </div>
        </section>
        EOF;
    }

    public function footer() {
        return '<footer id="footer">'
        . '<div class="inner">'
        . '<div class="content">'
        . '<section>'
        . ' <h3>Consistent effort over time</h3>'
        . '  <p>Most skills can be learned to a suprising level of mastery with a few minutes to a few hours at a time, daily or weekly, until one finds themself satisfied they have made a real x-y-z of themself</p>'
        . '</section>'
        . '<section>'
        . ' <h4>Things I want to support</h4>'
        . '  <ul class="alt">'
        . '   <li><a href="http://duolingo.com">Duolingo - My starting point for any new language.</a></li>'
        . '   <li><a href="http://twilio.com">Twilio - Awesome communications platform</a></li>'
        . '  </ul>'
        . ' </section>'
        . '<section>'
        . '<h4>Me on social media</h4>'
        . '<ul class="plain">'
        . ' <li><a href="https://github.com/applight"><i class="icon fa-github">&nbsp;</i>Github</a></li>'
        . ' <li><a href="https://www.linkedin.com/in/xmvaughan/"><i class="icon fa-linkedin">&nbsp;</i>LinkedIn</a></li>'
        . ' <li><a href="https://www.facebook.com/m.v.n.x.x"><i class="icon fa-facebook">&nbsp;</i>Facebook</a></li>'
        . ' <li><a href="https://www.instagram.com/x.mattv/"><i class="icon fa-instagram">&nbsp;</i>Instagram</a></li>'
        . '</ul>'
        . '</section></div></div></footer>';
    }

    public function tailscripts() {
        return '<script src="assets/js/jquery.min.js"></script>'
            .'<script src="assets/js/browser.min.js"></script>'
            .'<script src="assets/js/breakpoints.min.js"></script>'
            .'<script src="assets/js/util.js"></script>'  
            .'<script src="assets/js/main.js"></script>';
    }
    
    public function regForm() {
        $fb = new FormBuilder('POST', './verify.php');
        $fb->name("First Name", "first", "first", true);
        $fb->name("Last Name", "last", "last", true);
        $fb->email("email", true);
        $fb->phone("phone", true);
        $fb->submit("Register");
        return $fb->toString();
    }

    public function login() {
        $fb = new FormBuilder('POST', './login.php');
        $fb->phone("phone", true);  
        return $fb->toString();
    }

    public function otp($phone, $nextUrl) {

        $fb = new FormBuilder('POST', $nextUrl);
        $fb->code("code");
        $fb->hidden("phone", "phone", $phone);
        $fb->submit("Verify OTP");
        return $fb->toString();
    }

    public function clickAdvance($url, $message) {
        $fb = new FormBuilder('POST', $url);
        $fb->submit($message);
        return $fb->toString();
    }

    public function redirect($url) {
        return <<<EOF
        <script>
        setTimeout( function () {{ window.location.href='{$url}'; }}, 1500 ); 
        </script>
        EOF;
    }

    public function optin() {
        $fb = new FormBuilder('POST','./final.php');
        $fb->text("Number","number","number","[\+]?[0-9]+",true,"+18005551212");
        $fb->submit("Opt In");
        return <<<EOF
            Enter phone number to opt in to alerts here: {$fb->toString()}
            EOF;
    }
};

?>