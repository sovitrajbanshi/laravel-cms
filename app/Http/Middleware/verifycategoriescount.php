<?php

namespace App\Http\Middleware;

use App\category;
use Closure;

class verifycategoriescount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(category::all()->count()== 0){
            session()->flash('error','you need to add category to be able to create a post');
            return redirect(route('categories.create'));
        }

        return $next($request);
    }
}
