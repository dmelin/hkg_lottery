<?php

class lottery
{
    function __construct()
    {
    }

    public function wins($ticketCount, $ticketPrice, $winShare, $priceCost)
    {
        $totalCash = $ticketCount * $ticketPrice;
        $pricesTotal = $totalCash * $winShare;
        $numPrices = floor($pricesTotal / $priceCost);
        $winActualShare = ($numPrices * $priceCost) / $totalCash;
        $totalWins = 0;

        echo "<pre>";
        echo "Tickets sold: $ticketCount\n";
        echo "Prices: $numPrices\n";
        echo "Price ratio: " . round($winActualShare, 3) . "\n";
        echo "<hr>";

        $firstSecond = [];
        $otherWinners = [];

        $firstWins = ceil($numPrices * (1 / 3));
        $secondWins = ceil($numPrices * (1 / 9));

        $firstSecond[] = array("winners" => 1, "prices" => $firstWins);
        $firstSecond[] = array("winners" => 1, "prices" => $secondWins);

        $numPrices = $numPrices - $firstWins - $secondWins;

        
        print_r($numPrices);
        die();

        $totalTicketsOut = 0;
        $totalWinners = 0;

        $table = array_merge($firstSecond, $otherWinners);

        foreach ($table as $pos => $data) {
            $totalTicketsOut = $totalTicketsOut + ($data["winners"] * $data["prices"]);
            $totalWinners = $totalWinners + $data["winners"];
            $table[$pos]["totPrices"] = $data["winners"] * $data["prices"];
        }

        print_r($table);
        echo "\n";
        echo "Total winners: $totalWinners\n";
        echo "Total prices: $totalTicketsOut\n";
        echo "Total win sum: " . ($totalTicketsOut * $priceCost) . "\n";
        echo "Final win ratio: " . round(($totalTicketsOut * $priceCost) / $totalCash, 3) . "\n";
        echo "\n";
        echo "\n";
    }
}
