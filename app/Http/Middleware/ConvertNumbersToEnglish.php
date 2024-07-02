<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertNumbersToEnglish
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('source_card_number')) {
            $request->merge([
                'source_card_number' => $this->convertNumbersToEnglish($request->input('source_card_number'))
            ]);
        }

        if ($request->has('destination_card_number')) {
            $request->merge([
                'destination_card_number' => $this->convertNumbersToEnglish($request->input('destination_card_number'))
            ]);
        }

        return $next($request);
    }

    private function convertNumbersToEnglish($string)
    {
        $string = str_replace("-", "", $string);
        $string = str_replace(" ", "", $string);

        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        $string = str_replace($persianNumbers, $englishNumbers, $string);
        $string = str_replace($arabicNumbers, $englishNumbers, $string);

        return $string;
    }
}
