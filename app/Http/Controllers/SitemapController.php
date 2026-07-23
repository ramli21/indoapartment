<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap.
     */
    public function index(): Response
    {
        $urls = [];

        // 1. Static Pages
        $staticPages = [
            ['route' => 'home', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['route' => 'rooms.list', 'priority' => '0.8', 'changefreq' => 'daily'],
            ['route' => 'help', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['route' => 'terms', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['route' => 'inquiry.create', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['route' => 'rooms.owner.create', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['route' => 'booking.track', 'priority' => '0.6', 'changefreq' => 'weekly'],
        ];

        foreach ($staticPages as $page) {
            $urls[] = [
                'loc' => route($page['route']),
                'lastmod' => Carbon::today()->toAtomString(),
                'changefreq' => $page['changefreq'],
                'priority' => $page['priority'],
            ];
        }

        // 2. Dynamic Apartments Pages
        $apartments = Apartment::all();
        foreach ($apartments as $apartment) {
            $urls[] = [
                'loc' => route('apartment.rooms', $apartment),
                'lastmod' => ($apartment->updated_at ?? Carbon::today())->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 3. Dynamic Room Pages (Booking creation pages)
        $rooms = Room::whereIn('status', ['Tersedia', 'Perawatan', 'Terisi'])->get();
        foreach ($rooms as $room) {
            $urls[] = [
                'loc' => route('booking.create', $room),
                'lastmod' => ($room->updated_at ?? Carbon::today())->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        // Build the XML content
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
            $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $url['priority'] . '</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}
