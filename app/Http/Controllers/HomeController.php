<?php

// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Entidad;
use App\Models\Organization;
use App\Models\Influencer;
use App\Models\Organizacion;
use Illuminate\Support\Facades\DB;

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

        // $featuredBrands = collect([
        //     (object)['name' => 'Adidas', 'logo' => 'logos/adidas-logo.png'],
        //     (object)['name' => 'Apple', 'logo' => 'logos/apple-logo.png'],
        //     (object)['name' => 'Nike', 'logo' => 'logos/nike-logo.png'],
        //     (object)['name' => 'Starbucks', 'logo' => 'logos/starbucks-logo.png'],
        //     (object)['name' => 'Mc Donalds', 'logo' => 'logos/mc-donalds.png'],
        //     (object)['name' => 'Marathon', 'logo' => 'logos/marathon.png'],
        //     (object)['name' => 'Mostaza', 'logo' => 'logos/mostaza.png'],
        // ]);

        // $featuredBrands = Entidad::where('ent_estado', 1)
        //     ->get([
        //         'ent_id',
        //         DB::raw('ent_nombre_fantasia as name'),
        //         DB::raw('ent_logo_url as logo'),
        //     ]);

        $featuredBrands = Entidad::where('ent_estado', 1)
            ->with('imagenPrincipal')
            ->get()
            ->map(function ($ent) {
                return (object)[
                    'name' => $ent->ent_nombre_fantasia,
                    'logo' => $ent->imagenPrincipal
                        ? $ent->imagenPrincipal->ef_img_path
                        : 'default.png',
                ];
            });

        // $organizations = collect([
        //     (object)[
        //         'name' => 'Alto NOA',
        //         'logo' => 'logos/alto-noa-logo.png',
        //         'brands' => collect([
        //             (object)['name' => 'Adidas', 'logo' => 'logos/adidas-logo.png'],
        //             (object)['name' => 'Apple', 'logo' => 'logos/apple-logo.png'],
        //             (object)['name' => 'Nike', 'logo' => 'logos/nike-logo.png'],
        //             (object)['name' => 'Starbucks', 'logo' => 'logos/starbucks-logo.png'],
        //             (object)['name' => 'Mc Donalds', 'logo' => 'logos/mc-donalds.png'],
        //             (object)['name' => 'Marathon', 'logo' => 'logos/marathon.png'],
        //             (object)['name' => 'Mostaza', 'logo' => 'logos/mostaza.png'],
        //         ])
        //     ]
        // ]);

        $organizations = Organizacion::with([
                'domicilios.entidad' => function ($q) {
                    $q->where('ent_estado', 1);
                }
            ])
            ->where('org_estado', 1)
            ->get()
            ->map(function ($org) {
                return (object)[
                    'name' => $org->org_nombre,
                    'logo' => $org->org_img_path,
                    'brands' => $org->domicilios
                        ->filter(fn ($domicilio) => $domicilio->entidad)
                        ->map(function ($domicilio) {
                            return (object)[
                                'name' => $domicilio->entidad->ent_nombre_fantasia,
                                'logo' => $domicilio->entidad->ent_logo_url,
                            ];
                        })
                        ->unique('name')
                        ->values(),
                ];
            });

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

        // $influencers = collect([
        //     (object)[
        //         'name' => 'Cami Román',
        //         'photo' => 'influencers/cami_perez.png',
        //         'description' => 'Experiencias únicas'
        //     ],
        //     (object)[
        //         'name' => 'Juan Perez',
        //         'photo' => 'influencers/juan_perez.png',
        //         'description' => 'Equipamiento deportivo.'
        //     ],
        // ]);

        $influencers = Influencer::with('imagenPrincipal')
            ->get()
            ->map(function ($inf) {
                return (object)[
                    'name' => $inf->inf_nombre_fantasia,
                    'photo' => $inf->imagenPrincipal
                        ? $inf->imagenPrincipal->if_img_path
                        : 'default.png',
                    'description' => $inf->inf_descripcion_publica,
                ];
            });

        return view('home', compact(
            'categories',
            'featuredBrands',
            'organizations',
            'collections',
            'influencers'
        ));
    }
}