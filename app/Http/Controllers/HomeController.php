<?php

// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Organization;
use App\Models\Influencer;

class HomeController extends Controller
{
    // public function index()
    // {
    //     $categories = Category::where('is_active', true)
    //         ->orderBy('position')
    //         ->take(3)
    //         ->get();

    //     $featuredBrands = Brand::where('is_featured', true)
    //         ->where('is_active', true)
    //         ->orderBy('position')
    //         ->take(7)
    //         ->get();

    //     $organizations = Organization::with(['brands' => function ($q) {
    //             $q->where('is_active', true)->orderBy('position');
    //         }])
    //         ->where('is_active', true)
    //         ->orderBy('position')
    //         ->take(3)
    //         ->get();

    //     $influencers = Influencer::with('brand')
    //         ->where('is_active', true)
    //         ->orderBy('position')
    //         ->take(3)
    //         ->get();

    //     return view('home', compact(
    //         'categories',
    //         'featuredBrands',
    //         'organizations',
    //         'influencers'
    //     ));
    // }
    public function index()
    {
        $categories = collect([
            (object)[
                'name' => 'Objetos',
                'description' => 'Vouchers para tiendas',
                'image' => 'objetos.png',
                'color' => '#1f4ed8'
            ],
            (object)[
                'name' => 'Experiencias',
                'description' => 'Cenas, spa y más',
                'image' => 'experiencias.png',
                'color' => '#e11d48'
            ],
            (object)[
                'name' => 'Impacto Social',
                'description' => 'Apoya ONGs',
                'image' => 'impacto_social.png',
                'color' => '#059669'
            ]
        ]);

        $featuredBrands = collect([
            (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
            (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
            (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
            (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
            (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
            (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
            (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
            (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
            (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
            (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
            (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
            (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
        ]);

        $organizations = collect([
            (object)[
                'name' => 'Teletón',
                'logo' => 'logos/alto-noa-logo.png',
                'brands' => collect([
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                ])
            ],
            (object)[
                'name' => 'Teletón',
                'logo' => 'logos/alto-noa-logo.png',
                'brands' => collect([
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                ])
            ],
            (object)[
                'name' => 'Teletón',
                'logo' => 'logos/alto-noa-logo.png',
                'brands' => collect([
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                ])
            ],
            (object)[
                'name' => 'Teletón',
                'logo' => 'logos/alto-noa-logo.png',
                'brands' => collect([
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                    (object)['name' => 'Marca 1', 'logo' => 'logos/adidas-logo.png'],
                    (object)['name' => 'Marca 2', 'logo' => 'logos/apple-logo.png'],
                    (object)['name' => 'Marca 3', 'logo' => 'logos/nike-logo.png'],
                    (object)['name' => 'Marca 4', 'logo' => 'logos/starbucks-logo.png'],
                ])
            ]
        ]);

        $collections = collect([
            (object)[
                'name' => 'Amantes del Cafe',
                'photo' => 'collections/amantes-cafe.jpg',
                'description' => 'Experiencias únicas'
            ],
            (object)[
                'name' => 'Dia de la madre',
                'photo' => 'collections/dia_madre.png',
                'description' => 'Experiencias únicas'
            ],
            (object)[
                'name' => 'Cata de vinos',
                'photo' => 'collections/fanaticos-vino.jpg',
                'description' => 'Experiencias únicas'
            ],
            (object)[
                'name' => 'Peliculeros',
                'photo' => 'collections/peliculeros.jpg',
                'description' => 'Experiencias únicas'
            ],
        ]);

        $influencers = collect([
            (object)[
                'name' => 'Cami Román',
                'photo' => null,
                'description' => 'Experiencias únicas'
            ]
        ]);

        return view('home', compact(
            'categories',
            'featuredBrands',
            'organizations',
            'collections',
            'influencers'
        ));
    }
}