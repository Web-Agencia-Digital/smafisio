<?php header("Content-type: text/css"); ?>
<?php

/*
 * Para customizar o menu, acesse:  http://smarchal.com/twbscolor/?bd=048FD2&bh=047AB5&cd=ffffff&ch=f0f0f0
 * altere as cores e copie os valores para as variaveis abaixo
 */
/*
  $bd = '048FD2';
  $bh = '047AB5';
  $cd = 'ffffff';
  $ch = 'dcdcdc';
  $bk = '000';
  $bd_cat = 'F74141';
  $bh_cat = 'FF3333';
  $cd_cat = 'ecf0f1';
  $ch_cat = 'ecdbff';
  $bk_cat = '000';
 */
/*
  $bd = '9b59b6';
  $bh = '8e44ad';
  $cd = 'ecf0f1';
  $ch = 'ecdbff';
  $bk = '000';
 */

function get_color($c)
{
    return strip_tags($_GET["$c"]);
}

$bd = get_color('bd');
$bh = get_color('bh');
$cd = get_color('cd');
$ch = get_color('ch');
//$bk = get_color('bk');
$bt = get_color('bt');


$bd_cat = $bd;
$bh_cat = $bh;
$cd_cat = $cd;
$ch_cat = $ch;
//$bk_cat = $bk;


$style = "
.ch{color:#$ch !important;}
.cd{color:#$cd !important;}
.bd{color:#$bd !important;}
.bh{color:#$bh !important;}

/*TOP LOGO*/
#top {background: #$bt !important;padding-bottom:17px; min-height:100px}
/*SLIDE CONTROLS*/
.carousel-control.left,
.carousel-control.right {
    filter: alpha(opacity=10);
    opacity: 1;
    background-image: none;
    background-repeat: no-repeat;
    text-shadow: none;
    color: #$bd !important;
}
/* LOGIN */
.panel-custom{
    background: #$bd !important;
    color: #000 !important;
}
/* BG */
.bg-custom{ background: #$bd !important; }

/* FOOTER CONDICOES */
#footer-condicoes{
    background: #$bd;
    color: #$cd;
    padding: 15px;
}
#footer-company{
    background: #$bh;
    color: #$cd;
     padding: 15px;
}
/* BTN */
.btn-custom{
    background: #$bd !important;
    color: #$cd !important;
}
.btn-custom:hover{
    color: #$cd !important;
}
.btn-default{
    background: #$bh !important;
    color:#$cd !important;
}
.btn-default:hover{
    background: #$bd !important;
}

/* ALERT-CUSTOM BG */
.alert-custom{
    font-size: 18px !important;
    background: #$bd;
    color: #$cd;
    padding:6px !important;
}

/*LABEL-SUCCESS*/
.label-success{ background:#$bd !important;}

/* CORES SLIDER RANGE PREÇO */
  .slider-handle {background-color: #$bh !important;}
  .slider-handle {background: #$bh !important;}
  .slider-track{background-color: #$bh !important;}
  .slider-track{background: #$bh !important;}
  .slider-selection{background-color: #$ch !important;}
  .slider-selection{background: #$ch !important;}
/*FIM CORES SLIDER RANGE PREÇO */

/*CORES TOOLTIPS HOVER BOOTSTRAP*/
.tooltip-inner {
    max-width: 200px;
    padding: 3px 8px;
    color: #$ch;
    text-align: center;
    text-decoration: none;
    background-color: #$bh;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
.tooltip-arrow {
    position: absolute;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
}
.tooltip.top .tooltip-arrow {
    bottom: 0;
    left: 50%;
    margin-left: -5px;
    border-top-color: #$bh;
    border-width: 5px 5px 0;
}
.tooltip.right .tooltip-arrow {
    top: 50%;
    left: 0;
    margin-top: -5px;
    border-right-color: #$bh;
    border-width: 5px 5px 5px 0;
}
.tooltip.left .tooltip-arrow {
    top: 50%;
    right: 0;
    margin-top: -5px;
    border-left-color: #$bh;
    border-width: 5px 0 5px 5px;
}
.tooltip.bottom .tooltip-arrow {
    top: 0;
    left: 50%;
    margin-left: -5px;
    border-bottom-color: #$bh;
    border-width: 0 5px 5px;
}
/*FIM CORES TOOLTIPS HOVER BOOTSTRAP*/
.box-item:hover{
    -webkit-transition: all 0.4s ease-in-out;
    -moz-transition: all 0.4s ease-in-out;
    -o-transition: all 0.4s ease-in-out;
    -ms-transition: all 0.4s ease-in-out;
    transition: all 0.4s ease-in-out;
    box-shadow:0 0 0 0px #$bh inset;
    border-bottom: 2px solid #$bh !important;
}
.bootstrap-select.btn-group .no-results {
   background: #$cd !important;
}
.bootstrap-select.btn-group .dropdown-menu .notify {
   background: #$cd !important;
}
.bootstrap-select .selected a{
background: #$bh !important;
}

/*CSS PRELOADER CARREGAR/ORDENAR ITENS*/
#movingBallG{
    position:relative;
    width:256px;
    height:20px;
    margin:0 auto !important;
}
.movingBallLineG{
    position:absolute;
    left:0px;
    top:8px;
    height:4px;
    width:256px;
    background-color:#$cd;
}
.movingBallG{
    background-color:#$bh;
    position:absolute;.box-item .label-important{
   background-color: #$bh !important;
   border-radius: 0 0 50px 50px !important;
   padding:10px !important;
   font-size: 12px ;
}
    top:0;
    left:0;
    width:20px;
    height:20px;
    -moz-border-radius:10px;
    -moz-animation-name:bounce_movingBallG;
    -moz-animation-duration:0.5s;
    -moz-animation-iteration-count:infinite;
    -moz-animation-direction:linear;
    -webkit-border-radius:10px;
    -webkit-animation-name:bounce_movingBallG;
    -webkit-animation-duration:0.5s;
    -webkit-animation-iteration-count:infinite;
    -webkit-animation-direction:linear;
    -ms-border-radius:10px;
    -ms-animation-name:bounce_movingBallG;
    -ms-animation-duration:0.5s;
    -ms-animation-iteration-count:infinite;
    -ms-animation-direction:linear;
    -o-border-radius:10px;
    -o-animation-name:bounce_movingBallG;
    -o-animation-duration:0.5s;
    -o-animation-iteration-count:infinite;
    -o-animation-direction:linear;
    border-radius:10px;
    animation-name:bounce_movingBallG;
    animation-duration:0.5s;
    animation-iteration-count:infinite;
    animation-direction:linear;
}
@-moz-keyframes bounce_movingBallG{
    0%{left:0px;}
    50%{left:236px;}
    100%{left:0px;}
}
@-webkit-keyframes bounce_movingBallG{
    0%{left:0px;}
    50%{left:236px;}
    100%{left:0px;}
}
@-ms-keyframes bounce_movingBallG{
    0%{left:0px;}
    50%{left:236px;}
    100%{left:0px;}
}
@-o-keyframes bounce_movingBallG{
    0%{left:0px;}
    50%{left:236px;}
    100%{left:0px;}
}
@keyframes bounce_movingBallG{
    0%{left:0px;}
    50%{left:236px;}
    100%{left:0px;
    }
}
/*FIM PRELOADER*/

/*DIV TODAS A LOJA / CATEGORIAS*/
#lista-categorias{
    width: 100%;
    position: absolute;
    z-index: 600;
    margin-top: 0px;
    background-color: #fafafa;
    padding-top: 5px;
    padding-bottom: 5px;
    min-height:200px;
    border: 0px solid #000;
    border-top: 3px solid #$bh;
    border-bottom: 2px solid #$bh;
}
#lista-categorias a{
    color:#333;
}
#lista-categorias a:hover{
    color: #$bh !important;
    text-decoration:underline;
}
#lista-categorias p b{
    color:#$bh !important;
    font-size:12px;
}
#lista-categorias p{
    padding: 1px;
    margin: 0px;
    font-size: 12px;
    font-family: 'Open Sans';
    font-weight: normal;
}
.depto{
    min-width: 120px;
    margin-right: 10px;
    min-height: 80px;
    float:left;
}
#top-depto{
    border-bottom: 3px solid #$bh;
    height:54px;
    opacity:1 !important;
}
/*FIM DIV TODAS A LOJA / CATEGORIAS*/

/*DIV MENU LATERAL FILTROS */
.menu-filtro b, .menu-filtro strong {
    color: #$bh !important;
}
.filtro-sub-categoria, .filtro-categoria{
 list-style: none !important;
}  
.menu-filtro .filtro-categoria a.active{
    font-weight: bold;
    border-bottom:1px solid #$bh !important;
}
.menu-filtro a{
    color: #$bh;
}
.menu-filtro h5{
    font-family: 'Ubuntu',Helvetica,sans-serif,Arial;
    line-height:30px;
    font-size: 17px;
}
.menu-filtro{
    font-size:13px;
    color:#333;
}
.menu-filtro .filtro-sub-categoria a{
    /*padding-left:6px !important;*/
    font-size:12px;
    color:#555;
}
.menu-filtro  .filtro-sub-categoria a:hover{
    color:#$bh;
}
.menu-filtro  .filtro-sub-categoria a.active{
    color:#$bh;
    font-style:italic;
    border-bottom:1px dotted #$bh !important;
}
.menu-filtro #p-range-preco{
    z-index: 100 !important;
    position: relative !important;
}
/*FIM MENU LATERAL FILTROS */

/*CORES CUSTOM DA NAVBAR BOOTSTRAP*/

.dropdown-menu {background-color: #$bd;}
.dropdown-menu a { color: #$cd !important;}
.dropdown-menu a:hover {background-color: #$bh !important;}
.dropdown-toggle{padding-left:10px !important;padding-right:10px !important;}
.dropdown-toggle:hover {background-color: #$bh !important;}
.navbar-default {
    background-color: #$bd;
    border-color: #$bh;
    border: 0px solid #$bh;
    border-bottom: 3px solid #$bh;
}
.navbar-default .navbar-brand {
    color: #$cd;
}
.navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
    color: #$ch;
}
.navbar-default .navbar-text {
    color: #$cd;
}
.navbar-default .navbar-nav > li > a {
    color: #$cd;
}
.navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
   color: #$ch;
}
.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
    color: #$ch;
    background-color: #$bh;
}
.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
    color: #$ch;
    background-color: #$bh;
}
.navbar-default .navbar-toggle {
   border-color: #$bh;
}
.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
   background-color: #$bh;
}
.navbar-default .navbar-toggle .icon-bar {
   background-color: #$cd;
}
.navbar-default .navbar-collapse,
.navbar-default .navbar-form {
   border-color: #$cd;
}
.navbar-default .navbar-link {
   color: #$cd;
}
.navbar-default .navbar-link:hover {
    color: #$ch;
}

/* NAVBAR CATEGORIAS */

#nav-categoria .dropdown-menu {background-color: #$bd_cat !important;}
#nav-categoria .dropdown-menu a { color: #$cd_cat !important;}
#nav-categoria .dropdown-menu a:hover {background-color: #$bh_cat !important;}
#nav-categoria .dropdown-toggle{padding-left:10px !important;padding-right:10px !important;}
#nav-categoria .dropdown-toggle:hover {background-color: #$bh_cat !important;}
#nav-categoria.navbar-default {
    background-color: #$bd_cat !important;
    border-color: #$bh_cat !important;
    border: 0px solid #$bh_cat !important;
    border-bottom: 3px solid #$bh_cat !important;
}

#nav-categoria.navbar-default .navbar-brand {
    color: #$cd_cat;
}
#nav-categoria.navbar-default .navbar-brand:hover, .navbar-default .navbar-brand:focus {
    color: #$ch_cat;
}
#nav-categoria.navbar-default .navbar-text {
    color: #$cd_cat;
}
#nav-categoria.navbar-default.navbar-nav > li > a {
    color: #$cd_cat;
}
/* centraliza menu  --- remover */
/*
#nav-categoria.navbar-default .navbar-nav {
  width: 100%;
  text-align: center !important;
}
#nav-categoria.navbar-default .navbar-nav   > li {
  float: none;
 display: inline-block;
}
*/
/* end centraliza menu  --- remover */

#nav-categoria.navbar-default.navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
   color: #$ch_cat;
}
#nav-categoria.navbar-default.navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
    color: #$ch_cat;
    background-color: #$bh_cat !important;
}
#nav-categoria.navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
    color: #$ch_cat;
    background-color: #$bh_cat !important;
}
#nav-categoria.navbar-default .navbar-toggle {
   border-color: #$bh_cat;
}
#nav-categoria.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
   background-color: #$bh_cat !important;
}
#nav-categoria.navbar-default .navbar-toggle .icon-bar {
   background-color: #$cd_cat !important;
}
#nav-categoria.navbar-default .navbar-collapse,
#nav-categoria.navbar-default .navbar-form {
   border-color: #$cd_cat !important;
}
#nav-categoria.navbar-default .navbar-link {
   color: #$cd_cat !important;
}
#nav-categoria.navbar-default .navbar-link:hover {
    color: #$ch_cat !important;
}

.2box-item .2label-important{
   background-color: #$bh !important;
   opacity: 0.5 !important;
   border-radius: 5px !important;
   padding:10px !important;
   font-size: 12px ;
}
.box-item .label-important{
   background-color: #$bh !important;
   border-radius: 0 0 90px 90px !important;
   padding:10px !important;
   font-size: 12px ;
}
@media (max-width: 767px) {
    .navbar-default .navbar-nav .open .dropdown-menu > li > a {
       color: #$cd;
    }
    .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
       color: #$ch;
    }
    .navbar-default .navbar-nav .open .dropdown-menu > .active > a, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
        color: #$ch;
        background-color: #$bh;
    }
}
.navbar a{
    /*font-size: 13px !important;*/
}
.navbar .glyphicon{font-size: 15px !important;}
.navbar{
    border-radius:0px;
    -moz-border-radius:0px;
    -webkit-border-radius:0px;
}
.menu-fixed-border{
    border-bottom: 1px solid #$bh;
}
.navbar-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index:900;
    margin-top: 20px;
}
.navbar-wrapper .container {
    padding-left: 0;
    padding-right: 0;
}
.navbar-wrapper .navbar {
    padding-left: 15px;
    padding-right: 15px;
}
.navbar-content{
    padding: 15px;
    padding-bottom:0px;
    color:#$ch !important;
}
.navbar-content:before, .navbar-content:after{
    display: table;
    content: \"\";
    line-height: 0;
}
.navbar-nav.navbar-right:last-child {
    margin-right: 15px !important;
}
.navbar-footer{
    background-color:#$ch !important;
}
.navbar-footer-content { padding:15px 15px 15px 15px; }
.dropdown-menu {
    padding: 0px;
    overflow: hidden;
}
.navbar-content *{
    text-shadow: none !important;
    -moz-text-shadow: none #fff !important;
    -moz-box-shadow:none !important;
    -webkit-box-shadow:none !important;
    background: none;
    text-decoration: none !important;
    color:#$ch !important;
}
/*FIM CORES CUSTOM DA NAVBAR BOOTSTRAP*/
.box-item h3, .box-item h5{
    color: #$bh !important;
}
.transition-timer-carousel .transition-timer-carousel-progress-bar {
    height: 5px;
    background-color: #$bh;
}

/* BREADCRUMB - PRODUTO */

.breadcrumb {
    padding: 0px;
	background: #$bh;
	list-style: none;
	overflow: hidden;
    margin-top: 20px;
}
.breadcrumb>li+li:before {
	padding: 0;
}
.breadcrumb li {
	float: left;
}
.breadcrumb li.active a {
	background: brown;                   /* fallback color */
	background: #$bd;
}
.breadcrumb li.completed a {
	background: brown;                   /* fallback color */
	background: hsla(153, 57%, 51%, 1);
}
.breadcrumb li.active a:after {
	border-left: 30px solid #$bd ;
}
.breadcrumb li.completed a:after {
	border-left: 30px solid $bh;
}

.breadcrumb li a {
	color: white;
	text-decoration: none;
	padding: 10px 0 10px 45px;
	position: relative;
	display: block;
	float: left;
}
.breadcrumb li a:after {
	content: \" \";
	display: block;
	width: 0;
	height: 0;
	border-top: 50px solid transparent;           /* Go big on the size, and let overflow hide */
	border-bottom: 50px solid transparent;
	border-left: 30px solid #$bh;
	position: absolute;
	top: 50%;
	margin-top: -50px;
	left: 100%;
	z-index: 2;
}
.breadcrumb li a:before {
	content: \" \";
	display: block;
	width: 0;
	height: 0;
	border-top: 50px solid transparent;           /* Go big on the size, and let overflow hide */
	border-bottom: 50px solid transparent;
	border-left: 30px solid white;
	position: absolute;
	top: 50%;
	margin-top: -50px;
	margin-left: 1px;
	left: 100%;
	z-index: 1;
}
.breadcrumb li:first-child a {
	padding-left: 15px;
}
.breadcrumb li a:hover { background: #$bd  ; }
.breadcrumb li a:hover:after { border-left-color: #$bd   !important; }
/*HR*/
.separador h1 span {
    padding:0 10px;
}
.separador h1 {
   margin: 10px 0 20px;
   font-size:26px  !important;
   color:#$bd !important;
   overflow: hidden;
   text-align: center;
}
.separador h1:before,
.separador h1:after {
    background-color: #$bd;
    content: \"\";
    display: inline-block;
    height: 1px;
    position: relative;
    vertical-align: middle;
    width: 50%;
}
.separador h1:before {
    right: 0.5em;
    margin-left: -50%;
}
.separador h1:after {
    left: 0.5em;
    margin-right: -50%;
}
.hello-cliente{
    color: #$bh !important;
    display: inline-block;
    margin: 0px !important;
    padding-left:20px;
    font-size: 14px;
}

#sidemenu{
margin-bottom: 40px;
margin-top: 20px;
}
#sidemenu ul{
    margin:0px;
    padding:0px;    
}

#sidemenu li{
    list-style: none;
}
#sidemenu li a{
    font-size:1.1em;
    padding:4px;
    display: block;
    text-decoration: none;
    color:#$bd !important;
}
#sidemenu li a:hover{
    color:#$bh !important;
}
#sidemenu-header{
    text-align:center;
    font-size:1.2em;
    padding:4px; 
}
#sidemenu .cats{
    font-weight:bold !important;
    text-align:center;
    color:#$ch !important;
    background: #$bh !important;
}
#sidemenu .subs{
   color:#$bd !important;
}



.playground .controls {
	margin: 0 0 30px;
	padding: 30px;
	background-color: #fff;
	border-radius: 8px
}

.playground .result {
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-ms-flex-wrap: wrap;
	flex-wrap: wrap;
	-webkit-box-pack: justify;
	-ms-flex-pack: justify;
	justify-content: space-between;
	-ms-flex-line-pack: start;
	align-content: flex-start
}

.playground .result .post {
	position: relative;
	display: block;
	margin: 0 0 2%;
	widths: 32%;
	/*border-radius: 4px; */
	overflow: hidden
}

.playground .result .post img {
	position: absolute;
	top: 50%;
	left: 0;
	width: 100%;
	border-radius: 4px;
	-webkit-transform: translate(0, -50%);
	transform: translate(0, -50%)
}

.playground .result .post .meta {
	position: absolute;
	left: 0;
	bottom: 0;
	display: block;
	padding: 15px;
	width: 100%;
	height: 60px;
	color: #fff;
	font-size: 13px;
	text-decoration: none;
	background: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0)), color-stop(60%, rgba(0, 0, 0, 0.65)), to(rgba(0, 0, 0, 0.65)));
	background: linear-gradient(to bottom, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.65) 60%, rgba(0, 0, 0, 0.65) 100%);
	-webkit-transition: all .5s ease-in-out;
	transition: all .5s ease-in-out;
	overflow: hidden
}

.playground .result .post .meta p {
	margin: 0 0 20px;
	opacity: 0;
	visibility: hidden;
	-webkit-transition: all .5s ease;
	transition: all .5s ease
}

.playground .result .post .meta .stats {
	position: absolute;
	left: 15px;
	right: 15px;
	bottom: 10px;
	text-align: center
}

.playground .result .post .meta .stats i {
	margin: 0 10px 0 0
}

.playground .result .post .meta .stats .likes {
	margin: 0 30px 0 0
}

.playground .result .post::after {
	display: block;
	padding-top: 100%;
	content: ''
}

.playground .result .post:hover .meta {
	height: 100%;
	background: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0.65)), color-stop(60%, rgba(0, 0, 0, 0.65)), to(rgba(0, 0, 0, 0.65)));
	background: linear-gradient(to bottom, rgba(0, 0, 0, 0.65) 0%, rgba(0, 0, 0, 0.65) 60%, rgba(0, 0, 0, 0.65) 100%)
}

.playground .result .post:hover .meta p {
	opacity: 1;
	visibility: visible
}
.text-center {
text-align:center !important;
}
.news {
    background-color: #$bd;
    padding: 2%;
    color: #$ch
}
";
echo preg_replace('/\s+/', ' ', $style);
