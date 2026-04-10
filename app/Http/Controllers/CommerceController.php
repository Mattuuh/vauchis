<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommerceController extends Controller
{
    public function index()
    {
        $commerces = collect([
            [
                'id' => 1,
                'name' => 'Nike',
                'category' => 'Ropa y Calzado',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Logo_NIKE.svg',
                'email' => 'contacto@nike.com',
                'created_at' => '12/05/2024',
                'vouchers_count' => 24,
                'status' => 'activo',
            ],
            [
                'id' => 2,
                'name' => 'Adidas',
                'category' => 'Ropa y Calzado',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/20/Adidas_Logo.svg',
                'email' => 'info@adidas.com',
                'created_at' => '28/04/2024',
                'vouchers_count' => 18,
                'status' => 'activo',
            ],
            [
                'id' => 3,
                'name' => 'Starbucks',
                'category' => 'Alimentos y Bebidas',
                'logo' => 'https://upload.wikimedia.org/wikipedia/sco/thumb/d/d3/Starbucks_Corporation_Logo_2011.svg/2048px-Starbucks_Corporation_Logo_2011.svg.png',
                'email' => 'hola@starbucks.com',
                'created_at' => '15/03/2024',
                'vouchers_count' => 32,
                'status' => 'activo',
            ],
            [
                'id' => 4,
                'name' => 'Apple',
                'category' => 'Tecnología',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg',
                'email' => 'soporte@apple.com',
                'created_at' => '05/02/2024',
                'vouchers_count' => 15,
                'status' => 'activo',
            ],
            [
                'id' => 5,
                'name' => 'Sephora',
                'category' => 'Belleza y Cuidado',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/70/Sephora_logo.svg',
                'email' => 'contacto@sephora.com',
                'created_at' => '20/01/2024',
                'vouchers_count' => 9,
                'status' => 'activo',
            ],
            [
                'id' => 6,
                'name' => 'McDonald\'s',
                'category' => 'Alimentos y Bebidas',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/4/4e/McDonald%27s_Golden_Arches.svg',
                'email' => 'info@mcdonalds.com',
                'created_at' => '10/12/2023',
                'vouchers_count' => 27,
                'status' => 'activo',
            ],
            [
                'id' => 7,
                'name' => 'Samsung',
                'category' => 'Tecnología',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/24/Samsung_Logo.svg',
                'email' => 'info@samsung.com',
                'created_at' => '30/11/2023',
                'vouchers_count' => 12,
                'status' => 'pendiente',
            ],
            [
                'id' => 8,
                'name' => 'Zara',
                'category' => 'Moda',
                'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/fd/Zara_Logo.svg',
                'email' => 'online@zara.com',
                'created_at' => '18/10/2023',
                'vouchers_count' => 8,
                'status' => 'inactivo',
            ],
        ]);

        return view('commerces.index', compact('commerces'));
    }
}