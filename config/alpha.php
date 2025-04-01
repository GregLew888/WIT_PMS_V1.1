<?php 

return [

    'api_key' => env('ALPHA_VANTAGE_API_KEY'),

    'symbols' => [
        // Technology
        "AAPL" => "Apple Inc.",
        "MSFT" => "Microsoft Corporation",
        "META" => "Meta Platforms Inc.",
        "TSLA" => "Tesla Inc.",
        "GOOGL" => "Alphabet Inc.",
        "AMZN" => "Amazon.com Inc.",
        "NVDA" => "NVIDIA Corporation",
        "ORCL" => "Oracle Corporation",
        "IBM" => "International Business Machines Corporation",
        "INTC" => "Intel Corporation",
        "CSCO" => "Cisco Systems, Inc.",
        "ADBE" => "Adobe Inc.",
        "CRM" => "Salesforce.com Inc.",
    
        // Financial Institutions
        "JPM" => "JPMorgan Chase & Co.",
        "BAC" => "Bank of America Corporation",
        "C" => "Citigroup Inc.",
        "GS" => "Goldman Sachs Group Inc.",
        "WFC" => "Wells Fargo & Company",
        "MS" => "Morgan Stanley",
        "AXP" => "American Express Company",
        "BRK.B" => "Berkshire Hathaway Inc.",
        "BLK" => "BlackRock, Inc.",
        "SCHW" => "The Charles Schwab Corporation",
    
        // Consumer Goods
        "PG" => "Procter & Gamble Co.",
        "KO" => "The Coca-Cola Company",
        "PEP" => "PepsiCo Inc.",
        "MCD" => "McDonald's Corporation",
        "NKE" => "Nike Inc.",
        "SBUX" => "Starbucks Corporation",
        "DIS" => "The Walt Disney Company",
        "WMT" => "Walmart Inc.",
        "TGT" => "Target Corporation",
        "COST" => "Costco Wholesale Corporation",
        "EL" => "Estée Lauder Companies Inc.",
    
        // Energy
        "XOM" => "Exxon Mobil Corporation",
        "CVX" => "Chevron Corporation",
        "BP" => "BP p.l.c.",
        "TOT" => "TotalEnergies SE",
        "RDS.A" => "Royal Dutch Shell plc",
        "SLB" => "Schlumberger Limited",
        "COP" => "ConocoPhillips",
        "ENB" => "Enbridge Inc.",
        "EPD" => "Enterprise Products Partners L.P.",
    
        // Healthcare
        "JNJ" => "Johnson & Johnson",
        "PFE" => "Pfizer Inc.",
        "MRK" => "Merck & Co., Inc.",
        "ABBV" => "AbbVie Inc.",
        "UNH" => "UnitedHealth Group Incorporated",
        "CVS" => "CVS Health Corporation",
        "AMGN" => "Amgen Inc.",
        "ABT" => "Abbott Laboratories",
        "GILD" => "Gilead Sciences, Inc.",
        "LLY" => "Eli Lilly and Company",
    
        // Retail and E-commerce
        "HD" => "The Home Depot, Inc.",
        "TGT" => "Target Corporation",
        "COST" => "Costco Wholesale Corporation",
        "LOW" => "Lowe's Companies, Inc.",
        "EBAY" => "eBay Inc.",
        "WBA" => "Walgreens Boots Alliance, Inc.",
        "BBY" => "Best Buy Co., Inc.",
        "DLTR" => "Dollar Tree, Inc.",
        "DG" => "Dollar General Corporation",
        "M" => "Macy's Inc.",
    
        // Automotive
        "F" => "Ford Motor Company",
        "GM" => "General Motors Company",
        "HMC" => "Honda Motor Co., Ltd.",
        "TM" => "Toyota Motor Corporation",
        "NIO" => "NIO Inc.",
        "RIVN" => "Rivian Automotive, Inc.",
        "HOG" => "Harley-Davidson, Inc.",
        "LCID" => "Lucid Group, Inc.",
        "STLA" => "Stellantis N.V.",
    
        // Airlines
        "DAL" => "Delta Air Lines, Inc.",
        "AAL" => "American Airlines Group Inc.",
        "UAL" => "United Airlines Holdings, Inc.",
        "LUV" => "Southwest Airlines Co.",
        "BA" => "The Boeing Company",
        "ALK" => "Alaska Air Group, Inc.",
        "JBLU" => "JetBlue Airways Corporation",
        "SAVE" => "Spirit Airlines, Inc.",
    
        // Telecommunications
        "T" => "AT&T Inc.",
        "VZ" => "Verizon Communications Inc.",
        "TMUS" => "T-Mobile US, Inc.",
        "CHTR" => "Charter Communications, Inc.",
        "VOD" => "Vodafone Group Plc",
        "CMCSA" => "Comcast Corporation",
        "LUMN" => "Lumen Technologies, Inc.",
    
        // Utilities
        "NEE" => "NextEra Energy, Inc.",
        "DUK" => "Duke Energy Corporation",
        "SO" => "The Southern Company",
        "D" => "Dominion Energy, Inc.",
        "EXC" => "Exelon Corporation",
        "AEP" => "American Electric Power Company, Inc.",
        "ED" => "Consolidated Edison, Inc.",
        "SRE" => "Sempra Energy",
        "PEG" => "Public Service Enterprise Group Incorporated",
    
        // Real Estate
        "PLD" => "Prologis, Inc.",
        "SPG" => "Simon Property Group, Inc.",
        "AMT" => "American Tower Corporation",
        "EQIX" => "Equinix, Inc.",
        "DLR" => "Digital Realty Trust, Inc.",
        "O" => "Realty Income Corporation",
        "EQR" => "Equity Residential",
    
        // Consumer Services
        "BKNG" => "Booking Holdings Inc.",
        "CCL" => "Carnival Corporation & plc",
        "NCLH" => "Norwegian Cruise Line Holdings Ltd.",
        "RCL" => "Royal Caribbean Group",
        "MAR" => "Marriott International, Inc.",
        "HLT" => "Hilton Worldwide Holdings Inc."
    ],

    'digital_currencies' => [
        'USDT' => 'Tether',
        'XRP' => 'Ripple',
        'ADA' => 'Cardano',
        'DOGE' => 'Dogecoin',
        'MATIC'  => 'Polygon',
        'DOT'  => 'Polkadot',
    ],
    
];