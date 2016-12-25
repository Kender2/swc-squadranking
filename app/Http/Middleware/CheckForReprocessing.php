<?php

namespace App\Http\Middleware;

use App\Battle;
use Carbon\Carbon;
use Closure;
use File;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Response;

class CheckForReprocessing
{
    /**
     * The application implementation.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $file = storage_path().'/framework/reprocessing';
        if (File::exists($file)) {
            $total = Battle::count();
            $processed = Battle::whereNotNull('processed_at')->get()->count();

            $progress = $processed / $total;
            $percentDone = round($progress * 100);

            $timestamp = File::lastModified($file);
            $elapsed = time() - $timestamp;
            $seconds = round($elapsed / $progress) - $elapsed;

            $hours = floor($seconds / 3600);
            $minutes = floor(($seconds - $hours * 3600) / 60);
            $eta = 'in ';
            if ($hours > 1) {
                $eta .= $hours . ' hours and ';
            } elseif ($hours === 1.0) {
                $eta .= '1 hour and ';
            }
            $eta .= $minutes . ' minutes';

            return new Response(view('reranking', compact(['percentDone', 'eta'])));
        }
        return $next($request);
    }
}
