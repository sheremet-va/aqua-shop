<?php

return array(
    
    'product/([0-9]+)' => 'product/view/$1', // actionView в ProductController
     
    'catalog/list' => 'catalog/list', // actionList в CatalogController
    //'catalog/four' => 'catalog/four', // actionFour в CatalogController
    'catalog' => 'catalog/index', // actionIndex в CatalogController
   
    'category/([0-9]+)/page-([0-9]+)' => 'catalog/category/$1/$2', // actionCategory в CatalogController   
    'category/([0-9]+)' => 'catalog/category/$1', // actionCategory в CatalogController   
    'category-list/([0-9]+)/page-([0-9]+)' => 'catalog/categoryList/$1/$2', // actionCategoryList в CatalogController   
    'category-list/([0-9]+)' => 'catalog/categoryList/$1', // actionCategoryList в CatalogController   
    
    'cart/add/([0-9]+)' => 'cart/add/$1', // actionAdd в CartController
    'cart/delete/([0-9]+)' => 'cart/delete/$1', // actionDelete в CartController
    
    'cart/changeNumber/([0-9]+)/([0-9]+)' => 'cart/changeNumber/$1/$2', // actionChangeNumber в CartController
    'cart/addNumber/([0-9]+)/([0-9]+)' => 'cart/addNumber/$1/$2', // actionAddNumber в CartController
    'cart/addAjax/([0-9]+)' => 'cart/addAjax/$1', // actionAddAjax в CartController
    'cart/countCost/([0-9]+)/([0-9]+)' => 'cart/countCost/$1/$2', // actionCountCost в CartController
    'cart/countAjax' => 'cart/countAjax', // actionCountAjax в CartController
    'cart/checkout' => 'cart/checkout', // actionCheckout в CartController
    'cart' => 'cart/index', // actionIndex в CartController
    //
    // Управление товарами:    
    'admin/product/create' => 'adminProduct/create',
    'admin/product/update/([0-9]+)' => 'adminProduct/update/$1',
    'admin/product/delete/([0-9]+)' => 'adminProduct/delete/$1',
    'admin/product/search' => 'adminProduct/search',
    'admin/product' => 'adminProduct/index',
    // Управление категориями:    
    'admin/category/create' => 'adminCategory/create',
    'admin/category/update/([0-9]+)' => 'adminCategory/update/$1',
    'admin/category/delete/([0-9]+)' => 'adminCategory/delete/$1',
    'admin/category' => 'adminCategory/index',
    // Управление заказами:    
    'admin/order/update/([0-9]+)' => 'adminOrder/update/$1',
    'admin/order/delete/([0-9]+)' => 'adminOrder/delete/$1',
    'admin/order/view/([0-9]+)' => 'adminOrder/view/$1',
    'admin/order' => 'adminOrder/index',
    // Управление клиентами:    
    'admin/user/update/([0-9]+)' => 'adminUser/update/$1',
    'admin/user/delete/([0-9]+)' => 'adminUser/delete/$1',
    'admin/user/view/([0-9]+)' => 'adminUser/view/$1',
    'admin/user' => 'adminUser/index',
    // Управление рейтингом товаров
    'owner/raiting/([0-9]+)' => 'ownerRaiting/raitingView/$1',
    'owner/raiting' => 'ownerRaiting/raiting',
    // Закупка товаров
    //'admin/procurement/create' => 'adminProcurement/create',
    //'admin/procurement/view/([0-9]+)' => 'adminProcurement/view/$1',
    //'admin/procurement' => 'adminProcurement/index',
    // Страница поиска
    'admin/search/ajaxSearch' => 'adminSearch/ajaxSearch',
    'admin/search' => 'adminSearch/index',
    // Админпанель:
    'admin' => 'admin/index',
    
    // Страница поиска
    'search/ajaxSearch' => 'search/ajaxSearch',
    'search' => 'search/index',

    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',
    
    'cabinet/history/page-([0-9]+)' => 'cabinet/history/$1',
    'cabinet/history' => 'cabinet/history',
    'cabinet/edit' => 'cabinet/edit',
    'cabinet' => 'cabinet/index',
    
    '' => 'site/index', // actionIndex в SiteController
    
);