<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSSProtection
{
    /**
     * The following method loops through all request input and strips out all disallowed
     * tags from the request while allowing safe HTML tags. This ensures users are unable
     * to inject harmful HTML or JavaScript while allowing some form of markup.
     *
     * @param Request $request
     * @param callable $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        // Only apply XSS protection for PUT and POST requests
        if (!in_array(strtolower($request->method()), ['put', 'post'])) {
            return $next($request);
        }

        // Get all the input from the request
        $input = $request->all();

        // Define a list of allowed HTML tags
        $allowedTags = '<b><i><strong><em><u><a><p><br><ul><ol><li><span><img>';

        // Loop through the request input and sanitize each value
        array_walk_recursive($input, function (&$input) use ($allowedTags) {
            // Strip disallowed tags, but allow specific ones
            $input = strip_tags($input, $allowedTags);
        });

        // Merge the sanitized input back into the request object
        $request->merge($input);

        // Pass the request to the next middleware
        return $next($request);
    }
}
