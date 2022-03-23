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
        echo "Price per ticket: $ticketPrice\n";
        echo "Ratio for prices: $winShare\n";
        echo "Price per win: $priceCost\n";
        echo "Prices: $numPrices\n";
        echo "Price ratio: $winActualShare\n";
        echo "<hr>";

        $table = [];

        $ratio = 0.33;
        $winners = 1;
        $wins = ceil($numPrices * $ratio);
        $totalWins = $totalWins + $wins;
        $table[] = array($winners, $wins, $wins * $priceCost);

        $ratio = 0.1089;
        $winners = 1;
        $wins = ceil($numPrices * $ratio);
        $totalWins = $totalWins + $wins;
        $table[] = array($winners, $wins, $wins * $priceCost);

        $ratio = 0.05;
        $wins = ceil($numPrices * $ratio);
        // if ($wins < 4) { $wins = 4; }
        // if ($wins > 10) { $wins = 10; }
        
        for ($wins; $wins > 0; $wins--) {
            $winners = ($wins > 1) ? 4 : 1;
            $totalWins = $totalWins + $wins * $winners;
            if ($totalWins > $numPrices) {
                $totalWins = $totalWins - $wins * $winners;
                break;
            }
            $table[] = array($winners, $wins, $wins * $priceCost);
        }

        $leftOver = $numPrices - $totalWins;
        $lastWin = floor($leftOver / 4);
        if ($lastWin > 0) :
            $table[] = array(4, $lastWin, $lastWin * $priceCost);
            $totalWins = $totalWins + $lastWin * 4;
        endif;

        $leftOver = $numPrices - $totalWins;
        if ($leftOver > 0) :
            $table[] = array(1, $leftOver, $leftOver * $priceCost);
        endif;

        $totalTicketsOut = 0;
        $totalWinners = 0;

        foreach ($table as $pos => $data) {
            $totalTicketsOut = $totalTicketsOut + ($data[0] * $data[1]);
            $totalWinners = $totalWinners + $data[0];
            echo "Position: $pos\n";
            echo "Winners: {$data[0]}\n";
            echo "Tickets per person: {$data[1]}\n";
            echo "Total tickets: " . ($data[0] * $data[1]) . "\n";
            echo "\n";
        }
        echo "\n";
        echo "Total winners: $totalWinners\n";
        echo "Total tickets: $totalTicketsOut\n";
        
    }
}
