<?php
namespace models;

class Monster
{
    private $arraySize;
    private $monsterArray = [];
    private $pv;
    private $force;
    private $x;
    private $y;

    public function __construct()
    {
        if (isset($_SESSION['monsterArray'])) {
            $this->monsterArray = $_SESSION['monsterArray'];
        } else {
            $this->arraySize = rand(10, 50);
            $this->generateMonsters(); // Generate monsters initially
            $this->shuffleMonsters(); // Shuffle the monsters
            $_SESSION['monsterArray'] = $this->monsterArray; // Save the shuffled array in the session
            $this->pv;
            $this->force;
            $this->x;
            $this->y;
        }
    }

    private function generateMonsters()
    {
        while (count($this->monsterArray) < $this->arraySize) {
            $this->x = rand(0, 20);
            $this->y = rand(0, 20);
            $this->pv = rand(30, 130);
            $this->force = rand(40, 120);
            $point = ["positionX" => $this->x, "positionY" => $this->y, "PV" => $this->pv, "Force" => $this->force];

            if (!$this->isDuplicate($point)) {
                $this->monsterArray[] = $point;
            }
        }
    }

    private function isDuplicate($point)
    {
        foreach ($this->monsterArray as $existingPoint) {
            if ($existingPoint === $point) {
                return true;
            }
        }
        return false;
    }

    private function shuffleMonsters()
    {
        // Fisher-Yates shuffle algorithm
        $count = count($this->monsterArray);
        for ($i = $count - 1; $i > 0; $i--) {
            $j = rand(0, $i);
            if ($i != $j) {
                // Swap monsters at positions $i and $j
                $temp = $this->monsterArray[$i];
                $this->monsterArray[$i] = $this->monsterArray[$j];
                $this->monsterArray[$j] = $temp;
            }
        }
    }

    public function getMonsters()
    {
        return $this->monsterArray;
    }

    public function getPV()
    {
        return $this->pv;
    }
}
