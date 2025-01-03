<?php

namespace App\Http\Middleware;

use App\Enums\RoleType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class UserRedirectChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cucrrentRouteName = Route::currentRouteName();
        if (in_array(
            $cucrrentRouteName,
            $this->userAccessRole()[auth()->user()->roles()->pluck('name')[0]]
        )) {
            return $next($request);
        } else {
            abort(403);
        }
    }

    public function userAccessRole()
    {
        $routes = [];
        foreach (auth()->user()->mainMenus as $mainMenu) {
            $routes[] = $mainMenu->link;
        }
        foreach (auth()->user()->subMenus as $subMenu) {
            $routes[] = $subMenu->link;
        }
        return [
            RoleType::ADMIN => $routes,
            RoleType::FINANCE => $routes,
            RoleType::PHARMA => $routes,
            RoleType::FINANCE_RECIPES => $routes,
            RoleType::FINANCE_EXPENSES => $routes,
            RoleType::RECEPTION => $routes,
            RoleType::NURSE => $routes,
            RoleType::DOCTOR => $routes,
            RoleType::MONEY_BOX => $routes,
            RoleType::DEPOSIT_PHARMA => $routes,
            RoleType::AG => $routes,
            RoleType::RADIO => $routes,
            RoleType::LABO => $routes,
            RoleType::EMERGENCY => $routes,
            RoleType::IT => $routes,
            RoleType::CHIEF_NURSE => $routes,

        ];
    }
}
