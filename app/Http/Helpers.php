<?php

namespace App\Http;

use Illuminate\Support\Facades\Route;

class Helpers {
    public function getRoutes() {
        $routes = Route::getRoutes();

        $results = [];
        foreach ($routes as $route) {
            if ($route->getName()) {
                $results[$route->getName()] = $route->uri();
            }
        }

        return $results;
    }
}
