<?php
/**
   Template name: Menu
 */

get_header();
?>
   <style type="text/css">
@import url("https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap");
body {
    height: 100%;
    margin: 0;
}

a {
    color: #007bff;
    text-decoration: none;
}
button:focus,
input:focus {
    outline: none;
    box-shadow: none;
}
a,
a:hover {
    text-decoration: none;
}

body {
    font-family: "Nunito", sans-serif;
}

/*-------------------------------------*/

li {
    list-style: none;
}
.header_bottom {
    padding: 0px 10px;
    background-color: #fff;
    box-shadow: 0px 2px 3px rgb(0 0 0 / 16%);
}
.header_static {
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.logo-section a {
    font-weight: 800;
    color: #5161ce;
    font-size: 22px;
}
.main_menu nav > ul > li {
    display: inline-block;
}
.main_menu nav > ul {
    padding: 0;
    margin: 0;
}

.main_menu nav > ul > li > a {
    display: block;
    padding: 22px 22px;
    color: #565656;
    font-size: 13px;
    text-transform: capitalize;
    font-weight: 700;
    border-radius: 4px;
    transition: 0.5s;
    letter-spacing: 0.3px;
    position: relative;
}

.main_menu nav > ul > li > a:before {
    content: "";
    position: absolute;
    width: 100%;
    height: 3px;
    left: 0;
    top: 0;
    background-color: #5161ce;
    opacity: 0;
    visibility: hidden;
    transition: 0.5s;
}

.main_menu nav > ul > li > a:hover:before {
    color: #5161ce;
    opacity: 1;
    visibility: visible;
}

.main_menu nav ul li ul.mega_menu {
    position: absolute;
    min-width: 100%;
    padding: 0;
    background: #fff;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.16);
    border-radius: 4px;
    left: 0;
    right: auto;
    opacity: 0;
    visibility: hidden;
    -webkit-transition: 0.15s;
    transition: 0.15s;
    z-index: 9;
    top: 140%;
}
.main_menu nav > ul > li ul.sub_menu {
    position: absolute;
    min-width: 220px;
    padding: 10px 0px;
    background: #fff;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.16);
    border-radius: 4px;
    left: inherit;
    right: inherit;
    opacity: 0;
    visibility: hidden;
    -webkit-transition: 0.15s;
    transition: 0.15s;
    z-index: 9;
    top: 140%;
}
.main_menu nav ul li:hover .sub_menu,
.main_menu nav ul li:hover .mega_menu {
    opacity: 1;
    visibility: visible;
    top: 100%;
}
.sub_menu li a {
    padding: 7px 20px;
    color: #808080;
    font-size: 14px;
    display: inline-block;
    width: 100%;
}
.shop-category-contain {
    max-height: 420px;
}
.shop-category > li > a {
    color: #7d7d7d;
    font-size: 13px;
    text-transform: capitalize;
    line-height: 18px;
    display: block;
    font-weight: 600;
    padding: 11px 16px;
    border-radius: 4px;
}
.shop-menu {
    position: relative;
}
.shop-mega-menu {
    background-color: #fff;
    padding: 0px;
    width: 100%;
    -webkit-transition: 0.3s;
    transition: 0.3s;
    z-index: 9;
    max-height: 393px;
    overflow-x: hidden;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    position: absolute;
    width: calc(100% - 240px);
    top: 0px;
    right: 0;
    display: none;
}
.shop-mega-menu li {
    list-style: none;
}
.shop-menu > ul {
    max-height: 400px;
    overflow-x: hidden;
    width: 240px;
    padding: 10px;
}
.shop-category > li {
    width: 100%;
    position: static;
    display: inline-block;
}
.shop-category > li.active > a,
.shop-category > li:hover > a {
    background-color: #5161ce;
    color: #fff !important;
}
.shop-mega-menu > ul {
    width: calc(100% / 4);
    padding: 15px;
    float: left;
    max-height: 100%;
    overflow: initial;
}
.shop-mega-menu li a:hover {
    color: #5161ce;
}
.shop-mega-menu > ul > h6 {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 15px;
}
.shop-mega-menu > ul > h6 > a {
    display: inline-block;
    width: 100%;
    color: #444444 !important;
}
.shop-mega-menu li a {
    color: #a5a5a5;
    font-size: 13px;
    line-height: 18px;
    margin-bottom: 15px;
    display: block;
    text-transform: capitalize;
    font-weight: 400;
}
.shop-category > li:hover .shop-mega-menu,
.shop-category > li.active .shop-mega-menu.hover {
    display: flex;
}





</style>
   <main id="primary" class="site-main">
   <div class="header_bottom sticky-header">
      <div class="container-fluid">
         <div class="row align-items-center">
            <div class="col-12">
               <div class="header_static">
                  <div class="logo-section">
                     <a href="javascript:void(0);">Brand Logo</a>
                  </div>
                  <div class="main_menu_inner">
                     <div class="main_menu">
                        <nav>
                           <ul>
                              <li><a href="javascript:void(0);">Home</a></li>
                              <li>
                                 <a href="javascript:void(0);">Category <i class="fa fa-angle-down"></i></a>
                                 <ul class="mega_menu">
                                    <div class="brand-category-content shop-category-contain">
                                       <div class="shop-menu">
                                          <ul class="shop-category">
                                             <li class="active">
                                                <a href="javascript:void(0);">Appliances</a>
                                                <div class="shop-mega-menu hover">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Appliances</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Appliances</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Baby</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Baby</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Baby</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Bags, Wallets and Luggage</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Bags, Wallets and Luggage</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Bags, Wallets and Luggage</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Beauty</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Baby</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Baby</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Books</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Books</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Books</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Motorbike</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Motorbike</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Motorbike</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Clothing & Accessories</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Clothing & Accessories</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Clothing & Accessories</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Collectibles & Fine Art</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Collectibles & Fine Art</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Collectibles & Fine Art</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Computers & Accessories</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Computers & Accessories</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Computers & Accessories</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Electronics</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Electronics</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Electronics</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Grocery & Gourmet Foods</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Grocery & Gourmet Foods</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Grocery & Gourmet Foods</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Health & Personal Care</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Health & Personal Care</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Health & Personal Care</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Home & Kitchen</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Home & Kitchen</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Home & Kitchen</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Industrial & Scientific</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Industrial & Scientific</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Industrial & Scientific</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                             <li>
                                                <a href="#tabshop1">Jewellery</a>
                                                <div class="shop-mega-menu">
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Jewellery</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Jewellery</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                      <li><a href="javascript:void(0);">Clothing</a></li>
                                                      <li><a href="javascript:void(0);">Shoes</a></li>
                                                      <li><a href="javascript:void(0);">Check Trousers</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                      <li><a href="javascript:void(0);">Handbag</a></li>
                                                      <li><a href="javascript:void(0);">Accessories</a></li>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                   <ul>
                                                      <h6><a href="javascript:void(0);">Face</a></h6>
                                                   </ul>
                                                </div>
                                             </li>
                                          </ul>
                                       </div>
                                    </div>
                                 </ul>
                              </li>
                              <li>
                                 <a href="javascript:void(0);">Pages <i class="fa fa-angle-down"></i></a>
                                 <ul class="sub_menu pages">
                                    <li><a href="javascript:void(0);">About Us</a></li>
                                    <li><a href="javascript:void(0);">Services</a></li>
                                    <li><a href="javascript:void(0);">Frequently Questions</a></li>
                                    <li><a href="javascript:void(0);">Login</a></li>
                                    <li><a href="javascript:void(0);">My account</a></li>
                                    <li><a href="javascript:void(0);">Wishlist</a></li>
                                    <li><a href="javascript:void(0);">Error 404</a></li>
                                    <li><a href="javascript:void(0);">Compare</a></li>
                                    <li><a href="javascript:void(0);">Privacy policy</a></li>
                                    <li><a href="javascript:void(0);">Coming soon</a></li>
                                 </ul>
                              </li>
                              <li><a href="javascript:void(0);">Services</a></li>
                              <li><a href="javascript:void(0);">Blog</a></li>
                              <li><a href="javascript:void(0);">Contact Us</a></li>
                           </ul>
                        </nav>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   </main><!-- #main -->

<?php
// get_sidebar();
get_footer();