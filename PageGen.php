<?php

class PageGen {

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

    private function __construct($title) {
        $this->title = $title;
    }

    public function head($morecss=null) {
        return '<head><title>' . $this->title . '</title>'
            . '<meta charset="utf-8" />'
            . '<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />'
            . '<meta name="description" content="" />'
            . '<meta name="keywords" content="" />'
            . '<link rel="stylesheet" href="assets/css/main.css" />'
            .  ($morecss != null ? '<link rel="stylesheet" href="assets/css/'.$morecss.'" />' : '')
            . '</head>';
    }

    public function header() {
        return '<header id="header">'
        .'<a class="logo" href="index.php">' . $this->title . '</a>'
        .'<nav><a href="#menu">Menu</a></nav></header>';
    }

    public function nav() {
        return "<nav id=\"menu\">" 
        ."<ul class=\"links\">" 
        ."<li><a href=\"index.php\">Home</a></li>" 
        ."<li><a href=\"resume.php\">Resume</a></li>" 
        ."<li><a href=\"blog.php\">Blog</a></li>" 
        ."<li><a href=\"sms.php\">Two way messaging</a></li>" 
        ."<li><a href=\"assistant.php\">Twilio Assistant</a></li>" 
        ."</ul></nav>";
    }

    public function footer() {
        return '<footer id="footer">'
        . '<div class="inner">'
        . '<div class="content">'
        . '<section>'
        . ' <h3>Consistent effort over time</h3>'
        . '  <p>Nunc lacinia ante nunc ac lobortis. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus ornare mi ut ante amet placerat aliquet. Volutpat eu sed ante lacinia sapien lorem accumsan varius montes viverra nibh in adipiscing. Lorem ipsum dolor vestibulum ante ipsum primis in faucibus vestibulum. Blandit adipiscing eu felis iaculis volutpat ac adipiscing sed feugiat eu faucibus. Integer ac sed amet praesent. Nunc lacinia ante nunc ac gravida.</p>'
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
        . ' <li><a href="https://github.com/xmvaughan"><i class="icon fa-github">&nbsp;</i>Github</a></li>'
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

    public function optin() {
        return '<form><span> Enter phone number to opt in to alerts here: <input type="text"></input><input type="submit"/></span>';
    }

};

?>