<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AlphaVantageService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('alpha.api_key');
        $this->baseUrl = env('ALPHA_VANTAGE_BASE_URL', 'https://www.alphavantage.co');
    }

    /**
     * Get the monthly time series for multiple symbols.
     *
     * @param array $symbols
     * @return array
     */
    public function getMonthlyTimeSeries(array $symbols)
    {
        $responses = Http::pool(function ($pool) use ($symbols) {
            foreach ($symbols as $symbol) {
                $pool->as($symbol)->withOptions(['verify' => false])->get($this->baseUrl . '/query', [
                    'function' => 'TIME_SERIES_MONTHLY',
                    'symbol' => $symbol,
                    'apikey' => $this->apiKey,
                ]);
            }
        });

        $formattedData = [];

        foreach ($responses as $symbol => $response) {
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['Monthly Time Series'])) {
                    $formattedData[$symbol] = $this->formatMonthlyData($data['Monthly Time Series']);
                } else {
                    $formattedData[$symbol] = null; // If the data is not available or malformed
                }
            } else {
                $formattedData[$symbol] = null; // If the request fails
            }
        }

        return $formattedData;
    }

    /**
     * Get the Daily time series for multiple symbols.
     *
     * @param array $symbols
     * @return array
     */
    public function getDailyTimeSeries(array $symbols)
    {
        $responses = Http::pool(function ($pool) use ($symbols) {
            foreach ($symbols as $symbol) {
                $pool->as($symbol)->withOptions(['verify' => false])->get($this->baseUrl . '/query', [
                    'function' => 'TIME_SERIES_DAILY',
                    'symbol' => $symbol,
                    'apikey' => $this->apiKey,
                ]);
            }
        });

        $formattedData = [];

        foreach ($responses as $symbol => $response) {
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['Time Series (Daily)'])) {
                    $formattedData[$symbol] = $this->formatDailyData($data['Time Series (Daily)']);
                } else {
                    $formattedData[$symbol] = null; // If the data is not available or malformed
                }
            } else {
                $formattedData[$symbol] = null; // If the request fails
            }
        }

        return $formattedData;
    }

    /**
     * Get the Weekly time series for multiple symbols.
     *
     * @param array $symbols
     * @return array
     */
    public function getWeeklyTimeSeries(array $symbols)
    {
        $responses = Http::pool(function ($pool) use ($symbols) {
            foreach ($symbols as $symbol) {
                $pool->as($symbol)->withOptions(['verify' => false])->get($this->baseUrl . '/query', [
                    'function' => 'TIME_SERIES_WEEKLY',
                    'symbol' => $symbol,
                    'apikey' => $this->apiKey,
                ]);
            }
        });

        $formattedData = [];

        foreach ($responses as $symbol => $response) {
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['Weekly Time Series'])) {
                    $formattedData[$symbol] = $this->formatWeeklyData($data['Weekly Time Series']);
                } else {
                    $formattedData[$symbol] = null; // If the data is not available or malformed
                }
            } else {
                $formattedData[$symbol] = null; // If the request fails
            }
        }

        return $formattedData;
    }

     /**
     * Search for a symbol using the Alpha Vantage search API.
     *
     * @param string $keywords
     * @return array
     */
    public function searchSymbol(string $keywords)
    {
        $response = Http::withOptions(['verify' => false])
            ->get($this->baseUrl . '/query', [
                'function' => 'SYMBOL_SEARCH',
                'keywords' => $keywords,
                'apikey' => $this->apiKey,
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        return ['error' => 'Failed to fetch search results'];
    }

    /**
     * Format the monthly time series data to get the last 12 months with month initials as keys.
     *
     * @param array $data
     * @return array
     */
    protected function formatMonthlyData(array $data)
    {
        $formattedData = [];

        // Reverse the data to sort it from previous to the latest
        $data = array_reverse(array_slice($data, 0, 12));

        foreach ($data as $date => $details) {
            // Extract the month initials (e.g., 'Jan', 'Feb') from the date
            $monthInitial = date("M 'y", strtotime($date));

            $formattedData[$monthInitial] = $details['4. close'];
        }

        return $formattedData;
    }
    protected function formatDailyData(array $data)
    {
        $formattedData = [];

        // Reverse the data to ensure it's ordered from oldest to newest
        $data = array_reverse(array_slice($data, 0, 7));

        foreach ($data as $date => $details) {
            // Extract the day (e.g., '19 Nov') from the date
            $day = date('d M', strtotime($date));

            $formattedData[$day] = $details['4. close'];
        }

        return $formattedData;
    }
    protected function formatWeeklyData(array $data)
    {
        $formattedData = [];

        // Reverse the data to ensure it's ordered from oldest to newest
        $data = array_reverse(array_slice($data, 0, 5));  // Last 5 weeks = 28 days

        foreach ($data as $date => $details) {
            // Extract the day (e.g., '19 Nov') from the date
            $day = date('d M', strtotime($date));

            $formattedData[$day] = $details['4. close'];
        }

        return $formattedData;
    }

    public function fetchIntraDayDetails(array $symbols)
    {

        // return Http::withOptions(['verify' => false])->get('https://www.alphavantage.co/query?function=CRYPTO_INTRADAY&symbol=BTC&market=USD&interval=1min&apikey=4J6H02XJP9UUQEPU')->json();
        $responses = Http::pool(function ($pool) use ($symbols) {
        foreach ($symbols as $symbol) {
            $pool->as($symbol)->withOptions(['verify' => false])->get($this->baseUrl. '/query', [
                'function' => 'TIME_SERIES_INTRADAY',
                'symbol' => $symbol,
                'interval' => '60min',
                'entitlement' => 'realtime', // <--- add this line
                'apikey' => $this->apiKey,
            ]);
        }
    });

    $data = [];
    foreach ($responses as $symbol => $response) {
        $data[$symbol] = $this->formatIntraDayResponse($response);
    }

    return $data;
}

    public function fetchIntraDaySingleDetails(array $symbols)
    {

        // return Http::withOptions(['verify' => false])->get('https://www.alphavantage.co/query?function=CRYPTO_INTRADAY&symbol=BTC&market=USD&interval=1min&apikey=4J6H02XJP9UUQEPU')->json();
        $responses = Http::pool(function ($pool) use ($symbols) {
        foreach ($symbols as $symbol) {
            $pool->as($symbol)->withOptions(['verify' => false])->get($this->baseUrl. '/query', [
                'function' => 'TIME_SERIES_INTRADAY',
                'symbol' => $symbol,
                'interval' => '60min',
                'entitlement' => 'realtime', // <--- add this line
                'apikey' => $this->apiKey,
            ]);
        }
    });

    $formattedData = [];

    foreach ($responses as $symbol => $response) {
        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['Time Series (60min)'])) {
                $formattedData[$symbol] = $this->formatIntraSingleResponse($data['Time Series (60min)']);
            } else {
                $formattedData[$symbol] = null;
            }
        } else {
            $formattedData[$symbol] = null;
        }
    }

    return $formattedData;
}

    protected function formatIntraSingleResponse($data)
    {
        $formattedData = [];

        // Reverse the data to sort it from previous to the latest
        $data_before = $data;
        $data = array_reverse(array_slice($data, 0, 12));

        foreach ($data as $date => $details) {
            $time = date('h:i A', strtotime($date));
            $formattedData[$time] = $details['1. open'];
        }

        return $formattedData;

    }

    private function formatIntraDayResponse($response)
    {
        if ($response->successful()) {
            $json = $response->json();

            // Extracting the time series data
            $timeSeries = $json['Time Series (60min)'] ?? null;
            if ($timeSeries) {
                // Getting the latest time and corresponding 'close' value
                $latestTimestamp = array_key_first($timeSeries);
                $latestOpenValue = $timeSeries[$latestTimestamp]['1. open'];

                return
                    $latestOpenValue;
            } else {
                return 0;
            }
        }

        return ['error' => 'Failed to fetch data'];
    }
}
