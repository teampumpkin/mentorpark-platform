<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchEuropaSkills extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'europa:fetch-skills {--limit=100}';

    /**
     * The console command description.
     */
    protected $description = 'Fetch all ESCO skills from the EU API and save to storage or database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $baseUrl = 'https://ec.europa.eu/esco/api/resource/skill';
        $isInScheme = 'http://data.europa.eu/esco/concept-scheme/skills';
        $language = 'en';
        $selectedVersion = 'latest';
        $viewObsolete = 'false';

        $limit = (int) $this->option('limit');
        $offset = 0;
        $totalFetched = 0;

        $this->info('Fetching ESCO skills in batches of ' . $limit);

        while (true) {
            $query = [
                'isInScheme'      => $isInScheme,
                'language'        => $language,
                'offset'          => $offset,
                'limit'           => $limit,
                'selectedVersion' => $selectedVersion,
                'viewObsolete'    => $viewObsolete,
            ];

            $response = Http::retry(3, 2000)
                ->timeout(120)
                ->accept('application/json')
                ->get($baseUrl, $query);

            if ($response->failed()) {
                $this->error('Request failed on page ' . $offset . ' (' . $response->status() . ')');
                break;
            }

            $json = $response->json();
            $items = $json['concepts'] ?? [];

            if (empty($items)) {
                $this->info('No more data. Finished.');
                break;
            }

            // 👇 Option 1: Save to file (safe for first test)
            $path = storage_path("app/esco_skills_page_{$offset}.json");
            file_put_contents($path, json_encode($items, JSON_PRETTY_PRINT));

            // 👇 Option 2: Or save to DB (see below)
            // foreach ($items as $item) {
            //     EscoSkill::updateOrCreate(['uri' => $item['uri']], [
            //         'href' => $item['href'],
            //     ]);
            // }

            $fetched = count($items);
            $totalFetched += $fetched;

            $this->info("Fetched {$fetched} skills (total {$totalFetched}) – page {$offset}");

            $offset++;                // ESCO treats offset as page number
            usleep(300000);           // 0.3 s delay to avoid throttling
        }

        $this->info("✅ Done. Total fetched: {$totalFetched}");
        return Command::SUCCESS;
    }
}
