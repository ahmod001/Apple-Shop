<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    function homePage()
    {
        return view('pages.home-page');
    }

    function policyPage()
    {
        return view('pages.policy-page');
    }

    function productByBrandPage()
    {
        return view('pages.product-by-brand');
    }

    function productByCategoryPage()
    {
        return view('pages.product-by-category');
    }

    function productDetailsPage()
    {
        return view('pages.product-details-page');
    }
}